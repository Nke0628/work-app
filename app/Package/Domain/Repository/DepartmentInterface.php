<?php

namespace App\Package\Domain\Repository;

use App\Package\Domain\Department\Department;
use App\Package\UseCase\Department\Dto\SearchDepartmentRequest;

interface DepartmentInterface
{
    /**
     * @param Department $pDepartment
     * @return null | Department
     */
    public function save( Department $pDepartment );

    /**
     * @param SearchDepartmentRequest $searchDepartmentRequest
     * @return mixed
     */
    public function search( SearchDepartmentRequest $searchDepartmentRequest );
}
