<?php


namespace App\Package\Domain\Staff;

use App\Package\Domain\Department\DepartmentId;
use App\Package\Domain\User\UserId;

/**
 * Class Staff
 * @package App\Package\Domain\Staff
 */
class Staff
{
    /** @var StaffId */
    private $staffId;

    /** @var UserId */
    private $userId;

    /** @var DepartmentId */
    private $departmentId;

    /**
     * Staff constructor.
     * @param StaffId $staffId
     * @param UserId $userId
     * @param DepartmentId $departmentId
     */
    public function __construct(StaffId $staffId, UserId $userId, DepartmentId $departmentId)
    {
        $this->staffId = $staffId;
        $this->userId = $userId;
        $this->departmentId = $departmentId;
    }

    /**
     * @return StaffId
     */
    public function getStaffId(): StaffId
    {
        return $this->staffId;
    }

    /**
     * @return UserId
     */
    public function getUserId(): UserId
    {
        return $this->userId;
    }

    /**
     * @return DepartmentId
     */
    public function getDepartmentId(): DepartmentId
    {
        return $this->departmentId;
    }


}
