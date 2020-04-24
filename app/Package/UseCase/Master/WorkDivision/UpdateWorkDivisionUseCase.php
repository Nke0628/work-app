<?php


namespace App\Package\UseCase\Master\WorkDivision;

use App\Package\Domain\Master\WorkDivision\Service\WorkDivisionService;
use App\Package\Domain\Master\WorkDivision\WorkDivision;
use App\Package\Domain\Master\WorkDivision\WorkDivisionId;
use App\Package\Domain\Master\WorkDivision\WorkDivisionName;
use App\Package\Domain\Repository\WorkDivisionInterface;
use App\Package\UseCase\Master\WorkDivision\OutPutData\WorkDivisionDto;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UpdateWorkDivisionUseCase
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
     * 勤怠区分を更新する
     *
     * @param array $pParam 更新パラメータ
     * @return WorkDivisionDto|null
     */
    public function execute( array $pParam ): ?WorkDivisionDto
    {
        try
        {
            /**
             * Step1.勤怠区分IDの存在チェック
             */
            $aWorkDivisionId = WorkDivisionId::of( $pParam['id'] );
            if ( !$this->workDivisionService->isExistId($aWorkDivisionId) )
            {
                throw new \Exception( '勤怠区分の更新に失敗しました。' );
            }

            /**
             * Step2.勤怠区分IDを更新
             */
            DB::beginTransaction();

            $aWorkDivision = new WorkDivision(
                $aWorkDivisionId,
                WorkDivisionName::of( $pParam['work_division_name'] ),
                null
            );

            $aSavedWorkDivision = $this->workDivisionRepository->update( $aWorkDivision );
            if ( !$aSavedWorkDivision )
            {
                throw new \Exception( '勤怠区分の更新に失敗しました。' );
            }
            DB::commit();
        }
        catch ( \Exception $e )
        {
            $aErrMsg = '勤怠区分の更新に失敗しました。' . $e->getMessage();
            Log::error( $aErrMsg );
            DB::rollBack();
            return null;
        }
        return new WorkDivisionDto(
            $aSavedWorkDivision->getId()->getValue(),
            $aSavedWorkDivision->getDivisionName()->getValue(),
            $aSavedWorkDivision->getUpdateDate()
        );
    }
}
