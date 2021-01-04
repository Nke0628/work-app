<?php


namespace App\Package\Domain\PositionChangeApply;


use MyCLabs\Enum\Enum;

/**
 * @method static ApplyStatus APPLYING()
 * @method static ApplyStatus REMAND()
 * @method static ApplyStatus APPROVED()
 * @method static ApplyStatus DELETE()
 */
class ApplyStatus extends Enum
{
    public const APPLYING = 1;
    public const REMAND = 2;
    public const APPROVED = 3;
    public const DELETE = 9;
}
