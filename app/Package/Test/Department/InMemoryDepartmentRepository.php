<?php


namespace App\Package\Test\Department;


use App\Package\Domain\Department\Department;
use App\Package\Domain\Repository\DepartmentInterface;

class InMemoryDepartmentRepository implements DepartmentInterface
{
    /**
     * @inheritDoc
     */
    public function save(Department $pDepartment): bool
    {
        return true;
    }
}
