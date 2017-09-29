<?php

/**
 * Created by PhpStorm.
 * User: carlos
 * Date: 19/08/17
 * Time: 21:01
 */
class telefoneList
{
    private $_telefone = array();
    private $_telefoneCount = 0;
    public function __construct() {
    }
    public function getTelefoneCount() {
        return $this->_telefoneCount;
    }
    private function setTelefoneCount($newCount) {
        $this->_telefoneCount = $newCount;
    }
    public function getTelefone($_telefoneNumberToGet) {
        if ( (is_numeric($_telefoneNumberToGet)) &&
            ($_telefoneNumberToGet <= $this->getTelefoneCount())) {
            return $this->_telefone[$_telefoneNumberToGet];
        } else {
            return NULL;
        }
    }
    public function addTelefone(Telefone $_telefone_in) {
        $this->setTelefoneCount($this->getTelefoneCount() + 1);
        $this->_telefone[$this->getTelefoneCount()] = $_telefone_in;
        return $this->getTelefoneCount();
    }
    public function removeTelefone(Telefone $_telefone_in) {
        $counter = 0;
        while (++$counter <= $this->getTelefoneCount()) {
            if ($_telefone_in->getAuthorAndTitle() ==
                $this->_telefone[$counter]->getAuthorAndTitle())
            {
                for ($x = $counter; $x < $this->getTelefoneCount(); $x++) {
                    $this->_telefone[$x] = $this->_telefone[$x + 1];
                }
                $this->setTelefoneCount($this->getTelefoneCount() - 1);
            }
        }
        return $this->getTelefoneCount();
    }
}