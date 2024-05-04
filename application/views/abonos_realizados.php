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

    <style type="text/css">
    	#cabecera { height: 200px; }
	</style>

 	<script type="text/javascript">

 		$detalle_credito="";

 		function limpiar()
	    {	    		        
	        $('#cedula').val('');
	        $("#nombre").val('');
	        $("#valor").val('');
	        $("#totalapagar").val('');
	        $("#fecha_i").val(moment(new Date()).format('YYYY-MM-DD'));
	        $("#fecha_f").val(moment(new Date()).format('YYYY-MM-DD'));
	        $("#tabla_amortizacion_tmp tr").remove();
	        document.getElementById("cabecera").style.display='none';
	        document.getElementById("btn_calcular").style.display='none';
		    document.getElementById("btn_guardar").style.display='none';
		    document.getElementById("cedula").readOnly=false;   
		    document.getElementById("seleccionar").selected = true;  
	    }

	   
	    $(document).ready(function(){

 			listar_abono();
 		});
	
	    var listar_abono = function()
		{
					table = $('#tabla_abonos').DataTable();
					table.clear();
					table.destroy();
					table = $('#tabla_abonos').DataTable({
						"dom": "Bfrtip",
						"paging": false,
						"filter": false,
						"language": {
					            processing:     "Tratamiento en curso...",
					            search:         "Buscar:",
					            lengthMenu:     "Mostrar _MENU_ entradas",
					            info:           "Mostrando registros del _START_ al _END_ (Total: _TOTAL_ registros)",
					            infoEmpty:      "No hay datos para mostrar",
					            infoFiltered:   "(Filtrado sobre _MAX_ registros en total)",
					            infoPostFix:    "",
					            loadingRecords: "Cargando...",
					            zeroRecords:    "No hay datos para mostrar",
					            emptyTable:     "No hay datos disponibles en la tabla",
					            paginate: {
					                first:      "Primero",
					                previous:   "Anterior",
					                next:       "Siguiente",
					                last:       "Último"
	            				}
	            		},
						"ajax":{
							"method":"POST",
							"url":"<?php echo base_url(); ?>index.php/validacion/consulta_abonos_realizados_tabla",
							"data" : {"id_det_credito": $("#id_det_credito").val() }
						},

						"columns":[							
							{"data":"id_abono"},
							{"data":"fecha"},
							{"render":
							  	function ( data, type, row ) {
							  		var abono = row["totalpagado"];
									$("#t_abono").val(abono);

							  		return ("$ " + row["valor"]);	        						
							  	}
							}											  											
						],			
						"buttons": [
				            
				        ]
					});				
		}


	</script>

</head>

<body  class="body_alterno">
	<div class="container">
		<div class="row">
			<div class="col-md-6 offset-md-3 myform-cont" >				
				<div class="myform-top">
					<strong align="left">Abonos realizados</strong>
				</div>					

				<div class="myform-bottom">
                   	<table width="100%"> 	
						<tr>
							<td> Cédula: </td>
							<td><input type="text" readonly="true" id="cedula" value="<?php echo $cedula?>" name="cedula" required maxlength="45"style="height: 30px;width: 100%;font-size: 12px;border-color:gray;border-width:thin;line-height: 20px" /></td>
							
							<td><input type="text" readonly="true" id="id_cab_credito" value="<?php echo $id_cab_credito?>" name="id_cab_credito" style="display: none;" /></td>		
							<td><input type="text" readonly="true" id="id_det_credito" value="<?php echo $id_det_credito?>" name="id_det_credito" style="display: none;" /></td>																				
						</tr>
						<tr>
							<td> Nombre: </td>
							<td><input type="text" readonly="true" value="<?php echo $nombre?> <?php echo $apellido?>" id="nombre" name="nombre" required maxlength="45"style="height: 30px;width: 100%;font-size: 12px;border-color:gray;border-width:thin;line-height: 20px" /></td>
						</tr>
						<tr>	 	 	
						 	<td>Fecha Inicio</td>
						 	<td><input type="date" readonly="true" name="fecha_i"  id="fecha_i" value="<?php echo $fecha_i?>" style="height: 30px;width: 100%;font-size: 13px;">	 		
						 	</td>	 	
						</tr>
						<tr>
							<td>Fecha Fin</td>
							<td><input type="date" readonly="true"name="fecha_f" readonly="true" id="fecha_f" value="<?php echo $fecha_f?>" style="height: 30px;width: 100%;font-size: 13px;">	 		
						 	</td>
		 				</tr>	

						<tr>
							<td>Total Crédito: </td>
							<td><input type="text" readonly="true" id="valor" name="valor" value="$ <?php echo $totalapagar?>" required maxlength="10" onkeypress="return numeros(event)" style="height: 30px;width: 50%;text-align:center; font-size: 14px;border-color:gray;border-width:thin;line-height: 20px" /></td>
						</tr>
						<tr>
							<td>Saldo crédito: </td>
							<td><input type="text" readonly="true" id="saldo" name="saldo" value="$ <?php echo ($totalapagar - $totalpagado)?>" required maxlength="10" onkeypress="return numeros(event)" style="height: 30px;width: 50%;text-align:center; font-size: 14px;border-color:gray;border-width:thin;line-height: 20px" /></td>
						</tr>	
						<tr>
							<td>Dias Vencidos: </td>
							<td><input type="text" id="dias_mora" name="dias_mora" value="<?php 
									$resta = (strtotime(date("d-m-Y")) - strtotime($fecha_f)) / (60*60*24);
									if ($resta < 0)
										echo 0;
									else
										echo $resta;  									
								?>" 

								style="height: 30px;width: 50%;text-align:center; font-size: 14px;border-color:gray;border-width:thin;line-height: 20px" /></td>
						</tr>
					<tr>	 	 	
						<td>Próximo Pago</td>
						<td><input type="date" readonly="true" name="fecha_p"  id="fecha_p" value="<?php 
							if (is_null($proxima_fecha))
								echo date("Y-m-d");
							else
								echo $proxima_fecha;  
							?>" 
							style="height: 30px;width: 100%;font-size: 13px;"></td>	 
					</tr>

					</table>
					<br>

					 <table id="tabla_abonos" width="100%" style="font-family:sans-serif; font-size: 13px;text-align: center">
						<colgroup>
		       				<col style="width: 10%;">
		       				<col style="width: 50%;">
		       				<col style="width: 40%;">
		       				
		    			</colgroup>
						<thead>
							<tr style="color:#FFFFFF; background-color: #2E86C1;">
								<th>Id</th>
								<th>Fecha</th>
								<th>Valor</th>
														
							</tr>
						</thead>
					</table>
					<table>	
						<tr>
							<td style="width: 80%;font-size: 14px;font-weight: 1000;text-align: right;
    								background-color: #BDC3C7"> Total  Abonos: $</td>
							<td style="width: 20%;background-color: #BDC3C7"><input type="text" readonly="true" id="t_abono" name="t_abono" required maxlength="45"style="font-size: 14px;font-weight: 1000;text-align: right; height: 30px;width: 100%;line-height: 20px" /></td>
						</tr>
					</table>
					<table width="100%">
				
					<tr>
						<br>
						<form action="<?= base_url() .'index.php/menu_principal/inicio'?>" method="post" class="">		
							<td align="center"><input type="submit" id="btn_regresar" name="btn_regresar"class="btn-sm" style="background-color: #C8216A;color: #FFFFFF;width: 100px;" value="Regresar" onclick="regresar()"/></td>
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