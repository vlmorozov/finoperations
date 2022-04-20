<?php

namespace Vlmorozov\Finoperations\Types;

interface NumberInterface
{
    /**
     * @return float
     */
    public function getValue(): float;

    /**
     * @param NumberInterface $number
     * @return $this
     */
    public function add(NumberInterface $number): self;

    /**
     * @param NumberInterface $number
     * @return $this
     */
    public function sub(NumberInterface $number): self;

    /**
     * @return $this
     */
    public function inverseSign(): self;

    /**
     * @return bool
     */
    public function isPositive(): bool;

    /**
     * @return bool
     */
    public function isNegative(): bool;

    /**
     * @param NumberInterface $number
     * @return bool
     */
    public function lt(NumberInterface $number): bool;
}