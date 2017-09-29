<?php

/**
 * Created by PhpStorm.
 * User: carlos.bruno
 * Date: 28/09/2017
 * Time: 07:58
 */
class telefone
{
    private $pessoa;
    private $nrTelefone;
    private $tpTelefone;
    private $dsObservacao;

    /**
     * @return mixed
     */
    public function getPessoa()
    {
        return $this->pessoa;
    }

    /**
     * @param mixed $pessoa
     * @return telefone
     */
    public function setPessoa($pessoa)
    {
        $this->pessoa = $pessoa;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNrTelefone()
    {
        return $this->nrTelefone;
    }

    /**
     * @param mixed $nrTelefone
     * @return telefone
     */
    public function setNrTelefone($nrTelefone)
    {
        $this->nrTelefone = $nrTelefone;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTpTelefone()
    {
        return $this->tpTelefone;
    }

    /**
     * @param mixed $tpTelefone
     * @return telefone
     */
    public function setTpTelefone($tpTelefone)
    {
        $this->tpTelefone = $tpTelefone;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDsObservacao()
    {
        return $this->dsObservacao;
    }

    /**
     * @param mixed $dsObservacao
     * @return telefone
     */
    public function setDsObservacao($dsObservacao)
    {
        $this->dsObservacao = $dsObservacao;
        return $this;
    }




}