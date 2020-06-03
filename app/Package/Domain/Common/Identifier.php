<?php

namespace App\Package\Domain\Common;

class Identifier
{
    /** @var string */
    protected $value;

    /**
     * Identifier constructor.
     * @param string $value
     */
    private function __construct(string $value)
    {
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
