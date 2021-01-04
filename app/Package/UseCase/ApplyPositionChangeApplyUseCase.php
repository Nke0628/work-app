<?php


namespace App\Package\UseCase;


use App\Http\Requests\ApplyPositionChangeApplyRequest;
use App\Package\Domain\Common\Validator\ValidationNotification;
use App\Package\Domain\PositionChangeApply\DoApplyPositionChangeApplyValidator;
use App\Package\Domain\PositionChangeApply\NewCreatePositionChangeApply;
use App\Package\Domain\PositionChangeApply\PositionChangeApplyRepository;
use App\Package\UseCase\PositionChangeApply\Output\ErrorListDto;
use Illuminate\Support\Facades\DB;

class ApplyPositionChangeApplyUseCase
{
    /** @var PositionChangeApplyRepository */
    private $positionChangeRepository;

    /**
     * ApplyPositionChangeApplyUseCase constructor.
     * @param PositionChangeApplyRepository $positionChangeApplyRepository
     */
    public function __construct( PositionChangeApplyRepository $positionChangeApplyRepository )
    {
        $this->positionChangeRepository = $positionChangeApplyRepository;
    }

    public function execute( ApplyPositionChangeApplyRequest $request )
    {
        $errorMsgDto = new ErrorListDto();
        try {

            /**
             * Step1. 入力値検証
             */
            $validationNotification = new ValidationNotification();
            $validator = new DoApplyPositionChangeApplyValidator(
                $request,
                $validationNotification
            );
            $validator->validate();
            if ( $validationNotification->exist() ){
                $errorMsgDto->setMessageString( $validationNotification->toString() );
                return $errorMsgDto;
            }

            /**
             * Step2.　申請する
             */
            DB::beginTransaction();
            $positionChangeApply = NewCreatePositionChangeApply::newCreate(
                $request->getSkyId(),
                $request->getPositionId()
            );
            if ( !$this->positionChangeRepository->apply( $positionChangeApply ) ){
                throw new \Exception( '役職変更申請の登録に失敗しました' );
            }

            DB::commit();

        }catch ( \Exception $e) {
            DB::rollBack();
        }
    }
}
