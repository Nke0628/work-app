<?php

namespace App\Package\Domain\Common;

use http\Exception\InvalidArgumentException;

class MonthDay
{
    /** @var string */
    protected $value;

    /**
     * Identifier constructor.
     * @param string $value
     */
    private function __construct(string $value)
    {
        if ( preg_match('/^(2[0-3]|[01][0-9])[0-5][0-9]$/', $value) !== 1 )
        {
            throw new \InvalidArgumentException( '日付の値が不適切です。' );
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
     * @param Identifier $id
     * @return bool
     */
    public function equals(self $id): bool
    {
        return $this->value === $id->value;
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
