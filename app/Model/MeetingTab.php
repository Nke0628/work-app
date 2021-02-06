<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class MeetingTab extends Model
{
    protected $table = 'meeting_tabs';

    public function meetingItems()
    {
        return $this->hasMany('App\Model\MeetingItem','suriawase_tab_id','suriawase_tab_id');
    }
}
