<?php

/**
 * CSVファイルインポート前の確認時のユースケース
 */
namespace Kyuyo\Applications\Absence;

use Kyuyo\Instructors\Absence\AbsenceDivDto;
use Kyuyo\Requests\Absence\AbsenceCsvFileConformRequest;
use Kyuyo\Domains\CompanyRule\CompanyRuleService;
use Kyuyo\Resources\Kyuyo\Absence\{
    AbsenceDataImportErrorResource,
    AbsenceDataImportSuccessResource
};
use OaEtc\Helpers\LoggerHelper;
use OaEtc\ImportData\ImportCsv;
use Kyuyo\Domains\Absence\AbsenceDataImport\AbsenceDataImportService;
use Kyuyo\Domains\Absence\AbsenceRepositoryInterface;
use Kyuyo\Instructors\Absence\{
    ImportCsvRowDto,
    SelectedFiscalYearMonthDto,
    AbsenceDataImportErrorMessageDto
};
use Kyuyo\Domains\Absence\AbsenceService;
use Kyuyo\Instructors\CompanyRule\CompanyDateDto;

/**
 * Class ConfirmUseCase
 * @package Kyuyo\Applications\Absence\ImportAbsenceCsv
 */
class ImportCsvConfirmUseCase
{
    const INIT_RECODE_COUNT = 0;

    private $absenceDataImportService;
    private $absenceRepositoryInterface;
    private $companyRuleService;
    private $absenceService;
    private $importCsvRowDto;
    private $selectedFiscalYearMonthDto;
    private $rowNumber = self::INIT_RECODE_COUNT;
    private $importDiffStatus = null;

    /**
     * ConfirmUseCase constructor.
     *
     * @param AbsenceDataImportService $absenceDataImportService
     * @param AbsenceRepositoryInterface $absenceRepositoryInterface
     * @param CompanyRuleService $companyRuleService
     * @param AbsenceService $absenceService
     * @param ImportCsvRowDto $importCsvRowDto
     * @param SelectedFiscalYearMonthDto $selectedFiscalYearMonthDto
     */
    public function __construct(
        AbsenceDataImportService $absenceDataImportService,
        AbsenceRepositoryInterface $absenceRepositoryInterface,
        CompanyRuleService $companyRuleService,
        AbsenceService $absenceService,
        ImportCsvRowDto $importCsvRowDto,
        SelectedFiscalYearMonthDto $selectedFiscalYearMonthDto
    )
    {
        $this->absenceDataImportService = $absenceDataImportService;
        $this->absenceRepositoryInterface = $absenceRepositoryInterface;
        $this->companyRuleService = $companyRuleService;
        $this->absenceService = $absenceService;
        $this->importCsvRowDto = $importCsvRowDto;
        $this->selectedFiscalYearMonthDto = $selectedFiscalYearMonthDto;
    }

