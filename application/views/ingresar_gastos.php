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
	        $('#detalle').val('');
	        $("#valor").val('');
	        $("#fecha").val(moment(new Date()).format('YYYY-MM-DD'));	       
	        document.getElementById("check_gasto_comun").checked = false;
	    }

	    function calcular()
	    {	    		        
	        check = document.getElementById("check_gasto_comun");
		    if (check.checked)
		    {
	        	document.getElementById("cobrador").disabled=true;
	       	}
	       	else
	       	{
	       		document.getElementById("cobrador").disabled=false;
	       	}
	    }

	    function validar()
	    {
	    		$.post("<?= base_url() .'index.php/validacion/validar_gasto'?>",
		        {
		          id_cab_gasto: $("#id_cab_gasto").val(),
		          estado: "validado"
		        },
		        function(data,status){
		            if (data == "validado")
		            {
		            	alert("Gasto validado.");
		            	table.ajax.reload(); //Refresco el DataBase para que aparezcan los nuevos gastos 

		            }
		            else
		            {
		            	alert("Error al validar el Gasto");
		            }
		        });
	    }

	    function eliminar()
	    {
	    		$.post("<?= base_url() .'index.php/validacion/validar_gasto'?>",
		        {
		          id_cab_gasto: $("#id_cab_gasto").val(),
		          estado: "eliminado"
		        },
		        function(data,status){
		            if (data == "validado")
		            {
		            	alert("Gasto Eliminado.");
		            	table.ajax.reload(); //Refresco el DataBase para que aparezcan los nuevos gastos 

		            }
		            else
		            {
		            	alert("Error al eliminar el Gasto");
		            }
		        });
	    }

	    //*************************************************
	    //Se ingresa el gasto generado por los cobradores
	    //*************************************************
		function registrar_gasto()
		{		            			
			$id_cabecera_gastos=0;
			check = document.getElementById("check_gasto_comun");
			combobox = document.getElementById("cobrador");
		    
		    //******************************************************
		    //El ingreso del gasto  a la cab_gasto 
		    //******************************************************
		    		var id_generado_por = document.getElementById("cobrador").value;
		            var formData = new FormData();
		            
		            formData.append("detalle",$("#detalle").val());
					formData.append("fecha_gasto",$("#fecha").val());
					formData.append("valor",$("#valor").val());
					formData.append("id_generado_por", id_generado_por);
					if ($("#detalle").val()!="" && $("#valor").val()!="" && $("#fecha_gasto").val()!="" )
					{		

					    $.ajax({
							url:"<?php echo base_url(); ?>index.php/validacion/registrar_cab_gasto",
							type:'POST',						
							data: formData,
							cache: false,
	    					contentType: false,
	    					processData: false,
	    					async:false,
							success:function(result)
							{ 	
								$id_cabecera_gastos=result;
							},
							error:function(result)
							{
								alert("Error.Intente nuevamente. Si el error persiste consulte con el administrador");	
							}					
						});
					}else{				    
						alert("Faltan datos. Verifique.");
					}


		    if (check.checked)
		    {
		    		//*************************************************************
		    		//Se obtiene la cantidad de cobradores que hay en el combobox
		    		//*************************************************************
		    		var numero = combobox.length;
		    		var valor = ($("#valor").val() / numero).toFixed(2);

		    		$band = 0;		    
		    		for (i = 0; i < numero; i++) 
		    		{ 
    					var id_usuario = combobox.options[i].value;
    					    					    					
			    		var formData = new FormData();		            
			            formData.append("detalle",$("#detalle").val());
						formData.append("fecha_gasto",$("#fecha").val());
						formData.append("valor",valor);
						formData.append("id_usuario",id_usuario);
						formData.append("id_cabecera_gastos",$id_cabecera_gastos);
												
						if ($("#detalle").val()!="" || $("#valor").val()!="" || $("#fecha_gasto").val()!="" )
						{		

						    $.ajax({
								url:"<?php echo base_url(); ?>index.php/validacion/registrar_gasto",
								type:'POST',						
								data: formData,
								cache: false,
		    					contentType: false,
		    					processData: false,
		    					async:false,
								success:function(result)
								{																			
								},
								error:function(result)
								{
									$band = 1;
										
								}					
							});
						}else{				    
							alert("Faltan datos. Verifique.");
						}

					}

					//***********************************************************************
					//Se verifica que todos los ingresos se han realizado de manera correcta
					//***********************************************************************
					if ($band == 0)
					{
						alert("Gasto ingresado correctamente.");
					}
					else
					{
						alert("Error. Verifique que el cliente no este registrado. Si el error persiste consulte con el administrador");
					}
					
					table.ajax.reload(); //Refresco el DataBase para que aparezcan los nuevos gastos 
					limpiar();	    					    		
		    }
		    else
		    {
		    	//******************************************************
		    	//El ingreso del gasto es individual para cada cobrador
		    	//******************************************************
		    		var id_usuario = document.getElementById("cobrador").value;

		            var formData = new FormData();
		            
		            formData.append("detalle",$("#detalle").val());
					formData.append("fecha_gasto",$("#fecha").val());
					formData.append("valor",$("#valor").val());
					formData.append("id_usuario", id_usuario);
					formData.append("id_cabecera_gastos",$id_cabecera_gastos);
					
					if ($("#detalle").val()!="" || $("#valor").val()!="" || $("#fecha_gasto").val()!="" )
					{		

					    $.ajax({
							url:"<?php echo base_url(); ?>index.php/validacion/registrar_gasto",
							type:'POST',						
							data: formData,
							cache: false,
	    					contentType: false,
	    					processData: false,
	    					async:false,
							success:function(result)
							{
								alert("Gasto ingresado correctamente.");							
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
		}

		$(document).ready(function(e) {
	        listar();


			$('#tabla_gastos').on( 'click', 'tr', function () {
		       if ( $(this).hasClass('selected') ) {
		            $(this).removeClass('selected');
		            document.getElementById("btn_validar").disabled = true;
		            document.getElementById("btn_eliminar").disabled = true;
		        }
		        else {
		            table.$('tr.selected').removeClass('selected');
		            $(this).addClass('selected');
		            
		            var data = $(this).find("td:eq(0)").text();
		            $("#id_cab_gasto").val(data);
		            document.getElementById("btn_validar").disabled = false;
		            document.getElementById("btn_eliminar").disabled = false;
		        }
		    } );

	    });
	
		var listar = function()
		{
					table = $('#tabla_gastos').DataTable();
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
							"url":"<?php echo base_url(); ?>index.php/validacion/consulta_cab_gastos_validar",
						},

						"columns":[							
							{"data":"id_cab_gasto"},
							{"render":
								function ( data, type, row ) {
							  		return (row["nombre"] + " " + row["apellido"]);	
							  	}
							},
							{"data":"detalle"},						
							{"render":
							  	function ( data, type, row ) {
							  		return ("$ " + row["valor"]);	        						
							  	}
							},
							{"data":"fecha_gasto"}						  											
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
					<strong align="left">Registro de Gastos</strong>
				</div>					

				<div class="myform-bottom">
                   	<table style="width: 100%"> 	
						<tr>	 	 	
						 	<td>Fecha de Gasto:</td>
						 	<td><input type="date" name="fecha"  id="fecha" value="<?php echo date("Y-m-d")?>" style="height: 30px;width: 100%;font-size: 13px;">	 		
						 	</td>	 	
						</tr>
						<tr>
							<td> Detalle: </td>
							<td><textarea id="detalle" name="detalle" required maxlength="100" style="height: 60px;width: 100%;font-size: 12px;border-color:gray;border-width:thin;line-height: 20px;resize: none;"></textarea></td>
						</tr>
						<tr>
							<td>Valor: </td>
							<td><input type="text" id="valor" name="valor" required maxlength="10" onkeypress="return numeros(event)" style="height: 30px;width: 60%;text-align:center; font-size: 14px;border-color:gray;border-width:thin;line-height: 20px" /></td>
						</tr>
						<tr>
							<td>Realizado por: </td> 
							<td >
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
						<tr>
							<td>Es Gasto Común? </td>
							<td><input type="checkbox" style="height: 25px;width: 25px" id="check_gasto_comun" onclick="calcular()" value="check"> Sí </td>
						</tr>
					</table>
					
					<table style="width: 100%">
						<tr style="height: 10px"></tr>
							<td><input type="submit" class="btn-sm" style="background-color: #C8216A;color: #FFFFFF;width: 100%" value="Guardar" onclick="registrar_gasto()"/></td>
							<form action="<?= base_url() .'index.php/menu_principal/menu_reporte'?>" method="post" class="">		
									<td ><input type="submit" id="btn_regresar" name="btn_regresar"class="btn-sm" style="width: 100%;background-color: #C8216A;color: #FFFFFF;" value="Regresar" onclick="regresar()"/></td>
						</form>
						</tr>
						<tr style="height: 10px"></tr>                		
			            <tr>                		
			                <td><input type="submit" id="btn_validar" disabled name="btn_validar"class="btn-sm" style="background-color: #C8216A;color: #FFFFFF;width: 100%;" value="Validar" onclick="validar()"/></td>
			                <td><input type="submit" id="btn_eliminar" disabled name="btn_eliminar"class="btn-sm" style="background-color: #C8216A;color: #FFFFFF;width: 100%;" value="Eliminar" onclick="eliminar()"/></td>
			                		
			                <td><input type="text" style="display: none;" name="id_cab_gasto" id="id_cab_gasto"></td>
			            </tr>
			            <tr style="height: 10px"></tr>  
					</table>
					
					<div class="table-responsive">    
						
		                <table id="tabla_gastos" width="100%" style="font-family:sans-serif; font-size: 13px;">
								<colgroup>
									<col style="width: 10%;">
				       				<col style="width: 30%;">
				       				<col style="width: 30%;">
				       				<col style="width: 10%;">
				       				<col style="width: 40%;">
				       				
				    			</colgroup>
								<thead>
									<tr style="color:#FFFFFF; background-color: #2E86C1;">
										<th>Id</th>
										<th>Nombres</th>
										<th>Descripción</th>
										<th>Valor</th>
										<th>Fecha</th>																			
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