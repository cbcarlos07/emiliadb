<?php

/**
 * Created by PhpStorm.
 * User: carlos.bruno
 * Date: 24/09/2017
 * Time: 15:19
 */
class item
{
    private $cdItem;
    private $dsProduto;
    private $vlPreco;

    /**
     * @return mixed
     */
    public function getCdItem()
    {
        return $this->cdItem;
    }

    /**
     * @param mixed $cdItem
     * @return item
     */
    public function setCdItem($cdItem)
    {
        $this->cdItem = $cdItem;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDsProduto()
    {
        return $this->dsProduto;
    }

    /**
     * @param mixed $dsProduto
     * @return item
     */
    public function setDsProduto($dsProduto)
    {
        $this->dsProduto = $dsProduto;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getVlPreco()
    {
        return $this->vlPreco;
    }

    /**
     * @param mixed $vlPreco
     * @return item
     */
    public function setVlPreco($vlPreco)
    {
        $this->vlPreco = $vlPreco;
        return $this;
    }


}