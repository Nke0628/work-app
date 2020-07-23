<?php

namespace App\Package\Infrastructure\Eloquent;

use App\Model\Department as DepartmentModel;
use App\Model\AttendanceProperty as AttendancePropertyModel;
use App\Package\Domain\Department\AttendancePropertyId;
use App\Package\Domain\Department\Department;
use App\Package\Domain\Department\AttendanceProperty;
use App\Package\Domain\Department\DepartmentId;
use App\Package\Domain\Department\EndBreakTime;
use App\Package\Domain\Department\EndWorkTime;
use App\Package\Domain\Department\StartBreakTime;
use App\Package\Domain\Department\StartWorkTime;
use App\Package\Domain\Repository\DepartmentInterface;
use App\Package\Domain\User\UserId;
use App\Package\UseCase\Department\Dto\SearchDepartmentOutput;
use App\Package\UseCase\Department\Dto\SearchDepartmentOutputList;
use App\Package\UseCase\Department\Dto\SearchDepartmentRequest;
use Illuminate\Support\Facades\Auth;

class DepartmentRepository implements DepartmentInterface
{
    const SEARCH_PAGE_NUM = 5;

    /**
     * 検索
     *
     * @param SearchDepartmentRequest $searchDepartmentRequest
     * @return SearchDepartmentOutputList
     */
    public function search( SearchDepartmentRequest $searchDepartmentRequest ): SearchDepartmentOutputList
    {
        $aQuery = DepartmentModel::query();
        $aQuery->leftJoin('attendance_properties', 'departments.id', '=', 'attendance_properties.department_id');

        // 検索クエリ
        $aQuery->where( function($query) use ($searchDepartmentRequest){
            $query->where('name', 'like', '%'.$searchDepartmentRequest->getSearchQuery().'%')
                ->orWhere('work_time_start', 'like', '%'.$searchDepartmentRequest->getSearchQuery().'%')
                ->orWhere('work_time_end', 'like', '%'.$searchDepartmentRequest->getSearchQuery().'%')
                ->orWhere('break_time_start', 'like', '%'.$searchDepartmentRequest->getSearchQuery().'%')
                ->orWhere('break_time_end', 'like', '%'.$searchDepartmentRequest->getSearchQuery().'%');
        });
        //　組織名称
        $aQuery->where('name', 'like', '%'.$searchDepartmentRequest->getDepartmentName().'%');
        //　勤務開始時間
        $aQuery->where('work_time_start', 'like', '%'.$searchDepartmentRequest->getStartWorkTime().'%');
        // 勤務終了時間
        $aQuery->where('work_time_end', 'like', '%'.$searchDepartmentRequest->getEndWorkTIme().'%');
        //　休憩開始時間
        $aQuery->where('break_time_start', 'like', '%'.$searchDepartmentRequest->getStartBreakTime().'%');
        // 休憩終了時間
        $aQuery->where('break_time_end', 'like', '%'.$searchDepartmentRequest->getEndBreakTime().'%');
        $aQuery->select(
            'departments.id',
            'name',
            'work_time_start',
            'work_time_end',
            'break_time_start',
            'break_time_end'
            );
        $aDepartmentModelList = $aQuery->paginate( self::SEARCH_PAGE_NUM );

        $aSearchDepartmentOutputList=array();
        foreach ( $aDepartmentModelList as $aDepartmentModel )
        {
            $aSearchDepartmentOutput = new SearchDepartmentOutput(
                $aDepartmentModel->id,
                $aDepartmentModel->name,
                ( $aDepartmentModel->work_time_start ) ?? '',
                ( $aDepartmentModel->work_time_start ) ?? '',
                ( $aDepartmentModel->work_time_start ) ?? '',
                ( $aDepartmentModel->work_time_start ) ?? ''
            );
            $aSearchDepartmentOutputList[] = $aSearchDepartmentOutput;
        }

        $aPagingParams = array(
            'search_query' => $searchDepartmentRequest->getSearchQuery(),
            'department_name' => $searchDepartmentRequest->getDepartmentName(),
            'start_work_time' => $searchDepartmentRequest->getStartWorkTime(),
            'end_work_time' => $searchDepartmentRequest->getEndWorkTime(),
            'start_break_time' => $searchDepartmentRequest->getStartBreakTime(),
            'end_break_time' => $searchDepartmentRequest->getEndBreakTime()
        );

        return new SearchDepartmentOutputList(
            $aSearchDepartmentOutputList,
            $aDepartmentModelList->appends( $aPagingParams )->links(),
            $searchDepartmentRequest->getSearchQuery(),
            $searchDepartmentRequest->getDepartmentName(),
            $searchDepartmentRequest->getStartWorkTime(),
            $searchDepartmentRequest->getEndWorkTime(),
            $searchDepartmentRequest->getStartBreakTime(),
            $searchDepartmentRequest->getEndBreakTime()
        );
    }

    /**
     * 組織・勤怠設定の登録
     *
     * @param Department $pDepartment
     * @return null | Department
     */
    public function save( Department $pDepartment )
    {
        $aDepartmentModel = new DepartmentModel();
        $aDepartmentModel->id = $pDepartment->getDepartmentId()->getValue();
        $aDepartmentModel->user_id = $pDepartment->getUserId()->getValue();
        $aDepartmentModel->name = $pDepartment->getName();
        $aDepartmentModel->create_user_id = Auth::id();
        $aDepartmentModel->update_user_id = Auth::id();
        if ( !$aDepartmentModel->save() )
        {
            return null;
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
            return null;
        }
        return $this->toEntity( $aDepartmentModel, $aAttendancePropertyModel );
    }

    /**
     * Model→エンティティ変換
     *
     * @param DepartmentModel $pDepartment
     * @param AttendancePropertyModel $pAttendanceProperty
     * @return Department
     */
    private function toEntity( DepartmentModel $pDepartment, AttendancePropertyModel $pAttendanceProperty ): Department
    {
        return new Department(
            DepartmentId::of( $pDepartment->id ),
            UserId::of( $pDepartment->user_id ),
            $pDepartment->name,
            new AttendanceProperty(
                AttendancePropertyId::of( $pAttendanceProperty->id ),
                DepartmentId::of( $pAttendanceProperty->department_id ),
                StartWorkTime::of( $pAttendanceProperty->work_time_start ),
                EndWorkTime::of( $pAttendanceProperty->work_time_end ),
                StartBreakTime::of( $pAttendanceProperty->break_time_start ),
                EndBreakTime::of( $pAttendanceProperty->break_time_end )
            )
        );
    }
}
