<?php


namespace App\Package\Suriawase\Domain\Administrator;


use App\Package\Suriawase\Domain\HumanResource\HumanResource;
use App\Package\Suriawase\Domain\SuriawaseConfig\SuriawaseConfig;

class AdministratorList
{
    /**
     * @var Administrator[]
     */
    private $administratorList;

    /**
     * AdministratorList constructor.
     * @param Administrator[] $administratorList
     */
    public function __construct(array $administratorList)
    {
        $this->administratorList = $administratorList;
    }

    /**
     * 新規生成
     */
    public static  function newCreate(): self
    {
        return new static(
            []
        );
    }

    /**
     * 管理者が存在するか;
     *
     * @return bool
     */
    public function exist(): bool
    {
        return !empty($this->administratorList);
    }

    /**
     * 管理者として追加済みの社員かどうか
     *
     * @param int $personalId
     * @return bool
     */
    public function isAddedHuman(int $personalId): bool
    {
        foreach ( $this->administratorList as $administrator ) {

        }
        return false;
    }

    /**
     * 管理者追加
     *
     * @param HumanResource[] $humanResourceList
     * @param SuriawaseConfig $suriawaseConfig
     */
    public function add(array $humanResourceList, SuriawaseConfig $suriawaseConfig): void
    {
        foreach($humanResourceList as $humanResource ) {
            if ( AdministratorSpecification::isSatisfiedAdminCondition( $humanResource, $suriawaseConfig )) {
                throw new \UnexpectedValueException('管理者として追加することはできません。');
            }
            $this->administratorList[] = Administrator::newCreate($humanResource->getPersonalId());
        }
    }

    /**
     * 削除対象者の検証
     *
     * @param array $humanResourceList
     * @param SuriawaseConfig $suriawaseConfig
     */
    public function verifyDeleteAdministrator(array $humanResourceList, SuriawaseConfig $suriawaseConfig): void
    {
        foreach ( $humanResourceList as $humanResource ) {
            if ( !AdministratorSpecification::canDeleteAdministrator( $humanResource, $suriawaseConfig )){
                throw new \UnexpectedValueException('管理者として削除することはできません。');
            }
        }
    }
}
