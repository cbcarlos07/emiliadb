<?php
session_start();
if( !isset( $_SESSION['login'] ) ){
    header("location:./index.php");
}
?>
<!DOCTYPE html>
<html>
<?php include "include/head.php"?>

<body>
<link href="css/loader.css" rel="stylesheet">


<?php include "include/barra_superior.php" ?>


<?php include "include/menu_bar.php" ?>

<div class="progress" style="margin-top: -50px; position: absolute; z-index: 2;">
    <div class="indeterminate"></div>
</div>
<div class="mensagem"
   style="margin-top: -65px; margin-left: -15px; text-align: center; width: 110%; position: relative; font-size: 12px; z-index: 3">
    <p>Mensagem de retorno</p>
</div>

<div class="modal fade modal-question" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Aten&ccedil;&atilde;o</h4>
            </div>
            <div class="modal-body">
                <p>Deseja realmente voltar &agrave; tela empresas?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-sim">Sim</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Não</button>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<link rel="stylesheet" type="text/css" href="css/font-awesome.css">
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main" style="z-index: -2">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
            <li class="active">Usu&aacute;rios / Cadastrar Empresa</li>
        </ol>
    </div><!--/.row-->

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header col-lg-9">Cadastrar Empresa</h1>

        </div>
    </div><!--/.row-->


    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">

                <div class="panel-body">
                    <input id="id" type="hidden" value="0" />
                    <input id="acao" type="hidden" value="I" />
                    <div class="form-group col-lg-10">
                        <label for="nome">Nome</label>
                        <input id="nome" class="form-control" />
                    </div>

                    <div class="row"></div>
                    <div class="col-lg-3">
                        <button class="btn btn-success btn-salvar">Salvar</button>
                        <!--<button class="btn btn-warning btn-limpar">Limpar</button>-->

                        <button class="btn btn-default btn-cancelar">Voltar</button>
                    </div>

                </div>
            </div>
        </div>
    </div><!--/.row-->



</div><!--/.main-->

<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/chart.min.js"></script>
<script src="js/chart-data.js"></script>
<script src="js/easypiechart.js"></script>
<script src="js/easypiechart-data.js"></script>

<script src="js/selecao.js"></script>
<script src="js/empresa.js"></script>
</body>

</html>
