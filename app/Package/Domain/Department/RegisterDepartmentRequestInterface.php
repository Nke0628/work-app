<?php

namespace App\Package\Domain\Department;

interface RegisterDepartmentRequestInterface
{
    public function getDepartmentName() :string;

    public function getStartWorkTime(): string;

    public function getEndWorkTime(): string;

    public function getStartBreakTime(): string;

    public function getEndBreakTime(): string;
}
