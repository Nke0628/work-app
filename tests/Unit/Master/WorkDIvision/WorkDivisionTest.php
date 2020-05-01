<?php

namespace Tests\Unit;

use App\Model\WorkDivision;
use App\Package\Domain\Master\WorkDivision\WorkDivisionList;
use App\Package\Infrastructure\Eloquent\WorkDivisionRepository;
use App\Package\UseCase\Master\WorkDivision\GetWorkDivisionAllUseCase;
use App\Package\UseCase\Master\WorkDivision\OutPutData\ShowWorkDivisionListDto;
use Mockery;
use Tests\TestCase;

class WorkDivisionTest extends TestCase
{
    /** @var Mockery */
    protected $repositoryMock;

    /** @var GetWorkDivisionAllUseCase */
    protected $getWorkDivisionAllUseCase;

    public function setUp()
    {
        parent::setUp();

        // 擬似データ作成
        $aWorkDivision = factory( WorkDivision::class )
            ->make()
            ->toEntity();
        $aWorkDivisionList = new WorkDivisionList();
        for( $aIndex = 0 ; $aIndex < 5 ; $aIndex++ )
        {
            $aWorkDivisionList->add( $aWorkDivision );
        }

        // WorkDivisionRepositoryのMock作成
        $this->repositoryMock = Mockery::mock(WorkDivisionRepository::class);
        $this->repositoryMock->shouldReceive('findAll')
            ->andReturn($aWorkDivisionList);
        $this->app->instance(WorkDivisionRepository::class, $this->repositoryMock);

        // UseCaseのインスタンス作成
        $this->getWorkDivisionAllUseCase = app(GetWorkDivisionAllUseCase::class);
    }

    /**
     * @test
     */
    public function 返り値がShowWorkDivisionListDtoであること()
    {
        $data = $this->getWorkDivisionAllUseCase->execute();
        $this->assertInstanceOf(ShowWorkDivisionListDto::class, $data);
    }

    /**
     * @test
     */
    public function 必要なプロパティを保持していること()
    {
        $data = $this->getWorkDivisionAllUseCase->execute();

        foreach ( $data->getWorkDivisionList() as $aWorkDivisionDto )
        {
            $this->assertObjectHasAttribute('id', $aWorkDivisionDto );
            $this->assertObjectHasAttribute('division_name', $aWorkDivisionDto );
            $this->assertObjectHasAttribute('update_date', $aWorkDivisionDto );
        }
    }
}
