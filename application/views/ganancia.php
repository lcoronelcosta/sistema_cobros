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
		

		var listar_ganancia = function()
		{
					table = $('#tabla_ganancia').DataTable();
					table.clear();
					table.destroy();
					table = $('#tabla_ganancia').DataTable({
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
							"url":"<?php echo base_url(); ?>index.php/validacion/consulta_ganancia",
							"data" : {"fecha_i": $("#fecha_i").val(),
									  "fecha_f": $("#fecha_f").val() 	
								 }
						},

						"columns":[							
							{"render":
								function ( data, type, row ) {
							  		$('#total_ganancia').val(row["total_ganancia"]);
							  		return (row["nombre"] + " " + row["apellido"]);	
							  	}
							},							
							{"data":"ganancia"},
							{"data":"numero_credito"}															
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
					<strong align="left">Cálculo de Ganancia</strong>
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
	                </table>
					<table style="width: 100%">
							<tr>
								
								<td><input type="submit" class="btn-sm" style="background-color: #C8216A;color: #FFFFFF;width: 95%" value="Consultar" onclick="listar_ganancia()"/></td>
								<form action="<?= base_url() .'index.php/menu_principal/menu_reporte'?>" method="post" class="">		
										<td ><input type="submit" id="btn_regresar" name="btn_regresar"class="btn-sm" style="width: 95%;background-color: #C8216A;color: #FFFFFF;" value="Regresar" onclick="regresar()"/></td>
								</form>
							</tr>
					</table>  	
					
					<br>
					<div class="table-responsive">    
						<table style="width: 100%; color:#FFFFFF; background-color: #C8216A;">	
						<tr >	 	 	
						 	<td   style="font-size: 16px;font-weight: 1000;text-align: center">Reporte de Ganancia</td>	
						</tr>
						 </table>	

		                <table id="tabla_ganancia" width="100%" style="font-family:sans-serif; font-size: 13px;text-align: center">
								<colgroup>
									<col style="width: 30%;">
									<col style="width: 20%;">
				       				<col style="width: 30%;">				       						       			
				    			</colgroup>
								<thead>
									<tr style="color:#FFFFFF; background-color: #2E86C1;">
										<th>Colaborador</th>
										<th>Ganancia</th>
										<th># de créditos</th>																				
									</tr>
								</thead>
						</table>
						<table>	
							<tr>
								<td style="width: 80%;font-size: 14px;font-weight: 1000;text-align: right;
    								background-color: #BDC3C7"> ( + ) Total Ganancia: $</td>
								<td style="width: 20%;background-color: #BDC3C7"><input type="text" readonly="true" id="total_ganancia" name="total_ganancia" required maxlength="45"style="font-size: 14px;font-weight: 1000;text-align: right; height: 30px;width: 100%" /></td>
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