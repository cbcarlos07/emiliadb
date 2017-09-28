<?php

/**
 * Created by PhpStorm.
 * User: carlos
 * Date: 19/08/17
 * Time: 22:55
 */
class item_controller
{
    public function insert ( item $item ){
        require_once "../dao/class.item_dao.php";
        $objDao = new item_dao();
        $teste = $objDao->insert( $item );
        return $teste;
    }

    public function update ( item $item ){
        require_once "../dao/class.item_dao.php";
        $objDao = new item_dao();
        $teste = $objDao->update( $item );
        return $teste;
    }

    public function delete ( $item ){
        require_once "../dao/class.item_dao.php";
        $objDao = new item_dao();
        $teste = $objDao->delete( $item );
        return $teste;
    }


    public function listaItem( $item ){
        require_once "../dao/class.item_dao.php";
        $objDao = new item_dao();
        $teste = $objDao->listaItem( $item );
        return $teste;
    }

    public function getItem( $item ){
        require_once "../dao/class.item_dao.php";
        $objDao = new item_dao();
        $teste = $objDao->getItem( $item );
        return $teste;
    }

}