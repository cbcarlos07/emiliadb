<?php
session_start();
if( !isset( $_SESSION['login'] ) ){
    header("location:./index.php");
}
?>
<!DOCTYPE html>
<html>
<?php include "include/head.php"?>

<link href="css/chosen.min.css" rel="stylesheet" type="text/css">




<body>
	<?php include "include/barra_superior.php" ?>

		
	<?php include "include/menu_bar.php" ?>
    <link href="css/loader.css" rel="stylesheet">

    <div class="progress" style="margin-top: -50px; position: absolute; z-index: 2;">
        <div class="indeterminate"></div>
    </div>
    <div class="mensagem "
         style="margin-top: -65px; margin-left: -15px; text-align: center; width: 110%; position: relative; font-size: 12px; z-index: 3">
        <p class="alert alert-success">Mensagem de retorno</p>
    </div>
    <div class="modal fade modal-registro" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">

            <div class="modal-content">

                <div class="msgAvisoModal"
                     style="margin-top: 0;  text-align: center; width: 100%; position: relative; font-size: 12px; z-index: 3">
                    <p class="alert alert-success">Mensagem de retorno</p>
                </div>

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Novo Registro</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group col-lg-12">
                        <label for="cliente">Cliente</label>
                        <select  id="cliente" class="form-control" data-placeholder="Escolha um cliente">
                            <option value="0"></option>
                        </select>
                    </div>
                    <hr >
                    <div class="col-lg-4"></div>
                    <div class="panel panel-default col-lg-4">
                        <div class="panel-heading" style="text-align: center">Total</div>
                        <div class="panel-body" style="color: green; font-size: 35px; font-weight: bold; text-align: center">
                            <span class="vl-total"></span>
                        </div>
                    </div>
                    <div class="col-lg-4"></div>
                    <div class="row"></div>
                    <div class="form-group col-lg-2">
                        <label for="qtde">Qtde</label>
                        <input id="qtde" class="form-control" type="number" value="1" min="1"/>
                    </div>
                    <div class="form-group col-lg-6">
                        <label for="produto">Produto</label>
                        <select  id="produto" class="form-control" data-placeholder="Escolha um produto">
                            <option value="0"></option>
                        </select>
                    </div>
                    <div class="form-group col-lg-2">
                        <label for="valor">Valor Unit</label>
                        <input id="valor" class="form-control" />
                    </div>
                    <div class="form-group col-lg-2">
                        <label for="subtotal">Valor Total</label>
                        <input id="subtotal" class="form-control" style="color: blue; font-weight: bold"/>
                    </div>
                    <div class="row"></div>
                    <div class="form-group checkbox col-lg-2">
                        <label>
                            <input type="checkbox" id="pago" >Pago ?
                        </label>
                    </div>
                    <div class="row"></div>
                    <button class="btn btn-success btn-adicionar">Adicionar</button>
                    <div class="row"></div>

                    <table class="tb-produtos table table-hover">
                        <thead>
                          <th>#</th>
                          <th>Descri&ccedil;&atilde;o</th>
                          <th>Qtde</th>
                          <th>Valor</th>
                        </thead>
                        <tbody id="tb-itens"></tbody>
                    </table>


                    <div class="row"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary btn-sim">Sim</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Não</button>

                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->


	<link rel="stylesheet" type="text/css" href="css/font-awesome.css">
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
				<li class="active">Lan&ccedil;amento</li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-lg-12">
				<h1 class="col-lg-9">Lan&ccedil;amento</h1>
                <button class="btn btn-primary col-lg-1 btn-novo" style="margin-top: 50px;">Novo Registro</button>
			</div>
		</div><!--/.row-->

        <div class="row">
            <div class="col-lg-12">
                <div class="form-group col-lg-1">
                    <label for="cracha">Total a Receber</label>
                    <div class="panel panel-default"><span class="total"></span></div>
                </div>

        </div>

        <div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">

					<div class="panel-body">
						<table data-toggle="table"  class="table-user"  data-show-refresh="true" data-show-toggle="true" data-show-columns="true"  data-select-pessoa-name="toolbar1" data-pagination="true" data-sort-name="name" data-sort-order="desc">
						    <thead>
						    <tr>
						        <!--<th data-field="state" data-checkbox="true" >ID</th>-->
						        <th data-field="id" data-sortable="true">Cach&aacute;</th>
						        <th data-field="name"  data-sortable="true">Nome</th>
						        <th data-field="valor"  data-sortable="true">Empresa</th>
						        <th data-field="valor"  data-sortable="true">Valor</th>
						        <th data-field="" data-sortable="true"></th>
						    </tr>
						    </thead>
                            <tbody class="tbody"></tbody>
						</table>
					</div>
				</div>
			</div>
		</div><!--/.row-->	

		
		
	</div><!--/.main-->

	<script src="js/jquery-3.2.1.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/bootstrap-table.js"></script>

    <script src="js/selecao.js"></script>

    <script src="js/chosen.jquery.min.js"></script>
    <script src="js/jquery.tabletojson.min.js"></script>
    <script src="js/lancamento.js"></script>
    <script>
        $('.modal-registro').on('shown.bs.modal', function () {
           // $('#resp', this).chosen('destroy').chosen();
            $('#cliente', this).chosen('destroy').chosen( {allow_single_deselect: true} );
            $('#produto', this).chosen('destroy').chosen( {allow_single_deselect: true} );
            // console.log("User: "+$('#usuario').val());
            // $('#resp').text( $('#usuario').val() ).trigger("chosen:updated");
        });
    </script>


</body>

</html>
