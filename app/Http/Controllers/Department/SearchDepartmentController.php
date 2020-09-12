<?php

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;
use App\Package\Presenter\Department\SearchDepartmentViewModel;
use App\Package\Presenter\ViewModel;
use App\Package\UseCase\Department\Dto\SearchDepartmentRequest;
use App\Package\UseCase\Department\SearchDepartmentUseCase;
use Illuminate\Http\Request;

class SearchDepartmentController extends Controller
{
    /** @var SearchDepartmentUseCase */
    private $searchDepartmentUseCase;

    public function __construct( SearchDepartmentUseCase $searchDepartmentUseCase )
    {
        $this->searchDepartmentUseCase = $searchDepartmentUseCase;
    }

    /**
     * 組織を検索する
     *
     * @param Request $pRequest
     */
    public function searchDepartment( Request $pRequest )
    {
        $aSearchCondition = array();
        $aSearchCondition['search_query'] = $pRequest->input( 'search_query' ) ?? '';
        $aSearchCondition['department_name'] = $pRequest->input( 'department_name' ) ?? '';
        $aSearchCondition['start_work_time'] = $pRequest->input( 'start_work_time' ) ?? '';
        $aSearchCondition['end_work_time'] = $pRequest->input( 'end_work_time' ) ?? '';
        $aSearchCondition['start_break_time'] = $pRequest->input( 'start_break_time' ) ?? '';
        $aSearchCondition['end_break_time'] = $pRequest->input( 'end_break_time' ) ?? '';

        $aRequest = new SearchDepartmentRequest(
            $aSearchCondition['search_query'],
            $aSearchCondition['department_name'],
            $aSearchCondition['start_work_time'],
            $aSearchCondition['end_work_time'],
            $aSearchCondition['start_break_time'],
            $aSearchCondition['end_break_time']
        );

        $aResponse = $this->searchDepartmentUseCase->execute( $aRequest );

//        return ( new SearchDepartmentViewModel( $aResponse ) )->view( 'department.index' );
        return view( 'department.index', new SearchDepartmentViewModel( $aResponse) );
    }
}
