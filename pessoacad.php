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
<link href="css/jquery.datetimepicker.min.css" rel="stylesheet">
<link href="css/chosen.min.css" rel="stylesheet" type="text/css">


<?php include "include/barra_superior.php" ?>


<?php include "include/menu_bar.php" ?>

<div class="progress" style="margin-top: -50px; position: absolute; z-index: 2;">
    <div class="indeterminate"></div>
</div>
<div class="mensagem"
   style="margin-top: -65px; margin-left: -15px; text-align: center; width: 110%; position: fixed; font-size: 12px; z-index: 3">
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
                <p>Deseja realmente voltar &agrave; tela paciente?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-sim">Sim</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Não</button>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade modal-especialidade" tabindex="-1" role="dialog" data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="progressModal" style="margin-top: -50px; position: absolute; z-index: 2;">
                    <div class="indeterminate"></div>
                </div>
                <div class="msgAvisoModal"
                     style="margin-top: -65px; margin-left: -15px; text-align: center; width: 110%; position: fixed; font-size: 12px; z-index: 3">
                    <p>Mensagem de retorno</p>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Tipo de Atendimento</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="acaoModal">;
                <p>Agora escolha o tipo de atendimento para o paciente</p>
                <select class="form-control" id="especialidade"></select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-ok">OK</button>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->



<link rel="stylesheet" type="text/css" href="css/font-awesome.css">
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main" style="z-index: -2">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
            <li class="active">Usu&aacute;rios / Cadastrar Cliente</li>
        </ol>
    </div><!--/.row-->

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header col-lg-9">Cadastrar Cliente</h1>

        </div>
    </div><!--/.row-->


    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">

                <div class="panel-body">
                    <input id="id" type="hidden" value="0" />
                    <input id="acao" type="hidden" value="I" />
                    <div class="form-group col-lg-7">
                        <label for="nome">Nome</label>
                        <input id="nome" class="form-control" />
                    </div>

                    <div class="row"></div>
                    <div class="form-group col-lg-2">
                        <label for="cracha">Crach&aacute;</label>
                        <input id="cracha" class="form-control" />
                    </div>

                    <div class="form-group col-lg-5">
                        <label for="empresa">Empresa</label>
                        <select id="empresa" class="form-control"></select>
                    </div>
                    <div class="form-group col-lg-2" style="margin-top: 25px;">
                        <label for="fa"></label>
                        <a href="#refresh" title="Clique para atualizar a lista de empresa" class="btn-refresh"><i class=" fa fa-refresh" aria-hidden="true"></i></a>
                    </div>


                    <div class="row"></div>
                    <div class="form-group col-lg-2">
                        <label for="cep">CEP</label>
                        <input id="cep" class="form-control" />
                    </div>
                    <div class="row"></div>
                    <div class="form-group col-lg-6">
                        <label for="logradouro">Logradouro</label>
                        <input id="logradouro" class="form-control" />
                    </div>
                    <div class="form-group col-lg-2">
                        <label for="nrcasa">No. Casa</label>
                        <input id="nrcasa" class="form-control" />
                    </div>
                    <div class="row"></div>
                    <div class="form-group col-lg-6">
                        <label for="bairro">Bairro</label>
                        <input id="bairro" class="form-control" />
                    </div>
                    <div class="row"></div>
                    <div class="form-group col-lg-6">
                        <label for="complemento">Complemento</label>
                        <input id="complemento" class="form-control" />
                    </div>

                    <div class="row"></div>
                    <div class="panel panel-default">
                        <div class="panel-heading">Telefone</div>
                        <div class="panel-body">
                            <div class="form-group col-lg-3">
                                <label for="telefone">Telefone</label>
                                <input id="telefone" class="form-control" />
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="observacao">Observa&ccedil;&atilde;o</label>
                                <input id="observacao" class="form-control" />
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="tipo">Tipo de Telefone</label>
                                <select id="tipo" class="form-control" >
                                    <option value="C">Celular</option>
                                    <option value="R">Residencial</option>
                                </select>
                            </div>

                            <div class="form-group col-lg-3">
                                <button class="btn btn-primary btn-add">Adicionar</button>
                            </div>

                            <table class="table table-hover table-striped table-fone">
                                <thead>
                                  <tr>
                                      <th>Telefone</th>
                                      <th>Obs</th>
                                      <th width="1px">Tipo</th>
                                      <th>Descricao</th>
                                      <th></th>
                                  </tr>
                                </thead>
                                <tbody class="tbodycad"></tbody>
                            </table>

                        </div>


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
<script src="js/jquery.datetimepicker.full.js"></script>

<script src="js/jquery.mask.js"></script>
<script src="js/calcularIdade.js"></script>
<script src="js/jquery.tabletojson.min.js"></script>

<script src="js/chosen.jquery.min.js"></script>
<script src="js/cliente.js"></script>
<script>
    $('#empresa').chosen();
</script>

</body>

</html>
