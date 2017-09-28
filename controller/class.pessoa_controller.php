<?php

/**
 * Created by PhpStorm.
 * User: carlos
 * Date: 19/08/17
 * Time: 22:55
 */
class pessoa_controller
{
    public function insert ( pessoa $pessoa ){
        require_once "../dao/class.pessoa_dao.php";
        $objDao = new pessoa_dao();
        $teste = $objDao->insert( $pessoa );
        return $teste;
    }

    public function update ( pessoa $pessoa ){
        require_once "../dao/class.pessoa_dao.php";
        $objDao = new pessoa_dao();
        $teste = $objDao->update( $pessoa );
        return $teste;
    }

    public function delete ( $pessoa ){
        require_once "../dao/class.pessoa_dao.php";
        $objDao = new pessoa_dao();
        $teste = $objDao->delete( $pessoa );
        return $teste;
    }


    public function listaPessoa( $pessoa ){
        require_once "../dao/class.pessoa_dao.php";
        $objDao = new pessoa_dao();
        $teste = $objDao->listaPessoa( $pessoa );
        return $teste;
    }

    public function getPessoa( $pessoa ){
        require_once "../dao/class.pessoa_dao.php";
        $objDao = new pessoa_dao();
        $teste = $objDao->getPessoa( $pessoa );
        return $teste;
    }

}