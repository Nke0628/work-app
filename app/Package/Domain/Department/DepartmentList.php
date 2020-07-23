<?php


namespace App\Package\Domain\Department;

/**
 * 組織リスト
 *
 * Class DepartmentList
 * @package App\Package\Domain\Department
 */
class DepartmentList implements \IteratorAggregate
{
    /** @var Department[] **/
    private $departmentList;

    /**
     * DepartmentList constructor.
     * @param array $departmentList
     */
    public function __construct( array $departmentList )
    {
        $this->departmentList = $departmentList;
    }

    /**
     * @return Department[]
     */
    public function getBooks()
    {
        return $this->departmentList;
    }

    /**
     * @return \ArrayIterator|\Traversable
     */
    public function getIterator()
    {
        return new \ArrayIterator( $this->departmentList );
    }
}
