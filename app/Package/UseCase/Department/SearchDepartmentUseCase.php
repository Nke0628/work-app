<?php


namespace App\Package\UseCase\Department;

use App\Package\Domain\Repository\DepartmentInterface;
use App\Package\UseCase\Department\Dto\SearchDepartmentOutputList;
use App\Package\UseCase\Department\Dto\SearchDepartmentRequest;

class SearchDepartmentUseCase
{
    /** @var DepartmentInterface */
    private $departmentRepository;

    /**
     * GetWorkDivisionAllUseCase constructor.
     * @param DepartmentInterface $departmentRepository
     */
    public function __construct( DepartmentInterface $departmentRepository )
    {
        $this->departmentRepository = $departmentRepository;
    }

    /**
     * 組織を検索する
     *
     * @param SearchDepartmentRequest $pRequest
     * @return SearchDepartmentOutputList
     */
    public function execute( SearchDepartmentRequest $pRequest ): SearchDepartmentOutputList
    {
        /**
         * Step1.組織を検索する
         */
        return $this->departmentRepository->search( $pRequest );
    }
}
