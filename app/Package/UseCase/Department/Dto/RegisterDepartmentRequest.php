<?php

namespace App\Package\UseCase\Department\Dto;

/**
 * 組織生成リクエストDTO
 *
 * Class RegisterDepartmentRequest
 * @package App\Package\UseCase\Department\Dto
 */
class RegisterDepartmentRequest
{
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
     * @var string
     */
    private $userId;

    /**
     * RegisterDepartmentRequest constructor.
     * @param string $departmentName
     * @param string $startWorkTime
     * @param string $endWorkTIme
     * @param string $startBreakTime
     * @param string $endBreakTime
     * @param string $userId
     */
    public function __construct(string $departmentName, string $startWorkTime, string $endWorkTIme, string $startBreakTime, string $endBreakTime, string $userId)
    {
        $this->departmentName = $departmentName;
        $this->startWorkTime = $startWorkTime;
        $this->endWorkTIme = $endWorkTIme;
        $this->startBreakTime = $startBreakTime;
        $this->endBreakTime = $endBreakTime;
        $this->userId = $userId;
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

    /**
     * @return string
     */
    public function getUserId(): string
    {
        return $this->userId;
    }
}
