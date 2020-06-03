<?php


namespace App\Package\Domain\Factory;

use App\Package\Domain\Department\DepartmentId;
use App\Package\Domain\Staff\Staff;
use App\Package\Domain\Staff\StaffId;
use App\Package\Domain\User\UserId;
use Webpatser\Uuid\Uuid;

class StaffFactory
{
    /**
     * スタッフエンティティの生成
     *
     * @param string $userId
     * @param string $departmentId
     * @return Staff
     * @throws \Exception
     */
    public static function createStaffEntity( string $userId, string $departmentId ) :Staff
    {
        return new Staff(
            StaffId::of( Uuid::generate() ),
            UserId::of( $userId ),
            DepartmentId::of( $departmentId )
        );
    }
}
