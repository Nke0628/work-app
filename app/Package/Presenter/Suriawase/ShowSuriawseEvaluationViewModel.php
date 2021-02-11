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
        $param = [];
        $tabList = [];
        $itemList = [];

        foreach ( $this->meetingDto->getMeetingTabs() as $tab ) {
            $tabList[] = [
                'tab_id' => $tab->getTabId(),
                'tab_name' => $tab->getTabName(),
                'is_first_tab' => $tab->getTabNo() === 1,
            ];
        }

        foreach ( $this->meetingDto->getMeetingItems() as $item ) {
            $itemList[] = [
                'title' => $item->getItemName()
            ];
        }
        array_unshift($itemList,['title'=>'会議メモ']);
        array_unshift($itemList,['title'=>'']);

        $valueList = [];
        $rowList = [];
        $oldPersonalId = '';
        $keyLast = array_key_last( $this->meetingDto->getMeetingValues() );

        foreach ($this->meetingDto->getMeetingValues() as $index => $value) {
            if ($index !== 0 && $oldPersonalId !== $value->getPersonalId()) {
                array_unshift($valueList, '');
                array_unshift($valueList, $value->getTabId());
                $rowList[] = $valueList;
                $valueList = [];
            }
            $valueList[] = $value->getValue();
            $oldPersonalId = $value->getPersonalId();
            if ($index === $keyLast) {
                array_unshift($valueList, '');
                array_unshift($valueList, $value->getTabId());
                $rowList[] = $valueList;
            }
        }

        $rowList2 = [];
        for ($i=0;$i<333;$i++){
            foreach ( $rowList as $row) {
                $rowList2[] = $row;
            }
        }

//        $items = array_filter( $this->meetingDto->getMeetingItems(), function ( MeetingItemDto $item) use ($,.tab){
//            return $item->getTabId() === $tab->getTabId();
//        });
//
//        $values = array_filter( $this->meetingDto->getMeetingValues(), function ( MeetingValueDto $value) use ($tab){
//            return $value->getTabId() === $tab->getTabId();
//        });
//
//        'items' => $this->formatMeetingItemDtoList( $items ),
//                'values' => $this->formatMeetingValueDtoList( $values )

        $param['tab_list'] = $tabList;
        $param['item_list'] = $itemList;
        $param['row_list'] = $rowList2;
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
        $oldTabId = '';
        foreach ( $meetingValues as $index => $meetingValue ) {
            $ret[] = [
                'value' => $meetingValue->getValue(),
                'is_next_Row' => ( $index === 0 ) ? false : ( $oldPersonalId !== $meetingValue->getPersonalId() && $oldTabId === $meetingValue->getTabId())
            ];
            $oldTabId = $meetingValue->getTabId();
            $oldPersonalId = $meetingValue->getPersonalId();
        }
        return $ret;
    }
}
