<?php


namespace App\Package\Domain\Repository;


use App\Package\Domain\Staff\Staff;

Interface StaffRepositoryInterface
{
    public function save( Staff $pStaff ):bool;
}
