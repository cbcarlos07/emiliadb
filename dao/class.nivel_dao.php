<?php

/**
 * Created by PhpStorm.
 * User: carlos
 * Date: 19/08/17
 * Time: 21:20
 */
class nivel_dao
{
   private $connection;
   public function insert ( nivel $nivel ){

       require_once "class.connection_factory.php";
       $teste = false;
       $this->connection = new connection();
       $this->connection->beginTransaction();
       try{

           $sql = "INSERT INTO nivel 
                  (CD_NIVEL, DS_NIVEL)  
                  VALUES
                  (NULL, :DS_NIVEL)";
           $stmt = $this->connection->prepare( $sql );
           $stmt->bindValue( ":DS_NIVEL", $nivel->getDsNivel(), PDO::PARAM_STR );
           $stmt->execute();
           $this->connection->commit();
           $teste = true;
           $this->connection = null;


       }catch ( PDOException $exception ){
           Echo "Erro: ".$exception->getMessage();
       }
       return $teste;
   }

    public function update ( nivel $nivel ){

        require_once "class.connection_factory.php";
        $teste = false;
        $this->connection = new connection();
        $this->connection->beginTransaction();
        try{

            $sql = "UPDATE nivel SET
                     DS_NIVEL = :DS_NIVEL
                    WHERE CD_NIVEL = :CD_NIVEL";
            $stmt = $this->connection->prepare( $sql );
            $stmt->bindValue( ":DS_NIVEL", $nivel->getDsNivel(), PDO::PARAM_STR );
            $stmt->bindValue( ":CD_NIVEL", $nivel->getCdNivel(), PDO::PARAM_INT );
            $stmt->execute();
            $this->connection->commit();
            $teste = true;
            $this->connection = null;


        }catch ( PDOException $exception ){
            Echo "Erro: ".$exception->getMessage();
        }
        return $teste;
    }

    

    public function delete ( $nivel ){

        require_once "class.connection_factory.php";
        $teste = false;
        $this->connection = new connection();
        $this->connection->beginTransaction();
        try{

            $sql = "DELETE FROM nivel WHERE CD_NIVEL = :CD_NIVEL";
            $stmt = $this->connection->prepare( $sql );

            $stmt->bindValue( ":CD_NIVEL", $nivel, PDO::PARAM_INT );
            $stmt->execute();
            $this->connection->commit();
            $teste = true;
            $this->connection = null;


        }catch ( PDOException $exception ){
            Echo "Erro: ".$exception->getMessage();
        }
        return $teste;
    }

    public function listaNivel( $nivel ){
        require_once "class.connection_factory.php";
        require_once "../model/class.nivel.php";
        require_once "../services/class.nivelList.php";

        $this->connection = new connection();
        $objList = new nivelList();
        try{

            $sql = "SELECT * FROM nivel WHERE DS_NIVEL LIKE :USUARIO";
            $stmt = $this->connection->prepare( $sql );

            $stmt->bindValue( ":USUARIO", $nivel, PDO::PARAM_STR );
            $stmt->execute();
            while ($row = $stmt->fetch( PDO::FETCH_ASSOC )){
                $obj = new nivel();
                $obj->setCdNivel( $row['CD_NIVEL'] );
                $obj->setDsNivel( $row['DS_NIVEL'] );
                $objList->addNivel( $obj );
            }


            $this->connection = null;


        }catch ( PDOException $exception ){
            Echo "Erro: ".$exception->getMessage();
        }
        return $objList;
    }

    public function getNivel( $nivel ){
        require_once "class.connection_factory.php";
        require_once "../model/class.nivel.php";
        $obj = null;
        $this->connection = new connection();

        try{

            $sql = "SELECT * FROM nivel WHERE CD_NIVEL = :CD_NIVEL";
            $stmt = $this->connection->prepare( $sql );

            $stmt->bindValue( ":CD_NIVEL", $nivel, PDO::PARAM_INT );
            $stmt->execute();
            if ( $row = $stmt->fetch( PDO::FETCH_ASSOC ) ){
                $obj = new nivel();
                $obj->setCdNivel( $row['CD_NIVEL'] );
                $obj->setDsNivel( $row['DS_NIVEL'] );
            }


            $this->connection = null;


        }catch ( PDOException $exception ){
            Echo "Erro: ".$exception->getMessage();
        }
        return $obj;
    }



}