<?php

/**
 * Created by PhpStorm.
 * User: carlos
 * Date: 19/08/17
 * Time: 21:20
 */
class pessoa_dao
{
   private $connection;
   public function insert ( pessoa $pessoa ){

       require_once "class.connection_factory.php";
       $teste = 0;
       $this->connection = new connection();
       $this->connection->beginTransaction();
       try{

           $sql = "INSERT INTO pessoa 
                  (CD_PESSOA, NM_PESSOA, NR_CRACHA, CD_EMPRESA, NR_CEP, NR_CASA, DS_COMPLEMENTO, DT_CADASTRO)  
                  VALUES
                  (NULL, :NM_PESSOA, :NR_CRACHA, :CD_EMPRESA, :NR_CEP, :NR_CASA, :DS_COMPLEMENTO, CURDATE())";
           $stmt = $this->connection->prepare( $sql );
        /*   $nome = $pessoa->getNmPessoa();
           $cracha = $pessoa->getNrCracha();
           $empresa = $pessoa->getEmpresa();
           echo "Nome: $nome \n";
           echo "Cracha: $cracha \n";
           echo "Empresa: $empresa \n";*/

           $stmt->bindValue( ":NM_PESSOA", $pessoa->getNmPessoa(), PDO::PARAM_STR );
           $stmt->bindValue( ":NR_CRACHA", $pessoa->getNrCracha(), PDO::PARAM_STR );
           $stmt->bindValue( ":CD_EMPRESA", $pessoa->getEmpresa(), PDO::PARAM_INT );
           $stmt->bindValue( ":NR_CEP", $pessoa->getNrCep(), PDO::PARAM_STR );
           $stmt->bindValue( ":NR_CASA", $pessoa->getNrCasa(), PDO::PARAM_STR );
           $stmt->bindValue( ":DS_COMPLEMENTO", $pessoa->getDsComplemento(), PDO::PARAM_STR );
           $stmt->execute();
           $teste = $this->connection->lastInsertId();
           $this->connection->commit();

           echo "Codigo retornado: $teste \n";



           $this->connection = null;


       }catch ( PDOException $exception ){
           Echo "Erro: ".$exception->getMessage();
       }
       return $teste;
   }

    public function update ( pessoa $pessoa ){

        require_once "class.connection_factory.php";
        $teste = false;
        $this->connection = new connection();
        $this->connection->beginTransaction();
        try{

            $sql = "UPDATE pessoa SET
                     NM_PESSOA  = :NM_PESSOA
                    ,NR_CASA    = :NR_CRACHA
                    ,CD_EMPRESA = :CD_EMPRESA
                    ,NR_CEP     = :NR_CEP
                    ,NR_CASA    = :NR_CASA
                    ,DS_COMPLEMENTO = :DS_COMPLEMENTO  
                    WHERE CD_PESSOA = :CD_PESSOA";
            $stmt = $this->connection->prepare( $sql );
            $stmt->bindValue( ":NM_PESSOA", $pessoa->getNmPessoa(), PDO::PARAM_STR );
            $stmt->bindValue( ":NR_CRACHA", $pessoa->getNrCracha(), PDO::PARAM_STR );
            $stmt->bindValue( ":CD_EMPRESA", $pessoa->getEmpresa(), PDO::PARAM_INT );
            $stmt->bindValue( ":NR_CEP", $pessoa->getNrCep(), PDO::PARAM_STR );
            $stmt->bindValue( ":NR_CASA", $pessoa->getNrCasa(), PDO::PARAM_STR );
            $stmt->bindValue( ":DS_COMPLEMENTO", $pessoa->getDsComplemento(), PDO::PARAM_STR );
            $stmt->bindValue( ":CD_PESSOA", $pessoa->getCdPessoa(), PDO::PARAM_INT );
            $stmt->execute();
            $this->connection->commit();
            $teste = true;
            $this->connection = null;


        }catch ( PDOException $exception ){
            Echo "Erro: ".$exception->getMessage();
        }
        return $teste;
    }

    

    public function delete ( $pessoa ){

        require_once "class.connection_factory.php";
        $teste = false;
        $this->connection = new connection();
        $this->connection->beginTransaction();
        try{

            $sql = "DELETE FROM pessoa WHERE CD_PESSOA = :CD_PESSOA";
            $stmt = $this->connection->prepare( $sql );

            $stmt->bindValue( ":CD_PESSOA", $pessoa, PDO::PARAM_INT );
            $stmt->execute();
            $this->connection->commit();
            $teste = true;
            $this->connection = null;


        }catch ( PDOException $exception ){
            Echo "Erro: ".$exception->getMessage();
        }
        return $teste;
    }

    public function listaPessoa( $pessoa ){
        require_once "class.connection_factory.php";
        require_once "../model/class.pessoa.php";
        require_once "../services/class.pessoaList.php";

        $this->connection = new connection();
        $objList = new pessoaList();
        try{

            $sql = "SELECT P.*, E.DS_EMPRESA 
                      FROM pessoa P 
                      JOIN empresa E 
                     WHERE P.NM_PESSOA LIKE :PESSOA
                       AND E.CD_EMPRESA = P.CD_EMPRESA";
            $stmt = $this->connection->prepare( $sql );

            $stmt->bindValue( ":PESSOA", $pessoa, PDO::PARAM_STR );
            $stmt->execute();
            while ($row = $stmt->fetch( PDO::FETCH_ASSOC )){
                $obj = new pessoa();
                $obj->setCdPessoa( $row['CD_PESSOA'] );
                $obj->setNmPessoa( $row['NM_PESSOA'] );
                $obj->setNrCracha( $row['NR_CRACHA'] );
                $obj->setEmpresa( $row['DS_EMPRESA'] );
                $obj->setNrCep( $row['NR_CEP'] );
                $obj->setNrCasa( $row['NR_CASA'] );
                $obj->setDsComplemento( $row['DS_COMPLEMENTO'] );
                $objList->addPessoa( $obj );
            }


            $this->connection = null;


        }catch ( PDOException $exception ){
            Echo "Erro: ".$exception->getMessage();
        }
        return $objList;
    }

    public function getPessoa( $pessoa ){
        require_once "class.connection_factory.php";
        require_once "../model/class.pessoa.php";
        $obj = null;
        $this->connection = new connection();

        try{

            $sql = "SELECT * FROM pessoa WHERE CD_PESSOA = :CD_PESSOA";
            $stmt = $this->connection->prepare( $sql );

            $stmt->bindValue( ":CD_PESSOA", $pessoa, PDO::PARAM_INT );
            $stmt->execute();
            if ( $row = $stmt->fetch( PDO::FETCH_ASSOC ) ){
                $obj = new pessoa();
                $obj->setCdPessoa( $row['CD_PESSOA'] );
                $obj->setNmPessoa( $row['NM_PESSOA'] );
                $obj->setNrCracha( $row['NR_CRACHA'] );
                $obj->setEmpresa( $row['CD_EMPRESA'] );
                $obj->setNrCep( $row['NR_CEP'] );
                $obj->setNrCasa( $row['NR_CASA'] );
                $obj->setDsComplemento( $row['DS_COMPLEMENTO'] );
            }


            $this->connection = null;


        }catch ( PDOException $exception ){
            Echo "Erro: ".$exception->getMessage();
        }
        return $obj;
    }



}