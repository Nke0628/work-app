<?php


namespace App\Package\Domain\Department;


class AttendanceProperty
{
    /** @var AttendancePropertyId */
    private $attendancePropertyId;

    /** @var DepartmentId */
    private $departmentId;

    /** @var StartWorkTime */
    private $startWorkTime;

    /** @var EndWorkTime */
    private $endWorkTime;

    /** @var StartBreakTime */
    private $startBreakTime;

    /** @var EndBreakTime */
    private $endBreakTime;

    /**
     * AttendanceProperty constructor.
     * @param AttendancePropertyId $attendancePropertyId
     * @param DepartmentId $departmentId
     * @param StartWorkTime $startWorkTime
     * @param EndWorkTime $endWorkTime
     * @param StartBreakTime $startBreakTime
     * @param EndBreakTime $endBreakTime
     */
    public function __construct( AttendancePropertyId $attendancePropertyId, DepartmentId $departmentId ,StartWorkTime $startWorkTime, EndWorkTime $endWorkTime, StartBreakTime $startBreakTime, EndBreakTime $endBreakTime )
    {
        $this->attendancePropertyId = $attendancePropertyId;
        $this->departmentId = $departmentId;
        $this->startWorkTime = $startWorkTime;
        $this->endWorkTime = $endWorkTime;
        $this->startBreakTime = $startBreakTime;
        $this->endBreakTime = $endBreakTime;
    }

    /**
     * @return AttendancePropertyId
     */
    public function getAttendancePropertyId(): AttendancePropertyId
    {
        return $this->attendancePropertyId;
    }

    /**
     * @return DepartmentId
     */
    public function getDepartmentId(): DepartmentId
    {
        return $this->departmentId;
    }

    /**
     * @return StartWorkTime
     */
    public function getStartWorkTime(): StartWorkTime
    {
        return $this->startWorkTime;
    }

    /**
     * @return EndWorkTime
     */
    public function getEndWorkTime(): EndWorkTime
    {
        return $this->endWorkTime;
    }

    /**
     * @return StartBreakTime
     */
    public function getStartBreakTime(): StartBreakTime
    {
        return $this->startBreakTime;
    }

    /**
     * @return EndBreakTime
     */
    public function getEndBreakTime(): EndBreakTime
    {
        return $this->endBreakTime;
    }
}
