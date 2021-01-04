<?php


namespace App\Package\Domain\PositionChangeApply;


class ApplyingPositionChangeApply extends BasePositionChangeApply
{
    /**
     * 差戻をする
     *
     * @return void
     */
    public function doRemand(): void
    {
        ApplyStatusTransition::canTransition( $this->applyStatus, ApplyStatus::REMAND() );
        $this->applyStatus = ApplyStatus::REMAND();
    }
}
