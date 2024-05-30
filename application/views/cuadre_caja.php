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

	
	<!-- Negocio -->
	<script type="text/javascript" src="<?php echo base_url(); ?>js/admin/abonos.js"></script>

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
		

		function guardar_cuadre_caja()
		{
			$id_cuadre_caja=0;

			//*****************************************************************
			//Para guardar en tabla cuadre_caja
			//*****************************************************************
			//var id = $(this).find("td:eq(0)").text();

			$.post("<?= base_url() .'index.php/validacion/registrar_cuadre_caja'?>",
			{
			   	fecha_i: $("#fecha_i").val(),
			    fecha_f: $("#fecha_f").val(), 
			    id_cobrador: document.getElementById("cobrador").value,
			    t_caja: $("#t_caja").val(),
				t_abono: $("#t_abono").val(),
				t_credito: $("#t_credito").val(),
				t_gastos: $("#t_cab_gastos").val(),
				t_liquidacion: $("#t_liquidacion").val()

			},
			function(data,status){
				$id_cuadre_caja = data;
				registrar_detalle_cuadre_caja($id_cuadre_caja);

			});

			
			
		}	
	
		function registrar_detalle_cuadre_caja($id_cuadre_caja)
		{
			var band = 0;
			//*********************************************************************************
			// Se actualiza el estado de Cuadre_Caja a 'cancelado' cada elemento del DataTable
			//*********************************************************************************
			$('#tabla_caja' + ' tr').each(function(index){
				if (index > 0)
				{	
					
					//*****************************************************************
					//Obtengo cual el ID que está en la primera columna del DataTable
					//*****************************************************************
					var id = $(this).find("td:eq(0)").text();
					var fecha = $(this).find("td:eq(1)").text();
					var detalle = 	$(this).find("td:eq(2)").text();
					var valor = $(this).find("td:eq(3)").text().substring(2);

					if (id!="No hay datos disponibles en la tabla") 
	            	{
						$.post("<?= base_url() .'index.php/validacion/cuadre_ingreso_caja'?>",
				        {
				          id_caja: id,
				          fecha: fecha,
				          detalle: detalle,
				          valor: valor,
				          id_cuadre_caja: $id_cuadre_caja
				        },
				        function(data,status){
				            if (data != "validado")
				            {
				            	band = 1;
				          	}
				        });
					}

				}
				
			});

			//***************************************************************************************************
			// Se actualiza el estado de Cuadre_Caja de la tabla ABONO a 'cancelado' cada elemento del DataTable
			//***************************************************************************************************
			$('#tabla_abono' + ' tr').each(function(index){
				if (index > 0)
				{	
					
					//*****************************************************************
					//Obtengo cual el ID que está en la primera columna del DataTable
					//*****************************************************************
					var id = $(this).find("td:eq(0)").text();
					var fecha = $(this).find("td:eq(1)").text();
					var detalle = $(this).find("td:eq(2)").text();
					var valor = $(this).find("td:eq(3)").text().substring(2);

					if (id!="No hay datos disponibles en la tabla") 
	            	{
						$.post("<?= base_url() .'index.php/validacion/cuadre_ingreso_abono'?>",
				        {
				          id_abono: id,
				          fecha: fecha,
				          detalle: detalle,
				          valor: valor,
				          id_cuadre_caja: $id_cuadre_caja
				        },
				        function(data,status){
				            if (data != "validado")
				            {
				            	band = 1;
				          	}
				        });
					}

				}
				
			});

			//***************************************************************************************************
			// Se actualiza el estado de Cuadre_Caja de la tabla ABONO a 'cancelado' cada elemento del DataTable
			//***************************************************************************************************
			$('#tabla_credito' + ' tr').each(function(index){
				if (index > 0)
				{	
					
					//*****************************************************************
					//Obtengo cual el ID que está en la primera columna del DataTable
					//*****************************************************************
					var id = $(this).find("td:eq(0)").text();
					var fecha = $(this).find("td:eq(1)").text();
					var detalle = $(this).find("td:eq(2)").text();
					var valor = $(this).find("td:eq(3)").text().substring(2);

					if (id!="No hay datos disponibles en la tabla") 
	            	{
						$.post("<?= base_url() .'index.php/validacion/cuadre_ingreso_credito'?>",
				        {
				          id_cab_credito: id,
				          fecha: fecha,
				          detalle: detalle,
				          valor: valor,
				          id_cuadre_caja: $id_cuadre_caja
				        },
				        function(data,status){
				            if (data != "validado")
				            {
				            	band = 1;
				          	}
				        });
					}

				}
				
			});

			//***************************************************************************************************
			// Se actualiza el estado de Cuadre_Caja de la tabla ABONO a 'cancelado' cada elemento del DataTable
			//***************************************************************************************************
			$('#tabla_gastos' + ' tr').each(function(index){
				if (index > 0)
				{	
					
					//*****************************************************************
					//Obtengo cual el ID que está en la primera columna del DataTable
					//*****************************************************************
					var id = $(this).find("td:eq(0)").text();
					var fecha = $(this).find("td:eq(1)").text();
					var detalle = $(this).find("td:eq(2)").text();
					var valor = $(this).find("td:eq(3)").text().substring(2);

					if (id!="No hay datos disponibles en la tabla") 
	            	{
						$.post("<?= base_url() .'index.php/validacion/cuadre_ingreso_cab_gastos'?>",
				        {
				          id_cab_gastos: id,
				          fecha: fecha,
				          detalle: detalle,
				          valor: valor,
				          id_cuadre_caja: $id_cuadre_caja
				        },
				        function(data,status){
				            if (data != "validado")
				            {
				            	band = 1;
				          	}
				        });
					}

				}
				
			});


			if (band == 0)
			{
				
				alert("Cuadre de caja realizado con éxito.");
			}
			else
			{
				alert("Error al guardar el cuadre de caja.");
			}
		}

		function consultar_cuadre_caja()
		{					
			var fecha = moment($("#fecha_i").val()).day();
			if (fecha!=0)
			{
				$("#t_caja").val("0");
				$("#t_abono").val("0");
				$("#t_credito").val("0");
				$("#t_cab_gastos").val("0");
				$("#t_liquidacion").val("0");
				listar_caja();
				listar_abono();
				listar_credito();
				listar_gastos();
			}
			else
			{
				alert("Fecha inicio de cuadre debe ser lunes")
			}

		}

		$(document).ready(function(e) {
			$("#t_caja").val("0");
			$("#t_abono").val("0");
			$("#t_credito").val("0");
			$("#t_cab_gastos").val("0");
			$("#t_liquidacion").val("0");
	        listar_caja();
	        listar_abono();
	        listar_credito();
			listar_gastos();	       
	    });
	
		

		var listar_credito = function()
		{
					table = $('#tabla_credito').DataTable();
					table.clear();
					table.destroy();
					table = $('#tabla_credito').DataTable({
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
							"url":"<?php echo base_url(); ?>index.php/validacion/consulta_creditos",
							"data" : {"id_cobrador": document.getElementById("cobrador").value,
									  "fecha_i": $("#fecha_i").val(),
									  "fecha_f": $("#fecha_f").val() 	
								 }
						},

						"columns":[							
							{"data":"id_cab_credito"},
							{"data":"fecha"},
							{"render":
								function ( data, type, row ) {
									var gastos = row["total_credito"];
									$("#t_credito").val(gastos);
									
									//*****************************************************************
							  		//Para llenar el campo Liquidar y saber cuanto hay que pagar al 
							  		//cobrador
							  		//*****************************************************************										
									var total_liquidar = parseFloat($("#t_caja").val()) + parseFloat($("#t_abono").val()) - parseFloat($("#t_credito").val()) - parseFloat($("#t_cab_gastos").val()); 
									$("#t_liquidacion").val(total_liquidar);

							  		return (row["nombre"] + " " + row["apellido"]);	
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

		var listar_caja = function()
		{
					table = $('#tabla_caja').DataTable();
					table.clear();
					table.destroy();
					table = $('#tabla_caja').DataTable({
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
							"url":"<?php echo base_url(); ?>index.php/validacion/consulta_caja",
							"data" : {"id_cobrador": document.getElementById("cobrador").value,
									  "fecha_i": $("#fecha_i").val(),
									  "fecha_f": $("#fecha_f").val() 	
								 }
						},

						"columns":[							
							{"data":"id_caja"},
							{"data":"fecha_entrega"},
							{"data":"detalle"},
							{"render":
								function ( data, type, row ) {
									$("#t_caja").val(row["total_caja"]);

							  		//*****************************************************************
							  		//Para llenar el campo Liquidar y saber cuanto hay que pagar al 
							  		//cobrador
							  		//*****************************************************************
							  		var total_liquidar = parseFloat($("#t_caja").val()) + parseFloat($("#t_abono").val()) - parseFloat($("#t_credito").val()) - parseFloat($("#t_cab_gastos").val()); 
									$("#t_liquidacion").val(total_liquidar);
							  		return ("$ " + row["valor"]);	        						
							  	}
							}					  											
						],			
						"buttons": [
				            
				        ]
					});				
		}

		var listar_abono = function()
		{
					table = $('#tabla_abono').DataTable();
					table.clear();
					table.destroy();
					table = $('#tabla_abono').DataTable({
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
							"url":"<?php echo base_url(); ?>index.php/validacion/consulta_abonos",
							"data" : {"id_cobrador": document.getElementById("cobrador").value,
									  "fecha_i": $("#fecha_i").val(),
									  "fecha_f": $("#fecha_f").val() 	
								 }
						},

						"columns":[							
							{"data":"id_abono"},
							{"data":"fecha"},
							{"render":
								function ( data, type, row ) {
							  		return (row["nombre"] + " " + row["apellido"]);	
							  	}
							},
							{"render":
							  	function ( data, type, row ) {
							  		var abono = row["total_abono"];
									$("#t_abono").val(abono);

							  		
							  		//*****************************************************************
							  		//Para llenar el campo Liquidar y saber cuanto hay que pagar al 
							  		//cobrador
							  		//*****************************************************************
							  		
							  		var total_liquidar = parseFloat($("#t_caja").val()) + parseFloat($("#t_abono").val()) - parseFloat($("#t_credito").val()) - parseFloat($("#t_cab_gastos").val()); 
									$("#t_liquidacion").val(total_liquidar);
							  		return ("$ " + row["valor"]);	        						
							  	}
							},
							{"render":
							function ( data, type, row ) {
								return (`
								<div>
									<form action="<?= base_url() .'index.php/validacion/abono'?>" method="post" class="" onsubmit="target_popup(this)">
										<tr>	
											<td align="center">
												<button type="submit" class="btn btn-outline-dark btn-sm">
													<i class="fa fa-pencil" aria-hidden="true"></i>
												</button>
											</td>
											<td><input type="text" style="display: none;" value="${row["id_abono"]}" name="id_abono" id="id_abono"></td>
										</tr>	                
									</form>
								</div>`);
							}
						},
													  											
						],			
						"buttons": [
				            
				        ]
					});	
		}

		var listar_gastos = function()
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
							"url":"<?php echo base_url(); ?>index.php/validacion/consulta_cab_gastos_cuadre",
							"data" : {"id_cobrador": document.getElementById("cobrador").value,
									  "fecha_i": $("#fecha_i").val(),
									  "fecha_f": $("#fecha_f").val() 	
								 }
						},

						"columns":[							
							{"data":"id_cab_gasto"},
							{"data":"fecha_gasto"},
							{"data":"detalle"},
							{"render":
							  	function ( data, type, row ) {
							  		var t_cab_gasto = row["t_cab_gasto"];
									$("#t_cab_gastos").val(t_cab_gasto);

							  		
							  		//*****************************************************************
							  		//Para llenar el campo Liquidar y saber cuanto hay que pagar al 
							  		//cobrador
							  		//*****************************************************************
							  		
							  		var total_liquidar = parseFloat($("#t_caja").val()) + parseFloat($("#t_abono").val()) - parseFloat($("#t_credito").val()) - parseFloat($("#t_cab_gastos").val()); 
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
					<strong align="left">Cuadre de Caja</strong>
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
								<select style="width: 100%;" name="cobrador" id="cobrador" onchange="cambiar_cobrador()">
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
							
							<td><button id="button_consultar" type="submit" class="btn-sm" style="background-color: #C8216A;color: #FFFFFF;width: 95%" value="Consultar" onclick="consultar_cuadre_caja()">Consultar</button></td>
							<form action="<?= base_url() .'index.php/menu_principal/menu_reporte'?>" method="post" class="">		
									<td ><input type="submit" id="btn_regresar" name="btn_regresar"class="btn-sm" style="width: 95%;background-color: #C8216A;color: #FFFFFF;" value="Regresar"/></td>
							</form>
						</tr>
						<tr " style="height: 15px"></tr>
						<tr>
							<form action="<?= base_url() .'index.php/menu_principal/consultar_cuadre_caja'?>" method="post" class="">		
									<td ><input type="submit" id="btn_veranteriores" name="btn_veranteriores"class="btn-sm" style="width: 95%;background-color: #C8216A;color: #FFFFFF;" value="Ver anteriores"/></td>
							</form>
						</tr>
					</table> 	
					<br>
					<div class="table-responsive" >    
						<table style="width: 100%; color:#FFFFFF; background-color: #C8216A;">	
						<tr >	 	 	
						 	<td   style="font-size: 16px;font-weight: 1000;text-align: center">Detalle de Ingreso caja Cobrador</td>	
						</tr>
						 </table>	

		                <table id="tabla_caja" width="100%" style="font-family:sans-serif; font-size: 13px;text-align: center">
								<colgroup>
									<col style="width: 10%;">
									<col style="width: 30%;">
				       				<col style="width: 30%;">
				       				<col style="width: 30%;">
				       							       				
				    			</colgroup>
								<thead>
									<tr style="color:#FFFFFF; background-color: #2E86C1; ">
										<th>Id</th>
										<th>Fecha</th>
										<th>Detalle</th>
										<th>Valor</th>
																							
									</tr>
								</thead>
						</table>
						<table style="width: 100%">	
							<tr>
								<td style="width: 60%;font-size: 14px;font-weight: 1000;text-align: right;
    								background-color: #BDC3C7"> ( + ) Total Ingreso Caja: $</td>
								<td style="width: 40%;background-color: #BDC3C7"><input type="text" readonly="true" id="t_caja" name="t_caja" required maxlength="45"style="font-size: 14px;font-weight: 1000;text-align: right; height: 30px;width: 100%;line-height: 20px" /></td>
							</tr>
						</table>
	                </div>
	                <br>
	                <div class="table-responsive">    
						<table style="width: 100%; color:#FFFFFF; background-color: #C8216A;">	
						<tr >	 	 	
						 	<td   style="font-size: 16px;font-weight: 1000;text-align: center">Detalle Abonos Cobrados</td>	
						</tr>
						 </table>	
		                <table id="tabla_abono" width="100%" style="font-family:sans-serif; font-size: 13px;text-align: center">
								<colgroup>
									<col style="width: 10%;">
				       				<col style="width: 25%;">
				       				<col style="width: 25%;">
				       				<col style="width: 25%;">
									<col style="width: 15%;">
				       								       				
				    			</colgroup>
								<thead>
									<tr style="color:#FFFFFF; background-color: #2E86C1;">
										<th>Id</th>
										<th>Fecha</th>
										<th>Cliente</th>
										<th>Valor</th>	
										<th></th>												
									</tr>
								</thead>
						</table>
						
	                </div>

						<table style="width:100%">	
							<tr>
								<td style="width: 60%;font-size: 14px;font-weight: 1000;text-align: right;
    								background-color: #BDC3C7"> ( + ) Total  Cobrado: $</td>
								<td style="width: 40%;background-color: #BDC3C7"><input type="text" readonly="true" id="t_abono" name="t_abono" required maxlength="45"style="font-size: 14px;font-weight: 1000;text-align: right; height: 30px;width: 100%;line-height: 20px" /></td>
							</tr>
						</table>
	                <div class="table-responsive">    
					<br>
					<table style="width: 100%; color:#FFFFFF; background-color: #C8216A;">	
						<tr >	 	 	
						 	<td   style="font-size: 16px;font-weight: 1000;text-align: center">Detalle Nuevos Créditos</td>	
						</tr>
					</table>		
		            <table id="tabla_credito" width="100%" style="font-family:sans-serif; font-size: 13px;text-align: center">
								<colgroup>
									<col style="width: 10%;">
				       				<col style="width: 30%;">
				       				<col style="width: 30%;">
				       				<col style="width: 30%;">				       				
				       				
				    			</colgroup>
								<thead>
									<tr style="color:#FFFFFF; background-color: #2E86C1;">
										<th>Id</th>
										<th>Fecha</th>
										<th>Cliente</th>
										<th>Valor</th>	
									</tr>
								</thead>
					</table>
					<table style="width: 100%">	
							<tr>
								<td style="width: 60%;font-size: 14px;font-weight: 1000;text-align: right;
    								background-color: #BDC3C7">  ( - ) Total Créditos: $</td>
								<td style="width: 40%;background-color: #BDC3C7"><input type="text" readonly="true" id="t_credito" name="t_credito" required maxlength="45"style="font-size: 14px;font-weight: 1000;text-align: right; height: 30px;width: 100%;line-height: 20px" /></td>
							</tr>
					</table>
					<br>
					<table style="width: 100%; color:#FFFFFF; background-color: #C8216A;">	
						<tr >	 	 	
						 	<td   style="font-size: 16px;font-weight: 1000;text-align: center">Detalle Gastos</td>	
						</tr>
					</table>		
		                <table id="tabla_gastos" width="100%" style="font-family:sans-serif; font-size: 13px;text-align: center">
								<colgroup>
									<col style="width: 10%;">
				       				<col style="width: 30%;">
				       				<col style="width: 30%;">
				       				<col style="width: 30%;">				       				
				       				
				    			</colgroup>
								<thead>
									<tr style="color:#FFFFFF; background-color: #2E86C1;">
										<th>Id</th>
										<th>Fecha</th>
										<th>Detalle</th>
										<th>Valor</th>	
									</tr>
								</thead>
						</table>
						<table style="width: 100%">	
							<tr>
								<td style="width: 60%;font-size: 14px;font-weight: 1000;text-align: right;
    								background-color: #BDC3C7">  ( - ) Total Gastos: $</td>
								<td style="width: 40%;background-color: #BDC3C7"><input type="text" readonly="true" id="t_cab_gastos" name="t_cab_gastos" required maxlength="45"style="font-size: 14px;font-weight: 1000;text-align: right; line-height: 20px; height: 30px;width: 100%" /></td>
							</tr>
							<tr " style="height: 15px"></tr>
							<tr>
								<td style="width: 60%;font-size: 16px;font-weight: 1000;text-align: right;
    								background-color: #BDC3C7"> Total Liquidación: $</td>
								<td style="width: 40%;background-color: #BDC3C7"><input type="text" readonly="true" id="t_liquidacion" name="t_liquidacion" required maxlength="45"style="font-size: 16px;font-weight: 1000;text-align: right; line-height: 20px; height: 30px;width: 100%" /></td>
							</tr>
						</table>

	                </div>
	                <br>
	                 <table style="width: 100%">
						<tr>
							<td><input type="submit" class="btn-sm" style="background-color: #C8216A;color: #FFFFFF;width: 50%" value="Guardar" onclick="guardar_cuadre_caja()"/></td>
						</tr>
					</table>
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