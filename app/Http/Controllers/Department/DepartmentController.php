<?php

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;
use App\Http\Requests\DepartmentInputRequest;
use App\Package\UseCase\Department\Dto\RegisterDepartmentRequest;
use App\Package\UseCase\Department\RegisterDepartmentUseCase;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DepartmentController extends Controller
{
    /** @var RegisterDepartmentUseCase */
    private $registerDepartmentUseCase;

    public function __construct( RegisterDepartmentUseCase $registerDepartmentUseCase )
    {
        $this->registerDepartmentUseCase = $registerDepartmentUseCase;
    }

    /**
     * 組織一覧ページ
     *
     * @return View
     */
    public function showDepartments(): View
    {
        $aDefaultSearchCondition = array(
            'search_query' =>  '',
            'department_name' => '',
            'start_work_time' => '',
            'end_work_time' => '',
            'start_break_time' => '',
            'end_break_time' =>'',
        );
        return view('department.index');
    }

    /**
     * 組織登録ページ
     *
     * @return View
     */
    public function showRegisterDepartmentForm(): View
    {
        return view('department.register');
    }

    /**
     * 組織を登録する
     *
     * @param DepartmentInputRequest $pRequest
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function registerDepartment( DepartmentInputRequest $pRequest )
    {
        $aRequest = new RegisterDepartmentRequest(
            $pRequest->getDepartmentName(),
            $pRequest->getStartWorkTime(),
            $pRequest->getEndWorkTime(),
            $pRequest->getStartBreakTime(),
            $pRequest->getEndBreakTime(),
            Auth::id()
        );
        $this->registerDepartmentUseCase->execute( $aRequest );
        return redirect( '/department' );
    }
}
