<?php

namespace Tests\Unit\Department\UseCase;

use App\Package\Test\Department\InMemoryDepartmentRepository;
use App\Package\Test\Staff\InMemoryStaffRepository;
use App\Package\UseCase\Department\Dto\RegisterDepartmentOutput;
use App\Package\UseCase\Department\Dto\RegisterDepartmentRequest;
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
        $aResult = $this->registerDepartmentUseCase->execute( $pValue );
        $this->assertEquals( $pExpected->getDepartmentName(), $aResult->getDepartmentName());
    }

    /**
     * @test
     * @dataProvider exceptionDataProvider
     */
    public function 不適切な値が渡されると例外が発生すること( $pExpected, $pValue )
    {
        $aUseCase = new RegisterDepartmentUseCase(
            new InMemoryDepartmentRepository(),
            new InMemoryStaffRepository()
        );
        $this->expectException($pExpected);
        $aUseCase->execute( $pValue );
    }

    /**
     *
     * @return array
     */
    public function dataProvider(): array
    {
        return [
            [
                new RegisterDepartmentOutput(
                    'test',
                '株式会社テスト',
                    '0900',
                    '1730',
                    '1200',
                    '1300'
                ),
                new RegisterDepartmentRequest(
                    '株式会社テスト',
                    '0900',
                    '1730',
                    '1200',
                    '1300',
                    '1'
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
                new RegisterDepartmentRequest(
                    'test',
                    '9999',
                    '1730',
                    '1200',
                    '1300',
                    '1'
                )
            ],
            [
                \Exception::class
                ,
                new RegisterDepartmentRequest(
                    'test',
                    '0900',
                    '9999',
                    '1200',
                    '1300',
                    '1'
                )
            ],
            [
                \Exception::class
                ,
                new RegisterDepartmentRequest(
                    'test',
                    '0900',
                    '1730',
                    '9999',
                    '1300',
                    '1'
                )
            ],
            [
                \Exception::class
                ,
                new RegisterDepartmentRequest(
                    'test',
                    '0900',
                    '1730',
                    '1200',
                    '9999',
                    '1'
                )
            ]
        );
    }
}
