<?php

/**
 * Created by PhpStorm.
 * User: carlos
 * Date: 19/08/17
 * Time: 21:01
 */
class pessoaList
{
    private $_pessoa = array();
    private $_pessoaCount = 0;
    public function __construct() {
    }
    public function getPessoaCount() {
        return $this->_pessoaCount;
    }
    private function setPessoaCount($newCount) {
        $this->_pessoaCount = $newCount;
    }
    public function getPessoa($_pessoaNumberToGet) {
        if ( (is_numeric($_pessoaNumberToGet)) &&
            ($_pessoaNumberToGet <= $this->getPessoaCount())) {
            return $this->_pessoa[$_pessoaNumberToGet];
        } else {
            return NULL;
        }
    }
    public function addPessoa(Pessoa $_pessoa_in) {
        $this->setPessoaCount($this->getPessoaCount() + 1);
        $this->_pessoa[$this->getPessoaCount()] = $_pessoa_in;
        return $this->getPessoaCount();
    }
    public function removePessoa(Pessoa $_pessoa_in) {
        $counter = 0;
        while (++$counter <= $this->getPessoaCount()) {
            if ($_pessoa_in->getAuthorAndTitle() ==
                $this->_pessoa[$counter]->getAuthorAndTitle())
            {
                for ($x = $counter; $x < $this->getPessoaCount(); $x++) {
                    $this->_pessoa[$x] = $this->_pessoa[$x + 1];
                }
                $this->setPessoaCount($this->getPessoaCount() - 1);
            }
        }
        return $this->getPessoaCount();
    }
}