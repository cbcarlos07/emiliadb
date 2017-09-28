<?php

/**
 * Created by PhpStorm.
 * User: carlos.bruno
 * Date: 25/09/2017
 * Time: 11:53
 */
class pessoa
{
    private $cdPessoa;
    private $nmPessoa;
    private $nrCracha;
    private $empresa;
    private $nrCep;
    private $nrCasa;
    private $dsComplemento;

    /**
     * @return mixed
     */
    public function getCdPessoa()
    {
        return $this->cdPessoa;
    }

    /**
     * @param mixed $cdPessoa
     * @return pessoa
     */
    public function setCdPessoa($cdPessoa)
    {
        $this->cdPessoa = $cdPessoa;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNmPessoa()
    {
        return $this->nmPessoa;
    }

    /**
     * @param mixed $nmPessoa
     * @return pessoa
     */
    public function setNmPessoa($nmPessoa)
    {
        $this->nmPessoa = $nmPessoa;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNrCracha()
    {
        return $this->nrCracha;
    }

    /**
     * @param mixed $nrCracha
     * @return pessoa
     */
    public function setNrCracha($nrCracha)
    {
        $this->nrCracha = $nrCracha;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmpresa()
    {
        return $this->empresa;
    }

    /**
     * @param mixed $empresa
     * @return pessoa
     */
    public function setEmpresa($empresa)
    {
        $this->empresa = $empresa;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNrCep()
    {
        return $this->nrCep;
    }

    /**
     * @param mixed $nrCep
     * @return pessoa
     */
    public function setNrCep($nrCep)
    {
        $this->nrCep = $nrCep;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNrCasa()
    {
        return $this->nrCasa;
    }

    /**
     * @param mixed $nrCasa
     * @return pessoa
     */
    public function setNrCasa($nrCasa)
    {
        $this->nrCasa = $nrCasa;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDsComplemento()
    {
        return $this->dsComplemento;
    }

    /**
     * @param mixed $dsComplemento
     * @return pessoa
     */
    public function setDsComplemento($dsComplemento)
    {
        $this->dsComplemento = $dsComplemento;
        return $this;
    }


}