<?php

namespace AlexWestergaard\PhpGa4\Event;

use AlexWestergaard\PhpGa4\GA4Exception;
use AlexWestergaard\PhpGa4\Facade;
use AlexWestergaard\PhpGa4\Model;
use AlexWestergaard\PhpGa4\Item;

class Purchase extends Model\Event implements Facade\Purchase
{
    protected $currency;
    protected $transaction_id;
    protected $value;
    protected $affiliation;
    protected $coupon;
    protected $shipping;
    protected $tax;
    protected $items = [];

    public function getName(): string
    {
        return 'purchase';
    }

    public function getParams(): array
    {
        return [
            'currency',
            'transaction_id',
            'value',
            'affiliation',
            'coupon',
            'shipping',
            'tax',
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

        $return[] = 'transaction_id';
        $return[] = 'items';
        return $return;
    }

    public function setCurrency(string $iso)
    {
        $this->currency = $iso;
        return $this;
    }

    public function setTransactionId(string $id)
    {
        $this->transaction_id = $id;
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

        $this->value = $val;
        return $this;
    }

    public function setAffiliation(string $affiliation)
    {
        $this->affiliation = $affiliation;
        return $this;
    }

    public function setCoupon(string $code)
    {
        $this->coupon = $code;
        return $this;
    }

    public function setShipping(float $cost)
    {
        $this->shipping = 0 + $cost;
        return $this;
    }

    public function setTax(float $tax)
    {
        $this->tax = $tax;
        return $this;
    }

    public function addItem(Item $item)
    {
        $this->items[] = $item->toArray();
        return $this;
    }
}
