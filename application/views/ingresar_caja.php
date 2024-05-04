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
 		var table;
 		var path;
 		

 		function numeros(e){
		    key = e.keyCode || e.which;
		    tecla = String.fromCharCode(key).toLowerCase();
		    numero = "0123456789";
		    especiales = [46];
		 
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

 		function limpiar()
	    {	    		        
	        $("#valor").val('');
	        $("#fecha").val(moment(new Date()).format('YYYY-MM-DD'));	       
	    }


	    function eliminar()
	    {
	    		$.post("<?= base_url() .'index.php/validacion/eliminar_caja'?>",
		        {
		          id_caja: $("#id_caja").val(),
		          estado: "eliminado"
		        },
		        function(data,status){
		            if (data == "validado")
		            {
		            	alert("Ingreso de caja Eliminado.");
		            	table.ajax.reload(); //Refresco el DataBase para que aparezcan los nuevos Ingreso de caja 

		            }
		            else
		            {
		            	alert("Error al eliminar el Ingreso de caja");
		            }
		        });
	    }

	    //*************************************************
	    //Se ingresa la base a la caja de los cobradores
	    //*************************************************
		function registrar_caja()
		{		            			
		    	//******************************************************
		    	//El ingreso el valor a la caja para cada cobrador
		    	//******************************************************
		    		var id_usuario = document.getElementById("cobrador").value;

		            var formData = new FormData();
		            
		            formData.append("detalle",$("#detalle").val());
					formData.append("fecha_entrega",$("#fecha").val());
					formData.append("valor",$("#valor").val());
					formData.append("id_usuario", id_usuario);
					
					if ($("#detalle").val()!="" || $("#valor").val()!="" || $("#fecha_entrega").val()!="" )
					{		

					    $.ajax({
							url:"<?php echo base_url(); ?>index.php/validacion/registrar_caja",
							type:'POST',						
							data: formData,
							cache: false,
	    					contentType: false,
	    					processData: false,
	    					async:false,
							success:function(result)
							{
								alert("Ingreso de caja ingresado correctamente.");							
							},
							error:function(result)
							{
								alert("Error. Verifique que el cliente no este registrado. Si el error persiste consulte con el administrador");	
							}					
						});
					}else{				    
						alert("Faltan datos. Verifique.");
					}

					table.ajax.reload();
					limpiar();
			
		}

		$(document).ready(function(e) {
	        listar();


			$('#tabla_caja').on( 'click', 'tr', function () {
		       if ( $(this).hasClass('selected') ) {
		            $(this).removeClass('selected');
		            //document.getElementById("btn_validar").disabled = true;
		            document.getElementById("btn_eliminar").disabled = true;
		        }
		        else {
		            table.$('tr.selected').removeClass('selected');
		            $(this).addClass('selected');
		            
		            var data = $(this).find("td:eq(0)").text();
		            $("#id_caja").val(data);
		            //document.getElementById("btn_validar").disabled = false;
		            document.getElementById("btn_eliminar").disabled = false;
		        }
		    } );

	    });
	
		var listar = function()
		{
					table = $('#tabla_caja').DataTable();
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
							"url":"<?php echo base_url(); ?>index.php/validacion/consulta_ingreso_caja",
						},

						"columns":[							
							{"data":"id_caja"},
							{"data":"fecha_entrega"},	
							{"render":
								function ( data, type, row ) {
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

	</script>

</head>

<body  class="body_alterno">
	<div class="container">
		<div class="row">
			<div class="col-md-6 offset-md-3 myform-cont" >				
				<div class="myform-top">
					<strong align="left">Registro de Base</strong>
				</div>					

				<div class="myform-bottom">
                   	<table width="100%"> 	
						<tr>	 	 	
						 	<td>Fecha de Entrega:</td>
						 	<td><input type="date" name="fecha"  id="fecha" value="<?php echo date("Y-m-d")?>" style="height: 30px;width: 100%;font-size: 13px;">	 		
						 	</td>	 	
						</tr>
						<tr style="height: 15px"></tr>
						<tr>
							<td> Detalle: </td>
							<td><input value="Entrega de producto" id="detalle" name="detalle" required maxlength="100" style="height: 30px; width: 100%;font-size: 12px;border-color:gray;border-width:thin;line-height: 20px"/></td>
						</tr>
						<tr style="height: 15px"></tr>
						<tr>
							<td>Valor: </td>
							<td><input type="text" id="valor" name="valor" required maxlength="10" onkeypress="return numeros(event)" style="height: 30px;width: 50%;text-align:center; font-size: 14px;border-color:gray;border-width:thin;line-height: 20px" /></td>
						</tr>
                        <tr style="height: 15px"></tr>
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
					</table>
					<br>
					<div class="table-responsive">    
						<table style="width: 100%">
			                	<tr>                		
			                		<td><input type="submit" class="btn-sm" style="background-color: #C8216A;color: #FFFFFF;width: 95%" value="Guardar" onclick="registrar_caja()"/></td>
			                		<td align="center"><input type="submit" id="btn_eliminar" disabled name="btn_eliminar"class="btn-sm" style="background-color: #C8216A;color: #FFFFFF;width: 95%;" value="Eliminar" onclick="eliminar()"/></td>
			                		
			                		<td><input type="text" style="display: none" name="id_caja" id="id_caja"></td>
			                	</tr>
			                	<tr style="height: 15px"></tr>
			                	<tr>
				                	<form action="<?= base_url() .'index.php/menu_principal/menu_reporte'?>" method="post" class="">		
										<td ><input type="submit" id="btn_regresar" name="btn_regresar"class="btn-sm" style="width: 95%;background-color: #C8216A;color: #FFFFFF;" value="Regresar" onclick="regresar()"/></td>
									</form>
								</tr>		                	
		                </table>  

		                <table id="tabla_caja" width="100%" style="font-family:sans-serif; font-size: 13px;">
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
										<th>Cobrador</th>
										<th>Valor</th>
																												
									</tr>
								</thead>
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