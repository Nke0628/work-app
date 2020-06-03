<?php

namespace Tests\Unit;

use App\Package\Test\Department\InMemoryDepartmentRepository;
use App\Package\Test\Department\InMemoryRegisterDepartmentFormRequest;
use App\Package\Test\Staff\InMemoryStaffRepository;
use App\Package\UseCase\Department\RegisterDepartmentUseCase;
use Tests\TestCase;

class RegisterDepartmentTest extends TestCase
{
    /** @var RegisterDepartmentUseCase */
    protected $registerDepartmentUseCase;

    public function setUp()
    {
        parent::setUp();

        $this->registerDepartmentUseCase = new RegisterDepartmentUseCase(
            new InMemoryDepartmentRepository(),
            new InMemoryStaffRepository()
        );
    }

    /**
     * @test
     * @dataProvider dataProvider
     */
    public function 基本動作テスト( $pExpected, $pValue )
    {
        $aDummyUserId = 1;
        $aResult = $this->registerDepartmentUseCase->execute( $pValue, $aDummyUserId );
        $this->assertEquals( $pExpected, $aResult);
    }

    /**
     * @test
     * @dataProvider exceptionDataProvider
     */
    public function 不適切な値が渡されると例外が発生すること( $pExpected, $pValue )
    {
        $aDummyUserId = 1;
        $aUseCase = new RegisterDepartmentUseCase(
            new InMemoryDepartmentRepository(),
            new InMemoryStaffRepository()
        );
        $this->expectException($pExpected);
        $aUseCase->execute( $pValue, $aDummyUserId );
    }

    /**
     *
     * @return array
     */
    public function dataProvider(): array
    {
        return [
            [
                true,
                new InMemoryRegisterDepartmentFormRequest(
                    'test',
                    '2222',
                    '1730',
                    '1200',
                    '1300'
                )
            ],
        ];
    }

    /**
     * @return array
     */
    public function exceptionDataProvider()
    {
        return array(
            [
                \Exception::class
                ,
                new InMemoryRegisterDepartmentFormRequest(
                    'test',
                    '9999',
                    '1730',
                    '1200',
                    '1300'
                )
            ],
            [
                \Exception::class
                ,
                new InMemoryRegisterDepartmentFormRequest(
                    'test',
                    '0900',
                    '8888',
                    '1200',
                    '1300'
                )
            ],
            [
                \Exception::class
                ,
                new InMemoryRegisterDepartmentFormRequest(
                    'test',
                    '0900',
                    '1730',
                    '7777',
                    '1300'
                )
            ],
            [
                \Exception::class
                ,
                new InMemoryRegisterDepartmentFormRequest(
                    'test',
                    '0900',
                    '1730',
                    '1200',
                    '6666'
                )
            ]
        );
    }
}
