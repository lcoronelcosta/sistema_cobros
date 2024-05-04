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

		function eliminar(){

			if (confirm("Esta seguro que desea eliminar el crédito?"))
			{
				if ($("#totalpagado").val() == 0)
				{
					$.post("<?= base_url() .'index.php/validacion/eliminar_credito'?>",
			        {
			          id_cab_credito: $("#id_cab_credito").val(),
			          estado: "eliminado"
			        },
			        function(data,status){
			            if (data == "eliminado")
			            {
			            	alert("Crédito eliminado.");
			            	//table.ajax.reload(); //Refresco el DataBase para que aparezcan los nuevos gastos 

			            }
			            else
			            {
			            	alert("Error al eliminar el crédito");
			            }
			        });

			    }
			    else
			    {
			        alert("No se puede eliminar el crédito, ya tiene abono(s) realizado(s)");
			    }
			}

		}

 		
		$(document).ready(function(){

 			listar_det_credito();
 		});
	
	    var listar_det_credito = function()
		{
					table = $('#tabla_det').DataTable();
					table.clear();
					table.destroy();
					table = $('#tabla_det').DataTable({
						"dom": "Bfrtip",
						"paging": false,
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
							"url":"<?php echo base_url(); ?>index.php/validacion/consulta_informacion_credito_det",
							"data" : {"id_cab_credito": $("#id_cab_credito").val() }
						},

						"columns":[							
							{"data":"n_cuota"},
							{"data":"fechapago"},
							{"render":
							  	function ( data, type, row ) {
							  		return ("$ " + row["v_cuota"]);	        						
							  	}
							},
							{"data":"estado"}											  											
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
					<strong align="left">Consulta de Detalle de Créditos</strong>
				</div>					

				<div class="myform-bottom">
                   	<table width="100%"> 	
						<tr>
							<td>Cliente: </td> 
							<td>
								<input type="text" readonly="true" id="nombre" value="<?php echo $nombre?> <?php echo $apellido?>" name="nombre" required maxlength="100" style="height: 30px;width: 100%;font-size: 12px;border-color:gray;border-width:thin;line-height: 20px"/>
							</td>
							<td><input type="text" readonly="true" id="id_cab_credito" value="<?php echo $id_cab_credito?>" name="id_cab_credito" style="display: none;" /></td>
							
						</tr>
						<tr>
							<td> Motivo: </td>
							<td><input type="text" readonly="true" id="motivo" value="Venta de Producto" name="motivo" required maxlength="100"style="height: 30px;width: 100%;font-size: 12px;border-color:gray;border-width:thin;line-height: 20px" /></td>
						</tr>
						<tr>
							<td>Valor: </td>
							<td><input type="text" id="valor" readonly="true" name="valor" value="$ <?php echo $valor?>" required maxlength="10" style="height: 30px;width: 100%;font-size: 12px;border-color:gray;border-width:thin;line-height: 20px"/></td>
						</tr>
						<tr>
							<td>Tasa: </td>
							<td><input type="text" id="tasa" name="tasa" value="<?php echo $tasa?>" required maxlength="10" style="height: 30px;width: 80%;font-size: 12px;border-color:gray;border-width:thin;line-height: 20px"/> %</td>
						</tr>
						<tr>
							<td>Plazo: </td>
							<td>
								<input type="text" id="plazo" name="plazo" value="<?php echo $plazo?>" required maxlength="10" style="height: 30px;width: 80%;font-size: 12px;border-color:gray;border-width:thin;line-height: 20px"/> días
							</td>
						</tr>
						<tr>
							<td>Forma de pago: </td>
							<td>
								<input type="text" id="formadepago" name="formadepago" value="<?php echo $descripcion?>" required maxlength="10" style="height: 30px;width: 100%;font-size: 12px;border-color:gray;border-width:thin;line-height: 20px"/> 
							</td>
						</tr>
						<tr>	 	 	
						 	<td>Fecha Inicio</td>
						 	<td><input type="text" name="fecha_i" readonly="true" id="fecha_i" value="<?php echo $fecha_i?>" style="height: 30px;width: 100%;font-size: 12px;border-color:gray;border-width:thin;line-height: 20px">	 		
						 	</td>	 	
						</tr>
						<tr>
							<td>Fecha Fin</td>
							<td><input type="text" name="fecha_f" readonly="true" id="fecha_f" value="<?php echo $fecha_f?>" style="height: 30px;width: 100%;font-size: 12px;border-color:gray;border-width:thin;line-height: 20px">	 		
						 	</td>
		 				</tr>
						<tr>
							<td>Interés: </td>
							<td>
								<input type="text" readonly="true" id="interes" readonly="true" name="interes" required maxlength="45" value="<?php echo $interes?>" style="height: 30px;width: 100%;font-size: 12px;border-color:gray;border-width:thin;line-height: 20px" />
							</td>
						</tr>
						<tr>
							<td>Mora: </td>
							<td>
								<input type="text" readonly="true" id="mora" readonly="true" name="mora" required maxlength="45" value="<?php echo $mora?>" style="height: 30px;width: 100%;font-size: 12px;border-color:gray;border-width:thin;line-height: 20px" />
							</td>
						</tr>
						<tr>
							<td>Total a pagar: </td>
							<td>
								<input type="text" readonly="true" id="totalapagar" name="totalapagar" required maxlength="45" value="<?php echo $totalapagar?>" style="height: 30px;width: 100%;font-size: 12px;border-color:gray;border-width:thin;line-height: 20px" />
							</td>
						</tr>
						<tr>
							<td>Total pagado: </td>
							<td>
								<input type="text" readonly="true" id="totalpagado" readonly="true" name="totalpagado" required maxlength="45" value="<?php echo $totalpagado?>" style="height: 30px;width: 100%;font-size: 12px;border-color:gray;border-width:thin;line-height: 20px" />
							</td>
						</tr>						
					</table>
					<br>
					

					<div class="table-responsive" id="cabecera" style="display: none;">		    
						<table id="tabla_amortizacion_tmp" width="100%" style="font-family:sans-serif; font-size: 13px;">
					
						</table>
					</div>
					<table class="table-responsive"  id="tabla_det" width="100%" style="font-family:sans-serif; font-size: 13px;text-align: center">
						<colgroup>
		       				<col style="width: 5%;">
		       				<col style="width: 30%;">
		       				<col style="width: 15%;">
		       				<col style="width: 15%;">
		       				
		    			</colgroup>
						<thead>
							<tr style="color:#FFFFFF; background-color: #2E86C1;">
								<th>#</th>
								<th>Fecha</th>
								<th>Valor</th>
								<th>Estado</th>
														
							</tr>
						</thead>
					</table>
					<table width="100%">
							<tr style="height: 15px"></tr>
							 <tr>	 	
								<form action="<?= base_url() .'index.php/menu_principal/amortizacion_cobradores'?>" method="post" class="">		
									<td><input type="submit" id="btn_eliminar" name="btn_eliminar"class="btn-sm" style="width: 100%;background-color: #C8216A;color: #FFFFFF;" value="Eliminar" onclick="eliminar()"/></td>
								</form>
	     						<form action="<?= base_url() .'index.php/menu_principal/amortizacion_cobradores'?>" method="post" class="">		
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