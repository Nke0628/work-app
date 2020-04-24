<?php

namespace App\Package\UseCase\Master\WorkDivision\OutPutData;

class WorkDivisionDto
{
    /** @var int */
    private $id;

    /** @var string */
    private $division_name;

    /** @var string */
    private $update_date;

    /**
     * WorkDivisionDto constructor.
     * @param int $id
     * @param string $division_name
     * @param string $update_date
     */
    public function __construct( int $id, string $division_name, string $update_date )
    {
        $this->id = $id;
        $this->division_name = $division_name;
        $this->update_date = $update_date;
    }

    /**
     * @return int
     */
    public function getId():int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getDivisionName(): string
    {
        return $this->division_name;
    }

    /**
     * @return string
     */
    public function getUpdateDate():string
    {
        return $this->update_date;
    }

}
