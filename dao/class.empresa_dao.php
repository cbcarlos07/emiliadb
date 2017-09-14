<?php

/**
 * Created by PhpStorm.
 * User: carlos
 * Date: 19/08/17
 * Time: 21:20
 */
class empresa_dao
{
   private $connection;
   public function insert ( empresa $empresa ){

       require_once "class.connection_factory.php";
       $teste = false;
       $this->connection = new connection();
       $this->connection->beginTransaction();

       try{

           $sql = "INSERT INTO empresa 
                  (CD_EMPRESA, DS_EMPRESA)  
                  VALUES
                  ( NULL, :DS_EMPRESA )";
           $stmt = $this->connection->prepare( $sql );
           $stmt->bindValue( ":DS_EMPRESA", $empresa->getDsEmpresa(), PDO::PARAM_STR );
           
           $stmt->execute();
           $this->connection->commit();
           $teste = true;
           $this->connection = null;


       }catch ( PDOException $exception ){
           Echo "Erro: ".$exception->getMessage();
       }
       return $teste;
   }

    public function update ( empresa $empresa ){

        require_once "class.connection_factory.php";
        $teste = false;
        $this->connection = new connection();
        $this->connection->beginTransaction();
        try{

            $sql = "UPDATE empresa SET
                       DS_EMPRESA = :DS_EMPRESA
                    WHERE CD_EMPRESA = :CD_EMPRESA";
            $stmt = $this->connection->prepare( $sql );
            $stmt->bindValue( ":DS_EMPRESA", $empresa->getDsEmpresa(), PDO::PARAM_STR );
            $stmt->bindValue( ":CD_EMPRESA", $empresa->getCdEmpresa(), PDO::PARAM_INT );
            $stmt->execute();
            $this->connection->commit();
            $teste = true;
            $this->connection = null;


        }catch ( PDOException $exception ){
            Echo "Erro: ".$exception->getMessage();
        }
        return $teste;
    }

    

    public function delete ( $empresa ){

        require_once "class.connection_factory.php";
        $teste = false;
        $this->connection = new connection();
        $this->connection->beginTransaction();
        try{

            $sql = "DELETE FROM empresa WHERE CD_EMPRESA = :CD_EMPRESA";
            $stmt = $this->connection->prepare( $sql );

            $stmt->bindValue( ":CD_EMPRESA", $empresa, PDO::PARAM_INT );
            $stmt->execute();
            $this->connection->commit();
            $teste = true;
            $this->connection = null;


        }catch ( PDOException $exception ){
            Echo "Erro: ".$exception->getMessage();
        }
        return $teste;
    }

    public function listaEmpresa( $empresa ){
        require_once "class.connection_factory.php";
        require_once "../model/class.empresa.php";
        require_once "../services/class.empresaList.php";

        $this->connection = new connection();
        $objList = new empresaList();
        try{

            $sql = "SELECT P.*
                      FROM empresa P
                  WHERE P.DS_EMPRESA LIKE :EMPRESA";
            $stmt = $this->connection->prepare( $sql );

            $stmt->bindValue( ":EMPRESA", $empresa, PDO::PARAM_STR );
            $stmt->execute();
            while ($row = $stmt->fetch( PDO::FETCH_ASSOC )){
                $obj = new empresa();
                $obj->setCdEmpresa( $row['CD_EMPRESA'] );
                $obj->setDsEmpresa( $row['DS_EMPRESA'] );
                $objList->addEmpresa( $obj );
            }


            $this->connection = null;


        }catch ( PDOException $exception ){
            Echo "Erro: ".$exception->getMessage();
        }
        return $objList;
    }

    public function getEmpresa( $empresa ){
        require_once "class.connection_factory.php";
        require_once "../model/class.empresa.php";
        $obj = null;
        $this->connection = new connection();

        try{

            $sql = "SELECT P.* FROM empresa P
                    WHERE P.CD_EMPRESA = :CD_EMPRESA";
            $stmt = $this->connection->prepare( $sql );

            $stmt->bindValue( ":CD_EMPRESA", $empresa, PDO::PARAM_INT );
            $stmt->execute();
            if ( $row = $stmt->fetch( PDO::FETCH_ASSOC ) ){
                $obj = new empresa();
                $obj->setCdEmpresa( $row['CD_EMPRESA'] );
                $obj->setDsEmpresa( $row['DS_EMPRESA'] );
            }


            $this->connection = null;


        }catch ( PDOException $exception ){
            Echo "Erro: ".$exception->getMessage();
        }
        return $obj;
    }

 

}