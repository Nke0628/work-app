<?php


namespace App\Package\Suriawase\Domain\HumanResource;


class HumanResource
{
    /**
     * @var int
     */
    private $skyId;

    /**
     * @var string
     */
    private $personalId;

    /**
     * @var PositionLevel
     */
    private $positionLevel;

    /**
     * @var bool
     */
    private $managerFlg;

    /**
     * HumanResource constructor.
     * @param string $personalId
     * @param PositionLevel $positionLevel
     * @param bool $managerFlg
     */
    public function __construct(
        string $personalId,
        PositionLevel $positionLevel,
        bool $managerFlg
    )
    {
        $this->personalId = $personalId;
        $this->positionLevel = $positionLevel;
        $this->managerFlg = $managerFlg;
    }

    /**
     * @return int
     */
    public function getSkyId(): int
    {
        return $this->skyId;
    }

    /**
     * @return string
     */
    public function getPersonalId(): string
    {
        return $this->personalId;
    }

    /**
     * @return PositionLevel
     */
    public function getPositionLevel(): PositionLevel
    {
        return $this->positionLevel;
    }

    /**
     * @return bool
     */
    public function isManager(): bool
    {
        return $this->managerFlg;
    }
}
