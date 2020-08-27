<?php

namespace App\Http\Controllers\Csv;

use App\Http\Controllers\Controller;
use App\Http\Requests\AnyItemCsvImportRequest;
use App\Package\Domain\Csv\AnyItemImportService;
use App\Package\UseCase\Department\SearchDepartmentUseCase;
use App\Package\UseCase\Error\Dto\ErrorMessageDto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CsvController extends Controller
{
    /** @var SearchDepartmentUseCase */
    private $searchDepartmentUseCase;

    public function __construct( SearchDepartmentUseCase $searchDepartmentUseCase )
    {
        $this->searchDepartmentUseCase = $searchDepartmentUseCase;
    }

    /**
     * CSVインポート画面
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showCsv()
    {
        return view( 'csv.index');
    }

    /**
     * CSVアップロード
     *
     * @param AnyItemCsvImportRequest $pRequest
     * @param AnyItemImportService $anyItemImportService
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function uploadCsv( AnyItemCsvImportRequest $pRequest, AnyItemImportService $anyItemImportService )
    {
        if ( !$pRequest->file('file') )
        {
            $aRet['error'][] = '一括登録するファイルを選択してください';
            return view( 'csv.index', $aRet);
        }

        $aTemporaryCsvFile = $pRequest->file('file')->storeAs('upload','upload_file.csv');
        $aCsvFilePath = storage_path('app/') . $aTemporaryCsvFile;

        $errorMessageDto = new ErrorMessageDto();

        try
        {
            $file = new \SplFileObject( $aCsvFilePath );
            $file->setFlags(
                \SplFileObject::READ_CSV |
                \SplFileObject::READ_AHEAD |
                \SplFileObject::SKIP_EMPTY |
                \SplFileObject::DROP_NEW_LINE
            );

            /**
             * STEP1 前提条件確認
             */
            $anyItemImportService->validationHeader( $file->current(), $errorMessageDto );

            /**
             * Step2 すり合わせ項目登録
             */
            $header = $file->current();
            $colNoList = $anyItemImportService->getColumnNoIndex( $header );
            $userIdColNo = $colNoList['user_id'];
            $anyItemColNoList = $colNoList['any_item'];

            foreach ( $anyItemColNoList as $anyItemColNo )
            {
                // ヘッダー登録
                $anyItemHeader = $header[$anyItemColNo];
                foreach ( $file as $index => $record )
                {
                    if ( $index === 0 )
                    {
                        continue;
                    }
                    Log::info($record[$userIdColNo]);
                    Log::info($record[$anyItemColNo]);
                }
            }


//            foreach ( $file->current() as $index => $item )
//            {
//                if ( $anyItemImportService->isAnyItem( $index, $colNoList) )
//                {
//                    // すり合わせ項目エンティティ生成
//                    // 配列に詰め込む
//                    // 保存処理
//                    // $savedAnyItem{$index} = //$respotry->save( $anyItemSectItemList );
//                }
//            }

            /**
             * Step3 全タブにすり合わせ選択可能項目登録
             */
            // $tabList = $tabRepository->getList();
//            foreach ( $tabList as $tab )
//            {
//                foreach ()
//            }


            /**
             * Step2 実データ処理
             */
//            foreach ( $file as $record )
//            {
//                $userId = $record[$colNoList['user_id']];
//                $anyItem = [];
//                foreach ( $record as $index => $item )
//                {
//                    if ( $index != $colNoList['user_id'] )
//                    {
//                        $anyItem['any_item_'. $index] = $item;
//                    }
//                }
//            }

        }catch ( \Exception $e)
        {

        }
//        $aFp = fopen( $aCsvFilePath, 'r');
//        $aHeaderList = fgetcsv( $aFp );
//        $res = SuriawaseAnyItemRow::headerValidation( $aHeaderList );
//        Log::info( print_r($res,true));
//        $aColNoList = $this->_ValidateWorkDivisionCsvHeader( $aHeaderList );
//        if (  $aColNoList['error'] )
//        {
//            $aRet['error'] = $aColNoList['error'];
//            return HtmlHelper::FixJsonEncode( $aRet );
//        }
//
//        $aLists = array();
//        $aErrMsgList = array();
//        $aErrFlg = false;
//        $aRowCnt = self::DEFAULT_ROW_NO;
//        while ( $aRow = fgetcsv( $aFp ) )
//        {
//            if ( count( array_filter($aRow) ) === 0 )
//            {
//                continue;
//            }
//            $aRow = EncodeHelper::EncodeToUtf8( $aRow );
//            $aLine = $this->_CreatePreviewInputParam( $aRow, $aColNoList, $aRowCnt );
//            $aError = $this->_ValidateUpdateWorkDivision( $aLine, true );
//            if ( count( $aError ) > 0 )
//            {
//                $aErrFlg = true;
//                $aLine['is_error'] = true;
//                $aErrMsgList[] = $aRowCnt . "行目 " . implode("\n",$aError);
//            }
//            $aRowCnt++;
//            $aLists[] = $aLine;
//        }
//
//        $aParam = array(
//            'lists' => $aLists,
//            'is_error' => $aErrFlg,
//            'err_msg_list' => $aErrMsgList
//        );
    }
}
