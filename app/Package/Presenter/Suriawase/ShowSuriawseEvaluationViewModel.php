<?php


namespace App\Package\Presenter\Suriawase;


use App\Package\Presenter\ViewModel;
use App\Package\UseCase\Suriawase\Output\MeetingDto;
use App\Package\UseCase\Suriawase\Output\MeetingItemDto;
use App\Package\UseCase\Suriawase\Output\MeetingValueDto;

class ShowSuriawseEvaluationViewModel extends ViewModel
{
    /**
     * @var string
     */
    protected $view = 'suriawase.suriawase_evaluation';

    /**
     * @var MeetingDto
     */
    private $meetingDto;

    /**
     * ShowSuriawseEvaluationViewModel constructor.
     * @param MeetingDto $meetingDto
     */
    public function __construct( MeetingDto $meetingDto )
    {
        $this->meetingDto = $meetingDto;
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        $meetingData = [];
        foreach ( $this->meetingDto->getMeetingTabs() as $tab ) {

            $items = array_filter( $this->meetingDto->getMeetingItems(), function ( MeetingItemDto $item) use ($tab){
                return $item->getTabId() === $tab->getTabId();
            });

            $values = array_filter( $this->meetingDto->getMeetingValues(), function ( MeetingValueDto $value) use ($tab){
                return $value->getTabId() === $tab->getTabId();
            });

            $meetingData[] = [
                'tab_id' => $tab->getTabId(),
                'tab_name' => $tab->getTabName(),
                'is_active_tab' => $tab->getTabNo() === 1,
                'items' => $this->formatMeetingItemDtoList( $items ),
                'values' => $this->formatMeetingValueDtoList( $values )
            ];
        }
        $param['tab_items'] = $meetingData;
        return $param;
    }

    /**
     * すり合わせ会議項目DTOリストのフォーマット
     *
     * @param MeetingItemDto[] $meetingItems
     * @return array
     */
    private function formatMeetingItemDtoList(array $meetingItems ): array
    {
        $ret = [];
        foreach ( $meetingItems as $meetingItem ) {
            $ret[] = [
                'item_name' => $meetingItem->getItemName()
            ];
        }
        return $ret;
    }

    /**
     * すり合わせ会議値DTOリストのフォーマット
     *
     * @param MeetingValueDto[] $meetingValues
     * @return array
     */
    private function formatMeetingValueDtoList(array $meetingValues ): array
    {
        $ret = [];
        $oldPersonalId = '';
        foreach ( $meetingValues as $index => $meetingValue ) {
            $ret[] = [
                'value' => $meetingValue->getValue(),
                'is_next_Row' => ( $index === 0 ) ? false : $oldPersonalId !== $meetingValue->getPersonalId()
            ];
            $oldPersonalId = $meetingValue->getPersonalId();
        }
        return $ret;
    }
}
