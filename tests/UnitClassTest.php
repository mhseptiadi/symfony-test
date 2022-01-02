<?php

use PHPUnit\Framework\TestCase;
use Console\Classes\UnitClass;

class UnitClassTest extends TestCase
{
    public function testUnit()
    {
        $items = file_get_contents('./tests/data/items.json');
        $discountClass = new UnitClass(json_decode($items));

        $averageUnitPrice = $discountClass->getAverageUnitPrice();
        $this->assertEquals(19.99, $averageUnitPrice);

        $distinctUnitCount = $discountClass->getDistinctUnitCount();
        $this->assertEquals(1, $distinctUnitCount);

        $totalUnitCount = $discountClass->getTotalUnitCount();
        $this->assertEquals(2, $totalUnitCount);
    }

    public function testEmptyUnit()
    {
        $discountClass = new UnitClass(json_decode('[]'));

        $averageUnitPrice = $discountClass->getAverageUnitPrice();
        $this->assertEquals(0, $averageUnitPrice);

        $distinctUnitCount = $discountClass->getDistinctUnitCount();
        $this->assertEquals(0, $distinctUnitCount);

        $totalUnitCount = $discountClass->getTotalUnitCount();
        $this->assertEquals(0, $totalUnitCount);
    }
}
