<?php

namespace Tests\Types;

use PHPUnit\Framework\TestCase;
use Vlmorozov\Finoperations\Types\Date;
use Vlmorozov\Finoperations\Types\DateInterface;

final class DateTest extends TestCase
{
    /**
     * @test
     */
    public function testGetInstance(): void
    {
        $this->assertInstanceOf(DateInterface::class, Date::getInstance());
    }

    public function compareProvider(): array
    {
        return [
            [new Date('2022-04-18 13:00:00'), new Date('2022-04-19 13:00:00'), -1],
            [new Date('2022-04-18 13:00:00'), new Date('2022-04-18 13:00:00'), 0],
            [new Date('2022-04-19 13:00:00'), new Date('2022-04-18 13:00:00'), 1],
        ];
    }

    /**
     * @test
     * @dataProvider compareProvider
     */
    public function testCompare(DateInterface $dateA, DateInterface $dateB, $expected): void
    {
        $this->assertEquals($expected, $dateA->compare($dateB));
    }
}