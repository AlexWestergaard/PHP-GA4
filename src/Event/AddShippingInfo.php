<?php

namespace AlexWestergaard\PhpGa4\Event;

use AlexWestergaard\PhpGa4\GA4Exception;
use AlexWestergaard\PhpGa4\Facade;
use AlexWestergaard\PhpGa4\Model;
use AlexWestergaard\PhpGa4\Item;

class AddShippingInfo extends Model\Event implements Facade\AddShippingInfo
{
    protected $currency;
    protected $value;
    protected $coupon;
    protected $shipping_tier;
    protected $items = [];

    public function getName(): string
    {
        return 'add_shipping_info';
    }

    public function getParams(): array
    {
        return [
            'currency',
            'value',
            'coupon',
            'shipping_tier',
            'items',
        ];
    }

    public function getRequiredParams(): array
    {
        $return = [];

        if (
            isset($this->currency) && !isset($this->value)
            || !isset($this->currency) && isset($this->value)
        ) {
            $return = [
                'currency',
                'value'
            ];
        }

        $return[] = 'items';
        return $return;
    }

    public function setCurrency(string $iso)
    {
        $this->currency = $iso;
        return $this;
    }

    /**
     * @param int|float $val
     */
    public function setValue($val)
    {
        if (!is_numeric($val)) {
            throw new GA4Exception("setValue value must be numeric");
        }

        $this->value = 0 + $val;
        return $this;
    }

    public function setCoupon(string $code)
    {
        $this->coupon = $code;
        return $this;
    }

    public function setShippingTier(string $tier)
    {
        $this->shipping_tier = $tier;
        return $this;
    }

    public function addItem(Item $item)
    {
        $this->items[] = $item->toArray();
        return $this;
    }
}
