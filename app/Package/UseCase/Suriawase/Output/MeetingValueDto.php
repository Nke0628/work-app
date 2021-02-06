<?php


namespace App\Package\UseCase\Suriawase\Output;


class MeetingValueDto
{
    /**
     * @var int
     */
    private $tabId;

    /**
     * @var string
     */
    private $personalId;

    /**
     * @var string
     */
    private $value;

    /**
     * MeetingValueDto constructor.
     * @param int $tabId
     * @param string $personalId
     * @param string $value
     */
    public function __construct(int $tabId, string $personalId, string $value)
    {
        $this->tabId = $tabId;
        $this->personalId = $personalId;
        $this->value = $value;
    }

    /**
     * @return int
     */
    public function getTabId(): int
    {
        return $this->tabId;
    }

    /**
     * @return string
     */
    public function getPersonalId(): string
    {
        return $this->personalId;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }
}
