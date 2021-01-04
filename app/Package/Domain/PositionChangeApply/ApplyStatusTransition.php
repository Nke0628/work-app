<?php


namespace App\Package\Domain\PositionChangeApply;

/**
 * 役職変更申請ステータスの遷移仕様
 *
 * Class ApplyStatusTransition
 * @package App\Package\Domain\PositionChangeApply
 */
class ApplyStatusTransition
{
    private const ALLOW_TRANSITION_LIST = [
        ApplyStatus::APPLYING => [ ApplyStatus::REMAND, ApplyStatus::APPROVED ],
        ApplyStatus::REMAND => [ ApplyStatus::APPLYING, ApplyStatus::DELETE ],
        ApplyStatus::APPROVED => [],
        ApplyStatus::DELETE => [],
    ];

    /**
     * ステータスからステータスへ変更できるかを検証する
     * LogicExceptionが発生する場合は変更不可能な実装をしています
     * 実装コードを修正してください
     *
     * @param ApplyStatus $from
     * @param ApplyStatus $to
     */
    public static function canTransition( ApplyStatus $from, ApplyStatus $to ): void
    {
        $allowList = self::ALLOW_TRANSITION_LIST[$from->getValue()];

        if ( !in_array( $to->getValue(), $allowList ) ) {
            throw new \LogicException( 'ステータス変更が妥当ではありません' );
        }
    }
}
