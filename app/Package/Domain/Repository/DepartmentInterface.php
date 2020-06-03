<?php

namespace App\Package\Domain\Repository;

use App\Package\Domain\Department\Department;

interface DepartmentInterface
{
    /**
     * 組織・勤怠設定の登録
     *
     * @param Department $pDepartment
     * @return bool
     */
    public function save( Department $pDepartment ): bool;
}
