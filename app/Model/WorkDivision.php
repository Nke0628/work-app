<?php

namespace App\Model;

use App\Package\Domain\Master\WorkDivision\WorkDivision as WorkDivisionEntity;
use App\Package\Domain\Master\WorkDivision\WorkDivisionId;
use App\Package\Domain\Master\WorkDivision\WorkDivisionName;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class WorkDivision extends Model
{
    /** @var string テーブル名称  */
    protected $table = 'work_division';

    /**
     * Model→Entity変換
     *
     * @return WorkDivisionEntity
     */
    public function toEntity(): WorkDivisionEntity
    {
        return new WorkDivisionEntity(
            WorkDivisionId::of( $this->id ),
            WorkDivisionName::of( $this->division_name ),
            new Carbon( $this->updated_at )
        );
    }
}
