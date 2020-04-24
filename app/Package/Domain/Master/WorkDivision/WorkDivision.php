<?php


namespace App\Package\Domain\Master\WorkDivision;

use Carbon\Carbon;

class WorkDivision
{
    /** @var WorkDivisionId|null */
    private $id;

    /** @var WorkDivisionName */
    private $divisionName;

    /** @var Carbon|null */
    private $updateDate;

    /**
     * WorkDivision constructor.
     * @param WorkDivisionId|null $id
     * @param WorkDivisionName $divisionName
     * @param Carbon|null $updateDate
     */
    public function __construct( ?WorkDivisionId $id, WorkDivisionName $divisionName, ?Carbon $updateDate)
    {
        $this->id = $id;
        $this->divisionName = $divisionName;
        $this->updateDate = $updateDate;
    }

    /**
     * @return WorkDivisionId|null
     */
    public function getId(): ?WorkDivisionId
    {
        return $this->id;
    }

    /**
     * @return WorkDivisionName
     */
    public function getDivisionName(): WorkDivisionName
    {
        return $this->divisionName;
    }

    /**
     * @return Carbon|null
     */
    public function getUpdateDate(): ?Carbon
    {
        return $this->updateDate;
    }
}
