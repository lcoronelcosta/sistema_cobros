<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('America/Bogota');
?><!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Sistema de Permisos</title>

	<link rel="stylesheet" href="css/bootstrap.min.css">    
    <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css"> <!--Iconos-->   
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,300,400,500" rel="stylesheet">  
    <link rel="stylesheet" href="css/custom.css">	
</head>
<style type="text/css">
	.formulario{
		width: 95%;
		height: 50%;
	}
	.formulario_body{
		height: 95%;
	}

</style>	
<body  class="body_alterno">
	<div class="container formulario">
		<div class="row">
			<div class="col-md-6 offset-md-3 myform-cont" >				
				<div class="myform-top">
					<div class="myform-top-left">
						<h5>Ingrese al sistema</h5>
					</div>

					<div class="myform-top-right">
                            <i class="fa fa-key"></i>
                    </div>
                </div>				

				<div class="myform-bottom">
                    <form role="form" action="<?= base_url() .'index.php/validacion/login'?>" method="post" class="">
                        <div class="form-group">
                            <input type="text" style="border-color:gray;border-width:thin;" name="username" placeholder="Usuario..." class="form-control" id="username">
                        </div>
                        <div class="form-group">
                            <input type="password" style="border-color:gray;border-width:thin;" name="password" placeholder="Contraseña..." class="form-control" id="password">
                        </div>
                        <button type="submit" class="mybtn">Entrar</button>
                    </form>
                </div>

			</div>
		</div>
	</div>

<script src="tether/js/tether.min.js"></script>
<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>