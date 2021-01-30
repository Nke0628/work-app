<?php


namespace App\Package\Suriawase\Domain\SuriawaseConfig;


use MyCLabs\Enum\Enum;

/**
 * @method static BOSS()
 * @method static MANAGER()
 */
class SuriawaseType extends Enum
{
    private const BOSS = 1;
    private const MANAGER = 2;

    /**
     * 管理職すり合わせかどうか
     *
     * @return bool
     */
    public function isManagerSuriawase(): bool
    {
        return $this->value === self::MANAGER;
    }
}
