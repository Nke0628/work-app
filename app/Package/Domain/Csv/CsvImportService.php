<?php
/**
 * 休職情報CSVファイルインポート時のバリデーションルールクラス
 */

namespace Kyuyo\Domains\Absence\AbsenceDataImport;

use Kyuyo\Instructors\Absence\{
    ImportCsvRowDto,
    SelectedFiscalYearMonthDto,
    AbsenceDataImportErrorMessageDto,
};
use Kyuyo\Domains\Absence\AbsenceDiv;
use Kyuyo\Domains\Absence\AbsenceService;

/**
 * Class DataImportService
 * @package Kyuyo\Domains\Absence\DataImport
 */
class AbsenceDataImportService
{
    const DIV_CHANGE_DELETE = 'delete';
    const DIV_CHANGE_REGISTER = 'register';
    const DIV_CHANGE_UPDATE = 'update';
    const DIV_NO_CHANGE = 'noChange';
    const NON_EXISTS_DATA_ROW = 0;

    /**
     * ファイルの構成自体が取り込み対象にならない例外データの判定を行う
     *
     * @param array $recode
     * @param AbsenceDataImportErrorMessageDto $dataImportErrorMessageDto
     * @param SelectedFiscalYearMonthDto $selectedFiscalYearMonthDto
     */
    public function validateExceptionFormat(
        array $recode,
        AbsenceDataImportErrorMessageDto $dataImportErrorMessageDto,
        SelectedFiscalYearMonthDto $selectedFiscalYearMonthDto
    ): void
    {
        if (!(new AbsenceService())->isEditableDate($selectedFiscalYearMonthDto)) {
            $dataImportErrorMessageDto->addErrorMessage(1, AbsenceCsvValidate::NON_EDITABLE_DATE);
            throw new \UnexpectedValueException(AbsenceCsvValidate::MESSAGE[AbsenceCsvValidate::NON_EDITABLE_DATE]);
        }

        // 列数が足りないフォーマットエラーなので、入力値はチェックせずに早々に返す
        if (!AbsenceCsvValidate::requireFormat($recode)) {
            $dataImportErrorMessageDto->addErrorMessage(1, AbsenceCsvValidate::FORMAT_ERROR);
            throw new \UnexpectedValueException(AbsenceCsvValidate::MESSAGE[AbsenceCsvValidate::FORMAT_ERROR]);
        }
    }

    /**
     * 除外データの判定を行う
     *
     * @param ImportCsvRowDto $importCsvRowDto
     * @param SelectedFiscalYearMonthDto $absenceSelectMonthlyDto
     *
     * @return bool
     */
    public function isRemoveRow(
        ImportCsvRowDto $importCsvRowDto,
        SelectedFiscalYearMonthDto $absenceSelectMonthlyDto
    ): bool
    {
        return !AbsenceCsvValidate::isMatchSelectDate(
            $importCsvRowDto,
            $absenceSelectMonthlyDto
        );
    }

    /**
     * 取り込みデータの詳細なバリデーションを行う。
     * ユーザにエラーメッセージを返すことを目的としているので、ここで例外は投げずにエラーメッセージを蓄積する
     *
     * @param array $personalIdList
     * @param ImportCsvRowDto $importCsvRowDto
     * @param AbsenceDataImportErrorMessageDto $dataImportErrorMessageDto
     * @param int $recodeRow
     *
     * @return AbsenceDataImportErrorMessageDto
     */
    public function validateImportCsv(
        array $personalIdList,
        ImportCsvRowDto $importCsvRowDto,
        AbsenceDataImportErrorMessageDto $dataImportErrorMessageDto,
        int $recodeRow
    ): AbsenceDataImportErrorMessageDto
    {
        // 必須チェックと存在しない値チェックが同時に走らないように、値が存在する場合のみ存在値チェックを行う
        if (!AbsenceCsvValidate::requirePersonalId($importCsvRowDto->getPersonalId())) {
            $dataImportErrorMessageDto->addErrorMessage($recodeRow, AbsenceCsvValidate::REQUIRE_PERSONAL_ID);
        } elseif (!isset($personalIdList[$importCsvRowDto->getPersonalId()])) {
            $dataImportErrorMessageDto->addErrorMessage($recodeRow, AbsenceCsvValidate::NON_EXISTING_PERSONAL_ID, $importCsvRowDto->getPersonalId());
        } elseif (AbsenceCsvValidate::isDuplicatedPersonalId($importCsvRowDto)) {
            $dataImportErrorMessageDto->addErrorMessage(
                $recodeRow,
                AbsenceCsvValidate::DUPLICATED_SHAIN_ID,
                $importCsvRowDto->getPersonalId()
            );
        }

        // 休職区分値のバリデーション
        // CSV取り込み時には復職対象とするために空の休職区分が入ってくるケースがあるため、必須項目判定は設けない
        if (
            !AbsenceDiv::isComeback($importCsvRowDto->getAbsenceDiv())
            && !AbsenceCsvValidate::inRangeAbsenceDiv($importCsvRowDto->getAbsenceDiv())
        ) {
            $dataImportErrorMessageDto->addErrorMessage($recodeRow, AbsenceCsvValidate::NON_EXISTING_ABSENCE_DIV, $importCsvRowDto->getInputAbsenceDiv());
        }

        return $dataImportErrorMessageDto;
    }

