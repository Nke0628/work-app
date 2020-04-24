<?php

namespace App\Package\UseCase\Master\WorkDivision;

use App\Package\Domain\Repository\WorkDivisionInterface;
use App\Package\UseCase\Master\WorkDivision\OutPutData\ShowWorkDivisionListDto;
use App\Package\UseCase\Master\WorkDivision\OutPutData\WorkDivisionDto;

class GetWorkDivisionAllUseCase
{
    /** @var WorkDivisionInterface */
    private $workDivisionRepository;

    /**
     * GetWorkDivisionAllUseCase constructor.
     * @param WorkDivisionInterface $workDivisionRepository
     */
    public function __construct(WorkDivisionInterface $workDivisionRepository)
    {
        $this->workDivisionRepository = $workDivisionRepository;
    }

    /**
     * 勤怠区分を全て取得
     *
     * @return ShowWorkDivisionListDto
     */
    public function execute()
    {
        /**
         * Step1.勤怠区分を取得する
         */
       $aWorkDivisionList = $this->workDivisionRepository->findAll();
       $aWorkDivisionListDto = array();
       foreach ( $aWorkDivisionList->getIterator() as $aWorkDivision )
       {
            $aWorkDivisionListDto[] = new WorkDivisionDto(
                $aWorkDivision->getId()->getValue(),
                $aWorkDivision->getDivisionName()->getValue(),
                $aWorkDivision->getUpdateDate()
            );
       }
       return new ShowWorkDivisionListDto( $aWorkDivisionListDto );
    }
}
