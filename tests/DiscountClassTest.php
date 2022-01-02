<?php

use PHPUnit\Framework\TestCase;
use Console\Classes\DiscountClass;

class DiscountClassTest extends TestCase
{
    public function testDiscount()
    {
        $discounts = file_get_contents('./tests/data/discounts.json');
        $items = file_get_contents('./tests/data/items.json');
        $discountClass = new DiscountClass(json_decode($items), json_decode($discounts));
        $discountedPrice = $discountClass->getDiscountPrice();
        $this->assertEquals(26.737437999999997, $discountedPrice);
    }

    public function testNoItem()
    {
        $discounts = file_get_contents('./tests/data/discounts.json');
        $discountClass = new DiscountClass(json_decode('[]'), json_decode($discounts));
        $discountedPrice = $discountClass->getDiscountPrice();
        $this->assertEquals(0, $discountedPrice);
    }

    public function testNoDiscount()
    {
        $items = file_get_contents('./tests/data/items.json');
        $discountClass = new DiscountClass(json_decode($items), json_decode('[]'));
        $discountedPrice = $discountClass->getDiscountPrice();
        $this->assertEquals(39.98, $discountedPrice);
    }
}
