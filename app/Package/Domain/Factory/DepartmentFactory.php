<?php


namespace App\Package\Domain\Factory;

use App\Package\Domain\Department\AttendanceProperty;
use App\Package\Domain\Department\AttendancePropertyId;
use App\Package\Domain\Department\Department;
use App\Package\Domain\Department\DepartmentId;
use App\Package\Domain\Department\EndBreakTime;
use App\Package\Domain\Department\EndWorkTime;
use App\Package\Domain\Department\StartBreakTime;
use App\Package\Domain\Department\StartWorkTime;
use App\Package\Domain\User\UserId;
use Webpatser\Uuid\Uuid;

class DepartmentFactory
{
    /**
     * Departmentエンティティの生成
     *
     * @param string $departmentName
     * @param string $workTimeStart
     * @param string $workTimeEnd
     * @param string $breakTimeStart
     * @param string $breakTimeEnd
     * @param string $userId
     * @return Department
     * @throws \Exception
     */
    public static function createDepartmentEntity(
        string $departmentName,
        string $workTimeStart,
        string $workTimeEnd,
        string $breakTimeStart,
        string $breakTimeEnd,
        string $userId
    ) :Department
    {
        $aDepartmentId = DepartmentId::of( Uuid::generate() );
        return new Department(
            $aDepartmentId,
            UserId::of( $userId ),
            $departmentName,
            new AttendanceProperty(
                AttendancePropertyId::of( Uuid::generate() ),
                $aDepartmentId,
                StartWorkTime::of( $workTimeStart ),
                EndWorkTime::of( $workTimeEnd ),
                StartBreakTime::of( $breakTimeStart ),
                EndBreakTime::of( $breakTimeEnd )
            )
        );
    }
}
