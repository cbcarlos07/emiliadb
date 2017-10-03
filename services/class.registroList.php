<?php

/**
 * Created by PhpStorm.
 * User: carlos
 * Date: 19/08/17
 * Time: 21:01
 */
class registroList
{
    private $_registro = array();
    private $_registroCount = 0;
    public function __construct() {
    }
    public function getRegistroCount() {
        return $this->_registroCount;
    }
    private function setRegistroCount($newCount) {
        $this->_registroCount = $newCount;
    }
    public function getRegistro($_registroNumberToGet) {
        if ( (is_numeric($_registroNumberToGet)) &&
            ($_registroNumberToGet <= $this->getRegistroCount())) {
            return $this->_registro[$_registroNumberToGet];
        } else {
            return NULL;
        }
    }
    public function addRegistro(Registro $_registro_in) {
        $this->setRegistroCount($this->getRegistroCount() + 1);
        $this->_registro[$this->getRegistroCount()] = $_registro_in;
        return $this->getRegistroCount();
    }
    public function removeRegistro(Registro $_registro_in) {
        $counter = 0;
        while (++$counter <= $this->getRegistroCount()) {
            if ($_registro_in->getAuthorAndTitle() ==
                $this->_registro[$counter]->getAuthorAndTitle())
            {
                for ($x = $counter; $x < $this->getRegistroCount(); $x++) {
                    $this->_registro[$x] = $this->_registro[$x + 1];
                }
                $this->setRegistroCount($this->getRegistroCount() - 1);
            }
        }
        return $this->getRegistroCount();
    }
}