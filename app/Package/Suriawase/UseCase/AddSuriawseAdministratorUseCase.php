<?php


namespace App\Package\Suriawase\UseCase;


use App\Package\Suriawase\Domain\Administrator\AdministratorList;
use App\Package\Suriawase\Domain\HumanResource\HumanResourceRepository;
use App\Package\Suriawase\Domain\SuriawaseConfig\SuriawseConfigRepository;

class AddSuriawseAdministratorUseCase
{
    /**
     * @var SuriawseConfigRepository
     */
    private $suriawaseConfigRepository;

    /**
     * @var HumanResourceRepository
     */
    private $humanResourceRepository;

    /**
     * AddSuriawseAdministratorUseCase constructor.
     * @param SuriawseConfigRepository $suriawaseConfigRepository
     * @param HumanResourceRepository $humanResourceRepository
     */
    public function __construct(
        SuriawseConfigRepository $suriawaseConfigRepository,
        HumanResourceRepository $humanResourceRepository
    )
    {
        $this->suriawaseConfigRepository = $suriawaseConfigRepository;
        $this->humanResourceRepository = $humanResourceRepository;
    }

    /**
     * すり合わせ管理者を追加する
     */
    public function execute()
    {
        try {

            /**
             * Step1. すり合わせ設定取得
             */
            $suriawaseConfig = $this->suriawaseConfigRepository->find();
            if ( !$suriawaseConfig ) {
                throw new \Exception('すり合わせ設定が存在していません');
            }

            /**
             * Step2. リクエストリストから社員情報の取得
             */
            $personalIdList = ['S4000','S1000'];
            $humanResourceList = $this->humanResourceRepository->fetchHumanResourceListByPersonalIdList( $personalIdList );
            if ( !$humanResourceList ) {
                throw new \Exception('すり合わせ管理者の追加対象者が存在しません');
            }

            /**
             * Step3. 管理者リストを追加する
             */
            $administratorList = AdministratorList::newCreate();
            $administratorList->add( $humanResourceList, $suriawaseConfig );

        } catch ( \Exception $e ) {

        }



    }
}
