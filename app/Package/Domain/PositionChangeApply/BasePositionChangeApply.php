<?php


namespace App\Package\Domain\PositionChangeApply;


abstract class BasePositionChangeApply
{
    /** @var int */
    protected $id;

    /** @var int */
    protected $skyId;

    /** @var string */
    protected $positionId;

    /** @var ApplyStatus */
    protected $applyStatus;

    /**
     * BasePositionChangeApply constructor.
     * @param int $id
     * @param int $skyId
     * @param string $positionId
     * @param ApplyStatus $applyStatus
     */
    public function __construct(
        int $id,
        int $skyId,
        string $positionId,
        ApplyStatus $applyStatus
    )
    {
        $this->id = $id;
        $this->skyId = $skyId;
        $this->positionId = $positionId;
        $this->applyStatus = $applyStatus;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
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
    public function getPositionId(): string
    {
        return $this->positionId;
    }

    /**
     * @return ApplyStatus
     */
    public function getApplyStatus(): ApplyStatus
    {
        return $this->applyStatus;
    }
}
