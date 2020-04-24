<?php


namespace App\Package\Domain\Master\WorkDivision;

class WorkDivisionName
{
    const MAX_NAME_SIZE = 255;

    /** @var string */
    private $value;

    /**
     * Identifier constructor.
     * @param string $value
     */
    private function __construct(string $value)
    {
        if ( strlen($value) > self::MAX_NAME_SIZE )
        {
            throw new \InvalidArgumentException('文字数に誤りがあります。' . $value);
        }
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @param WorkDivisionName $workDivisionName
     * @return bool
     */
    public function equals(self $workDivisionName): bool
    {
        return $this->value === $workDivisionName->value;
    }

    /**
     * @param string $value
     * @return $this
     */
    public static function of(string $value): self
    {
        return new static($value);
    }
}
