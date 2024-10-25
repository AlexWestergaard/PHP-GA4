<?php

namespace AlexWestergaard\PhpGa4;

use AlexWestergaard\PhpGa4\Model;
use AlexWestergaard\PhpGa4\Facade;

/**
 * @requires One of item_id or item_name must be present and valid
 */
class Item extends Model\ToArray implements Facade\Export, Facade\Item
{
    protected $item_id;
    protected $item_name;
    protected $affiliation;
    protected $coupon;
    protected $currency;
    protected $discount;
    protected $index;
    protected $item_brand;
    protected $item_category = [];
    protected $item_list_id;
    protected $item_list_name;
    protected $item_variant;
    protected $location_id;
    protected $price;
    protected $quantity;

    public function setItemId(string $id)
    {
        $this->item_id = $id;
        return $this;
    }

    public function setItemName(string $name)
    {
        $this->item_name = $name;
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

    public function setCurrency(string $iso)
    {
        $this->currency = $iso;
        return $this;
    }

    /**
     * @param int|float $amount
     */
    public function setDiscount($amount)
    {
        if (!is_numeric($amount)) {
            throw new GA4Exception("setDiscount value must be numeric");
        }

        $this->discount = $amount;
        return $this;
    }

    public function setIndex(int $i)
    {
        $this->index = $i;
        return $this;
    }

    public function setItemBrand(string $brand)
    {
        $this->item_brand = $brand;
        return $this;
    }

    public function addItemCategory(string $category)
    {
        $this->item_category[] = $category;
        return $this;
    }

    public function setItemListId(string $id)
    {
        $this->item_list_id = $id;
        return $this;
    }

    public function setItemListName(string $name)
    {
        $this->item_list_name = $name;
        return $this;
    }

    public function setItemVariant(string $variant)
    {
        $this->item_variant = $variant;
        return $this;
    }

    public function setLocationId(string $id)
    {
        $this->location_id = $id;
        return $this;
    }

    /**
     * @param int|float $amount
     */
    public function setPrice($amount)
    {
        if (!is_numeric($amount)) {
            throw new GA4Exception("setPrice value must be numeric");
        }

        $this->price = 0 + $amount;
        return $this;
    }

    public function setQuantity(int $amount)
    {
        $this->quantity = $amount;
        return $this;
    }

    public function getParams(): array
    {
        return [
            'item_id',
            'item_name',
            'affiliation',
            'coupon',
            'currency',
            'discount',
            'index',
            'item_brand',
            'item_category',
            'item_list_id',
            'item_list_name',
            'item_variant',
            'location_id',
            'price',
            'quantity',
        ];
    }

    public function getRequiredParams(): array
    {
        $return = [];

        if (
            (!isset($this->item_id) || empty($this->item_id) && strval($this->item_id) !== '0')
            && (!isset($this->item_name) || empty($this->item_name) && strval($this->item_name) !== '0')
        ) {
            $return = [
                'item_id',
                'item_name',
            ];
        }

        return $return;
    }

    public static function fromArray(array $params = [])
    {
        $item = static::new();

        $insertables = array_unique(array_merge($item->getParams(), $item->getRequiredParams()));

        foreach ($insertables as $insertable) {
            if (!in_array($insertable, array_keys($params)) || is_null($param = $params[$insertable])) {
                continue;
            }

            $callableName = implode('', array_map('ucfirst', explode('_', $insertable)));

            if (method_exists($item, ($method = 'add' . $callableName))) {
                $item->$method($param);
            } elseif (method_exists($item, ($method = 'set' . $callableName))) {
                $item->$method($param);
            }
        }

        return $item;
    }

    /**
     * @param GA4Exception $childErrors
     */
    public function toArray(bool $isParent = false, $childErrors = null): array
    {
        if (!($childErrors instanceof GA4Exception) && $childErrors !== null) {
            throw new GA4Exception("$childErrors is neither NULL of instance of GA4Exception");
        }
        $return = parent::toArray($isParent, $childErrors);

        if (isset($return['item_category'])) {
            $cats = $return['item_category'];
            unset($return['item_category']);

            foreach ($cats as $i => $v) {
                $id = $i > 0 ? $i + 1 : '';
                $return['item_category' . $id] = $v;
            }
        }

        return $return;
    }

    public static function new()
    {
        return new static();
    }
}
