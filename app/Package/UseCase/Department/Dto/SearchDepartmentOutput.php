<?php

namespace App\Package\UseCase\Department\Dto;

/**
 * 組織検索アウトプットDTO
 *
 * Class SearchrDepartmentOutput
 * @package App\Package\UseCase\Department\Dto
 */
class SearchDepartmentOutput
{
    /** @var string */
    private $departmentId;

    /**
     * @var string
     */
    private $departmentName;

    /**
     * @var string
     */
    private $startWorkTime;

    /**
     * @var string
     */
    private $endWorkTIme;

    /**
     * @var string
     */
    private $startBreakTime;

    /**
     * @var string
     */
    private $endBreakTime;

    /**
     * RegisterDepartmentRequest constructor.
     * @param string $departmentId
     * @param string $departmentName
     * @param string $startWorkTime
     * @param string $endWorkTIme
     * @param string $startBreakTime
     * @param string $endBreakTime
     */
    public function __construct(string $departmentId, string $departmentName, string $startWorkTime, string $endWorkTIme, string $startBreakTime, string $endBreakTime )
    {
        $this->departmentId = $departmentId;
        $this->departmentName = $departmentName;
        $this->startWorkTime = $startWorkTime;
        $this->endWorkTIme = $endWorkTIme;
        $this->startBreakTime = $startBreakTime;
        $this->endBreakTime = $endBreakTime;
    }

    /**
     * @return string
     */
    public function getDepartmentId() :string
    {
        return $this->departmentId;
    }

    /**
     * @return string
     */
    public function getDepartmentName(): string
    {
        return $this->departmentName;
    }

    /**
     * @return string
     */
    public function getStartWorkTime(): string
    {
        return $this->startWorkTime;
    }

    /**
     * @return string
     */
    public function getEndWorkTIme(): string
    {
        return $this->endWorkTIme;
    }

    /**
     * @return string
     */
    public function getStartBreakTime(): string
    {
        return $this->startBreakTime;
    }

    /**
     * @return string
     */
    public function getEndBreakTime(): string
    {
        return $this->endBreakTime;
    }
}
