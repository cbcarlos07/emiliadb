<?php
  $id = $_POST['id'];
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Alterar Senha</title>

<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/datepicker3.css" rel="stylesheet">
<link href="css/styles.css" rel="stylesheet">
<link href="css/loader.css" rel="stylesheet">

<!--[if lt IE 9]>
<script src="js/html5shiv.js"></script>
<script src="js/respond.min.js"></script>
<![endif]-->

</head>

<body>
    <div class="progress" style="margin-top: -50px; position: absolute;">
        <div class="indeterminate"></div>
    </div>
	<p class="mensagem alert" style="margin-top: -70px; margin-left: -15px; text-align: center; width: 110%;"></p>
	<div class="row">
		<div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4">
			<div class="login-panel panel panel-default">
				<div class="panel-heading">Log in</div>
				<div class="panel-body">
                    <p class="alert alert-success">Ol&aacute;, <b><span class="nome-user"></span></b> altere sua senha agora para acessar o sistema </p>
					<form role="form">
						<fieldset>
                            <input type="hidden" id="id" value="<?= $id; ?>">
							<div class="form-group">
								<input class="form-control" placeholder="Senha" name="pwd" id="pwd" type="password" autofocus="">
                                <span class="alerta-senha" style="color: red"></span>
							</div>
							<div class="form-group">
								<input class="form-control" placeholder="Repita a senha" name="pwd1" id="pwd1" type="password" value="">
                                <span class="alerta-senha1" style="color: red"></span>
							</div>
							<div class="checkbox">
								<label>
									<input name="remember" id="lembrar" type="checkbox" value="Remember Me">Remember Me
								</label>
							</div>
							<a href="#" class="btn btn-primary btn-new-pwd">Login</a>
						</fieldset>
					</form>
				</div>
			</div>
		</div><!-- /.col-->
	</div><!-- /.row -->	
	
		

	<script src="js/jquery-1.11.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/chart.min.js"></script>
	<script src="js/chart-data.js"></script>
	<script src="js/easypiechart.js"></script>
	<script src="js/easypiechart-data.js"></script>
	<script src="js/bootstrap-datepicker.js"></script>
	<script>
		!function ($) {
			$(document).on("click","ul.nav li.parent > a > span.icon", function(){		  
				$(this).find('em:first').toggleClass("glyphicon-minus");	  
			}); 
			$(".sidebar span.icon").find('em:first').addClass("glyphicon-plus");
		}(window.jQuery);

		$(window).on('resize', function () {
		  if ($(window).width() > 768) $('#sidebar-collapse').collapse('show')
		})
		$(window).on('resize', function () {
		  if ($(window).width() <= 767) $('#sidebar-collapse').collapse('hide')
		})
	</script>
<script src="js/login.js"></script>
</body>

</html>
