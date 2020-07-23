<?php


namespace App\Package\UseCase\Department;

use App\Package\Domain\Factory\DepartmentFactory;
use App\Package\Domain\Factory\StaffFactory;
use App\Package\Domain\Repository\DepartmentInterface;
use App\Package\Domain\Repository\StaffRepositoryInterface;
use App\Package\UseCase\Department\Dto\RegisterDepartmentOutput;
use App\Package\UseCase\Department\Dto\RegisterDepartmentRequest;
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
     * @param RegisterDepartmentRequest $pRequest
     * @return RegisterDepartmentOutput
     * @throws \Exception
     */
    public function execute( RegisterDepartmentRequest $pRequest ): RegisterDepartmentOutput
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
                $pRequest->getUserId()
            );
            $aCreatedDepartment = $this->departmentRepository->save( $aDepartment );
            if ( !$aCreatedDepartment )
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
            $aCreatedStaff = $this->staffRepository->save( $aStaff );
            if ( !$aCreatedStaff )
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
        return new RegisterDepartmentOutput(
            $aDepartment->getDepartmentId()->getValue(),
            $aDepartment->getName(),
            $aDepartment->getAttendanceProperty()->getStartWorkTime()->getValue(),
            $aDepartment->getAttendanceProperty()->getEndWorkTime()->getValue(),
            $aDepartment->getAttendanceProperty()->getStartBreakTime()->getValue(),
            $aDepartment->getAttendanceProperty()->getEndBreakTime()->getValue()
        );
    }
}
