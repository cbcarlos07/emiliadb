<?php

/**
 * Created by PhpStorm.
 * User: carlos
 * Date: 19/08/17
 * Time: 21:02
 */
class itemListIterator
{
    protected $itemList;
    protected $currentItem = 0;

    public function __construct(ItemList $itemList_in) {
        $this->itemList = $itemList_in;
    }
    public function getCurrentItem() {
        if (($this->currentItem > 0) &&
            ($this->itemList->getItemCount() >= $this->currentItem)) {
            return $this->itemList->getItem($this->currentItem);
        }
    }
    public function getNextItem() {
        if ($this->hasNextItem()) {
            return $this->itemList->getItem(++$this->currentItem);
        } else {
            return NULL;
        }
    }
    public function hasNextItem() {
        if ($this->itemList->getItemCount() > $this->currentItem) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}