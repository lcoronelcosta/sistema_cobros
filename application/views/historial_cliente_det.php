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

 		function cambiar(){
		    var pdrs = document.getElementById('user_file').files[0].name;
		    document.getElementById('info').innerHTML = pdrs;
		}

 		function numeros(e){
		    key = e.keyCode || e.which;
		    tecla = String.fromCharCode(key).toLowerCase();
		    numero = "0123456789";
		    especiales = [8,37];
		 
		    tecla_especial = false
		    for(var i in especiales){
			 if(key == especiales[i]){
			     tecla_especial = true;
			     break;
			        } 
			    }
		 
		    if(numero.indexOf(tecla)==-1 && !tecla_especial)
		        return false;
		}

		function letras(e){
		    key = e.keyCode || e.which;
		    tecla = String.fromCharCode(key).toLowerCase();
		    numero = " abcdefghijklmnñopqrstuvwxyz";
		    especiales = [8,37];
		 
		    tecla_especial = false
		    for(var i in especiales){
			 if(key == especiales[i]){
			     tecla_especial = true;
			     break;
			        } 
			    }
		 
		    if(numero.indexOf(tecla)==-1 && !tecla_especial)
		        return false;
		}

		 		
		$(document).ready(function(){
 			$("#t_interes").val(0);
 			$("#t_saldo").val(0);
 			$("#t_total").val(0);
			$("#t_mora_real").val(0);
			$("#t_efectivo").val(0);
 			listar_cancelados();
 			listar_pendientes();
		});
	
	    var listar_cancelados = function()
		{
					table = $('#tabla_cancelados').DataTable();
					table.clear();
					table.destroy();
					table = $('#tabla_cancelados').DataTable({
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
							"url":"<?php echo base_url(); ?>index.php/validacion/historial_cliente_cancelados",
							"data" : {"id_cliente": $("#id_cliente").val() }
						},

						"columns":[							
							//{"data":"id_cab_credito"},
							{"data":"fecha_i"},
							{"render":
							  	function ( data, type, row ) {
							  		var total = row["t_interes"]; 
									$("#t_interes").val(total);
									//*****************************************************************
							  		//Para llenar el campo total 
							  		//*****************************************************************
							  		var t_total = parseFloat(parseFloat($("#t_interes").val()) + parseFloat($("#t_mora").val()) - parseFloat($("#t_saldo").val())).toFixed(2); 
									$("#t_total").val(t_total);

							  		return ("$ " + row["interes"]);	        						
							  	}
							},
							{"render":
							  	function ( data, type, row ) {
							  		var total_mora = row["t_mora"]; 
									$("#t_mora").val(total_mora);
									var total_mora_real = row["t_mora_real"]; 
									$("#t_mora_real").val(total_mora_real);
									//*****************************************************************
							  		//Para llenar el campo total 
							  		//*****************************************************************
							  		var t_total = parseFloat(parseFloat($("#t_interes").val()) + parseFloat($("#t_mora_real").val()) - parseFloat($("#t_saldo").val())).toFixed(2); 
									$("#t_total").val(t_total);

									var t_efectivo = parseFloat(parseFloat($("#t_interes").val()) + parseFloat($("#t_mora_real").val())).toFixed(2); 
									$("#t_efectivo").val(t_efectivo);

							  		return ("$ " + row["mora"]);	        						
							  	}
							},
							{"render":
							  	function ( data, type, row ) {
							  		return ("$ " + row["mora_real"]);	        						
							  	}
							},
						],			
						"buttons": [
				            
				        ]
					});				
		}

		var listar_pendientes = function()
		{
					table = $('#tabla_pendientes').DataTable();
					table.clear();
					table.destroy();
					table = $('#tabla_pendientes').DataTable({
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
							"url":"<?php echo base_url(); ?>index.php/validacion/historial_cliente_pendientes",
							"data" : {"id_cliente": $("#id_cliente").val() }
						},

						"columns":[							
							{"data":"id_cab_credito"},
							{"data":"fecha_i"},
							{"render":
							  	function ( data, type, row ) {
							  		valor_p =  parseFloat(parseFloat(row["valor"]) - parseFloat(row["totalpagado"])).toFixed(2);
									$("#t_saldo").val(row['t_saldo_capital']);   
									
									var t_total = parseFloat(parseFloat($("#t_interes").val()) + parseFloat($("#t_mora_real").val()) - parseFloat(row['t_saldo_capital'])).toFixed(2); 
									$("#t_total").val(t_total);
									if (valor_p<=0)
							  		{
							  			return ("$ 0");
							  		}
							  		else
							  		{	
							  			return ("$ "+valor_p);
							  		}	 
							  	}
							},
							{"render":
								 function ( data, type, row ) {
							  		
							  		valor_p =  parseFloat(parseFloat(row["valor"]) - parseFloat(row["totalpagado"])).toFixed(2);

							  		if (valor_p>=0)
							  		{
							  			return ("$ "+row["interes"]);
							  		}
							  		else
							  		{

								  		valor_p = parseFloat(parseFloat(row["interes"]) - valor_p).toFixed(2); 

								  		if (valor_p<=0)
								  		{
								  			return ("$ 0");
								  		}
								  		else
								  		{	


								  			return ("$ "+valor_p);
								  		}	
							  		}        						
							  	}

							},
							{"render":
								 function ( data, type, row ) {
							  		
							  		valor_p =  parseFloat(parseFloat(row["valor"]) + parseFloat(row["interes"]) - parseFloat(row["totalpagado"])).toFixed(2);

							  		if (valor_p>=0)
							  		{
							  			return ("$ "+row["mora"]);
							  		}
							  		else
							  		{

								  		valor_p = parseFloat(parseFloat(row["mora"]) - valor_p).toFixed(2); 

								  		return ("$ "+valor_p);

								  			
							  		}

							  			        						
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
					<strong align="left">Consulta Historial de Créditos</strong>
				</div>					

				<div class="myform-bottom">
                   	<table width="100%"> 	
						<tr>
							<td>Cliente: </td> 
							<td>
								<input type="text" readonly="true" id="nombre" value="<?php echo $nombre?> <?php echo $apellido?>" name="nombre" required maxlength="100" style="height: 30px;width: 100%;font-size: 12px;border-color:gray;border-width:thin;line-height: 20px"/>
							</td>
							<td><input type="text" readonly="true" id="id_cliente" value="<?php echo $id_cliente?>" name="id_cliente" style="display: none;" /></td>
							
						</tr>
						
					</table>
					<br>
					
					<table style="width: 100%; color:#FFFFFF; background-color: #C8216A;">	
						<tr >	 	 	
						 	<td   style="font-size: 16px;font-weight: 1000;text-align: center">Cancelados</td>	
						</tr>
					</table>	
					<table class="table-responsive"  id="tabla_cancelados" width="100%" style="font-family:sans-serif; font-size: 13px;text-align: center">
						<thead>
							<tr style="color:#FFFFFF; background-color: #2E86C1;">
								<th width="25%">Fecha</th>
								<th width="2%">Interes</th>
								<th width="25%">Mora</th>
								<th width="25%">M-Cobro</th>
							</tr>
						</thead>
					</table>
					<table style="width: 100%">	
							<tr>
								<td style="width: 60%;font-size: 14px;font-weight: 1000;text-align: right;
    								background-color: #BDC3C7"> ( + ) Total Interes cobrado: $</td>
								<td style="width: 40%;background-color: #BDC3C7"><input type="text" readonly="true" id="t_interes" name="t_interes" required maxlength="45"style="font-size: 14px;font-weight: 1000;text-align: right; height: 30px;width: 100%;line-height: 20px" /></td>						
							</tr>

							<tr>
								<td style="width: 60%;font-size: 14px;font-weight: 1000;text-align: right;
    								background-color: #BDC3C7"> Total Mora : $</td>
								<td style="width: 40%;background-color: #BDC3C7"><input type="text" readonly="true" id="t_mora" name="t_mora" required maxlength="45"style="font-size: 14px;font-weight: 1000;text-align: right; height: 30px;width: 100%;line-height: 20px" /></td>						
							</tr>

							<tr>
								<td style="width: 60%;font-size: 14px;font-weight: 1000;text-align: right;
    								background-color: #BDC3C7"> ( + ) Total Mora cobrada: $</td>
								<td style="width: 40%;background-color: #BDC3C7"><input type="text" readonly="true" id="t_mora_real" name="t_mora_real" required maxlength="45"style="font-size: 14px;font-weight: 1000;text-align: right; height: 30px;width: 100%;line-height: 20px" /></td>						
							</tr>

							<tr>
								<td style="width: 60%;font-size: 14px;font-weight: 1000;text-align: right;
    								background-color: #BDC3C7"> ( = ) Total Efectivo: $</td>
								<td style="width: 40%;background-color: #BDC3C7"><input type="text" readonly="true" id="t_efectivo" name="t_efectivo" required maxlength="45"style="font-size: 14px;font-weight: 1000;text-align: right; height: 30px;width: 100%;line-height: 20px" /></td>						
							</tr>

							<tr style="height: 20px"></tr>
					</table>
					<table style="width: 100%; color:#FFFFFF; background-color: #C8216A;">	
						
						<tr >	 	 	
						 	<td   style="font-size: 16px;font-weight: 1000;text-align: center">Pendientes</td>	
						</tr>
					</table>	
					<table class="table-responsive"  id="tabla_pendientes" width="100%" style="font-family:sans-serif; font-size: 13px;text-align: center">
						<colgroup>
		       				<col style="width: 5%;">
		       				<col style="width: 30%;">
		       				<col style="width: 20%;">
		       				<col style="width: 20%;">
		       				<col style="width: 20%;">
		       				
		       				
		    			</colgroup>
						<thead>
							<tr style="color:#FFFFFF; background-color: #2E86C1;">
								<th>#</th>
								<th>Fecha</th>
								<th>Capital</th>
								<th>Interes</th>
								<th>Mora</th>
																					
							</tr>
						</thead>
					</table>
					<table style="width: 100%">	
							<tr>
								<td style="width: 60%;font-size: 14px;font-weight: 1000;text-align: right;
    								background-color: #BDC3C7"> ( - ) Total No cobrado: $</td>
								<td style="width: 40%;background-color: #BDC3C7"><input type="text" readonly="true" id="t_saldo" name="t_saldo" required maxlength="45"style="font-size: 14px;font-weight: 1000;text-align: right; height: 30px;width: 100%;line-height: 20px" /></td>
							</tr>
							<tr " style="height: 15px"></tr>
							<tr>
								<td style="width: 60%;font-size: 16px;font-weight: 1000;text-align: right;
    								background-color: #BDC3C7"> Total: $</td>
								<td style="width: 40%;background-color: #BDC3C7"><input type="text" readonly="true" id="t_total" name="t_total" required maxlength="45"style="font-size: 16px;font-weight: 1000;text-align: right; height: 30px;width: 100%;line-height: 20px" /></td>
							</tr>
					</table>


					<table width="100%">
							<tr style="height: 15px"></tr>
							 		<form action="<?= base_url() .'index.php/menu_principal/historial'?>" method="post" class="">		
									<td><input type="submit" id="btn_regresar" name="btn_regresar"class="btn-sm" style="width: 100%;background-color: #C8216A;color: #FFFFFF;" value="Regresar" /></td>
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