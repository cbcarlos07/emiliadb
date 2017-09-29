<?php

/**
 * Created by PhpStorm.
 * User: carlos
 * Date: 19/08/17
 * Time: 21:20
 */
class telefone_dao
{
   private $connection;
   public function insert ( telefone $telefone ){

       require_once "class.connection_factory.php";
       $teste = false;
       $this->connection = new connection();
       $this->connection->beginTransaction();

       try{

           $sql = "INSERT INTO telefone 
                  (CD_PESSOA, NR_TELEFONE, TP_TELEFONE, DS_OBSERVACAO)  
                  VALUES
                  ( :CD_PESSOA, :NR_TELEFONE, :TP_TELEFONE, :DS_OBSERVACAO)";
           $stmt = $this->connection->prepare( $sql );
           $stmt->bindValue( "CD_PESSOA", $telefone->getPessoa(), PDO::PARAM_INT );
           $stmt->bindValue( "NR_TELEFONE", $telefone->getNrTelefone(), PDO::PARAM_STR );
           $stmt->bindValue( "TP_TELEFONE", $telefone->getTpTelefone(), PDO::PARAM_STR );
           $stmt->bindValue( "DS_OBSERVACAO", $telefone->getDsObservacao(), PDO::PARAM_STR );

           $stmt->execute();
           $this->connection->commit();
           $teste = true;
           $this->connection = null;


       }catch ( PDOException $exception ){
           Echo "Erro: ".$exception->getMessage();
       }
       return $teste;
   }

    

    public function delete ( $telefone ){

        require_once "class.connection_factory.php";
        $teste = false;
        $this->connection = new connection();
        $this->connection->beginTransaction();
        try{

            $sql = "DELETE FROM telefone WHERE CD_PESSOA = :CD_PESSOA";
            $stmt = $this->connection->prepare( $sql );

            $stmt->bindValue( ":CD_PESSOA", $telefone, PDO::PARAM_INT );
            $stmt->execute();
            $this->connection->commit();
            $teste = true;
            $this->connection = null;


        }catch ( PDOException $exception ){
            Echo "Erro: ".$exception->getMessage();
        }
        return $teste;
    }

    public function listaTelefone( $telefone ){
        require_once "class.connection_factory.php";
        require_once "../model/class.telefone.php";
        require_once "../services/class.telefoneList.php";

        $this->connection = new connection();
        $objList = new telefoneList();
        try{

            $sql = "SELECT P.*
                      FROM telefone P
                  WHERE P.CD_PESSOA LIKE :PESSOA";
            $stmt = $this->connection->prepare( $sql );

            $stmt->bindValue( ":PESSOA", $telefone, PDO::PARAM_STR );
            $stmt->execute();
            while ($row = $stmt->fetch( PDO::FETCH_ASSOC )){
                $obj = new telefone();
                $obj->setPessoa( $row['CD_PESSOA'] );
                $obj->setNrTelefone( $row['NR_TELEFONE'] );
                $obj->setTpTelefone( $row['TP_TELEFONE'] );
                $obj->setDsObservacao( $row['DS_OBSERVACAO'] );
                $objList->addTelefone( $obj );
            }


            $this->connection = null;


        }catch ( PDOException $exception ){
            Echo "Erro: ".$exception->getMessage();
        }
        return $objList;
    }

 

}