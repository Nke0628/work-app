<?php


namespace App\Package\Suriawase\Domain\Administrator;


use App\Package\Suriawase\Domain\SuriawaseConfig\SuriawaseConfig;

class AdministratorRepository
{
    /**
     * @param SuriawaseConfig $suriawaseConfig
     * @return AdministratorList
     */
    public function fetchAdministratorList( SuriawaseConfig $suriawaseConfig ): AdministratorList
    {
        return new AdministratorList(
            [
                new Administrator(
                  1,
                  'S4000'
                )
            ]
        );
    }
}
