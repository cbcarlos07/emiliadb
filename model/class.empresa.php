<?php

/**
 * Created by PhpStorm.
 * User: carlos
 * Date: 19/08/17
 * Time: 21:07
 */
class empresa
{
    private $cdEmpresa;
    private $dsEmpresa;
    

    /**
     * @return mixed
     */
    public function getCdEmpresa()
    {
        return $this->cdEmpresa;
    }

    /**
     * @param mixed $cdEmpresa
     * @return empresa
     */
    public function setCdEmpresa($cdEmpresa)
    {
        $this->cdEmpresa = $cdEmpresa;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDsEmpresa()
    {
        return $this->dsEmpresa;
    }

    /**
     * @param mixed $dsEmpresa
     * @return empresa
     */
    public function setDsEmpresa($dsEmpresa)
    {
        $this->dsEmpresa = $dsEmpresa;
        return $this;
    }



}