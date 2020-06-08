<?php

namespace App\Package\Infrastructure\Eloquent;

use App\Package\Domain\Master\WorkDivision\WorkDivisionId;
use App\Package\Domain\Master\WorkDivision\WorkDivisionName;
use App\Package\Domain\Master\WorkDivision\WorkDivision;
use App\Package\Domain\Master\WorkDivision\WorkDivisionList;
use App\Package\Domain\Repository\WorkDivisionInterface;
use App\Model\WorkDivision as WorkDivisionElq;
use Carbon\Carbon;

class WorkDivisionRepository implements WorkDivisionInterface
{
    const PAGE_LIMIT = 10;

    /**
     * 勤怠区分を取得
     *
     * @param WorkDivisionId $pWorkDivisionId
     * @return WorkDivision|null
     */
    public function findById( WorkDivisionId $pWorkDivisionId ): ?WorkDivision
    {
        $aWorkDivisionModel = WorkDivisionElq::find( $pWorkDivisionId->getValue() );
        if ( $aWorkDivisionModel )
        {
            return new WorkDivision(
                WorkDivisionId::of( $aWorkDivisionModel->id ),
                WorkDivisionName::of( $aWorkDivisionModel->division_name ),
                new Carbon( $aWorkDivisionModel->updated_at )
            );
        }
        return null;
    }

    /**
     * 勤怠区分を全て取得
     *
     * @param array $requestOption
     * @return WorkDivisionList
     */
    public function findAll( array $requestOption = array() ): WorkDivisionList
    {
        $aWorkDivisionList = new WorkDivisionList();
        $aWorkDivisions = WorkDivisionElq::all();
        if ( $aWorkDivisions )
        {
            foreach ( $aWorkDivisions as $aWorkDivision )
            {
                $aWorkDivisionList->add( new WorkDivision(
                    WorkDivisionId::of( $aWorkDivision->id ),
                    WorkDivisionName::of( $aWorkDivision->division_name ),
                    new Carbon( $aWorkDivision->updated_at )
                ));
            }
        }
        return $aWorkDivisionList;
    }

    public function fetchConditionCount( array $pSearchCondition ): int
    {
        $query = WorkDivisionElq::query();

        // 条件生成
        if( $pSearchCondition['word'] )
        {
            $query->where('name', 'LIKE', $pSearchCondition['word']);
        }

        return  $query->count();
    }

    /**
     * 検索取得
     *
     * @param array $pSearchCondition
     * @return WorkDivisionList
     */
    public function fetchCondition( array $pSearchCondition ): WorkDivisionList
    {
        $query = WorkDivisionElq::query();

        // 条件生成
        if( $pSearchCondition['word'] )
        {
            $query->where('name', 'LIKE', $pSearchCondition['word']);
        }

        if ( $pSearchCondition['page_num'] )
        {
            $aOffset = ( $pSearchCondition['page_num'] )  -1 * self::PAGE_LIMIT;
            $query->offset( $aOffset );
            $query->limit( self::PAGE_LIMIT );
        }

        if ( $pSearchCondition[ 'sort'] && $pSearchCondition['order'] )
        {
            $query->orderBy( $pSearchCondition[ 'sort'], $pSearchCondition['order'] );
        }

        $aWorkDivisions = $query->get();
        $aWorkDivisionList = new WorkDivisionList();
        if ( $aWorkDivisions )
        {
            foreach ( $aWorkDivisions as $aWorkDivision )
            {
                $aWorkDivisionList->add( new WorkDivision(
                    WorkDivisionId::of( $aWorkDivision->id ),
                    WorkDivisionName::of( $aWorkDivision->division_name ),
                    new Carbon( $aWorkDivision->updated_at )
                ));
            }
        }
        return $aWorkDivisionList;
    }

    /**
     * 勤怠区分を保存する
     *
     * @param WorkDivision $workDivision
     * @return WorkDivision|null
     */
    public function save( WorkDivision $workDivision ): ?WorkDivision
    {
        $aWorkDivisionModel = new WorkDivisionElq();
        $aWorkDivisionModel->division_name = $workDivision->getDivisionName()->getValue();
        $aResult = $aWorkDivisionModel->save();
        if ( $aResult )
        {
            return new WorkDivision(
                WorkDivisionId::of( $aWorkDivisionModel->id ),
                WorkDivisionName::of( $aWorkDivisionModel->division_name ),
                new Carbon( $aWorkDivisionModel->updated_at )
            );
        }
        return null;
    }

    /**
     * 勤怠区分を更新する
     *
     * @param WorkDivision $pWorkDivision
     * @return WorkDivision|null
     */
    public function update( WorkDivision $pWorkDivision ): ?WorkDivision
    {
        $aWorkDivisionModel = WorkDivisionElq::find( $pWorkDivision->getId()->getValue() );
        $aWorkDivisionModel->division_name = $pWorkDivision->getDivisionName()->getValue();
        $aResult = $aWorkDivisionModel->update();
        if ( $aResult )
        {
            return new WorkDivision(
                WorkDivisionId::of( $aWorkDivisionModel->id ),
                WorkDivisionName::of( $aWorkDivisionModel->division_name ),
                new Carbon( $aWorkDivisionModel->updated_at )
            );
        }
        return null;
    }

    /**
     * 勤怠区分をUPSERTする
     *
     * @param WorkDivision $pWorkDivision
     * @return bool 成功可否
     */
    public function upsert( WorkDivision $pWorkDivision ): bool
    {
        $aWorkDivisionModel = WorkDivisionElq::find( $pWorkDivision->getId()->getValue() );
        if ( !$aWorkDivisionModel )
        {
            $aWorkDivisionModel = new WorkDivisionElq();
            $aWorkDivisionModel->id = $pWorkDivision->getId()->getValue();
         }
        $aWorkDivisionModel->division_name = $pWorkDivision->getDivisionName()->getValue();
        $aResult = $aWorkDivisionModel->save();
        if ( $aResult )
        {
           return true;
        }
        return false;
    }

    /**
     * 勤怠区分を削除
     *
     * @param WorkDivisionId[] $pWorkDivisionIds
     * @return bool
     */
    public function delete( array $pWorkDivisionIds ): bool
    {
        $aIds = array();
        foreach ( $pWorkDivisionIds as $aWorkDivisionId )
        {
            $aIds[] = $aWorkDivisionId->getValue();
        }
        return WorkDivisionElq::whereIn('id', $aIds )->delete();
    }
}
