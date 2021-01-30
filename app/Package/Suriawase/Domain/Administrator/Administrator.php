<?php


namespace App\Package\Suriawase\Domain\Administrator;


class Administrator
{
    /**
     * @var int
     */
    private $administrator_id;

    /**
     * @var string
     */
    private $personal_id;

    /**
     * Administrator constructor.
     * @param int $administrator_id
     * @param string $personal_id
     */
    public function __construct(
        int $administrator_id,
        string $personal_id
    )
    {
        $this->administrator_id = $administrator_id;
        $this->personal_id = $personal_id;
    }

    /**
     * 新規生成
     *
     * @param string $personalId
     * @return static
     */
    public static function newCreate( string $personalId )
    {
        return new static(
            null,
            $personalId
        );
    }

    /**
     * @return int
     */
    public function getAdministratorId(): int
    {
        return $this->administrator_id;
    }

    /**
     * @return string
     */
    public function getPersonalId(): string
    {
        return $this->personal_id;
    }
}
