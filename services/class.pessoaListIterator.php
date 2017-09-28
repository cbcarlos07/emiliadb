<?php

/**
 * Created by PhpStorm.
 * User: carlos
 * Date: 19/08/17
 * Time: 21:02
 */
class pessoaListIterator
{
    protected $pessoaList;
    protected $currentPessoa = 0;

    public function __construct(PessoaList $pessoaList_in) {
        $this->pessoaList = $pessoaList_in;
    }
    public function getCurrentPessoa() {
        if (($this->currentPessoa > 0) &&
            ($this->pessoaList->getPessoaCount() >= $this->currentPessoa)) {
            return $this->pessoaList->getPessoa($this->currentPessoa);
        }
    }
    public function getNextPessoa() {
        if ($this->hasNextPessoa()) {
            return $this->pessoaList->getPessoa(++$this->currentPessoa);
        } else {
            return NULL;
        }
    }
    public function hasNextPessoa() {
        if ($this->pessoaList->getPessoaCount() > $this->currentPessoa) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}