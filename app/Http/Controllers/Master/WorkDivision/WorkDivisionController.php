<?php

namespace App\Http\Controllers\Master\WorkDivision;

use App\Http\Controllers\Controller;
use App\Package\Domain\Helpers\EncodeHelper;
use App\Package\Domain\Helpers\HtmlHelper;
use App\Package\UseCase\Master\WorkDivision\CsvUploadWorkDivisionUseCase;
use App\Package\UseCase\Master\WorkDivision\DeleteWorkDivisionUseCase;
use App\Package\UseCase\Master\WorkDivision\GetWorkDivisionAllUseCase;
use App\Package\UseCase\Master\WorkDivision\OutPutData\WorkDivisionDto;
use App\Package\UseCase\Master\WorkDivision\RegisterWorkDivisionUseCase;
use App\Package\UseCase\Master\WorkDivision\UpdateWorkDivisionUseCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WorkDivisionController extends Controller
{
    const MAX_WORK_DIVISION_NAME_SIZE = 255;

    const DEFAULT_ROW_NO = 1;
    const COL_NAME_WORK_DIVISION_ID = 'ID';
    const COL_NAME_WORK_DIVISION_NAME = '勤怠区分名称';

    private static $UPLOAD_CSV_INPUT_COL_LIST = array(
        self::COL_NAME_WORK_DIVISION_ID => 'id',
        self::COL_NAME_WORK_DIVISION_NAME => 'work_division_name'
    );

    private static $DEFAULT_SEARCH_CONDITION = array(
        'word' => '',
        'page_num' => 1,
        'sort' => 'updated_at',
        'order' => 'desc',
    );

    /** @var GetWorkDivisionAllUseCase */
    private $getWorkDivisionAllUseCase;

    /** @var RegisterWorkDivisionUseCase */
    private $registerWorkDivisionUseCase;

    /** @var DeleteWorkDivisionUseCase */
    private $deleteWorkDivisionUseCase;

    /** @var UpdateWorkDivisionUseCase */
    private $updateWorkDivisionUseCase;

    /** @var CsvUploadWorkDivisionUseCase */
    private $csvUploadWorkDivisionUseCase;

    /**
     * @param GetWorkDivisionAllUseCase $getWorkDivisionAllUseCase
     * @param RegisterWorkDivisionUseCase $registerWorkDivisionUseCase
     * @param DeleteWorkDivisionUseCase $deleteWorkDivisionUseCase
     * @param UpdateWorkDivisionUseCase $updateWorkDivisionUseCase
     * @param CsvUploadWorkDivisionUseCase $csvUploadWorkDivisionUseCase
     */
    public function __construct(
        GetWorkDivisionAllUseCase $getWorkDivisionAllUseCase,
        RegisterWorkDivisionUseCase $registerWorkDivisionUseCase,
        DeleteWorkDivisionUseCase $deleteWorkDivisionUseCase,
        UpdateWorkDivisionUseCase $updateWorkDivisionUseCase,
        CsvUploadWorkDivisionUseCase $csvUploadWorkDivisionUseCase
    )
    {
        $this->getWorkDivisionAllUseCase = $getWorkDivisionAllUseCase;
        $this->registerWorkDivisionUseCase = $registerWorkDivisionUseCase;
        $this->deleteWorkDivisionUseCase = $deleteWorkDivisionUseCase;
        $this->updateWorkDivisionUseCase = $updateWorkDivisionUseCase;
        $this->csvUploadWorkDivisionUseCase = $csvUploadWorkDivisionUseCase;
    }

    /**
     * 勤怠区分一覧を表示
     *
     * @return View
     */
    public function showList(): View
    {
        $aWorkDivisionListDto = $this->getWorkDivisionAllUseCase->execute();
        $aParam['work_division_list'] = $this->_ToArrayWorkDivisionListDto( $aWorkDivisionListDto->getWorkDivisionList() );
        return view('master.workdivision.index', $aParam );
    }

    /**
     * 勤怠区分を登録
     *
     * @param Request $request
     * @return JsonResponse
     * @throws \Throwable
     */
    public function registerWorkDivision( Request $request ): JsonResponse
    {
        $aContentParam = $this->_CreateContentParam( $request );
        $aRet['error'] = $this->_ValidateUpdateWorkDivision( $aContentParam );
        if ( $aRet['error'] )
        {
            $aRet['error'] = implode( "\n", $aRet['error'] );
            return HtmlHelper::FixJsonEncode( $aRet );

        }
        $aWorkDivisionDto = $this->registerWorkDivisionUseCase->execute( $aContentParam );
        if ( !$aWorkDivisionDto )
        {
            $aRet['error'] = '登録に失敗しました';
            return HtmlHelper::FixJsonEncode( $aRet );
        }
        $aWorkDivisionListDto = $this->getWorkDivisionAllUseCase->execute();
        $aParam['work_division_list'] = $this->_ToArrayWorkDivisionListDto( $aWorkDivisionListDto->getWorkDivisionList() );
        return HtmlHelper::FixJsonEncode( view( 'master.workdivision.component.work_division_list', $aParam )->render() );
    }

    /**
     * 勤怠区分を更新
     *
     * @param Request $request
     * @return JsonResponse
     * @throws \Throwable
     */
    public function updateWorkDivision( Request $request ): JsonResponse
    {
        $aContentParam = $this->_CreateContentParam( $request );
        $aRet['error'] = $this->_ValidateUpdateWorkDivision( $aContentParam );
        if ( $aRet['error'] )
        {
            $aRet['error'] = implode( "\n", $aRet['error'] );
            return HtmlHelper::FixJsonEncode( $aRet );

        }
        $aWorkDivisionDto = $this->updateWorkDivisionUseCase->execute( $aContentParam );
        if ( !$aWorkDivisionDto )
        {
            $aRet['error'] = '更新に失敗しました';
            return HtmlHelper::FixJsonEncode( $aRet );
        }
        $aWorkDivisionListDto = $this->getWorkDivisionAllUseCase->execute();
        $aParam['work_division_list'] = $this->_ToArrayWorkDivisionListDto( $aWorkDivisionListDto->getWorkDivisionList() );
        return HtmlHelper::FixJsonEncode( view( 'master.workdivision.component.work_division_list', $aParam )->render() );
    }

    /**
     * 勤怠区分を削除
     *
     * @param Request $request
     * @return JsonResponse
     * @throws \Throwable
     */
    public function deleteWorkDivision( Request $request ): JsonResponse
    {
        $aResult = $this->deleteWorkDivisionUseCase->execute($request->input('id'));
        if ( !$aResult )
        {
            $aRet['error'] = '削除に失敗しました';
            return HtmlHelper::FixJsonEncode( $aRet );
        }
        $aWorkDivisionListDto = $this->getWorkDivisionAllUseCase->execute();
        $aParam['work_division_list'] = $this->_ToArrayWorkDivisionListDto( $aWorkDivisionListDto->getWorkDivisionList() );
        return HtmlHelper::FixJsonEncode( view( 'master.workdivision.component.work_division_list', $aParam )->render() );
    }

    /**
     * 勤怠区分更新バリデーション
     *
     * @param array $pParam
     * @param bool $pUpdateFlg 更新かどうか
     * @return array
     */
    private function _ValidateUpdateWorkDivision( array $pParam, bool $pUpdateFlg=false ):array
    {
        $aRet = array();

        if ( $pUpdateFlg )
        {
            if ( !is_numeric($pParam['id']) )
            {
                $aRet[] = 'IDは必須(数字)です。';
            }
        }

        if ( $pParam['work_division_name'] === '' || is_null($pParam['work_division_name']) )
        {
            $aRet[] = '勤怠区分名称は必須です。';
        }
        else
        {
            if ( strlen($pParam['work_division_name']) > self::MAX_WORK_DIVISION_NAME_SIZE )
            {
                $aRet[] = '勤怠区分名称の文字数は半角255文字以下で入力してください。';
            }
        }
        return $aRet;
    }

    /**
     * CSVアップロードプレビュー表示
     *
     * @param Request $pRequest
     * @return JsonResponse
     * @throws \Throwable
     */
    public function getPreviewHtml( Request $pRequest )
    {
        $aRet = array();
        if ( !$pRequest->file('file') )
        {
            $aRet['error'] = '一括登録するファイルを選択してください';
            return HtmlHelper::FixJsonEncode( $aRet );
        }
        // TODO ファイル形式チェック
        $aTemporaryCsvFile = $pRequest->file('file')->storeAs('upload','upload_file.csv');
        $aCsvFilePath = storage_path('app/') . $aTemporaryCsvFile;

        $aFp = fopen( $aCsvFilePath, 'r');
        $aHeaderList = fgetcsv( $aFp );
        $aColNoList = $this->_ValidateWorkDivisionCsvHeader( $aHeaderList );
        if (  $aColNoList['error'] )
        {
            $aRet['error'] = $aColNoList['error'];
            return HtmlHelper::FixJsonEncode( $aRet );
        }

        $aLists = array();
        $aErrMsgList = array();
        $aErrFlg = false;
        $aRowCnt = self::DEFAULT_ROW_NO;
        while ( $aRow = fgetcsv( $aFp ) )
        {
            if ( count( array_filter($aRow) ) === 0 )
            {
                continue;
            }
            $aRow = EncodeHelper::EncodeToUtf8( $aRow );
            $aLine = $this->_CreatePreviewInputParam( $aRow, $aColNoList, $aRowCnt );
            $aError = $this->_ValidateUpdateWorkDivision( $aLine, true );
            if ( count( $aError ) > 0 )
            {
                $aErrFlg = true;
                $aLine['is_error'] = true;
                $aErrMsgList[] = $aRowCnt . "行目 " . implode("\n",$aError);
            }
            $aRowCnt++;
            $aLists[] = $aLine;
        }

        $aParam = array(
            'lists' => $aLists,
            'is_error' => $aErrFlg,
            'err_msg_list' => $aErrMsgList
        );

        return HtmlHelper::FixJsonEncode( view( 'master.workdivision.component.preview', $aParam )->render() );
    }

    /**
     * csvアップロード保存
     *
     * @param Request $pRequest
     * @return JsonResponse
     * @throws \Throwable
     */
    public function saveCsvData( Request $pRequest ) :JsonResponse
    {
        $aRet = array();
        $aContentParams = $this->_CreateUploadContentParam( $pRequest );
        foreach ( $aContentParams as $aContentParam )
        {
            $aError = $this->_ValidateUpdateWorkDivision( $aContentParam, true );
            if ( $aError )
            {
                $aRet['error'] = implode( "\n",$aError );
                return HtmlHelper::FixJsonEncode( $aRet );
            }
        }

        $aResult = $this->csvUploadWorkDivisionUseCase->execute( $aContentParams );
        if ( !$aResult )
        {
            $aRet['error'] = '更新に失敗しました';
            return HtmlHelper::FixJsonEncode( $aRet );
        }

        $aWorkDivisionListDto = $this->getWorkDivisionAllUseCase->execute();
        $aParam['work_division_list'] = $this->_ToArrayWorkDivisionListDto( $aWorkDivisionListDto->getWorkDivisionList() );
        return HtmlHelper::FixJsonEncode( view( 'master.workdivision.component.work_division_list', $aParam )->render() );
    }

    /**
     * CSVヘッダーバリデーション
     *
     * @param array $pHeaderList CSVヘッダーリスト
     * @return array
     */
    private function _ValidateWorkDivisionCsvHeader( array $pHeaderList ) :array
    {
        $aRet = array();

        // カラムNOの設定
        $aColCnt = 0;
        foreach ( $pHeaderList as $aHeader )
        {
            $aHeader = EncodeHelper::EncodeToUtf8( $aHeader );
            if ( array_key_exists( $aHeader, self::$UPLOAD_CSV_INPUT_COL_LIST ))
            {
                $aRet[self::$UPLOAD_CSV_INPUT_COL_LIST[$aHeader]] = $aColCnt;
            }
            $aColCnt++;
        }

        //エラーメッセージの設定
        $aRet['error'] = '';
        foreach ( self::$UPLOAD_CSV_INPUT_COL_LIST as $aInputCol => $val )
        {
            if ( !in_array( $aInputCol, $pHeaderList ))
            {
                $aRet['error'] .=  $aInputCol. 'は必須項目です'  . "\n";
            }
        }

        return $aRet;
    }

    /**
     * プレビュー画面用パラメータ生成
     *
     * @param array $pRow 行データ
     * @param array $pColNoList 入力項目のカラムNOリスト
     * @param int $pRowCnt 行数
     * @return array
     */
    private function _CreatePreviewInputParam( array $pRow, array $pColNoList, int $pRowCnt ) :array
    {
        $aLine = array();
        $aLine['no'] = $pRowCnt;
        $aLine['id'] = $pRow[$pColNoList['id']];
        $aLine['work_division_name'] = $pRow[$pColNoList['work_division_name']];
        $aLine['is_error'] = false;
        return $aLine;
    }

    /**
     * CSVアップロード保存時のパラメータ生成
     *
     * @param Request $pRequest
     * @return array
     */
    private function _CreateUploadContentParam( Request $pRequest) :array
    {
        $aRet = array();
        foreach ( $pRequest->all() as $aData )
        {
            $aRowData = array();
            $aRowData['id'] = $aData['id'];
            $aRowData['work_division_name'] = $aData['name'];
            $aRet[] = $aRowData;
        }
        return $aRet;
    }

    /**
     * 更新時のパラメータ作成
     *
     * @param Request $pRequest
     * @return array
     */
    private function _CreateContentParam( Request $pRequest ): array
    {
        return array(
            'id' => $pRequest->input('id'),
            'work_division_name' => $pRequest->input('work_division_name'),
        );
    }

    /**
     * DTOList→配列
     *
     * @param array $pWorkDivisionListDto
     * @return array
     */
    private function _ToArrayWorkDivisionListDto( array $pWorkDivisionListDto ):array
    {
        $aRet = array();
        foreach ( $pWorkDivisionListDto as $aWorkDivision )
        {
            $aRet[] = $this->_ToArrayWorkDivisionDto( $aWorkDivision );
        }
        return $aRet;
    }

    /**
     * DTO→配列
     *
     * @param WorkDivisionDto $pWorkDivisionDto
     * @return array
     */
    private function _ToArrayWorkDivisionDto( WorkDivisionDto $pWorkDivisionDto ):array
    {
        $aRet = array();
        $aRet['id'] = $pWorkDivisionDto->getId();
        $aRet['division_name'] = $pWorkDivisionDto->getDivisionName();
        $aRet['update_date'] = $pWorkDivisionDto->getUpdateDate();
        return $aRet;
    }
}
