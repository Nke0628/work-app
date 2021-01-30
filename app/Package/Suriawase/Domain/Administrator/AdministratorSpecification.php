<?php


namespace App\Package\Suriawase\Domain\Administrator;


use App\Package\Suriawase\Domain\HumanResource\HumanResource;
use App\Package\Suriawase\Domain\SuriawaseConfig\SuriawaseConfig;

/**
 * すり合わせ管理者の仕様クラス
 *
 * Class AdministratorSpecification
 * @package App\Package\Suriawase\Domain\Administrator
 */
class AdministratorSpecification
{
    /**
     * 管理者条件を満たしているか
     *
     * @param HumanResource $humanResource
     * @param SuriawaseConfig $suriawaseConfig
     * @return bool
     */
    public static function isSatisfiedAdminCondition(
        HumanResource $humanResource,
        SuriawaseConfig $suriawaseConfig
    ): bool
    {
        // 管理職すり合わせの場合は管理職のみ
        if ( $suriawaseConfig->isManagerSuriawase()) {
            return $humanResource->isManager();
        }

        // 評価者すり合わせの場合は上位評価者及び、管理職
        if ( $humanResource->getPositionLevel()->isUpperBoss() || $humanResource->isManager() ) {
            return true;
        }

        return false;
    }

    /**
     * 管理者として削除可能かどうか
     *
     * @param HumanResource $humanResource
     * @param SuriawaseConfig $suriawaseConfig
     * @return bool
     */
    public static function canDeleteAdministrator( HumanResource $humanResource, SuriawaseConfig $suriawaseConfig): bool
    {
        // すり合わせ作成者は削除できない
        if ( $suriawaseConfig->isCreator( $humanResource->getSkyId())) {
            return false;
        }

        //　現在のすり合わせ設定者は削除できない

        return true;
    }

}
