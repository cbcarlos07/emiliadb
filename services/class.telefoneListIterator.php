<?php

/**
 * Created by PhpStorm.
 * User: carlos
 * Date: 19/08/17
 * Time: 21:02
 */
class telefoneListIterator
{
    protected $telefoneList;
    protected $currentTelefone = 0;

    public function __construct(TelefoneList $telefoneList_in) {
        $this->telefoneList = $telefoneList_in;
    }
    public function getCurrentTelefone() {
        if (($this->currentTelefone > 0) &&
            ($this->telefoneList->getTelefoneCount() >= $this->currentTelefone)) {
            return $this->telefoneList->getTelefone($this->currentTelefone);
        }
    }
    public function getNextTelefone() {
        if ($this->hasNextTelefone()) {
            return $this->telefoneList->getTelefone(++$this->currentTelefone);
        } else {
            return NULL;
        }
    }
    public function hasNextTelefone() {
        if ($this->telefoneList->getTelefoneCount() > $this->currentTelefone) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}