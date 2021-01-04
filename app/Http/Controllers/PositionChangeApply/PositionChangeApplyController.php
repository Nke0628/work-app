<?php

namespace App\Http\Controllers\PositionChangeApply;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApplyPositionChangeApplyRequest;
use App\Package\UseCase\ApplyPositionChangeApplyUseCase;
use App\Package\UseCase\PositionChangeApply\Output\ErrorListDto;
use App\Package\UseCase\RemandPositionChangeApplyUseCase;
use Illuminate\View\View;

class PositionChangeApplyController extends Controller
{
    /** @var ApplyPositionChangeApplyUseCase */
    private $applyPositionChangeApplyUseCase;

    /** @var RemandPositionChangeApplyUseCase */
    private $remandPositionChangeApplyUseCase;

    /**
     * PositionChangeApplyController constructor.
     * @param RemandPositionChangeApplyUseCase $remandPositionChangeApplyUseCase
     * @param ApplyPositionChangeApplyUseCase $applyPositionChangeApplyUseCase
     */
    public function __construct(
        RemandPositionChangeApplyUseCase $remandPositionChangeApplyUseCase,
        ApplyPositionChangeApplyUseCase $applyPositionChangeApplyUseCase
    )
    {
        $this->remandPositionChangeApplyUseCase = $remandPositionChangeApplyUseCase;
        $this->applyPositionChangeApplyUseCase = $applyPositionChangeApplyUseCase;
    }

    /**
     * 役職変更申請トップ
     *
     * @return View
     */
    public function showPositionChangeApply() :View
    {
        return view('position_change_apply.index');
    }

    public function registerPositionChangeApply( ApplyPositionChangeApplyRequest $request )
    {
        $response = $this->applyPositionChangeApplyUseCase->execute( $request );
        if ( $response instanceof ErrorListDto ){
            dd($response->getMessageStr());
        }
    }

    public function remandPositionChangeApply()
    {
        $this->remandPositionChangeApplyUseCase->execute();
    }
}
