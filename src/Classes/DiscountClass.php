<?php

namespace Console\Classes;

class DiscountClass
{
    private $items;
    private $discounts;
    private $price;

    public function __construct($items, $discounts)
    {
        $this->items = $items;
        $this->discounts = $discounts;
    }

    public function getDiscountPrice(): float
    {
        $this->price = 0;
        foreach ($this->items as $item) {
            $this->price += $item->quantity * $item->unit_price;
        }

        if (0 === $this->price) {
            return $this->price;
        }

        usort($this->discounts, [$this, 'priority']);

        $this->calculateDiscount($this->discounts);

        return $this->price;
    }

    private function calculateDiscount($discounts): void
    {
        foreach ($discounts as $discount) {
            switch ($discount->type) {
                case 'PERCENTAGE':
                    $this->price -= $this->price * $discount->value / 100;
                    break;
                case 'DOLLAR':
                    $this->price -= $discount->value;
                    break;
            }
        }
    }

    private function priority($a, $b)
    {
        return strcmp($a->priority, $b->priority);
    }
}
