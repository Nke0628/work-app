<?php


namespace App\Package\UseCase\Suriawase\Output;


class MeetingItemDto
{
    /**
     * @var int
     */
    private $tabId;

    /**
     * @var string
     */
    private $itemName;

    /**
     * MeetingItemDto constructor.
     * @param int $tabId
     * @param string $itemName
     */
    public function __construct(int $tabId, string $itemName)
    {
        $this->tabId = $tabId;
        $this->itemName = $itemName;
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
    public function getItemName(): string
    {
        return $this->itemName;
    }
}
