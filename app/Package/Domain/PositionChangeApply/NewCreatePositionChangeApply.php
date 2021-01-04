<?php


namespace App\Package\Domain\PositionChangeApply;


class NewCreatePositionChangeApply
{
    /** @var int */
    private $skyId;

    /** @var string */
    private $positionId;

    /** @var ApplyStatus */
    private $applyStatus;

    /**
     * NewCreatePositionChangeApply constructor.
     * @param int $skyId
     * @param string $positionId
     * @param ApplyStatus $applyStatus
     */
    private function __construct(
        int $skyId,
        string $positionId,
        ApplyStatus $applyStatus
    )
    {
        $this->skyId = $skyId;
        $this->positionId = $positionId;
        $this->applyStatus = $applyStatus;
    }

    /**
     * 新規申請役職申請生成
     *
     * @param int $skyId
     * @param string $positionId
     * @return static
     */
    public static function newCreate( int $skyId, string $positionId ): self
    {
        return new static(
            $skyId,
            $positionId,
            ApplyStatus::APPLYING()
        );
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
