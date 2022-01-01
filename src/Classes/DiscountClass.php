<?php

namespace Console\Classes;

class DiscountClass
{
    public $items;
    public $discounts;
    private $price;

    function __construct($items, $discounts) {
        $this->items = $items;
        $this->discounts = $discounts;
    }

    function getDiscountPrice(): float {
        $price = 0;
        foreach ($this->items as $item) {
            $price += $item->quantity * $item->unit_price;
        }

        usort($this->discounts, array($this, 'priority'));

        $price = $this->calculateDiscount($price, $this->discounts);

        return $price;
    }

    private function calculateDiscount($price, $discounts): float {
        foreach ($discounts as $discount) {
            switch ($discount->type) {
                case 'PERCENTAGE':
                    $price -= $price * $discount->value / 100;
                    break;
                case 'DOLLAR':
                    $price -= $discount->value;
                    break;
            }
        }

        return $price;
    }

    private function priority($a, $b) {
        return strcmp($a->priority, $b->priority);
    }
}
