<?php

/**
 * Created by PhpStorm.
 * User: carlos
 * Date: 19/08/17
 * Time: 21:01
 */
class empresaList
{
    private $_empresa = array();
    private $_empresaCount = 0;
    public function __construct() {
    }
    public function getEmpresaCount() {
        return $this->_empresaCount;
    }
    private function setEmpresaCount($newCount) {
        $this->_empresaCount = $newCount;
    }
    public function getEmpresa($_empresaNumberToGet) {
        if ( (is_numeric($_empresaNumberToGet)) &&
            ($_empresaNumberToGet <= $this->getEmpresaCount())) {
            return $this->_empresa[$_empresaNumberToGet];
        } else {
            return NULL;
        }
    }
    public function addEmpresa(Empresa $_empresa_in) {
        $this->setEmpresaCount($this->getEmpresaCount() + 1);
        $this->_empresa[$this->getEmpresaCount()] = $_empresa_in;
        return $this->getEmpresaCount();
    }
    public function removeEmpresa(Empresa $_empresa_in) {
        $counter = 0;
        while (++$counter <= $this->getEmpresaCount()) {
            if ($_empresa_in->getAuthorAndTitle() ==
                $this->_empresa[$counter]->getAuthorAndTitle())
            {
                for ($x = $counter; $x < $this->getEmpresaCount(); $x++) {
                    $this->_empresa[$x] = $this->_empresa[$x + 1];
                }
                $this->setEmpresaCount($this->getEmpresaCount() - 1);
            }
        }
        return $this->getEmpresaCount();
    }
}