<?php

/**
 * Created by PhpStorm.
 * User: carlos
 * Date: 19/08/17
 * Time: 21:01
 */
class itemList
{
    private $_item = array();
    private $_itemCount = 0;
    public function __construct() {
    }
    public function getItemCount() {
        return $this->_itemCount;
    }
    private function setItemCount($newCount) {
        $this->_itemCount = $newCount;
    }
    public function getItem($_itemNumberToGet) {
        if ( (is_numeric($_itemNumberToGet)) &&
            ($_itemNumberToGet <= $this->getItemCount())) {
            return $this->_item[$_itemNumberToGet];
        } else {
            return NULL;
        }
    }
    public function addItem(Item $_item_in) {
        $this->setItemCount($this->getItemCount() + 1);
        $this->_item[$this->getItemCount()] = $_item_in;
        return $this->getItemCount();
    }
    public function removeItem(Item $_item_in) {
        $counter = 0;
        while (++$counter <= $this->getItemCount()) {
            if ($_item_in->getAuthorAndTitle() ==
                $this->_item[$counter]->getAuthorAndTitle())
            {
                for ($x = $counter; $x < $this->getItemCount(); $x++) {
                    $this->_item[$x] = $this->_item[$x + 1];
                }
                $this->setItemCount($this->getItemCount() - 1);
            }
        }
        return $this->getItemCount();
    }
}