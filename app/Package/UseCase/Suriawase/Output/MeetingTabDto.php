<?php


namespace App\Package\UseCase\Suriawase\Output;


class MeetingTabDto
{
    /**
     * @var int
     */
    private $tabId;

    /**
     * @var string
     */
    private $tabName;

    /**
     * @var int
     */
    private $tabNo;

    /**
     * MeetingTabDto constructor.
     * @param int $tabId
     * @param string $tabName
     * @param int $tabNo
     */
    public function __construct(int $tabId, string $tabName, int $tabNo)
    {
        $this->tabId = $tabId;
        $this->tabName = $tabName;
        $this->tabNo = $tabNo;
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
    public function getTabName(): string
    {
        return $this->tabName;
    }

    /**
     * @return int
     */
    public function getTabNo(): int
    {
        return $this->tabNo;
    }
}
