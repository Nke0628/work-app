<?php


namespace App\Package\Test\Department;


use App\Package\Domain\Department\RegisterDepartmentRequestInterface;

class InMemoryRegisterDepartmentFormRequest implements RegisterDepartmentRequestInterface
{
    private $departmentName;

    private $startWorkTime;

    private $endWorkTime;

    private $startBreakTime;

    private $endBreakTime;

    /**
     * InMemoryRegisterDepartmentFormRequest constructor.
     * @param $departmentName
     * @param $startWorkTime
     * @param $endWorkTime
     * @param $startBreakTime
     * @param $endBreakTime
     */
    public function __construct($departmentName, $startWorkTime, $endWorkTime, $startBreakTime, $endBreakTime)
    {
        $this->departmentName = $departmentName;
        $this->startWorkTime = $startWorkTime;
        $this->endWorkTime = $endWorkTime;
        $this->startBreakTime = $startBreakTime;
        $this->endBreakTime = $endBreakTime;
    }

    public function getDepartmentName(): string
    {
        return $this->departmentName;
    }

    public function getStartWorkTime(): string
    {
        return $this->startWorkTime;
    }

    public function getEndWorkTime(): string
    {
        return $this->endWorkTime;
    }

    public function getStartBreakTime(): string
    {
        return $this->startBreakTime;
    }

    public function getEndBreakTime(): string
    {
        return $this->endBreakTime;
    }
}
