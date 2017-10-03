<?php

/**
 * Created by PhpStorm.
 * User: carlos.bruno
 * Date: 03/10/2017
 * Time: 12:12
 */
class registro
{
  private $cdRegPessoa;
  private $Pessoa;
  private $item;
  private $vlPreco;
  private $dtRegistro;
  private $snPago;
  private $qtCompra;

    /**
     * @return mixed
     */
    public function getCdRegPessoa()
    {
        return $this->cdRegPessoa;
    }

    /**
     * @param mixed $cdRegPessoa
     * @return registro
     */
    public function setCdRegPessoa($cdRegPessoa)
    {
        $this->cdRegPessoa = $cdRegPessoa;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPessoa()
    {
        return $this->Pessoa;
    }

    /**
     * @param mixed $Pessoa
     * @return registro
     */
    public function setPessoa($Pessoa)
    {
        $this->Pessoa = $Pessoa;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getItem()
    {
        return $this->item;
    }

    /**
     * @param mixed $item
     * @return registro
     */
    public function setItem($item)
    {
        $this->item = $item;
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
     * @return registro
     */
    public function setVlPreco($vlPreco)
    {
        $this->vlPreco = $vlPreco;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDtRegistro()
    {
        return $this->dtRegistro;
    }

    /**
     * @param mixed $dtRegistro
     * @return registro
     */
    public function setDtRegistro($dtRegistro)
    {
        $this->dtRegistro = $dtRegistro;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSnPago()
    {
        return $this->snPago;
    }

    /**
     * @param mixed $snPago
     * @return registro
     */
    public function setSnPago($snPago)
    {
        $this->snPago = $snPago;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getQtCompra()
    {
        return $this->qtCompra;
    }

    /**
     * @param mixed $qtCompra
     * @return registro
     */
    public function setQtCompra($qtCompra)
    {
        $this->qtCompra = $qtCompra;
        return $this;
    }




}