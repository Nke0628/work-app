<?php

namespace App\Package\Infrastructure\Eloquent;

use App\Model\AttendanceProperty;
use App\Package\Domain\Department\Department;
use App\Package\Domain\Repository\DepartmentInterface;
use App\Model\Department as DepartmentModel;
use App\Model\AttendanceProperty as AttendancePropertyModel;
use Illuminate\Support\Facades\Auth;

class DepartmentRepository implements DepartmentInterface
{
    /**
     * 組織・勤怠設定の登録
     *
     * @param Department $pDepartment
     * @return bool 成功可否
     */
    public function save( Department $pDepartment ): bool
    {
        $aDepartmentModel = new DepartmentModel();
        $aDepartmentModel->id = $pDepartment->getDepartmentId()->getValue();
        $aDepartmentModel->user_id = $pDepartment->getUserId()->getValue();
        $aDepartmentModel->name = $pDepartment->getName();
        $aDepartmentModel->create_user_id = Auth::id();
        $aDepartmentModel->update_user_id = Auth::id();
        if ( !$aDepartmentModel->save() )
        {
            return false;
        }

        $aAttendancePropertyModel = new AttendancePropertyModel();
        $aAttendancePropertyModel->id = $pDepartment->getAttendanceProperty()->getAttendancePropertyId()->getValue();
        $aAttendancePropertyModel->department_id = $pDepartment->getAttendanceProperty()->getDepartmentId()->getValue();
        $aAttendancePropertyModel->work_time_start = $pDepartment->getAttendanceProperty()->getStartWorkTime()->getValue();
        $aAttendancePropertyModel->work_time_end = $pDepartment->getAttendanceProperty()->getEndWorkTime()->getValue();
        $aAttendancePropertyModel->break_time_start = $pDepartment->getAttendanceProperty()->getStartBreakTime()->getValue();
        $aAttendancePropertyModel->break_time_end = $pDepartment->getAttendanceProperty()->getEndBreakTime()->getValue();
        $aAttendancePropertyModel->create_user_id = Auth::id();
        $aAttendancePropertyModel->update_user_id = Auth::id();
        if ( !$aAttendancePropertyModel->save() )
        {
            return false;
        }
        return true;
    }
}
