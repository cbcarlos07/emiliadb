<?php

/**
 * Created by PhpStorm.
 * User: carlos
 * Date: 19/08/17
 * Time: 21:20
 */
class usuario_dao
{
   private $connection;
   public function insert ( usuario $usuario ){

       require_once "class.connection_factory.php";
       $teste = false;
       $this->connection = new connection();
       $this->connection->beginTransaction();
       try{

           $sql = "INSERT INTO usuario 
                  (CD_USUARIO, NM_USUARIO, DS_LOGIN, CD_NIVEL, DS_SENHA, SN_ATIVO, SN_SENHA_ATUAL)  
                  VALUES
                  (NULL, :NM_USUARIO, :DS_LOGIN, :CD_NIVEL ,MD5( :DS_SENHA ), :SN_ATIVO, 'N')";
           $stmt = $this->connection->prepare( $sql );
           $stmt->bindValue( ":NM_USUARIO", $usuario->getNmUsuario(), PDO::PARAM_STR );
           $stmt->bindValue( ":DS_LOGIN", $usuario->getDsLogin(), PDO::PARAM_STR );
           $stmt->bindValue( ":DS_SENHA", $usuario->getDsSenha(), PDO::PARAM_STR );
           $stmt->bindValue( ":SN_ATIVO", $usuario->getSnAtivo(), PDO::PARAM_STR );
           $stmt->bindValue( ":CD_NIVEL", $usuario->getNivel(), PDO::PARAM_INT );
           $stmt->execute();
           $this->connection->commit();
           $teste = true;
           $this->connection = null;


       }catch ( PDOException $exception ){
           Echo "Erro: ".$exception->getMessage();
       }
       return $teste;
   }

    public function update ( usuario $usuario ){

        require_once "class.connection_factory.php";
        $teste = false;
        $this->connection = new connection();
        $this->connection->beginTransaction();
        try{

            $sql = "UPDATE usuario SET
                     NM_USUARIO = :NM_USUARIO
                    ,DS_LOGIN   = :DS_LOGIN
                    ,DS_SENHA   = md5(:DS_SENHA)
                    ,SN_ATIVO   = :SN_ATIVO
                    ,SN_SENHA_ATUAL = 'N'
                    ,CD_NIVEL = :CD_NIVEL
                    WHERE CD_USUARIO = :CD_USUARIO";
            $stmt = $this->connection->prepare( $sql );
            $stmt->bindValue( ":NM_USUARIO", $usuario->getNmUsuario(), PDO::PARAM_STR );
            $stmt->bindValue( ":DS_LOGIN", $usuario->getDsLogin(), PDO::PARAM_STR );
            $stmt->bindValue( ":DS_SENHA", $usuario->getDsSenha(), PDO::PARAM_STR );
            $stmt->bindValue( ":SN_ATIVO", $usuario->getSnAtivo(), PDO::PARAM_STR );
            $stmt->bindValue( ":CD_USUARIO", $usuario->getCdUsuario(), PDO::PARAM_INT );
            $stmt->bindValue( ":CD_NIVEL", $usuario->getNivel(), PDO::PARAM_INT );
            $stmt->execute();
            $this->connection->commit();
            $teste = true;
            $this->connection = null;


        }catch ( PDOException $exception ){
            Echo "Erro: ".$exception->getMessage();
        }
        return $teste;
    }

    public function ativarSenha ( usuario $usuario ){

        require_once "class.connection_factory.php";
        $teste = false;
        $this->connection = new connection();
        $this->connection->beginTransaction();
        try{

            $sql = "UPDATE usuario SET
                     DS_SENHA   = md5(:DS_SENHA)
                    ,SN_SENHA_ATUAL   = 'S'
                    WHERE CD_USUARIO = :CD_USUARIO";
            $stmt = $this->connection->prepare( $sql );

            $stmt->bindValue( ":DS_SENHA", $usuario->getDsSenha(), PDO::PARAM_STR );
            $stmt->bindValue( ":CD_USUARIO", $usuario->getCdUsuario(), PDO::PARAM_INT );
            $stmt->execute();
            $this->connection->commit();
            $teste = true;
            $this->connection = null;


        }catch ( PDOException $exception ){
            Echo "Erro: ".$exception->getMessage();
        }
        return $teste;
    }

    public function delete ( $usuario ){

        require_once "class.connection_factory.php";
        $teste = false;
        $this->connection = new connection();
        $this->connection->beginTransaction();
        try{

            $sql = "DELETE FROM usuario WHERE CD_USUARIO = :CD_USUARIO";
            $stmt = $this->connection->prepare( $sql );

            $stmt->bindValue( ":CD_USUARIO", $usuario, PDO::PARAM_INT );
            $stmt->execute();
            $this->connection->commit();
            $teste = true;
            $this->connection = null;


        }catch ( PDOException $exception ){
            Echo "Erro: ".$exception->getMessage();
        }
        return $teste;
    }

