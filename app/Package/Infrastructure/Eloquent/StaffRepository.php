<?php


namespace App\Package\Infrastructure\Eloquent;


use App\Package\Domain\Repository\StaffRepositoryInterface;
use App\Package\Domain\Staff\Staff;
use App\Model\Staff as StaffModel;
use Illuminate\Support\Facades\Auth;

class StaffRepository implements StaffRepositoryInterface
{
    /**
     * スタッフを保存する
     *
     * @param Staff $pStaff
     * @return bool
     */
    public function save( Staff $pStaff ): bool
    {
        $aStaffModel = new StaffModel();
        $aStaffModel->id = $pStaff->getStaffId()->getValue();
        $aStaffModel->user_id = $pStaff->getUserId()->getValue();
        $aStaffModel->department_id = $pStaff->getDepartmentId()->getValue();
        $aStaffModel->delete_flag = 0;
        $aStaffModel->create_user_id = Auth::id();
        $aStaffModel->update_user_id = Auth::id();
        $aResult = $aStaffModel->save();
        if ( $aResult )
        {
            return true;
        }
        return false;
    }
}
