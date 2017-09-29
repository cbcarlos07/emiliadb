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
    <div class="modal fade modal-question" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">

            <div class="modal-content">

                <div class="msgAvisoModal"
                     style="margin-top: 0;  text-align: center; width: 100%; position: relative; font-size: 12px; z-index: 3">
                    <p class="alert alert-success">Mensagem de retorno</p>
                </div>

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Aten&ccedil;&atilde;o</h4>
                </div>
                <div class="modal-body">
                    <p>Deseja realmente excluir o pessoa <b><span class="user-nome"></span></b>?</p>
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
				<li class="active">Cliente</li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header col-lg-9">Cliente</h1>
                <a href="pessoacad.php" class="btn btn-primary col-lg-3" style="margin-top: 20px;">Novo</a>
			</div>
		</div><!--/.row-->
				
		
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">

					<div class="panel-body">
						<table data-toggle="table"  class="table-user"  data-show-refresh="true" data-show-toggle="true" data-show-columns="true"  data-select-pessoa-name="toolbar1" data-pagination="true" data-sort-name="name" data-sort-order="desc">
						    <thead>
						    <tr>
						        <!--<th data-field="state" data-checkbox="true" >ID</th>-->
						        <th data-field="id" data-sortable="true">ID</th>
						        <th data-field="name"  data-sortable="true">Nome</th>
						        <th data-field="valor"  data-sortable="true">Empresa</th>
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


    <script src="js/pessoa.js"></script>
</body>

</html>
