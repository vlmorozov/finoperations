<?php

namespace Vlmorozov\Finoperations\Types;

class Number implements NumberInterface
{
    /**
     * @param float $value
     */
    public function __construct(
        private float $value = 0.0
    )
    {
    }

    /**
     * @return float
     */
    public function getValue(): float
    {
        return $this->value;
    }

    /**
     * @param NumberInterface $number
     * @return $this
     */
    public function add(NumberInterface $number): self
    {
        $this->value += $number->getValue();
        return $this;
    }

    /**
     * @param NumberInterface $number
     * @return $this
     */
    public function sub(NumberInterface $number): self
    {
        $this->value -= $number->getValue();
        return $this;
    }

    /**
     * @return $this
     */
    public function inverseSign(): self
    {
        $this->value *= -1;
        return $this;
    }

    /**
     * @return bool
     */
    public function isPositive(): bool
    {
        return $this->value > 0;
    }

    /**
     * @return bool
     */
    public function isNegative(): bool
    {
        return $this->value < 0;
    }

    /**
     * @param NumberInterface $number
     * @return bool
     */
    public function lt(NumberInterface $number): bool
    {
        return $this->value < $number->getValue();
    }

}