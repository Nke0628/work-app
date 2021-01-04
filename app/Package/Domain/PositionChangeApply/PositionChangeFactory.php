<?php


namespace App\Package\Domain\PositionChangeApply;


class PositionChangeFactory
{
    /**
     * ステータスに応じた役職申請を生成
     *
     * @param int $id
     * @param int $skyId
     * @param string $positionId
     * @param ApplyStatus $applyStatus
     * @return ApplyingPositionChangeApply|RemandPositionChangeApply
     */
    public static function createFromDb(
        int $id,
        int $skyId,
        string $positionId,
        ApplyStatus $applyStatus )
    {
        switch ( $applyStatus->getValue() ) {
            case ApplyStatus::APPLYING()->getValue():
                return new ApplyingPositionChangeApply(
                    $id,
                    $skyId,
                    $positionId,
                    $applyStatus
                );
            case ApplyStatus::REMAND()->getValue():
                return new RemandPositionChangeApply(
                    $id,
                    $skyId,
                    $positionId,
                    $applyStatus
                );
        }
    }
}
