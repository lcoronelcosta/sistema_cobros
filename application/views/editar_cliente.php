<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('America/Bogota');
?><!DOCTYPE html>
<html lang="es">
<head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistema de Cobro</title>
    
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap.min.css">    
    <link rel="stylesheet" href="<?php echo base_url(); ?>font-awesome/css/font-awesome.min.css"> <!--Iconos-->   
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,300,400,500" rel="stylesheet">  
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/custom.css">  
    <script src="<?php echo base_url(); ?>js/jquery.js"></script>	

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

		$(document).ready(function(e) {
	    	document.getElementById("<?php echo $cliente['antecesor']?>").selected = true;
	    })

	    function editar()
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


					if ($("#cedula").val()!="" && $("#nombre").val()!="" )
					{		
					    
					    $.ajax({
							url:"<?php echo base_url(); ?>index.php/validacion/actualizar_cliente",
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
									alert("Error al modificar el Cliente. No se pudo cargar la foto.");
								}		
								else
								{
									alert("Cliente modificado correctamente.");
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
	</script>

</head>

<body  class="body_alterno">
	<div class="container">
		<div class="row">
			<div class="col-md-6 offset-md-3 myform-cont" >				
				<div class="myform-top">
					<strong align="left">Actualización de cliente</strong>
				</div>					
				<div class="myform-bottom">
					<div id="mostrar_foto" style="text-align:center;display: block;">			
					</div>
					<script type="text/javascript">
						var archivo_tmp = "<?php echo $cliente['ruta_foto']?>";
						var path_tmp = "<?php echo base_url(); ?>";
						var path_tmp= path_tmp.concat('files/');
						var path_tmp= path_tmp.concat(archivo_tmp);
													
						document.getElementById('mostrar_foto').innerHTML = "<img src='"+path_tmp+"' width='95%'/>";
					</script>
                   	<table width="100%"> 	
						<tr>
							<td> Cedula: </td>
							<td><input type="text" id="cedula" value="<?php echo $cliente['cedula']?>" name="cedula" required maxlength="15" onkeypress="return numeros(event)" style="height: 30px;width: 75%;font-size: 12px;border-color:gray;border-width:thin;line-height: 20px" /></td>
						</tr>
						<tr>
							<td> Nombre: </td>
							<td><input type="text" id="nombre" name="nombre" value="<?php echo $cliente['nombre']?>" required maxlength="45" onkeypress="return letras(event)" style="height: 30px;width: 100%;font-size: 12px;border-color:gray;border-width:thin;line-height: 20px" /></td>
						</tr>
						<tr>
							<td> Apellido: </td>
							<td><input type="text" id="apellido" name="apellido" value="<?php echo $cliente['apellido']?>" required maxlength="45" onkeypress="return letras(event)" style="height: 30px;width: 100%;font-size: 12px;border-color:gray;border-width:thin;line-height: 20px" /></td>
		 				</tr>
						<tr>
							<td> Telf. Casa: </td>
							<td><input type="text" id="telefono" name="telefono" value="<?php echo $cliente['telefono']?>" required maxlength="45" style="height: 30px;width: 100%;font-size: 12px;border-color:gray;border-width:thin;line-height: 20px" /></td>
						</tr>
						<tr>
							<td>Telf. Celular: </td>
							<td><input type="text" id="celular" name="celular" value="<?php echo $cliente['celular']?>" required maxlength="45" onkeypress="return numeros(event)" style="height: 30px;width: 100%;font-size: 12px;border-color:gray;border-width:thin;line-height: 20px" /></td>
						</tr>
						<tr>
							<td> Direccion: </td>
							<td><input type="text" id="direccion" name="direccion" value="<?php echo $cliente['direccion']?>" required maxlength="100" style="height: 30px;width: 100%;font-size: 12px;border-color:gray;border-width:thin;line-height: 20px" />
							</td>
						</tr>
						<tr>
							<td> Referencia: </td>
							<td><input type="text" id="referencia" name="referencia" value="<?php echo $cliente['referencia']?>" required maxlength="100" style="height: 30px;width: 100%;font-size: 12px;border-color:gray;border-width:thin;line-height: 20px" />
							</td>
						</tr>
						<tr>
							<td>Enrutar Cliente: </td> 
							<td>
								<select  style="width: 100%" name="antecesor" id="antecesor">
							
									<?php 
									foreach($listado['clientes'] as $fila)
										 {
										 ?>
										 <option id="<?=$fila->id_cliente?>" value="<?=$fila->id_cliente?>"><?=$fila->nombre?> <?=$fila->apellido?></option>
										 <?php
										 }
										?> 
								</select>
								<script type="text/javascript">

								</script>
							</td>
							<td style="height: 50px"></td>
						</tr>

					</table>
					
					<form enctype="multipart/form-data" id="formuploadsolicitud">	
						<div>
							<label for="user_file" class="subir"> Cambiar Foto Cliente </label>
							<input id="user_file" name="user_file" onchange='cambiar()' accept=".jpg, .jpeg, .png" type="file" style='display: none;'/>
							<div id="info"></div>
							  	
						</div>
					</form>
					<table width="100%">
							<tr>
								<td style="height: 50px"></td>
								<td><input type="submit" class="btn-sm" style="background-color: #C8216A;color: #FFFFFF;width: 95%" value="Guardar cambios" onclick="editar()"/></td>
								<form action="<?= base_url() .'index.php/menu_principal/crear_cliente'?>" method="post" class="">		
									<td style="width: 50%"><input type="submit" id="btn_regresar" name="btn_regresar"class="btn-sm" style="background-color: #C8216A;color: #FFFFFF;width: 95%;" value="Regresar" onclick="regresar()"/></td>
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
</body>
</html>