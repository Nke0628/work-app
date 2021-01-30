<?php


namespace App\Package\Suriawase\Domain\HumanResource;

/**
 * 役職レベルに関する仕様を定義するクラス
 *
 * Class PositionLevel
 * @package App\Package\Suriawase\Domain\HumanResource
 */
class PositionLevel
{
    private const UPPER_BOSS_BOUNDARY_LEVEL = 12;

    /**
     * @var int
     */
    private $level;

    /**
     * PositionLevel constructor.
     * @param int $level
     */
    public function __construct(int $level)
    {
        $this->level = $level;
    }

    /**
     * 上位評価者かどうか
     *
     * @return bool
     */
    public function isUpperBoss(): bool
    {
        return $this->level >= self::UPPER_BOSS_BOUNDARY_LEVEL;
    }
}
