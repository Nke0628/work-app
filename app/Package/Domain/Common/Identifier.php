<?php

namespace App\Package\Domain\Common;

class Identifier
{
    /** @var int */
    protected $value;

    /**
     * Identifier constructor.
     * @param int $value
     */
    private function __construct(int $value)
    {
        if ( !is_numeric($value) )
        {
            throw new \InvalidArgumentException('IDの内容に誤りがあります。' . $value);
        }
        $this->value = $value;
    }

    /**
     * @return int
     */
    public function getValue(): int
    {
        return $this->value;
    }

    /**
     * @param Identifier $id
     * @return bool
     */
    public function equals(self $id): bool
    {
        return $this->value === $id->value;
    }

    /**
     * @param int $value
     * @return $this
     */
    public static function of(int $value): self
    {
        return new static($value);
    }
}
