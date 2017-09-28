<?php

/**
 * Created by PhpStorm.
 * User: carlos
 * Date: 19/08/17
 * Time: 21:20
 */
class item_dao
{
   private $connection;
   public function insert ( item $item ){

       require_once "class.connection_factory.php";
       $teste = false;
       $this->connection = new connection();
       $this->connection->beginTransaction();
       try{

           $sql = "INSERT INTO item 
                  (CD_ITEM, DS_PRODUTO, VL_PRECO)  
                  VALUES
                  (NULL, :DS_PRODUTO, :VL_PRECO)";
           $stmt = $this->connection->prepare( $sql );
           $stmt->bindValue( ":DS_PRODUTO", $item->getDsProduto(), PDO::PARAM_STR );
           $stmt->bindValue( ":VL_PRECO", $item->getVlPreco(), PDO::PARAM_STR );
           $stmt->execute();
           $this->connection->commit();
           $teste = true;
           $this->connection = null;


       }catch ( PDOException $exception ){
           Echo "Erro: ".$exception->getMessage();
       }
       return $teste;
   }

    public function update ( item $item ){

        require_once "class.connection_factory.php";
        $teste = false;
        $this->connection = new connection();
        $this->connection->beginTransaction();
        try{

            $sql = "UPDATE item SET
                     DS_PRODUTO = :DS_PRODUTO
                     ,VL_PRECO = :VL_PRECO
                    WHERE CD_ITEM = :CD_ITEM";
            $stmt = $this->connection->prepare( $sql );
            $stmt->bindValue( ":DS_PRODUTO", $item->getDsProduto(), PDO::PARAM_STR );
            $stmt->bindValue( ":VL_PRECO", $item->getVlPreco(), PDO::PARAM_STR );
            $stmt->bindValue( ":CD_ITEM", $item->getCdItem(), PDO::PARAM_INT );
            $stmt->execute();
            $this->connection->commit();
            $teste = true;
            $this->connection = null;


        }catch ( PDOException $exception ){
            Echo "Erro: ".$exception->getMessage();
        }
        return $teste;
    }

    

    public function delete ( $item ){

        require_once "class.connection_factory.php";
        $teste = false;
        $this->connection = new connection();
        $this->connection->beginTransaction();
        try{

            $sql = "DELETE FROM item WHERE CD_ITEM = :CD_ITEM";
            $stmt = $this->connection->prepare( $sql );

            $stmt->bindValue( ":CD_ITEM", $item, PDO::PARAM_INT );
            $stmt->execute();
            $this->connection->commit();
            $teste = true;
            $this->connection = null;


        }catch ( PDOException $exception ){
            Echo "Erro: ".$exception->getMessage();
        }
        return $teste;
    }

    public function listaItem( $item ){
        require_once "class.connection_factory.php";
        require_once "../model/class.item.php";
        require_once "../services/class.itemList.php";

        $this->connection = new connection();
        $objList = new itemList();
        try{

            $sql = "SELECT * FROM item WHERE DS_PRODUTO LIKE :USUARIO";
            $stmt = $this->connection->prepare( $sql );

            $stmt->bindValue( ":USUARIO", $item, PDO::PARAM_STR );
            $stmt->execute();
            while ($row = $stmt->fetch( PDO::FETCH_ASSOC )){
                $obj = new item();
                $obj->setCdItem( $row['CD_ITEM'] );
                $obj->setDsProduto( $row['DS_PRODUTO'] );
                $obj->setVlPreco( $row['VL_PRECO'] );
                $objList->addItem( $obj );
            }


            $this->connection = null;


        }catch ( PDOException $exception ){
            Echo "Erro: ".$exception->getMessage();
        }
        return $objList;
    }

    public function getItem( $item ){
        require_once "class.connection_factory.php";
        require_once "../model/class.item.php";
        $obj = null;
        $this->connection = new connection();

        try{

            $sql = "SELECT * FROM item WHERE CD_ITEM = :CD_ITEM";
            $stmt = $this->connection->prepare( $sql );

            $stmt->bindValue( ":CD_ITEM", $item, PDO::PARAM_INT );
            $stmt->execute();
            if ( $row = $stmt->fetch( PDO::FETCH_ASSOC ) ){
                $obj = new item();
                $obj->setCdItem( $row['CD_ITEM'] );
                $obj->setDsProduto( $row['DS_PRODUTO'] );
                $obj->setVlPreco( $row['VL_PRECO'] );
            }


            $this->connection = null;


        }catch ( PDOException $exception ){
            Echo "Erro: ".$exception->getMessage();
        }
        return $obj;
    }



}