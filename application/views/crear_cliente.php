<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('America/Bogota');
?><!DOCTYPE html>
<html lang="es">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistema de Cobro</title>
    
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

 		function limpiar()
	    {	    		        
	        $('#cedula').val('');
	        $("#nombre").val('');
	        $("#apellido").val('');
	        $("#telefono").val('');
	        $("#celular").val('');
	        $("#direccion").val('');
	        $("#referencia").val('');     
	    }

	    function guardar()
		{
		    var id_antecesor = document.getElementById("antecesor").value;
		    var formData = new FormData(document.getElementById("formuploadsolicitud"));
		            
		            formData.append("cedula",$("#cedula").val());
					formData.append("nombre",$("#nombre").val());
					formData.append("apellido",$("#apellido").val());
					formData.append("telefono",$("#telefono").val());
					formData.append("celular",$("#celular").val());
					formData.append("direccion",$("#direccion").val());
					formData.append("referencia",$("#referencia").val());
					formData.append("id_antecesor",id_antecesor);


					if ($("#cedula").val()!="" || $("#nombre").val()!="" )
					{		
					    /*for (var pair of formData.entries()) 
						{
	    					console.log(pair[0]+ ', ' + pair[1]); 
						}*/

					    $.ajax({
							url:"<?php echo base_url(); ?>index.php/validacion/guardar_cliente",
							type:'POST',						
							data: formData,
							cache: false,
	    					contentType: false,
	    					processData: false,
	    					async:false,
							success:function(result)
							{
								//$("#mens").html(result);
								if (result=="0")
								{
									alert("Error al ingresar el Cliente. No se pudo cargar la foto.");
								}		
								else
								{
									alert("Cliente ingresado correctamente.");
								}

								
								limpiar();
							},
							error:function(result)
							{
								alert("Error. Verifique que el cliente no este registrado. Si el error persiste consulte con el administrador");	
							}					
						});
					}else{				    
						alert("Faltan datos. Verifique.");
					}

		}

		 
	$(document).ready(function(e) {
        
		$("#buscar_t").click(function(){
			
			listar();
		});

		$('#tabla_clientes').on( 'click', 'tr', function () {
	       if ( $(this).hasClass('selected') ) {
	            $(this).removeClass('selected');
	            document.getElementById("btn_abonar").disabled = true;
	            document.getElementById("btn_abonar").style.opacity = "0.5";
	            
	        }
	        else {
	            table.$('tr.selected').removeClass('selected');
	            $(this).addClass('selected');
	            
	            var data = $(this).find("td:eq(0)").text();
	            if (data!="No hay datos disponibles en la tabla") 
	            {
					$("#id_cliente").val(data);
		            document.getElementById("btn_abonar").disabled = false;
		            document.getElementById("btn_abonar").style.opacity = "1";
		           
		        }
	        }
	    } );

    });

    var listar = function()
		{	
	    
					table = $('#tabla_clientes').DataTable();
					table.clear();
					table.destroy();
					table = $('#tabla_clientes').DataTable({
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
							"url":"<?php echo base_url(); ?>index.php/validacion/consulta_allclientes_cobrador"
							
						},

						"columns":[							
							{"data":"id_cliente"},
							{"data":"cedula"},
							{"render":
							function ( data, type, row ) {
						  		return (row["nombre"] + " " + row["apellido"]) ;        				         					
						  	}
							},
							{"data":"celular"}							  											
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
					<strong align="left">Registro de cliente</strong>
				</div>					

				<div class="myform-bottom">
                   	<table width="100%"> 	
						<tr>
							<td> Cédula: </td>
							<td><input type="text" id="cedula" name="cedula" required maxlength="15" onkeypress="return numeros(event)" style="height: 30px;width: 75%;font-size: 12px;border-color:gray;border-width:thin;line-height: 20px" /></td>
						</tr>
						<tr>
							<td> Nombre: </td>
							<td><input type="text" id="nombre" name="nombre" required maxlength="45" onkeypress="return letras(event)" style="height: 30px;width: 100%;font-size: 12px;border-color:gray;border-width:thin;line-height: 20px" /></td>
						</tr>
						<tr>
							<td> Apellido: </td>
							<td><input type="text" id="apellido" name="apellido" required maxlength="45" onkeypress="return letras(event)" style="height: 30px;width: 100%;font-size: 12px;border-color:gray;border-width:thin;line-height: 20px" /></td>
		 				</tr>
						<tr>
							<td> Telf. Casa: </td>
							<td><input type="text" id="telefono" name="telefono" required maxlength="45" style="height: 30px;width: 100%;font-size: 12px;border-color:gray;border-width:thin;line-height: 20px" /></td>
						</tr>
						<tr>
							<td>Telf. Celular: </td>
							<td><input type="text" id="celular" name="celular" required maxlength="45" onkeypress="return numeros(event)" style="height: 30px;width: 100%;font-size: 12px;border-color:gray;border-width:thin;line-height: 20px" /></td>
						</tr>
						<tr>
							<td> Dirección: </td>
							<td><textarea id="direccion" name="direccion" required maxlength="100" style="height: 60px;width: 100%;font-size: 12px;border-color:gray;border-width:thin;line-height: 20px;resize: none;"></textarea></td>
						</tr>
						<tr>
							<td> Referencia: </td>
							<td><textarea id="referencia" name="referencia" required maxlength="100" style="height: 60px;width: 100%;font-size: 12px;border-color:gray;border-width:thin;line-height: 20px;resize: none;"></textarea></td>
						</tr>
						<tr>
							<td>Enrutar Cliente: </td> 
							<td>
								<select name="antecesor" id="antecesor" style="width: 100%;">
							
									<?php 
									foreach($clientes as $fila)
										 {
										 ?>
										 <option value="<?=$fila->id_cliente?>"><?=$fila->nombre?> <?=$fila->apellido?></option>
										 <?php
										 }
										?> 
								</select>
							</td>
						</tr>

					</table>
					
					<form enctype="multipart/form-data" id="formuploadsolicitud">	
						<div>
							<label for="user_file" class="subir"> Subir Foto Cliente </label>
							<input id="user_file" name="user_file" onchange='cambiar()' accept=".jpg, .jpeg, .png" type="file" style='display: none;'/>
							<div id="info"></div>
							  	
						</div>
					</form>
					
					<table width="100%">
						<tr>	 	 	
							 	<td ><input type="submit" class="btn-sm" style="width: 100%;background-color: #C8216A;color: #FFFFFF;" value="Guardar" onclick="guardar()"/></td>
							 	<form action="<?= base_url() .'index.php/menu_principal/inicio'?>" method="post" class="">		
									<td ><input type="submit" id="btn_regresar" name="btn_regresar"class="btn-sm" style="width: 100%;background-color: #C8216A;color: #FFFFFF;" value="Regresar" onclick="regresar()"/></td>
								</form>
						</tr>
						<tr style="height: 30px"></tr>

						<tr>	 	
							<td><input type="submit" id="buscar_t" name="buscar_t"class="btn-sm" style="width: 100%;background-color: #C8216A;color: #FFFFFF;" value="Consultar clientes" /></td>
     						<form action="<?= base_url() .'index.php/validacion/editar_cliente'?>" method="post" class="">
	                	               		
	                			<td style="width: 50%" ><input type="submit" id="btn_abonar" disabled name="btn_abonar"class="btn-sm" style="background-color: #C8216A; opacity: 0.5;color: #FFFFFF;width: 100%;" value="Editar"/></td>
	                			<td><input type="text" name="id_cliente" id="id_cliente" style="display:none;"></td>        		
	                	
                			</form>
     					</tr>
					</table>
					

                
                <div class="table-responsive">    
				<table width="100%">
    	
                	
                	

                </table> 

                    <table id="tabla_clientes" width="100%" style="font-family:sans-serif; font-size: 13px;text-align: center">
						<colgroup>
		       				<col style="width: 20%;">
		       				<col style="width: 20%;">
		       				<col style="width: 40%;">
		       				<col style="width: 20%;">
		       				
		    			</colgroup>
						<thead>
							<tr style="color:#FFFFFF; background-color: #2E86C1;">
								<th>Id</th>
								<th>Cédula</th>
								<th>Nombre</th>
								<th>Teléfono</th>												
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
</body>
</html>