    /**
     * @param \SplFileObject $fileObject
     * @param AbsenceCsvFileConformRequest $request
     *
     * @return AbsenceDataImportErrorResource|AbsenceDataImportSuccessResource|void
     */
    public function execute(
        \SplFileObject $fileObject,
        AbsenceCsvFileConformRequest $request
    )
    {
        $countByDiv = [];
        $assignedList = [];
        $absenceDivDto = new AbsenceDivDto();
        $absenceDtaImportErrorMessageDto = new AbsenceDataImportErrorMessageDto();
        try {
            /**
             * STEP1 取り込みデータ確認用の一時データ書き込み先ファイル作成
             */
            $writeFilePath = storage_path('tmp/absenceCsvImport/import') . '/' . time() . '.csv';
            $writeCsvFile = new \SplFileObject(
                $writeFilePath,
                'w'
            );

            /**
             * STEP2 バリデーション用のデータ準備
             *  取り込みデータの社員IDチェックのために、退職者を含む過去に在籍していた社員ID一覧を抽出
             *  取り込みデータと状態を比較するために、選択日時の登録済みデータの抽出
             */
            $fiscalDate = $this->companyRuleService->toFiscalDate(
                new CompanyDateDto(
                    $request->requestYear,
                    $request->requestMonth
                )
            );
            $this->selectedFiscalYearMonthDto->setSelectYear($request->requestYear);
            $this->selectedFiscalYearMonthDto->setSelectMonth($request->requestMonth);

            $personalInfoList = $this->absenceRepositoryInterface->fetchPersonalInfoList()
                ->keyBy('personal_id')
                ->toArray();
            $this->importDiffStatus = $this->absenceDataImportService->factoryImportDiffStatus(
                $this->absenceRepositoryInterface
                    ->fetchRegisteredAbsence(
                        $fiscalDate->getFiscalYear(),
                        $fiscalDate->getFiscalMonth()
                    )
                    ->toArray()
            );

            /**
             * STEP4 ファイル拡張子が違う、列数が違う等、前提条件を満たしていないデータをはじく
             */
            $this->absenceDataImportService->validateExceptionFormat(
                $fileObject->current(),
                $absenceDtaImportErrorMessageDto,
                $this->selectedFiscalYearMonthDto
            );

            /**
             * STEP5～8 アップロードされたCSVファイルから、取り込み対象となるデータの判定から一時CSVファイルまでの書き込みまでを行う
             */
            foreach ($fileObject as $index => $recode) {
                // ファイル全体で見た時に除外された行数も加味されるように、全てのケースで行数が一致するように先頭で行数の加算を開始
                $this->rowNumber++;
                if ($this->absenceDataImportService->isSkipRow($index, $recode)) {
                    continue;
                }
                $recode = ImportCsv::convertEncodingVariables($recode);

                /**
                 * STEP5 一部のデータを除外する。
                 * 対象は次の通り
                 * ・CSV内の日付と画面で指定した日付が一致していないデータ
                 */
                list($personalId, $shainName, $absenceDiv, $selectYear, $selectMonth) = $recode;
                $this->importCsvRowDto->setPersonalId($personalId);
                $this->importCsvRowDto->setShainName($shainName);
                $this->importCsvRowDto->setAbsenceDiv(
                    $this->absenceService->getDivNameToNumber($absenceDiv)
                );
                $this->importCsvRowDto->setInputAbsenceDiv($absenceDiv);
                $this->importCsvRowDto->setSelectYear($selectYear);
                $this->importCsvRowDto->setSelectMonth($selectMonth);
                if ($this->absenceDataImportService->isRemoveRow(
                    $this->importCsvRowDto,
                    $this->selectedFiscalYearMonthDto
                )) {
                    continue;
                }

                /**
                 * STEP6 取り込み対象となるデータのバリデーションを行う。
                 *  バリデーションエラーがあった場合、行ごとにエラー情報を蓄積していく
                 */
                $this->absenceDataImportService->validateImportCsv(
                    $personalInfoList,
                    $this->importCsvRowDto,
                    $absenceDtaImportErrorMessageDto,
                    $this->rowNumber
                );

                /**
                 * STEP7 登録済みデータと取り込みデータを比較して、どういったデータの変化があったのかを割り当てる
                 */
                $absenceDivDto->setPersonalId($this->importCsvRowDto->getPersonalId());
                $absenceDivDto->setAbsenceDiv($this->importCsvRowDto->getAbsenceDiv());
                $countByDiv = $this->absenceService->countAbsenceDivType(
                    $absenceDivDto,
                    $countByDiv
                );
                $this->importCsvRowDto->setChangeDiv(
                    $this->absenceDataImportService->assignChangeAbsenceList(
                        $this->importDiffStatus,
                        $this->importCsvRowDto
                    )
                );
                $personalInfo = ($personalInfoList[$this->importCsvRowDto->getPersonalId()]) ?? [
                        'kanji_family_name' => '',
                        'kanji_given_name' => ''
                    ];
                $assignedList[$index] = [
                    'personalId' => $this->importCsvRowDto->getPersonalId(),
                    'shainName' => $personalInfo['kanji_family_name'] . $personalInfo['kanji_given_name'],
                    'absenceDiv' => $this->importCsvRowDto->getAbsenceDiv(),
                    'diffStatus' => $this->importCsvRowDto->getChangeDiv()
                ];

                /**
                 * STEP8 取り込み対象となったデータを一時保存用のCSVファイルに書き込み
                 */
                $this->absenceDataImportService->writeConfirmCsvFile(
                    $writeCsvFile,
                    $this->importCsvRowDto
                );
            }

            /**
             * STEP9 CSVファイル精査の結果、取り込み対象が1件も無ければこれ以降の処理を中断する
             */
            $removeComeBackList = [];
            if (!$this->absenceDataImportService->existsImportTargetData($assignedList)) {
                return $this->returnSuccessResource(
                    $assignedList,
                    $removeComeBackList,
                    $writeFilePath,
                    $countByDiv,
                );
            }

            /**
             * STEP10 該当年月にCSVから行ごと削除されている社員がいれば、復職者として一時保存用のCSVファイルに書き込む
             */
            $removeComeBackList = $this->absenceDataImportService->addRemovedRowComeback($this->importDiffStatus);
            foreach ($removeComeBackList as $comeback) {
                $this->importCsvRowDto->setPersonalId($comeback['personalId']);
                $this->importCsvRowDto->setAbsenceDiv($comeback['absenceDiv']);
                $this->importCsvRowDto->setChangeDiv($comeback['diffStatus']);
                $this->absenceDataImportService->writeConfirmCsvFile(
                    $writeCsvFile,
                    $this->importCsvRowDto
                );
            }

            $errorList = $absenceDtaImportErrorMessageDto->getErrorMessageList();
            if (count($errorList) > 0) {
                @unlink($writeFilePath);
                return new AbsenceDataImportErrorResource($absenceDtaImportErrorMessageDto);
            } else {
                /**
                 * STEP11 データ出力
                 */
                return $this->returnSuccessResource(
                    $assignedList,
                    $removeComeBackList,
                    $writeFilePath,
                    $countByDiv,
                );
            }
        } catch (\UnexpectedValueException $e) {
            @unlink($writeFilePath);
            LoggerHelper::exceptionLogger($e, $e->getMessage(), ($recode) ?? []);
            return new AbsenceDataImportErrorResource($absenceDtaImportErrorMessageDto);
        } catch (\Exception $exception) {
            // ユースケース内で予期しないエラーの検知はサーバ―エラーとして扱う
            @unlink($writeFilePath);
            LoggerHelper::exceptionLogger($exception, $exception->getMessage());
            return response($exception->getMessage(), 500);
        }
    }

    /**
     * 成功リソース返却処理の共通化
     *
     * @param array $assignedList
     * @param array $removeComeBackList
     * @param string $writeFilePath
     * @param array $countByDiv
     *
     * @return AbsenceDataImportSuccessResource
     */
    private function returnSuccessResource(
        array $assignedList,
        array $removeComeBackList,
        string $writeFilePath,
        array $countByDiv
    ): AbsenceDataImportSuccessResource
    {
        return new AbsenceDataImportSuccessResource(
            $assignedList,
            $removeComeBackList,
            $writeFilePath,
            $countByDiv,
        );
    }
}
