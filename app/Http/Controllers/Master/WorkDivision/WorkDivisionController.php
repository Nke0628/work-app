<?php

namespace App\Http\Controllers\Master\WorkDivision;

use App\Http\Controllers\Controller;
use App\Package\Domain\Helpers\HtmlHelper;
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

    /** @var GetWorkDivisionAllUseCase */
    private $getWorkDivisionAllUseCase;

    /** @var RegisterWorkDivisionUseCase */
    private $registerWorkDivisionUseCase;

    /** @var DeleteWorkDivisionUseCase */
    private $deleteWorkDivisionUseCase;

    /** @var UpdateWorkDivisionUseCase */
    private $updateWorkDivisionUseCase;

    /**
     * @param GetWorkDivisionAllUseCase $getWorkDivisionAllUseCase
     * @param RegisterWorkDivisionUseCase $registerWorkDivisionUseCase
     * @param DeleteWorkDivisionUseCase $deleteWorkDivisionUseCase
     * @param UpdateWorkDivisionUseCase $updateWorkDivisionUseCase
     */
    public function __construct(
        GetWorkDivisionAllUseCase $getWorkDivisionAllUseCase,
        RegisterWorkDivisionUseCase $registerWorkDivisionUseCase,
        DeleteWorkDivisionUseCase $deleteWorkDivisionUseCase,
        UpdateWorkDivisionUseCase $updateWorkDivisionUseCase
    )
    {
        $this->getWorkDivisionAllUseCase = $getWorkDivisionAllUseCase;
        $this->registerWorkDivisionUseCase = $registerWorkDivisionUseCase;
        $this->deleteWorkDivisionUseCase = $deleteWorkDivisionUseCase;
        $this->updateWorkDivisionUseCase = $updateWorkDivisionUseCase;
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
     * @return array
     */
    private function _ValidateUpdateWorkDivision(array $pParam):array
    {
        $aRet = array();
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
     * 更新時のパラメータ作成
     *
     * @param Request $request
     * @return array
     */
    private function _CreateContentParam( Request $request ): array
    {
        return array(
            'id' => $request->input('id'),
            'work_division_name' => $request->input('work_division_name'),
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
