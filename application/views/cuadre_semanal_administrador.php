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
    <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/dataTables.buttons.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>js/dataTables.select.min.js"></script>

 	<script type="text/javascript">


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

	    function validar()
	    {
	    		$.post("<?= base_url() .'index.php/validacion/validar_comision'?>",
		        {
		          id_gasto: $("#id_gasto").val()
		        },
		        function(data,status){
		            if (data == "validado")
		            {
		            	alert("Gasto validado.");
		            	table.ajax.reload(); //Refresco el DataBase para que aparezcan los nuevos gastos 

		            }
		            else
		            {
		            	alert("Error al validad el Gasto");
		            }
		        });
	    }
		

		function guardar_cuadre()
		{
			var band = 0;	
			$('#tabla_comision' + ' tr').each(function(index){
				if (index > 0)
				{	
					
					//*****************************************************************
					//Obtengo cual el ID que está en la primera columna del DataTable
					//*****************************************************************
					var id = $(this).find("td:eq(0)").text();
					$.post("<?= base_url() .'index.php/validacion/cuadre_comision'?>",
			        {
			          id_liquidacion: id
			        },
			        function(data,status){
			            if (data != "validado")
			            {
			            	band = 1;
			          	}
			        });

				}
				
			});

			$('#tabla_faltante_sobrante' + ' tr').each(function(index){
				if (index > 0)
				{	
					//*****************************************************************
					//Obtengo cual el ID que está en la primera columna del DataTable
					//*****************************************************************
					var id = $(this).find("td:eq(0)").text();
					$.post("<?= base_url() .'index.php/validacion/cuadre_faltante_sobrante'?>",
			        {
			          id_liquidacion: id
			        },
			        function(data,status){
			            if (data != "validado")
			            {
			            	band = 1;
			          	}
			        });

				}
				
			});

			$('#tabla_gastos' + ' tr').each(function(index){
				if (index > 0)
				{	
					//*****************************************************************
					//Obtengo cual el ID que está en la primera columna del DataTable
					//*****************************************************************
					var id = $(this).find("td:eq(0)").text();
					$.post("<?= base_url() .'index.php/validacion/cuadre_gastos'?>",
			        {
			          id_gasto: id
			        },
			        function(data,status){
			            if (data != "validado")
			            {
			            	band = 1;
			          	}
			        });

				}
				
			});


			//*****************************************************************
			//Para guardar en tabla cuadre_semanal
			//*****************************************************************
			//var id = $(this).find("td:eq(0)").text();
			$.post("<?= base_url() .'index.php/validacion/registrar_cuadre'?>",
			{
			   	fecha_i: $("#fecha_i").val(),
			    fecha_f: $("#fecha_f").val(), 
			    id_cobrador: document.getElementById("cobrador").value,
			    t_comision: $("#t_comision").val(),
				t_faltante_sobrante: $("#t_faltante_sobrante").val(),
				t_gastos: $("#t_gastos").val(),
				t_liquidacion: $("#t_liquidacion").val()

			},
			function(data,status){
				if (data != "validado")
			    {
			    	band = 1;
			    }
			});


			if (band == 0)
			{
				
				alert("Cuadre semanal realizado con éxito.");
			}
			else
			{
				alert("Error al guardar el cuadre semanal.");
			}
		}	
	

		function cambiar_cobrador()
		{
			$("#t_comision").val("0");
			$("#t_faltante_sobrante").val("0");
			$("#t_gastos").val("0");
			$("#t_liquidacion").val("0");
			listar_comision();
			listar_faltante_sobrante();
			listar_gasto();

		}

		$(document).ready(function(e) {
			$("#t_comision").val("0");
			$("#t_faltante_sobrante").val("0");
			$("#t_gastos").val("0");
			$("#t_liquidacion").val("0");
	        listar_comision();
	        listar_faltante_sobrante();
	        listar_gasto();
	       
	    });
	
		

		var listar_gasto = function()
		{
					table = $('#tabla_gastos').DataTable();
					table.clear();
					table.destroy();
					table = $('#tabla_gastos').DataTable({
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
							"url":"<?php echo base_url(); ?>index.php/validacion/consulta_gastos_cuadre",
							"data" : {"id_cobrador": document.getElementById("cobrador").value,
									  "fecha_i": $("#fecha_i").val(),
									  "fecha_f": $("#fecha_f").val() 	
								 }
						},

						"columns":[							
							{"data":"id_gasto"},
							{"data":"fecha_gasto"},
							{"data":"detalle"},
							{"render":
								function ( data, type, row ) {											
									var gastos = row["sum_gasto"];
									$("#t_gastos").val(gastos);
									
									//*****************************************************************
							  		//Para llenar el campo Liquidar y saber cuanto hay que pagar al 
							  		//cobrador
							  		//*****************************************************************										
									var total_liquidar = parseFloat($("#t_comision").val()) + parseFloat($("#t_faltante_sobrante").val()) - parseFloat($("#t_gastos").val()); 
									$("#t_liquidacion").val(total_liquidar);
									return ("$ " + row["valor"]);	
										
							  	}
							}									
						],			
						"buttons": [
				            
				        ]
					});				
		}	

		var listar_comision = function()
		{
					table = $('#tabla_comision').DataTable();
					table.clear();
					table.destroy();
					table = $('#tabla_comision').DataTable({
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
							"url":"<?php echo base_url(); ?>index.php/validacion/consulta_comision",
							"data" : {"id_cobrador": document.getElementById("cobrador").value,
									  "fecha_i": $("#fecha_i").val(),
									  "fecha_f": $("#fecha_f").val() 	
								 }
						},

						"columns":[							
							{"data":"id_liquidacion"},
							{"data":"fecha"},
							{"render":
								function ( data, type, row ) {
							  		return (row["nombre"] + " " + row["apellido"]);	
							  	}
							},
							{"render":
								function ( data, type, row ) {
							  		$("#t_comision").val(row["total_pagar"]);

							  		//*****************************************************************
							  		//Para llenar el campo Liquidar y saber cuanto hay que pagar al 
							  		//cobrador
							  		//*****************************************************************
							  		var total_liquidar = parseFloat($("#t_comision").val()) + parseFloat($("#t_faltante_sobrante").val()) - parseFloat($("#t_gastos").val()); 
									$("#t_liquidacion").val(total_liquidar);
							  		return ("$ " + row["interes"]);	        						
							  	}
							},
							{"render":
								function ( data, type, row ) {
							  		return ("$ " + row["valor"]);	        						
							  	}
							}					  											
						],			
						"buttons": [
				            
				        ]
					});				
		}

		var listar_faltante_sobrante = function()
		{
					table = $('#tabla_faltante_sobrante').DataTable();
					table.clear();
					table.destroy();
					table = $('#tabla_faltante_sobrante').DataTable({
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
							"url":"<?php echo base_url(); ?>index.php/validacion/consulta_sobrante_faltante",
							"data" : {"id_cobrador": document.getElementById("cobrador").value,
									  "fecha_i": $("#fecha_i").val(),
									  "fecha_f": $("#fecha_f").val() 	
								 }
						},

						"columns":[							
							{"data":"id_liquidacion"},
							{"data":"fecha"},
							{"render":
								function ( data, type, row ) {
							  		return (row["nombre"] + " " + row["apellido"]);	
							  	}
							},
							{"data":"descripcion"},						
							{"render":
							  	function ( data, type, row ) {
							  		//var sob_fal=parseInt(row["sum_sobrante"] - row["sum_faltante"]);
							  	    var sob_fal=parseFloat(row["sum_sobrante"] - row["sum_faltante"]).toFixed(2);
                            	//*****************************************************************
							  		//Para llenar el campo Liquidar y saber cuanto hay que pagar al 
							  		//cobrador
							  		//*****************************************************************
							  		$("#t_faltante_sobrante").val(sob_fal);
							  		var total_liquidar = parseFloat($("#t_comision").val()) + parseFloat($("#t_faltante_sobrante").val()) - parseFloat($("#t_gastos").val()); 
									$("#t_liquidacion").val(total_liquidar);
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
					<strong align="left">Cuadre Semanal</strong>
				</div>					

				<div class="myform-bottom">
                   	<table style="width: 100%">
	                   	<tr>	 	 	
						 	<td>Fecha Inicio</td>
						 	<td><input type="date" name="fecha_i"  id="fecha_i" value="<?php echo date("Y-m-d")?>" style="height: 30px;width: 100%;font-size: 13px;">	 		
						 	</td>	 	
						</tr>
						<tr " style="height: 15px"></tr>
						<tr>
							<td>Fecha Fin</td>
							<td><input type="date" name="fecha_f" id="fecha_f" value="<?php echo date("Y-m-d")?>" style="height: 30px;width: 100%;font-size: 13px;">	 		
						 	</td>
		 				</tr>
                        <tr " style="height: 15px"></tr>
	                   	<tr>
							<td>Cobrador: </td> 
							<td>
								<select style="width: 100%;" name="cobrador" id="cobrador">
									<?php 
									foreach($cobradores as $fila)
										 {
										 ?>
										 <option value="<?=$fila->id_usuario?>"><?=$fila->nombre?> <?=$fila->apellido?></option>
										 <?php
										 }
										?> 
								</select>
							</td>
						</tr>
						<tr " style="height: 15px"></tr>

					</table> 
					<table style="width: 100%">
						<tr>
							
							<td><input type="submit" class="btn-sm" style="background-color: #C8216A;color: #FFFFFF;width: 95%" value="Consultar" onclick="cambiar_cobrador()"/></td>
							<form action="<?= base_url() .'index.php/menu_principal/menu_reporte'?>" method="post" class="">		
									<td ><input type="submit" id="btn_regresar" name="btn_regresar"class="btn-sm" style="width: 95%;background-color: #C8216A;color: #FFFFFF;" value="Regresar" onclick="regresar()"/></td>
							</form>
						</tr>
					</table>
					<br>
					<div class="table-responsive">    
						<table style="width: 100%; color:#FFFFFF; background-color: #C8216A;">	
						<tr >	 	 	
						 	<td   style="font-size: 16px;font-weight: 1000;text-align: center">Detalle Comisión</td>	
						</tr>
						 </table>	

		                <table id="tabla_comision" width="100%" style="font-family:sans-serif; font-size: 13px;">
								<colgroup>
									<col style="width: 10%;">
									<col style="width: 20%;">
				       				<col style="width: 40%;">
				       				<col style="width: 20%;">
				       				<col style="width: 20%;">				       				
				    			</colgroup>
								<thead>
									<tr style="color:#FFFFFF; background-color: #2E86C1;">
										<th>Id</th>
										<th>Fecha</th>
										<th>Nombres</th>
										<th>Interes</th>
										<th>Comisión</th>													
									</tr>
								</thead>
						</table>
						<table style="width: 100%">	
							<tr>
								<td style="width: 60%;font-size: 14px;font-weight: 1000;text-align: right;
    								background-color: #BDC3C7"> ( + ) Total Comisión: $</td>
								<td style="width: 40%;background-color: #BDC3C7"><input type="text" readonly="true" id="t_comision" name="t_comision" required maxlength="45"style="font-size: 14px;font-weight: 1000;text-align: right; height: 30px;width: 100%;line-height: 20px" /></td>
							</tr>
						</table>
	                </div>
	                <br>
	                <div class="table-responsive">    
						<table style="width: 100%; color:#FFFFFF; background-color: #C8216A;">	
						<tr >	 	 	
						 	<td   style="font-size: 16px;font-weight: 1000;text-align: center">Detalle Faltantes y Sobrantes</td>	
						</tr>
						 </table>	
		                <table id="tabla_faltante_sobrante" width="100%" style="font-family:sans-serif; font-size: 13px;">
								<colgroup>
									<col style="width: 10%;">
				       				<col style="width: 20%;">
				       				<col style="width: 30%;">
				       				<col style="width: 20%;">
				       				<col style="width: 15%;">
				       				
				    			</colgroup>
								<thead>
									<tr style="color:#FFFFFF; background-color: #2E86C1;">
										<th>Id</th>
										<th>Fecha</th>
										<th>Nombres</th>
										<th>Descripción</th>
										<th>Valor</th>												
									</tr>
								</thead>
						</table>
						<table style="width: 100%">	
							<tr>
								<td style="width: 60%;font-size: 14px;font-weight: 1000;text-align: right;
    								background-color: #BDC3C7"> Total  ( - ) Faltante /  ( + ) Sobrante: $</td>
								<td style="width: 40%;background-color: #BDC3C7"><input type="text" readonly="true" id="t_faltante_sobrante" name="t_faltante_sobrante" required maxlength="45"style="font-size: 14px;font-weight: 1000;text-align: right; height: 30px;width: 100%;line-height: 20px" /></td>
							</tr>
						</table>
	                </div>

	                <div class="table-responsive">    
					<br>
					<table style="width: 100%; color:#FFFFFF; background-color: #C8216A;">	
						<tr >	 	 	
						 	<td   style="font-size: 16px;font-weight: 1000;text-align: center">Detalle Gastos</td>	
						</tr>
						 </table>		
		                <table id="tabla_gastos" width="100%" style="font-family:sans-serif; font-size: 13px;">
								<colgroup>
									<col style="width: 10%;">
				       				<col style="width: 30%;">
				       				<col style="width: 30%;">
				       				<col style="width: 10%;">				       				
				       				
				    			</colgroup>
								<thead>
									<tr style="color:#FFFFFF; background-color: #2E86C1;">
										<th>Id</th>
										<th>Fecha Gasto</th>
										<th>Detalle</th>
										<th>Valor</th>	
									</tr>
								</thead>
						</table>
						
						<table style="width: 100%">	
						    <tr>
								<td style="width: 60%;font-size: 14px;font-weight: 1000;text-align: right;
    								background-color: #BDC3C7">  ( - ) Total Gastos: $</td>
								<td style="width: 40%;background-color: #BDC3C7"><input type="text" readonly="true" id="t_gastos" name="t_gastos" required maxlength="45"style="font-size: 14px;font-weight: 1000;text-align: right; height: 30px;width: 100%;line-height: 20px" /></td>
							</tr>
							<tr " style="height: 15px"></tr>
							<tr>
								<td style="width: 60%;font-size: 16px;font-weight: 1000;text-align: right;
    								background-color: #BDC3C7"> Total Liquidación: $</td>
								<td style="width: 40%;background-color: #BDC3C7"><input type="text" readonly="true" id="t_liquidacion" name="t_liquidacion" required maxlength="45"style="font-size: 16px;font-weight: 1000;text-align: right; height: 30px;width: 100%;line-height: 20px" /></td>
							</tr>
							<tr " style="height: 15px"></tr>
							<tr>
							<td><input type="submit" class="btn-sm" style="background-color: #C8216A;color: #FFFFFF;width: 95%" value="Guardar" onclick="guardar_cuadre()"/></td>
						</tr>
						</table>

	                </div>

	                
                </div>

			</div>			
		</div>
	</div>

<script src="<?php echo base_url(); ?>tether/js/tether.min.js"></script>
<script src="<?php echo base_url(); ?>js/jquery.js"></script>
<script src="<?php echo base_url(); ?>js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/dataTables.select.min.js"></script>
<script src="<?php echo base_url(); ?>js/moment.min.js"></script>
</body>
</html>