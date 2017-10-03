<?php

/**
 * Created by PhpStorm.
 * User: carlos
 * Date: 19/08/17
 * Time: 21:02
 */
class registroListIterator
{
    protected $registroList;
    protected $currentRegistro = 0;

    public function __construct(RegistroList $registroList_in) {
        $this->registroList = $registroList_in;
    }
    public function getCurrentRegistro() {
        if (($this->currentRegistro > 0) &&
            ($this->registroList->getRegistroCount() >= $this->currentRegistro)) {
            return $this->registroList->getRegistro($this->currentRegistro);
        }
    }
    public function getNextRegistro() {
        if ($this->hasNextRegistro()) {
            return $this->registroList->getRegistro(++$this->currentRegistro);
        } else {
            return NULL;
        }
    }
    public function hasNextRegistro() {
        if ($this->registroList->getRegistroCount() > $this->currentRegistro) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}