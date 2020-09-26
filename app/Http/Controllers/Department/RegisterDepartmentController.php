<?php


namespace App\Http\Controllers\Department;


use App\Http\Requests\DepartmentInputRequest;
use App\Package\UseCase\Department\Dto\RegisterDepartmentRequest;
use App\Package\UseCase\Department\RegisterDepartmentUseCase;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class RegisterDepartmentController
{
    /** @var RegisterDepartmentUseCase */
    private $registerDepartmentUseCase;

    public function __construct( RegisterDepartmentUseCase $registerDepartmentUseCase )
    {
        $this->registerDepartmentUseCase = $registerDepartmentUseCase;
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
