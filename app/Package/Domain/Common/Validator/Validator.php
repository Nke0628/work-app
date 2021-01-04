<?php


namespace App\Package\Domain\Common\Validator;

/**
 * バリデータ基底クラス
 *
 * Class Validator
 * @package App\Package\Domain\Common\Validator
 */
abstract class Validator
{
    /** @var ValidationNotification */
    protected $validationNotification;

    public function __construct(ValidationNotification $validationNotification )
    {
        $this->validationNotification = $validationNotification;
    }

    public abstract function validate(): void;
}
