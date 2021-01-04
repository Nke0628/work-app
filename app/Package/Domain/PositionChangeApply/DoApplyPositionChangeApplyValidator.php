<?php


namespace App\Package\Domain\PositionChangeApply;


use App\Http\Requests\ApplyPositionChangeApplyRequest;
use App\Package\Domain\Common\Validator\ValidationNotification;
use App\Package\Domain\Common\Validator\Validator;

class DoApplyPositionChangeApplyValidator extends Validator
{
    /** @var ApplyPositionChangeApplyRequest */
    private $request;

    /**
     * DoApplyPositionChangeApplyValidator constructor.
     * @param ApplyPositionChangeApplyRequest $request
     * @param ValidationNotification $validationNotification
     */
    public function __construct
    (
        ApplyPositionChangeApplyRequest $request,
        ValidationNotification $validationNotification
    )
    {
        parent::__construct($validationNotification);
        $this->request = $request;
    }

    /**
     * 役職変更申請バリデーション
     *
     * @return void
     */
    public function validate(): void
    {
        if ( $this->request->getSkyId() !== 1 ) {
            $this->validationNotification->setErrorMsg( 'sky_id','skyIDが不正です');
        }

        if ( $this->request->getSkyId() !== 1 ) {
            $this->validationNotification->setErrorMsg( 'sky_id','skyIDが不正です2');
        }
    }
}
