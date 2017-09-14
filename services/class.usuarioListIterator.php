<?php

/**
 * Created by PhpStorm.
 * User: carlos
 * Date: 19/08/17
 * Time: 21:02
 */
class usuarioListIterator
{
    protected $usuarioList;
    protected $currentUsuario = 0;

    public function __construct(UsuarioList $usuarioList_in) {
        $this->usuarioList = $usuarioList_in;
    }
    public function getCurrentUsuario() {
        if (($this->currentUsuario > 0) &&
            ($this->usuarioList->getUsuarioCount() >= $this->currentUsuario)) {
            return $this->usuarioList->getUsuario($this->currentUsuario);
        }
    }
    public function getNextUsuario() {
        if ($this->hasNextUsuario()) {
            return $this->usuarioList->getUsuario(++$this->currentUsuario);
        } else {
            return NULL;
        }
    }
    public function hasNextUsuario() {
        if ($this->usuarioList->getUsuarioCount() > $this->currentUsuario) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}