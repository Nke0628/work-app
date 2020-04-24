<?php


namespace App\Package\Domain\Master\WorkDivision\Service;

use App\Package\Domain\Master\WorkDivision\WorkDivisionId;
use App\Package\Domain\Repository\WorkDivisionInterface;

class WorkDivisionService
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
     * IDが存在するかどうか
     *
     * @param WorkDivisionId $pWorkDivisionId
     * @return bool
     */
    public function isExistId( WorkDivisionId $pWorkDivisionId ): bool
    {
        $aResult = $this->workDivisionRepository->findById( $pWorkDivisionId );
        if ( $aResult )
        {
            return true;
        }
        return false;
    }

    /**
     * IDListが存在するかどうか
     *
     * @param WorkDivisionId[] $pWorkDivisionIdList
     * @return bool
     */
    public function isExistIdList( array $pWorkDivisionIdList ): bool
    {
        foreach ( $pWorkDivisionIdList as $aWorkDivisionId )
        {
            $aResult = $this->workDivisionRepository->findById( $aWorkDivisionId );
            if ( !$aResult )
            {
                return false;
            }
        }
        return true;
    }
}
