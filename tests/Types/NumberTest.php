<?php

namespace Tests\Types;

use PHPUnit\Framework\TestCase;
use Vlmorozov\Finoperations\Types\Number;

final class NumberTest extends TestCase
{
    public function getValueProvider(): array
    {
        return [
            [1.0],
            [1],
            [0],
            [-1],
            [-1.0],
        ];
    }

    /**
     * @test
     * @dataProvider getValueProvider
     */
    public function testGetValue($value): void
    {
        $number = new Number($value);

        $this->assertEquals($value, $number->getValue());
    }

    public function addProvider(): array
    {
        return [
            [1.0, 2.0, 3.0],
            [1, 2, 3],
            [0, 0, 0],
            [-1, 1, 0],
            [-1.0, -1, -2],
        ];
    }

    /**
     * @test
     * @dataProvider addProvider
     */
    public function testAdd($a, $b, $expected): void
    {
        $numberA = new Number($a);
        $numberB = new Number($b);

        $result = $numberA->add($numberB);

        $this->assertEquals($expected, $numberA->getValue());
        $this->assertSame($numberA, $result);
    }

    public function subProvider(): array
    {
        return [
            [3.0, 2.0, 1.0],
            [1, 2, -1],
            [0, 0, 0],
            [-1, 1, -2],
            [-1.0, -1, 0],
        ];
    }

    /**
     * @test
     * @dataProvider subProvider
     */
    public function testSub($a, $b, $expected): void
    {
        $numberA = new Number($a);
        $numberB = new Number($b);

        $result = $numberA->sub($numberB);

        $this->assertEquals($expected, $numberA->getValue());
        $this->assertSame($numberA, $result);
    }


    public function inverseSignProvider(): array
    {
        return [
            [1.0, -1.0],
            [0, 0, 0],
            [-1, 1],
        ];
    }

    /**
     * @test
     * @dataProvider inverseSignProvider
     */
    public function testInverseSign($a, $expected): void
    {
        $numberA = new Number($a);

        $result = $numberA->inverseSign();

        $this->assertEquals($expected, $numberA->getValue());
        $this->assertSame($numberA, $result);
    }


    public function isPositiveProvider(): array
    {
        return [
            [1.0, true],
            [0, false],
            [-1, false],
        ];
    }

    /**
     * @test
     * @dataProvider isPositiveProvider
     */
    public function testIsPositive($a, $expected): void
    {
        $numberA = new Number($a);
        $this->assertEquals($expected, $numberA->isPositive());
    }

    public function isNegativeProvider(): array
    {
        return [
            [1.0, false],
            [0, false],
            [-1, true],
        ];
    }

    /**
     * @test
     * @dataProvider isNegativeProvider
     */
    public function testIsNegative($a, $expected): void
    {
        $numberA = new Number($a);
        $this->assertEquals($expected, $numberA->isNegative());
    }


    public function ltProvider(): array
    {
        return [
            [3.0, 2.0, false],
            [1, 2, true],
            [0, 0, false],
            [-1, 1, true],
            [-1.0, -1, false],
        ];
    }

    /**
     * @test
     * @dataProvider ltProvider
     */
    public function testLt($a, $b, $expected): void
    {
        $numberA = new Number($a);
        $numberB = new Number($b);

        $this->assertEquals($expected, $numberA->lt($numberB));
    }

}