<?php

/**
 * Created by PhpStorm.
 * User: carlos
 * Date: 19/08/17
 * Time: 22:55
 */
class usuario_controller
{
    public function insert ( usuario $usuario ){
        require_once "../dao/class.usuario_dao.php";
        $objDao = new usuario_dao();
        $teste = $objDao->insert( $usuario );
        return $teste;
    }

    public function update ( usuario $usuario ){
        require_once "../dao/class.usuario_dao.php";
        $objDao = new usuario_dao();
        $teste = $objDao->update( $usuario );
        return $teste;
    }

    public function delete ( $usuario ){
        require_once "../dao/class.usuario_dao.php";
        $objDao = new usuario_dao();
        $teste = $objDao->delete( $usuario );
        return $teste;
    }

    public function ativarSenha ( usuario $usuario ){
        require_once "../dao/class.usuario_dao.php";
        $objDao = new usuario_dao();
        $teste = $objDao->ativarSenha( $usuario );
        return $teste;
    }

    public function listaUsuario( $usuario ){
        require_once "../dao/class.usuario_dao.php";
        $objDao = new usuario_dao();
        $teste = $objDao->listaUsuario( $usuario );
        return $teste;
    }

    public function getUsuario( $usuario ){
        require_once "../dao/class.usuario_dao.php";
        $objDao = new usuario_dao();
        $teste = $objDao->getUsuario( $usuario );
        return $teste;
    }

    public function loginSenha( $usuario, $senha ){
        require_once "../dao/class.usuario_dao.php";
        $objDao = new usuario_dao();
        $teste = $objDao->loginSenha( $usuario, $senha );
        return $teste;
    }

    public function verificarLogin( $usuario ){
        require_once "../dao/class.usuario_dao.php";
        $objDao = new usuario_dao();
        $teste = $objDao->verificarLogin( $usuario );
        return $teste;
    }
}