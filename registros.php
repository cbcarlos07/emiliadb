<?php
session_start();
if( !isset( $_SESSION['login'] ) ){
    header("location:./index.php");
}
?>
<!DOCTYPE html>
<html>
<?php include "include/head.php";
     $_id = $_POST['id'];
?>

<link href="css/chosen.min.css" rel="stylesheet" type="text/css">




<body>
    <input type="hidden" value="<?= $_id ?>" id="id">
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
    <div class="modal fade modal-registro" tabindex="-1" role="dialog" data-backdrop="static">
        <div class="modal-dialog " role="document">

            <div class="modal-content">
                <input type="hidden" id="cdregistro">

                <div class="msgAvisoModal"
                     style="margin-top: 0;  text-align: center; width: 100%; position: relative; font-size: 12px; z-index: 3">
                    <p class="alert alert-success">Mensagem de retorno</p>
                </div>

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Confirmar Pagamento</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="cdregistro">

                    <p>Confirmar pagamento no valor de: </p>
                    <div class="col-lg-3"></div>
                    <div class="panel panel-default col-lg-6">
                        <!--<div class="panel-heading" style="text-align: center">Total</div>-->
                        <div class="panel-body" style="color: red; font-size: 35px; font-weight: bold; text-align: center">
                            <span class="vl-total"></span>
                        </div>
                    </div>
                    <div class="col-lg-3"></div>
                    <div class="row"></div>

                    <div class="col-lg-3"></div>
                    <div class="panel panel-default col-lg-6" >
                        <div class="panel-heading" style="text-align: center">Valor Pago</div>
                        <div class="panel-body" style="color: blue; font-size: 35px; font-weight: bold; text-align: center">
                            <div class="col-lg-3"></div>
                            <input type="text" id="valorpago" class="col-lg-12" style="text-align: center" placeholder="R$ 0,00">

                            <div class="col-lg-3"></div>
                        </div>
                    </div>

                    <div class="row"></div>

                    <div class="col-lg-3"></div>
                    <div class="panel panel-default col-lg-6" >
                        <div class="panel-heading" style="text-align: center">Troco</div>
                        <div class="panel-body" style="color: green; font-size: 35px; font-weight: bold; text-align: center">
                            <div class="col-lg-3"></div>
                            <input type="text" id="troco" class="col-lg-12" style="text-align: center" disabled>

                            <div class="col-lg-3"></div>
                        </div>
                    </div>


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
				<li class="active">Lan&ccedil;amento / Registros</li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-lg-12">
				<h1 class="col-lg-9">Registros</h1>
                <button class="btn btn-primary col-lg-2 btn-multiple" style="margin-top: 50px;" disabled>M&uacute;ltiplos Pagamentos</button>
			</div>
		</div><!--/.row-->

        <div class="row">
            <div class="col-lg-12">
                <div class="form-group col-lg-1">
                    <label for="cracha">Crach&aacute;</label>
                    <div class="panel panel-default"><span class="cracha"></span></div>
                </div>
                <div class="form-group col-lg-5">
                    <label for="nome">Nome</label>
                    <div class="panel panel-default"><span class="nome"></span></div>
                </div>
                <div class="row"></div>
                <div class="form-group col-lg-4">
                    <label for="empresa">Empresa</label>
                    <div class="panel panel-default"><span class="empresa"></span></div>
                </div>
                <div class="form-group col-lg-2">
                    <label for="total">Total</label>
                    <div class="panel panel-default"><span class="total"></span></div>
                </div>
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
						        <th><input type="checkbox" id="checkHead"></th>
						        <th data-field="id" data-sortable="true">#</th>
						        <th data-field="name"  data-sortable="true">Produto</th>
						        <th data-field="valor"  data-sortable="true">Qtde</th>
						        <th data-field="valor"  data-sortable="true">Valor</th>
						        <th data-field="valor"  data-sortable="true">Data</th>
						        <th data-field=""></th>
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
    <script src="js/jquery.maskMoney.min.js"></script>

    <script src="js/registro.js"></script>
</body>

</html>
