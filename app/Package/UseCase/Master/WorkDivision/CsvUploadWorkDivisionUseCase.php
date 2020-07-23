<?php


namespace App\Package\UseCase\Master\WorkDivision;

use App\Package\Domain\Master\WorkDivision\WorkDivision;
use App\Package\Domain\Master\WorkDivision\WorkDivisionId;
use App\Package\Domain\Master\WorkDivision\WorkDivisionName;
use App\Package\Domain\Repository\WorkDivisionInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CsvUploadWorkDivisionUseCase
{
    /** @var WorkDivisionInterface */
    private $workDivisionRepository;

    /**
     * GetWorkDivisionAllUseCase constructor.
     * @param WorkDivisionInterface $workDivisionRepository
     */
    public function __construct( WorkDivisionInterface $workDivisionRepository )
    {
        $this->workDivisionRepository = $workDivisionRepository;
    }

    /**
     * CSVアップロードを保存する
     *
     * @param array $pParams 更新パラメータ
     * @return bool 成功可否
     */
    public function execute( array $pParams ): bool
    {
        try {
            DB::beginTransaction();
            foreach ( $pParams as $aParam )
            {
                /**
                 * Step1.エンティティの生成
                 */
                $aWorkDivision = new WorkDivision(
                    WorkDivisionId::of( $aParam['id'] ),
                    WorkDivisionName::of( $aParam['work_division_name'] ),
                    null
                );

                /**
                 * Step2.永続化
                 */
                $aSavedWorkDivision = $this->workDivisionRepository->upsert( $aWorkDivision );
                if ( !$aSavedWorkDivision )
                {
                    throw new \Exception( '永続処理時にエラーが発生しました。' );
                }
            }
            DB::commit();
        }
        catch ( \Exception $e )
        {
            $aErrMsg = '勤怠区分CSV登録に失敗しました。' . $e->getMessage();
            Log::error( $aErrMsg );
            DB::rollBack();
            return false;
        }
        return true;
    }
}
