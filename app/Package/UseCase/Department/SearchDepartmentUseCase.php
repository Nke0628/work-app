<?php


namespace App\Package\UseCase\Department;

use App\Package\Domain\Repository\DepartmentInterface;
use App\Package\Presenter\Department\SearchDepartmentViewModel;
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
     * @return SearchDepartmentViewModel
     */
    public function execute( SearchDepartmentRequest $pRequest ): SearchDepartmentViewModel
    {
        /**
         * Step1.組織を検索する
         */
        return new SearchDepartmentViewModel(
            $this->departmentRepository->search( $pRequest )
        );
    }
}
