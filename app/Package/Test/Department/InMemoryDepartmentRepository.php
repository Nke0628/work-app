<?php


namespace App\Package\Test\Department;

use App\Package\Domain\Department\Department;
use App\Package\Domain\Repository\DepartmentInterface;
use App\Package\UseCase\Department\Dto\SearchDepartmentRequest;

class InMemoryDepartmentRepository implements DepartmentInterface
{
    /**
     * @inheritDoc
     */
    public function save( Department $pDepartment )
    {
        return $pDepartment;
    }

    /**
     *
     * @inheritDoc
     *
     */
    public function search(SearchDepartmentRequest $searchDepartmentRequest)
    {
        // TODO: Implement search() method.
    }
}
