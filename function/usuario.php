<?php
/**
 * Created by PhpStorm.
 * User: carlos
 * Date: 19/08/17
 * Time: 23:12
 */
$acao = $_POST['acao'];

$login = "";
$senha = "";
$lembrar = "";
$nome = "";
$ativo = "";
$id = 0;
$nivel = 0;
if( isset( $_POST['login'] ) ){
    $login = $_POST['login'];
}

if( isset( $_POST['id'] ) ){
    $id = $_POST['id'];
}

if( isset( $_POST['ativo'] ) ){
    $ativo = $_POST['ativo'];
}

if( isset( $_POST['nivel'] ) ){
    $nivel = $_POST['nivel'];
}

if( isset( $_POST['nome'] ) ){
    $nome = $_POST['nome'];
}
if( isset( $_POST['senha'] ) ){
    $senha = $_POST['senha'];
}

if( isset( $_POST['lembrar'] ) ){
    $lembrar = $_POST['lembrar'];
}

switch ( $acao ){

    case 'L':
        logar( $login, $senha, $lembrar );
        break;
    case 'U':
        getListUsuarios();
        break;
    case 'I':
        inserir( $nome, $login, $senha, $ativo, $nivel );
        break;
    case 'V':
        verificarLogin( $login );
        break;
    case 'G':
        getUser( $id );
        break;
    case 'A':
        update( $id,$nome, $login, $senha, $ativo );
        break;
    case 'E':
        excluir( $id );
        break;
    case 'S':
        ativarSenha( $id, $senha );
        break;
    case 'D':
        logOff(  );
        break;




}

function logar( $login, $senha, $lembrar ){
    require_once "../controller/class.usuario_controller.php";
    $usuarioController = new usuario_controller();

    $usuario = $usuarioController->loginSenha( $login, $senha );
    // var_dump($usuario);
    if( $usuario != null){
        session_start();
        if( $usuario->getSnSenhaAtual() == 'S' ){

            if( $lembrar == 'S' ){
                $ck_login  = "login";
                $ck_vlogin = $login;
                setcookie( $ck_login, $ck_vlogin, time() + ( 86400 * 30 ), "/" ); //86400 = 1 dia

                $ck_pwd  = "senha";
                $ck_vpwd = $senha;
                setcookie( $ck_pwd, $ck_vpwd, time() + ( 86400 * 30 ), "/" ); //86400 = 1 dia

                $ck_remember  = "checked";
                $ck_vremember = 'S';
                setcookie( $ck_remember, $ck_vremember, time() + ( 86400 * 30 ), "/" ); //86400 = 1 dia
            }

            $_SESSION['login'] = $login;
            $nome = explode(" ", $usuario->getNmUsuario() );
            $_SESSION['nome'] = $nome[0];
            $_SESSION['sobrenome'] = $nome[count($nome) - 1];
            $retorno['sucesso'] = 1;
            $retorno['codigo']  = $usuario->getCdUsuario();
            echo json_encode( $retorno );


        }else{

            $retorno['sucesso'] = 0;
            $nome = explode(" ", $usuario->getNmUsuario() );
            $_SESSION['nome'] = $nome[0];
            $retorno['codigo']  = $usuario->getCdUsuario();

            echo json_encode( $retorno );

        }

    }else{

        echo json_encode( array( "sucesso" => -1 ) );
    }
}

function getListUsuarios(){
    require_once "../controller/class.usuario_controller.php";
    require_once "../services/class.usuarioListIterator.php";
    require_once "../model/class.usuario.php";

    $uc = new usuario_controller();
    $lista = $uc->listaUsuario( '%%' );
    $userList = new usuarioListIterator( $lista );
    $usuarios = array();

    while ( $userList->hasNextUsuario() ){
        $usuario = $userList->getNextUsuario();
        $usuarios[] = array(
            "id" => $usuario->getCdUsuario(),
            "name"   => $usuario->getNmUsuario(),
            "login"  => $usuario->getDsLogin(),
            "nivel"  => $usuario->getNivel()->getDsNivel(),
            "ativo"  => $usuario->getSnAtivo()
        );
    }
  //  $dados_json = json_encode( $usuarios );

// Cria o arquivo cadastro.json
// O parâmetro "a" indica que o arquivo será aberto para escrita
  //  $fp = fopen("../tables/data3.json", "a");

    // Escreve o conteúdo JSON no arquivo
    //$escreve = fwrite($fp, $dados_json);


  //  fclose($fp);
    echo json_encode( array( "usuarios" => $usuarios ) );


}

function inserir ( $nome, $login, $senha, $ativo, $nivel ){
    require_once "../controller/class.usuario_controller.php";
    require_once "../model/class.usuario.php";

    $usuario = new usuario();
    $usuario->setNmUsuario( $nome );
    $usuario->setDsLogin( $login );
    $usuario->setDsSenha( $senha );
    $usuario->setSnAtivo( $ativo);
    $usuario->setNivel( $nivel );
    $uc = new usuario_controller();
    $teste = $uc->insert( $usuario );
    if( $teste ){

        echo json_encode( array( "sucesso" => 1 ) );

    }
    else{

        echo json_encode( array( "sucesso" => 0 ) );

    }
}

function update ( $id, $nome, $login, $senha, $ativo ){
    require_once "../controller/class.usuario_controller.php";
    require_once "../model/class.usuario.php";

    $usuario = new usuario();
    $usuario->setCdUsuario( $id );
    $usuario->setNmUsuario( $nome );
    $usuario->setDsLogin( $login );
    $usuario->setDsSenha( $senha );
    $usuario->setSnAtivo( $ativo);
    $uc = new usuario_controller();
    $teste = $uc->update( $usuario );
    if( $teste ){

        echo json_encode( array( "sucesso" => 1 ) );

    }
    else{

        echo json_encode( array( "sucesso" => 0 ) );

    }
}

function verificarLogin( $login ){
    require_once "../controller/class.usuario_controller.php";

    $uc = new usuario_controller();
    $teste = $uc->verificarLogin( $login );
    if( $teste ){
        echo json_encode( array( "success" => 0 ));
    }else{
        echo json_encode( array( "success" => 1 ));
    }
}

function getUser($id){
    require_once "../controller/class.usuario_controller.php";
    require_once "../model/class.usuario.php";

    $uc = new usuario_controller();
    $usuario = $uc->getUsuario( $id );

    $obj['nome']   = $usuario->getNmUsuario();
    $obj['login']  = $usuario->getDsLogin();
    $obj['ativo']  = $usuario->getSnAtivo();
    $obj['nivel']  = $usuario->getNivel();

    echo json_encode( $obj );

}

function excluir( $id ){
    require_once "../controller/class.usuario_controller.php";
    $uc = new usuario_controller();
    $teste = $uc->delete( $id );
    if( $teste ){
        echo json_encode( array( "success" => 1) );
    }else{
        echo json_encode( array( "success" => 0) );
    }
}

function ativarSenha($id, $senha){
    require_once "../controller/class.usuario_controller.php";
    require_once "../model/class.usuario.php";
    $uc = new usuario_controller();
    $usuario = new usuario();
    $usuario->setCdUsuario( $id );
   // echo "Senha: ".$senha;
    $usuario->setDsSenha( $senha );
    $teste = $uc->ativarSenha( $usuario );
    if( $teste ){
        echo json_encode( array( "success" => 1 ) );
    }else{
        echo json_encode( array( "success" => 0 ) );
    }
}

function logOff(){
    session_start();
    $_SESSION['login'] = null;
    session_destroy();
    echo json_encode( array("success" => 1));
}