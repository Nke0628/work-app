<?php


namespace App\Package\UseCase\Suriawase\ReadQuery;


use App\Model\MeetingItem;
use App\Model\MeetingTab;
use App\Model\MeetingValue;
use App\Package\UseCase\Suriawase\Output\MeetingDto;
use App\Package\UseCase\Suriawase\Output\MeetingItemDto;
use App\Package\UseCase\Suriawase\Output\MeetingTabDto;
use App\Package\UseCase\Suriawase\Output\MeetingValueDto;

class GetSuriawaseMeetingReadQuery
{
    /**
     * @return MeetingDto
     */
    public function fetchMeetingData():MeetingDto
    {
        //すり合わせ会議タブ取得
        $meetingTabModels = MeetingTab::where('suriawase_config_id',1)
            ->get();
        $meetingTabDtoList = [];
        foreach ( $meetingTabModels as $tabModel ) {
            $meetingTabDtoList[] = new MeetingTabDto(
                $tabModel->suriawase_tab_id,
                $tabModel->tab_name,
                $tabModel->tab_no
            );
        }

        //すり合わせ会議項目取得
        $meetingItemModels = MeetingItem::where('suriawase_config_id',1)
            ->get();
        $meetingItemDtoList = [];
        foreach ( $meetingItemModels as $itemModel ) {
            $meetingItemDtoList[] = new MeetingItemDto(
                $itemModel->suriawase_tab_id,
                $itemModel->item_name
            );
        }

        //すり合わせ会議値取得
        $meetingValueModels = MeetingValue::query()
            ->join('meeting_items','meeting_items.suriawase_item_id','=','meeting_values.suriawase_item_id')
            ->join('meeting_tabs','meeting_tabs.suriawase_tab_id','=','meeting_items.suriawase_tab_id')
            ->where('meeting_values.suriawase_config_id',1)
            ->orderByRaw('personal_id,item_no')
            ->get();
        $meetingValueDtoList = [];
        foreach ( $meetingValueModels as $valueModel ) {
            $meetingValueDtoList[] = new MeetingValueDto(
                $valueModel->suriawase_tab_id,
                $valueModel->personal_id,
                $valueModel->value
            );
        }

        //すり合わせ会議生成
        return new MeetingDto(
            $meetingTabDtoList,
            $meetingItemDtoList,
            $meetingValueDtoList
        );
    }
}
