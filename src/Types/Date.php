<?php

namespace Vlmorozov\Finoperations\Types;

class Date extends \DateTimeImmutable implements DateInterface
{
    /**
     * @return DateInterface
     */
    public static function getInstance(): DateInterface
    {
        return new self();
    }

    /**
     * @param DateInterface $date
     * @return int
     */
    public function compare(DateInterface $date): int
    {
        return match (true) {
            $this->getTimestamp() === $date->getTimestamp() => 0,
            $this->getTimestamp() < $date->getTimestamp() => -1,
            $this->getTimestamp() > $date->getTimestamp() => 1,
        };
    }

}