    public function listaUsuario( $usuario ){
        require_once "class.connection_factory.php";
        require_once "../model/class.usuario.php";
        require_once "../model/class.nivel.php";
        require_once "../services/class.usuarioList.php";

        $this->connection = new connection();
        $objList = new usuarioList();
        try{

            $sql = "SELECT * 
                      FROM usuario U
                      JOIN nivel N
                    WHERE N.CD_NIVEL = U.CD_NIVEL";
            $stmt = $this->connection->prepare( $sql );

            $stmt->bindValue( ":USUARIO", $usuario, PDO::PARAM_STR );
            $stmt->execute();
            while ($row = $stmt->fetch( PDO::FETCH_ASSOC )){
                $obj = new usuario();
                $obj->setCdUsuario( $row['CD_USUARIO'] );
                $obj->setNmUsuario( $row['NM_USUARIO'] );
                $obj->setDsLogin( $row['DS_LOGIN'] );
                $obj->setSnAtivo( $row['SN_ATIVO'] );
                $obj->setNivel( new nivel() );
                $obj->getNivel()->setCdNivel( $row['CD_NIVEL'] );
                $obj->getNivel()->setDsNivel( $row['DS_NIVEL'] );
                $obj->setSnSenhaAtual( $row['SN_SENHA_ATUAL'] );
                $objList->addUsuario( $obj );
            }


            $this->connection = null;


        }catch ( PDOException $exception ){
            Echo "Erro: ".$exception->getMessage();
        }
        return $objList;
    }

    public function getUsuario( $usuario ){
        require_once "class.connection_factory.php";
        require_once "../model/class.usuario.php";
        $obj = null;
        $this->connection = new connection();

        try{

            $sql = "SELECT * FROM usuario WHERE CD_USUARIO = :CD_USUARIO";
            $stmt = $this->connection->prepare( $sql );

            $stmt->bindValue( ":CD_USUARIO", $usuario, PDO::PARAM_INT );
            $stmt->execute();
            if ( $row = $stmt->fetch( PDO::FETCH_ASSOC ) ){
                $obj = new usuario();
                $obj->setCdUsuario( $row['CD_USUARIO'] );
                $obj->setNmUsuario( $row['NM_USUARIO'] );
                $obj->setDsLogin( $row['DS_LOGIN'] );
                $obj->setNivel( $row['CD_NIVEL'] );
                $obj->setSnAtivo( $row['SN_ATIVO'] );
                $obj->setSnSenhaAtual( $row['SN_SENHA_ATUAL'] );
            }


            $this->connection = null;


        }catch ( PDOException $exception ){
            Echo "Erro: ".$exception->getMessage();
        }
        return $obj;
    }

    public function loginSenha( $usuario, $senha ){
        require_once "class.connection_factory.php";
        require_once "../model/class.usuario.php";
        $obj = null;
        $this->connection = new connection();

        try{

            $sql = "SELECT * FROM usuario WHERE DS_LOGIN = :DS_LOGIN AND DS_SENHA = md5(:DS_SENHA)";
            $stmt = $this->connection->prepare( $sql );

            $stmt->bindValue( ":DS_LOGIN", $usuario, PDO::PARAM_STR );
            $stmt->bindValue( ":DS_SENHA", $senha, PDO::PARAM_STR );
            $stmt->execute();
            if ( $row = $stmt->fetch( PDO::FETCH_ASSOC ) ){
                $obj = new usuario();
                $obj->setCdUsuario( $row['CD_USUARIO'] );
                $obj->setNmUsuario( $row['NM_USUARIO'] );
                $obj->setDsLogin( $row['DS_LOGIN'] );
                $obj->setNivel( $row['CD_NIVEL'] );
                $obj->setSnAtivo( $row['SN_ATIVO'] );
                $obj->setSnSenhaAtual( $row['SN_SENHA_ATUAL'] );
            }


            $this->connection = null;


        }catch ( PDOException $exception ){
            Echo "Erro: ".$exception->getMessage();
        }
        return $obj;
    }

    public function verificarLogin( $usuario ){
        require_once "class.connection_factory.php";
        require_once "../model/class.usuario.php";
        $obj = false;
        $this->connection = new connection();

        try{

            $sql = "SELECT * FROM usuario WHERE DS_LOGIN = :DS_LOGIN ";
            $stmt = $this->connection->prepare( $sql );

            $stmt->bindValue( ":DS_LOGIN", $usuario, PDO::PARAM_STR );

            $stmt->execute();
            if ( $row = $stmt->fetch( PDO::FETCH_ASSOC ) ){
                $obj =  true;

            }


            $this->connection = null;


        }catch ( PDOException $exception ){
            Echo "Erro: ".$exception->getMessage();
        }
        return $obj;
    }

}