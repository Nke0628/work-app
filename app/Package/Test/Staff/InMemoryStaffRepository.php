<?php


namespace App\Package\Test\Staff;

use App\Package\Domain\Repository\StaffRepositoryInterface;
use App\Package\Domain\Staff\Staff;

class InMemoryStaffRepository implements StaffRepositoryInterface
{
    /**
     * @param Staff $staff
     * @return bool
     */
    public function save( Staff $staff ): bool
    {
        return true;
    }
}
