<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('America/Bogota');
?><!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistema de Crédito</title>
    
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap.min.css">    
    <link rel="stylesheet" href="<?php echo base_url(); ?>font-awesome/css/font-awesome.min.css"> <!--Iconos-->   
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,300,400,500" rel="stylesheet">  
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/custom.css">  
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/jquery.dataTables.min.css">
    <script src="<?php echo base_url(); ?>js/jquery.js"></script>
	
	<!-- Negocio -->
	<script type="text/javascript" src="<?php echo base_url(); ?>js/admin/abonos.js"></script>


    <style type="text/css">
    	#cabecera { height: 200px; }
	</style>


</head>

<body  class="body_alterno">
	<div class="container">
		<div class="row">
			<div class="col-md-6 offset-md-3 myform-cont" >				
				<div class="myform-top">
					<strong align="left">Editar Abono</strong>
				</div>					

				<div class="myform-bottom">
                   	<table width="100%"> 	
						<tr>
							<td> Cédula: </td>
							<td><input type="text" readonly="true" id="cedula" value="<?php echo $cedula?>" name="cedula" required maxlength="45"style="height: 30px;width: 100%;font-size: 12px;border-color:gray;border-width:thin;line-height: 20px" /></td>
							
							<td><input type="text" readonly="true" id="id_cab_credito" value="<?php echo $id_cab_credito?>" name="id_cab_credito" style="display: none;" /></td>		
						</tr>
						<tr>
							<td> Nombre: </td>
							<td><input type="text" readonly="true" value="<?php echo $nombre_completo?>" id="nombre" name="nombre" required maxlength="45"style="height: 30px;width: 100%;font-size: 12px;border-color:gray;border-width:thin;line-height: 20px" /></td>
						</tr>
						<tr>	 	 	
						 	<td>Fecha Inicio</td>
						 	<td><input type="text" readonly="true" name="fecha_i"  id="fecha_i" value="<?php echo $fecha_i?>" style="height: 30px;width: 100%;font-size: 12px;border-color:gray;border-width:thin;line-height: 20px">	 		
						 	</td>	 	
						</tr>
						<tr>
							<td>Fecha Fin</td>
							<td><input type="text" readonly="true"name="fecha_f" readonly="true" id="fecha_f" value="<?php echo $fecha_f?>" style="height: 30px;width: 100%;font-size: 12px;border-color:gray;border-width:thin;line-height: 20px">	 		
						 	</td>
		 				</tr>	

						<tr>
							<td>Crédito por: </td>
							<td><input type="text" readonly="true" id="valor" name="valor" value="$ <?php echo ($totalapagar - $mora)?>" required maxlength="10" onkeypress="return numeros(event)" style="height: 30px;width: 70%;text-align:center; font-size: 14px;border-color:gray;border-width:thin;line-height: 20px" /></td>
						</tr>
						<tr>
							<td>Valor Mora: </td>
							<td><input type="text" readonly="true" id="mora" name="mora" value="$ <?php echo $mora?>" required maxlength="10" onkeypress="return numeros(event)" style="height: 30px;width: 70%;text-align:center; font-size: 14px;border-color:gray;border-width:thin;line-height: 20px" /></td>
						</tr>
						<tr>
							<td>Saldo a pagar: </td>
							<td><input type="text" readonly="true" id="saldo" name="saldo" value="$ <?php echo ($totalapagar - $totalpagado)?>" required maxlength="10" onkeypress="return numeros(event)" style="height: 30px;width: 70%;text-align:center; font-size: 14px;border-color:gray;border-width:thin;line-height: 20px" /></td>
						</tr>
						<tr>
							<td>Abono: </td>
							<td><input type="text" readonly="true" id="abono" name="abono" value="$ <?php echo ($valor)?>" disabled style="height: 30px;width: 70%;text-align:center; font-size: 14px;border-color:gray;border-width:thin;line-height: 20px" /></td>
						</tr>

					<form name="fs" action="<?= base_url() .'index.php/menu_principal/inicio'?>" method="post" class="" onsubmit="if (document.abono.value!='') {return true;} else {return false;}">
					<tr>
							<td>Valor del Abono: </td>
							<td><input type="number" id="abono_modify" name="abono_modify" onkeypress="return numeros(event)" required maxlength="10" style="height: 30px;width: 70%;text-align:center; font-size: 14px;border-color:gray;border-width:thin;line-height: 20px" required="true"/></td>
					</tr>
					</table>
					<br>
					<table width="100%">
				
					<tr>
							<td align="center"><input type="submit" id="btn_guardar" name="btn_abonar"class="btn-sm" style="background-color: #C8216A;color: #FFFFFF;width: 98%;" value="Guardar" onclick="guardar()"/></td>
					</form>
					<form action="" method="" class="">		
							<td align="center"><input type="submit" id="btn_regresar" name="btn_regresar"class="btn-sm" style="background-color: #C8216A;color: #FFFFFF;width: 98%;" value="Regresar" onclick="window.close();"/></td>
					</form>	
					</tr>	
					</table>
					
                </div>
			</div>
			
		</div>
	</div>

<script src="<?php echo base_url(); ?>tether/js/tether.min.js"></script>
<script src="<?php echo base_url(); ?>js/jquery.js"></script>
<script src="<?php echo base_url(); ?>js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>js/moment.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.dataTables.min.js"></script>
</body>
</html>