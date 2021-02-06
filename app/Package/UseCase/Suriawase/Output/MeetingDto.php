<?php


namespace App\Package\UseCase\Suriawase\Output;


class MeetingDto
{
    /**
     * @var MeetingTabDto[]
     */
    private $meetingTabs;

    /**
     * @var MeetingItemDto[]
     */
    private $meetingItems;

    /**
     * @var MeetingValueDto[]
     */
    private $meetingValues;

    /**
     * MeetingDto constructor.
     * @param MeetingValueDto[] $meetingTabs
     * @param MeetingItemDto[] $meetingItems
     * @param MeetingValueDto[] $meetingValues
     */
    public function __construct(array $meetingTabs, array $meetingItems, array $meetingValues)
    {
        $this->meetingTabs = $meetingTabs;
        $this->meetingItems = $meetingItems;
        $this->meetingValues = $meetingValues;
    }

    /**
     * @return MeetingTabDto[]
     */
    public function getMeetingTabs(): array
    {
        return $this->meetingTabs;
    }

    /**
     * @return MeetingItemDto[]
     */
    public function getMeetingItems(): array
    {
        return $this->meetingItems;
    }

    /**
     * @return MeetingValueDto[]
     */
    public function getMeetingValues(): array
    {
        return $this->meetingValues;
    }
}
