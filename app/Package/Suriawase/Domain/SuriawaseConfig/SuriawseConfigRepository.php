<?php


namespace App\Package\Suriawase\Domain\SuriawaseConfig;


class SuriawseConfigRepository
{
    public function find(): SuriawaseConfig
    {
        return new SuriawaseConfig(
            1,
            1,
            'サンプルすり合わせ',
            SuriawaseType::MANAGER(),
            100,
            '2021-01-30',
            100,
            '2021--1-30'
        );
    }
}
