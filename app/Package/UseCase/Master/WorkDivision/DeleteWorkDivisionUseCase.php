<?php

namespace App\Package\UseCase\Master\WorkDivision;

use App\Package\Domain\Master\WorkDivision\Service\WorkDivisionService;
use App\Package\Domain\Master\WorkDivision\WorkDivisionId;
use App\Package\Domain\Repository\WorkDivisionInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DeleteWorkDivisionUseCase
{
    /** @var WorkDivisionInterface */
    private $workDivisionRepository;

    /** @var WorkDivisionService */
    private $workDivisionService;

    /**
     * GetWorkDivisionAllUseCase constructor.
     * @param WorkDivisionInterface $workDivisionRepository
     * @param WorkDivisionService $workDivisionService
     */
    public function __construct(
        WorkDivisionInterface $workDivisionRepository,
        WorkDivisionService $workDivisionService)
    {
        $this->workDivisionRepository = $workDivisionRepository;
        $this->workDivisionService = $workDivisionService;
    }

    /**
     * 勤怠区分を削除
     *
     * @param int[] $pIdList IDリスト
     * @return bool
     */
    public function execute( array $pIdList ): bool
    {
        /**
         * Step1.勤怠区分IDの存在チェック
         */
        try
        {
            $aWorkDivisionIdList = array();
            foreach ( $pIdList as $aId )
            {
                $aWorkDivisionIdList[] = WorkDivisionId::of( $aId );
            }

            if ( !$this->workDivisionService->isExistIdList( $aWorkDivisionIdList ) )
            {
                throw new \Exception( '勤怠区分の削除に失敗しました。' );
            }

        /**
         * Step2.勤怠区分IDを削除
         */
            DB::beginTransaction();

            $aResult = $this->workDivisionRepository->delete( $aWorkDivisionIdList );
            if ( !$aResult )
            {
                throw new \Exception( '勤怠区分の削除に失敗しました。' );
            }

            DB::commit();
        }
        catch ( \Exception $e )
        {
            $aErrMsg = '勤怠区分の削除に失敗しました。' . $e->getMessage();
            Log::error( $aErrMsg );
            DB::rollBack();
            return false;
        }
        return true;
    }
}
