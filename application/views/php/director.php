<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Sistema de Permisos</title>
	
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap.min.css">    
    <link rel="stylesheet" href="<?php echo base_url(); ?>font-awesome/css/font-awesome.min.css"> <!--Iconos-->   
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,300,400,500" rel="stylesheet">  
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/custom.css">	

    <style type="text/css">

        #principal{ 
            border:1px;
            min-width: 60%;
            max-width: 72%;
            width:72%; 
            display:inline-block;
            overflow-y: scroll;    
        }
    </style>

</head>

<body class="body_alterno">
<div class="container" style="width: -webkit-fill-available;">   

		<div class="row">
			<div class="col-md-3  myform-cont" >
				<div class="myform-top">				    
                    <div class="myform-top-usuario-right">
                        <?php echo $nombre?>
                        <?php echo $apellido?>
                        <h4><?php echo $tipo_empleado;?></h4>                        
                    </div>
                    <div class="myform-top-usuario-left">
                            <img src="<?php echo base_url(); ?>images/usuario.png">
                    </div>                    				
                </div>

				<div class="myform-bottom-principal">
                    <h5><strong>Menu Principal</strong></h5>                            
                    
                    <form role="form" action="<?= base_url() .'index.php/validacion/login'?>" method="post" class="">
                        <button type="submit" class="option"><img src="<?php echo base_url(); ?>images/solicitud.png" align="left"/>Solicitud de Permiso</button>
                    </form>                    
                    <form role="form" action="<?= base_url() .'index.php/validacion/login'?>" method="post" class="">
                        <button type="submit" class="option"><img src="<?php echo base_url(); ?>images/historial.png" align="left"/>Historial de Permisos Solicitados</button>
                    </form>  
                    <form role="form" action="<?= base_url() .'index.php/validacion/login'?>" method="post" class="">
                        <button type="submit" class="option"><img src="<?php echo base_url(); ?>images/historial.png" align="left"/>Permisos del Personal de la Carrera</button>
                    </form>                      
                    <form role="form" action="<?= base_url() .'index.php/validacion/login'?>" method="post" class="">
                        <button type="submit" class="option"><img src="<?php echo base_url(); ?>images/solicitud.png" align="left"/>Salir</button>
                    </form>
                    
                </div>

			</div>
            <div id="principal" class="myform-principal"></div>
		</div>
    </div>

<script src="<?php echo base_url(); ?>tether/js/tether.min.js"></script>
<script src="<?php echo base_url(); ?>js/jquery.js"></script>
<script src="<?php echo base_url(); ?>js/bootstrap.min.js"></script>
</body>
</html>