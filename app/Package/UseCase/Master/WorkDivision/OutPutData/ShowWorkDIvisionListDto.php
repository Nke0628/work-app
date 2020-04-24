<?php

namespace App\Package\UseCase\Master\WorkDivision\OutPutData;

class ShowWorkDivisionListDto
{
    /** @var WorkDivisionDto[] */
    private $workDivisionList;

    /**
     * ShowWorkDivisionListDto constructor.
     * @param array $workDivisionList
     */
    public function __construct( array $workDivisionList )
    {
        $this->workDivisionList = $workDivisionList;
    }

    /**
     * @return WorkDivisionDto[]
     */
    public function getWorkDivisionList():array
    {
        return $this->workDivisionList;
    }
}
