<?php

namespace Vlmorozov\Finoperations\Types;

interface DateInterface
{
    /**
     * @return static
     */
    public static function getInstance(): self;

    /**
     * @param DateInterface $date
     * @return int
     */
    public function compare(DateInterface $date): int;

    /**
     * @return int
     */
    public function getTimestamp(): int;
}