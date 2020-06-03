<?php


namespace App\Package\UseCase\Department;

use App\Package\Domain\Department\RegisterDepartmentRequestInterface;
use App\Package\Domain\Factory\DepartmentFactory;
use App\Package\Domain\Factory\StaffFactory;
use App\Package\Domain\Repository\DepartmentInterface;
use App\Package\Domain\Repository\StaffRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RegisterDepartmentUseCase
{
    /** @var DepartmentInterface */
    private $departmentRepository;

    /** @var StaffRepositoryInterface */
    private $staffRepository;

    /**
     * GetWorkDivisionAllUseCase constructor.
     * @param DepartmentInterface $departmentRepository
     * @param StaffRepositoryInterface $staffRepository
     */
    public function __construct( DepartmentInterface $departmentRepository, StaffRepositoryInterface $staffRepository )
    {
        $this->departmentRepository = $departmentRepository;
        $this->staffRepository = $staffRepository;
    }

    /**
     * 組織を登録する
     *
     * @param RegisterDepartmentRequestInterface $pRequest
     * @param string $userId
     * @return bool
     * @throws \Exception
     */
    public function execute( RegisterDepartmentRequestInterface $pRequest, string $userId ): bool
    {
        try
        {
            DB::beginTransaction();
            /**
             * Step1.組織/勤怠設定を登録する
             */
            $aDepartment = DepartmentFactory::createDepartmentEntity(
                $pRequest->getDepartmentName(),
                $pRequest->getStartWorkTime(),
                $pRequest->getEndWorkTime(),
                $pRequest->getStartBreakTime(),
                $pRequest->getEndBreakTime(),
                $userId
            );
            $aResult = $this->departmentRepository->save( $aDepartment );
            if ( !$aResult )
            {
                throw new \Exception( '組織/勤怠設定の登録に失敗しました。' );
            }

            /**
             * Step2.組織作成者をスタッフとして登録する
             */
            $aStaff = StaffFactory::createStaffEntity(
                $aDepartment->getUserId()->getValue(),
                $aDepartment->getDepartmentId()->getValue()
            );
            $aResult = $this->staffRepository->save( $aStaff );
            if ( !$aResult )
            {
                throw new \Exception( '組織/勤怠設定の登録に失敗しました。' );
            }
            DB::commit();
        }
        catch ( \Exception $e )
        {
            $aErrMsg = $e->getMessage() . '登録者ID: ' . Auth::id();
            Log::error( $aErrMsg );
            DB::rollBack();
            throw $e;
        }
        return true;
    }
}
