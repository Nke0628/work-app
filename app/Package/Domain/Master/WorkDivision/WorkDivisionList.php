<?php


namespace App\Package\Domain\Master\WorkDivision;


class WorkDivisionList implements \IteratorAggregate
{
    /** @var \ArrayObject */
    private $workDivisionList;

    public function __construct()
    {
        $this->workDivisionList = new \ArrayObject();
    }

    public function add(WorkDivision $workDivision)
    {
        $this->workDivisionList[] = $workDivision;
    }

    public function getIterator()
    {
        return $this->workDivisionList->getIterator();
    }
}
