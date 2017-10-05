<?php

/**
 * Created by PhpStorm.
 * User: carlos
 * Date: 19/08/17
 * Time: 21:20
 */
class registro_dao
{
   private $connection;
   public function insert ( $registro ){
       require_once "../include/error.php";
       require_once "class.connection_factory.php";
      // echo "Valor ".$registro['valor']." \n";
       $teste = false;
       $this->connection = new connection();
       $this->connection->beginTransaction();
       try{

           $sql = "INSERT INTO registro 
                  (CD_REG_PESSOA, CD_PESSOA, CD_ITEM, VL_PRECO, DT_REGISTRO, SN_PAGO, QT_COMPRA)  
                  VALUES
                  ( NULL, :CD_PESSOA, :CD_ITEM, :VL_PRECO, NOW(), :SN_PAGO, :QT_COMPRA)";
           $stmt = $this->connection->prepare( $sql );
           $stmt->bindValue( "CD_PESSOA", $registro['pessoa'], PDO::PARAM_INT );
           $stmt->bindValue( "CD_ITEM", $registro['item'], PDO::PARAM_INT );
           $stmt->bindValue( "VL_PRECO", $registro['valor'], PDO::PARAM_STR );
           /*$stmt->bindValue( "DT_REGISTRO", $registro->getDtRegistro(), PDO::PARAM_STR );*/
           $stmt->bindValue( "SN_PAGO", $registro['pago'], PDO::PARAM_STR );
           $stmt->bindValue( "QT_COMPRA", $registro['qtde'], PDO::PARAM_INT );
           $stmt->execute();
           $this->connection->commit();
           $teste = true;
           $this->connection = null;


       }catch ( PDOException $exception ){
           Echo "Erro: ".$exception->getMessage();
       }
       return $teste;
   }

    public function update (  $registro ){

        require_once "class.connection_factory.php";
        $teste = false;
        $this->connection = new connection();
        $this->connection->beginTransaction();
        try{

            $sql = "UPDATE registro SET
                     SN_PAGO = :SN_PAGO
                    WHERE CD_REG_PESSOA = :CD_REG_PESSOA";
            $stmt = $this->connection->prepare( $sql );
            $stmt->bindValue( "SN_PAGO", $registro['pago'], PDO::PARAM_STR );
            $stmt->bindValue( "CD_REG_PESSOA", $registro['registro'], PDO::PARAM_INT );
            $stmt->execute();
            $this->connection->commit();
            $teste = true;
            $this->connection = null;


        }catch ( PDOException $exception ){
            Echo "Erro: ".$exception->getMessage();
        }
        return $teste;
    }

    


    public function listaRegistro( $pessoa, $cracha ){
        require_once "class.connection_factory.php";
        require_once "../model/class.registro.php";
        require_once "../model/class.pessoa.php";
        require_once "../services/class.registroList.php";

        $this->connection = new connection();
        $objList = new registroList();
        try{

            $sql = "SELECT P.CD_PESSOA
                          ,P.NR_CRACHA     CRACHA
                          ,P.NM_PESSOA     NOME
                          ,E.DS_EMPRESA    EMPRESA
                          ,SUM( R.VL_PRECO ) VALOR
                      FROM registro R
                      JOIN pessoa   P
                      JOIN empresa E
                      WHERE P.CD_PESSOA  = R.CD_PESSOA
                        AND E.CD_EMPRESA = P.CD_EMPRESA	
                        AND (P.NM_PESSOA LIKE :pessoa OR P.NR_CRACHA LIKE :cracha)
                        AND R.SN_PAGO = 'N'
                    GROUP BY P.CD_PESSOA
                    ";
            $stmt = $this->connection->prepare( $sql );

            $stmt->bindValue( ":pessoa", $pessoa, PDO::PARAM_STR );
            $stmt->bindValue( ":cracha", $cracha, PDO::PARAM_STR );
            $stmt->execute();
            while ($row = $stmt->fetch( PDO::FETCH_ASSOC )){
                $obj = new registro();
                $obj->setCdRegPessoa( $row['CD_PESSOA'] );
                $obj->setPessoa( new pessoa() );
                $obj->getPessoa( )->setNrCracha( $row['CRACHA'] );
                $obj->getPessoa( )->setNmPessoa( $row['NOME'] );
                $obj->setSnPago( $row['EMPRESA'] );
                $obj->setVlPreco( $row['VALOR'] );
                $objList->addRegistro( $obj );
            }


            $this->connection = null;


        }catch ( PDOException $exception ){
            Echo "Erro: ".$exception->getMessage();
        }
        return $objList;
    }

    public function listaRegistroItem( $pessoa){
        require_once "class.connection_factory.php";
        require_once "../model/class.registro.php";
        require_once "../model/class.pessoa.php";
        require_once "../services/class.registroList.php";

        $this->connection = new connection();
        $objList = new registroList();
        try{

            $sql = "SELECT R.CD_REG_PESSOA CODIGO
                          ,P.NR_CRACHA     CRACHA  
                          ,P.NM_PESSOA     NOME
                          ,E.DS_EMPRESA    EMPRESA
                          ,I.DS_PRODUTO   
                          ,R.QT_COMPRA
                          ,R.VL_PRECO      VALOR
                          ,DATE_FORMAT(R.DT_REGISTRO, '%d/%m/%Y %H:%i' ) DT_REGISTRO
                      FROM registro     R
                           JOIN pessoa  P
                           JOIN empresa E
                           JOIN item    I
                      WHERE P.CD_PESSOA   =  R.CD_PESSOA
                        AND E.CD_EMPRESA  =  P.CD_EMPRESA 
                        AND I.CD_ITEM     =  R.CD_ITEM
                        AND R.SN_PAGO = 'N'
                        AND R.CD_PESSOA = :pessoa
                    ";
            $stmt = $this->connection->prepare( $sql );

            $stmt->bindValue( ":pessoa", $pessoa, PDO::PARAM_INT );
            $stmt->execute();
            while ($row = $stmt->fetch( PDO::FETCH_ASSOC )){
                $obj = new registro();
                $obj->setCdRegPessoa( $row['CODIGO'] );
                $obj->setPessoa( new pessoa() );
                $obj->getPessoa( )->setNrCracha( $row['CRACHA'] );
                $obj->getPessoa( )->setNmPessoa( $row['NOME'] );
                $obj->setSnPago( $row['EMPRESA'] );
                $obj->setItem( $row['DS_PRODUTO'] );
                $obj->setQtCompra( $row['QT_COMPRA'] );
                $obj->setVlPreco( $row['VALOR'] );
                $obj->setDtRegistro( $row['DT_REGISTRO'] );
                $objList->addRegistro( $obj );
            }


            $this->connection = null;


        }catch ( PDOException $exception ){
            Echo "Erro: ".$exception->getMessage();
        }
        return $objList;
    }



}