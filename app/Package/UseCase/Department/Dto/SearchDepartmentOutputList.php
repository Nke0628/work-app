<?php


namespace App\Package\UseCase\Department\Dto;


/**
 * 組織検索アウトプットDTOリスト
 *
 * Class DepartmentList
 * @package App\Package\Domain\Department
 */
class SearchDepartmentOutputList implements \IteratorAggregate
{
    /** @var string */
    private $pages;

    /**
     * @var string
     */
    private $searchQuery;

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

    /** @var SearchDepartmentOutput[] **/
    private $searchDepartmentOutputList;

    /**
     * DepartmentList constructor.
     * @param array $searchDepartmentOutputList
     * @param string $pages
     * @param string $searchQuery
     * @param string $departmentName
     * @param string $startWorkTime
     * @param string $endWorkTIme
     * @param string $startBreakTime
     * @param string $endBreakTime
     */
    public function __construct( array $searchDepartmentOutputList, string $pages, string $searchQuery, string $departmentName, string $startWorkTime, string $endWorkTIme, string $startBreakTime, string $endBreakTime )
    {
        $this->searchDepartmentOutputList = $searchDepartmentOutputList;
        $this->pages = $pages;
        $this->searchQuery = $searchQuery;
        $this->departmentName = $departmentName;
        $this->startWorkTime = $startWorkTime;
        $this->endWorkTIme = $endWorkTIme;
        $this->startBreakTime = $startBreakTime;
        $this->endBreakTime = $endBreakTime;
    }

    /**
     * @return SearchDepartmentOutput[]
     */
    public function getSearchDepartmentOutputList()
    {
        return $this->searchDepartmentOutputList;
    }

    /**
     * @return \ArrayIterator|\Traversable
     */
    public function getIterator()
    {
        return new \ArrayIterator( $this->searchDepartmentOutputList );
    }

    /**
     * @return string
     */
    public function getPages(): string
    {
        return $this->pages;
    }

    /**
     * @return string
     */
    public function getSearchQuery(): string
    {
        return $this->searchQuery;
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
