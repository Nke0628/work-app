<?php

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;
use App\Http\Requests\DepartmentInputRequest;
use App\Package\UseCase\Department\RegisterDepartmentUseCase;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DepartmentController extends Controller
{
    /** @var RegisterDepartmentUseCase */
    private $registerDepartmentUseCase;

    public function __construct(
        RegisterDepartmentUseCase $registerDepartmentUseCase
    )
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
     */
    public function registerDepartment( DepartmentInputRequest $pRequest )
    {
        $aResult = $this->registerDepartmentUseCase->execute( $pRequest, Auth::id() );
        if ( $aResult === true )
        {
            return redirect( '/department' );
        }
    }
}
