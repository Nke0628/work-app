<?php


namespace App\Package\UseCase\Master\WorkDivision;

use App\Package\Domain\Master\WorkDivision\WorkDivision;
use App\Package\Domain\Master\WorkDivision\WorkDivisionName;
use App\Package\Domain\Repository\WorkDivisionInterface;
use App\Package\UseCase\Master\WorkDivision\OutPutData\WorkDivisionDto;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RegisterWorkDivisionUseCase
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
     * 勤怠区分を登録する
     *
     * @param array $pParam 更新パラメータ
     * @return WorkDivisionDto|null
     */
    public function execute( array $pParam ): ?WorkDivisionDto
    {
        try
        {
            /**
             * Step1.勤怠区分を登録する
             */
            $aWorkDivision = new WorkDivision(
                null,
                WorkDivisionName::of( $pParam['work_division_name'] ),
                null
            );

            DB::beginTransaction();

            $aSavedWorkDivision = $this->workDivisionRepository->save( $aWorkDivision );
            if ( !$aSavedWorkDivision )
            {
                throw new \Exception( '勤怠区分の登録に失敗しました。' );
            }

            DB::commit();
        }
        catch ( \Exception $e )
        {
            $aErrMsg = '勤怠区分登録に失敗しました。' . $e->getMessage();
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
