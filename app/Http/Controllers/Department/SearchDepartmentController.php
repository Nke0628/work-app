<?php

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;
use App\Package\Presenter\Department\SearchDepartmentViewModel;
use App\Package\UseCase\Department\Dto\SearchDepartmentRequest;
use App\Package\UseCase\Department\SearchDepartmentUseCase;
use Illuminate\Http\Request;

class SearchDepartmentController extends Controller
{
    private const DEFAULT_SEARCH_CONDITION = [
        'search_query' => '',
        'department_name' => '',
        'start_work_time' => '',
        'end_work_time' => '',
        'start_break_time' => '',
        'end_break_time' => ''
    ];

    /** @var SearchDepartmentUseCase */
    private $searchDepartmentUseCase;

    /**
     * SearchDepartmentController constructor.
     * @param SearchDepartmentUseCase $searchDepartmentUseCase
     */
    public function __construct( SearchDepartmentUseCase $searchDepartmentUseCase )
    {
        $this->searchDepartmentUseCase = $searchDepartmentUseCase;
    }

    /**
     * 組織を検索する
     *
     * @param Request $pRequest
     * @return SearchDepartmentViewModel
     */
    public function searchDepartment( Request $pRequest )
    {
        $aRequest = new SearchDepartmentRequest(
            $pRequest->input( 'search_query' ) ?? self::DEFAULT_SEARCH_CONDITION['search_query'],
            $pRequest->input( 'department_name' ) ?? self::DEFAULT_SEARCH_CONDITION['department_name'],
            $pRequest->input( 'start_work_time' ) ?? self::DEFAULT_SEARCH_CONDITION['start_work_time'],
            $pRequest->input( 'end_work_time' ) ?? self::DEFAULT_SEARCH_CONDITION['end_work_time'],
            $pRequest->input( 'start_break_time' ) ?? self::DEFAULT_SEARCH_CONDITION['start_break_time'],
            $pRequest->input( 'end_break_time' ) ?? self::DEFAULT_SEARCH_CONDITION['end_break_time']
        );

        return $this->searchDepartmentUseCase->execute( $aRequest );
    }
}
