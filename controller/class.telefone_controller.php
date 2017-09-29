<?php

/**
 * Created by PhpStorm.
 * User: carlos
 * Date: 19/08/17
 * Time: 22:55
 */
class telefone_controller
{
    public function insert ( telefone $telefone ){
        require_once "../dao/class.telefone_dao.php";
        $objDao = new telefone_dao();
        $teste = $objDao->insert( $telefone );
        return $teste;
    }


    public function delete ( $telefone ){
        require_once "../dao/class.telefone_dao.php";
        $objDao = new telefone_dao();
        $teste = $objDao->delete( $telefone );
        return $teste;
    }


    public function listaTelefone( $telefone ){
        require_once "../dao/class.telefone_dao.php";
        $objDao = new telefone_dao();
        $teste = $objDao->listaTelefone( $telefone );
        return $teste;
    }


}