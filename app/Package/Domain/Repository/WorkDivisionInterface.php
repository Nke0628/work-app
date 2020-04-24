<?php

namespace App\Package\Domain\Repository;

use App\Package\Domain\Master\WorkDivision\WorkDivision;
use App\Package\Domain\Master\WorkDivision\WorkDivisionId;
use App\Package\Domain\Master\WorkDivision\WorkDivisionList;

interface WorkDivisionInterface
{
    /**
     * 勤怠区分を取得
     *
     * @param WorkDivisionId $pWorkDivisionId
     * @return WorkDivision|null
     */
    public function findById( WorkDivisionId $pWorkDivisionId ): ?WorkDivision;

    /**
     * 勤怠区分を全て取得
     *
     * @param array $requestOption
     * @return WorkDivisionList
     */
    public function findAll(array $requestOption=array()): WorkDivisionList;

    /**
     * 勤怠区分を登録
     *
     * @param WorkDivision $workDivision
     * @return WorkDivision|null
     */
    public function save( WorkDivision $workDivision ): ?WorkDivision;

    /**
     * 勤怠区分を更新
     *
     * @param WorkDivision $pWorkDivision
     * @return WorkDivision|null
     */
    public function update( WorkDivision $pWorkDivision ): ?WorkDivision;

    /**
     * 勤怠区分削除
     *
     * @param WorkDivisionId[] $pWorkDivisionIds
     * @return bool
     */
    public function delete( array $pWorkDivisionIds ): bool;
}
