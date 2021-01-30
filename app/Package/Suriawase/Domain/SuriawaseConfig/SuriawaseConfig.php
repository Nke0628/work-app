<?php


namespace App\Package\Suriawase\Domain\SuriawaseConfig;


class SuriawaseConfig
{
    /**
     * @var int
     */
    private $suriawaseConfigId;

    /**
     * @var int
     */
    private $termId;

    /**
     * @var string
     */
    private $title;

    /**
     * @var SuriawaseType
     */
    private $suriawaseType;

    /**
     * @var int
     */
    private $createSkyId;

    /**
     * @var string
     */
    private $createData;

    /**
     * @var int
     */
    private $updateSkyId;

    /**
     * @var string
     */
    private $updateDate;

    /**
     * SuriawaseConfig constructor.
     * @param int $suriawaseConfigId
     * @param int $termId
     * @param string $title
     * @param SuriawaseType $suriawaseType
     * @param int $createSkyId
     * @param string $createData
     * @param int $updateSkyId
     * @param string $updateDate
     */
    public function __construct(int $suriawaseConfigId, int $termId, string $title, SuriawaseType $suriawaseType, int $createSkyId, string $createData, int $updateSkyId, string $updateDate)
    {
        $this->suriawaseConfigId = $suriawaseConfigId;
        $this->termId = $termId;
        $this->title = $title;
        $this->suriawaseType = $suriawaseType;
        $this->createSkyId = $createSkyId;
        $this->createData = $createData;
        $this->updateSkyId = $updateSkyId;
        $this->updateDate = $updateDate;
    }

    /**
     * 管理職すり合わせかどうか
     *
     * @return bool
     */
    public function isManagerSuriawase(): bool
    {
        return $this->suriawaseType->isManagerSuriawase();
    }

    /**
     * すり合わせ作成者かどうか
     *
     * @param int $skyId
     * @return bool
     */
    public function isCreator(int $skyId): bool
    {
        return $this->createSkyId = $skyId;
    }

    /**
     * @return int
     */
    public function getSuriawaseConfigId(): int
    {
        return $this->suriawaseConfigId;
    }

    /**
     * @return int
     */
    public function getTermId(): int
    {
        return $this->termId;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return SuriawaseType
     */
    public function getSuriawaseType(): SuriawaseType
    {
        return $this->suriawaseType;
    }

    /**
     * @return int
     */
    public function getCreateSkyId(): int
    {
        return $this->createSkyId;
    }

    /**
     * @return string
     */
    public function getCreateData(): string
    {
        return $this->createData;
    }

    /**
     * @return int
     */
    public function getUpdateSkyId(): int
    {
        return $this->updateSkyId;
    }

    /**
     * @return string
     */
    public function getUpdateDate(): string
    {
        return $this->updateDate;
    }
}
