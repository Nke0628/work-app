<?php


namespace App\Package\Domain\PositionChangeApply;


use App\Model\PositionChangeApply;

class PositionChangeApplyRepository
{
    /**
     * 申請を登録
     *
     * @param NewCreatePositionChangeApply $positionChangeApply
     * @return bool
     */
    public function apply(NewCreatePositionChangeApply $positionChangeApply ): bool
    {
        $model = new PositionChangeApply();
        $model->fill([
                'sky_id' => $positionChangeApply->getSkyId(),
                'position_id'=> $positionChangeApply->getPositionId(),
                'status' => $positionChangeApply->getApplyStatus()->getValue()
            ]
        );
        return $model->save();
    }

    /**
     * 申請を更新
     *
     * @param BasePositionChangeApply $positionChangeApply
     * @return bool
     */
    public function save( BasePositionChangeApply $positionChangeApply ): bool
    {
        $model = PositionChangeApply::find( $positionChangeApply->getId() );
        $model->fill([
                'sky_id' => $positionChangeApply->getSkyId(),
                'position_id'=> $positionChangeApply->getPositionId(),
                'status' => $positionChangeApply->getApplyStatus()->getValue()
            ]
        );
        return $model->save();
    }

    /**
     * @param int $id
     * @return ApplyingPositionChangeApply|RemandPositionChangeApply|null
     */
    public function find( int $id )
    {
        $model = PositionChangeApply::find( $id );
        if ( !$model ) {
            throw new \UnexpectedValueException( '役職変更申請が取得できませんでした' );
        }

        return PositionChangeFactory::createFromDb(
            $model->id,
            $model->sky_id,
            $model->position_id,
            new ApplyStatus( $model->status )
        );
    }

}