    /**
     * @param array $registeredDataList
     *
     * @return ImportDiffStatus
     */
    public function factoryImportDiffStatus(array $registeredDataList)
    {
        return new ImportDiffStatus($registeredDataList);
    }

    /**
     * 登録済みのデータと新規登録対象のデータを比較して、
     * 登録対象のデータが新規登録、更新のどれに該当するかを割り当てる
     *
     * @param ImportDiffStatus $importDiffStatus,
     * @param ImportCsvRowDto $importCsvRowDto
     *
     * @return string
     */
    public function assignChangeAbsenceList(
        ImportDiffStatus $importDiffStatus,
        ImportCsvRowDto $importCsvRowDto
    ): string
    {
        $importDiffStatus->setAssignLog($importCsvRowDto);
        if (AbsenceDiv::isComeback($importCsvRowDto->getAbsenceDiv())) {
            return self::DIV_CHANGE_DELETE;
        }

        if ($importDiffStatus->isNewRegister($importCsvRowDto)) {
            return self::DIV_CHANGE_REGISTER;
        }

        if ($importDiffStatus->isChangeAbsence($importCsvRowDto)) {
            return self::DIV_CHANGE_UPDATE;
        }

        return self::DIV_NO_CHANGE;
    }

    /**
     * 入力データから行ごと削除されたケースの復職対象者を抽出する
     * 行ごと削除されているので、入力データとの並び順は考慮しない
     *
     * @param ImportDiffStatus $importDiffStatus
     *
     * @return array
     */
    public function addRemovedRowComeback(ImportDiffStatus $importDiffStatus): array
    {
        $comebackList = [];
        foreach ($importDiffStatus->filterComeback() as $comeback) {
            $comebackList[] = [
                'personalId' => $comeback['personalId'],
                'shainName' =>
                    $comeback['human_resource']['actual_family_name'] . $comeback['human_resource']['actual_given_name'],
                'absenceDiv' => AbsenceDiv::DIV_COMEBACK,
                'diffStatus' => self::DIV_CHANGE_DELETE
            ];
        }

        return $comebackList;
    }

    /**
     * 保存用にCSVファイルに書き込む
     *
     * @param \SplFileObject $splFileObject
     * @param ImportCsvRowDto $importCsvRowDto
     */
    public function writeConfirmCsvFile(
        \SplFileObject $splFileObject,
        ImportCsvRowDto $importCsvRowDto
    ): void
    {
        $splFileObject->fputcsv(
            [
                $importCsvRowDto->getPersonalId(),
                $importCsvRowDto->getAbsenceDiv(),
                $importCsvRowDto->getChangeDiv()
            ]
        );
    }

    /**
     * 取り込み対象で無い行をスキップする
     *  ・タイトル行
     *  ・空行
     *
     * @param int $index
     * @param array $recode
     *
     * @return bool
     */
    public function isSkipRow(
        int $index,
        array $recode
    ): bool
    {
        if ($this->isTitleRow($index)) {
            return true;
        }

        return
            empty(
            array_filter($recode, function ($value) {
                return $value !== '';
            }));
    }

    /**
     * タイトル行かどうか判定
     *
     * @param int $index
     *
     * @return bool
     */
    private function isTitleRow(int $index): bool
    {
        return $index === 0;
    }

    /**
     * 取り込み対象データ存在するかどうか判定する
     *
     * @param array $assignedList
     *
     * @return bool
     */
    public function existsImportTargetData(array $assignedList): bool
    {
        return count($assignedList) > self::NON_EXISTS_DATA_ROW;
    }
}
