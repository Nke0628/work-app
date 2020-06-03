<?php


namespace App\Package\Domain\Department;

use App\Package\Domain\User\UserId;

class Department
{
    /** @var DepartmentId */
    private $departmentId;

    /** @var UserId */
    private $userId;

    /** @var string */
    private $name;

    /** @var AttendanceProperty */
    private $attendanceProperty;

    /**
     * WorkDivision constructor.
     * @param DepartmentId $departmentId
     * @param UserId $userId
     * @param string $name
     * @param AttendanceProperty $attendanceProperty
     */
    public function __construct( DepartmentId $departmentId, UserId $userId, string $name, AttendanceProperty $attendanceProperty )
    {
        $this->departmentId = $departmentId;
        $this->userId = $userId;
        $this->name = $name;
        $this->attendanceProperty = $attendanceProperty;
    }

    /**
     * @return DepartmentId
     */
    public function getDepartmentId(): DepartmentId
    {
        return $this->departmentId;
    }

    /**
     * @return UserId
     */
    public function getUserId(): UserId
    {
        return $this->userId;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return AttendanceProperty
     */
    public function getAttendanceProperty(): AttendanceProperty
    {
        return $this->attendanceProperty;
    }

}
