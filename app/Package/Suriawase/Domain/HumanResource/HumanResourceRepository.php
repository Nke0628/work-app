<?php


namespace App\Package\Suriawase\Domain\HumanResource;


class HumanResourceRepository
{
    /**
     * 社員IDリストから社員情報リストを取得する
     *
     * @param string[] $personalIdList
     * @return HumanResource[]
     */
    public function fetchHumanResourceListByPersonalIdList( array $personalIdList ): array
    {
        return [
            new HumanResource(
                'S4000',
                new PositionLevel(1),
                true
            )
        ];
    }
}
