<?php

/**
 * Created by PhpStorm.
 * User: carlos.bruno
 * Date: 12/09/2017
 * Time: 10:03
 */
class nivel
{
private  $cdNivel;
private  $dsNivel;

    /**
     * @return mixed
     */
    public function getCdNivel()
    {
        return $this->cdNivel;
    }

    /**
     * @param mixed $cdNivel
     * @return nivel
     */
    public function setCdNivel($cdNivel)
    {
        $this->cdNivel = $cdNivel;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDsNivel()
    {
        return $this->dsNivel;
    }

    /**
     * @param mixed $dsNivel
     * @return nivel
     */
    public function setDsNivel($dsNivel)
    {
        $this->dsNivel = $dsNivel;
        return $this;
    }


}