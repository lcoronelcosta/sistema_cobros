<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('America/Bogota');
?><!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
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
	        //$("#comision").val(''); 
	        //$("#estado").val('');    
	        $("#user").val(''); 
	        $("#clave").val('');    
	        document.getElementById('info').innerHTML = ""; 
	    }


		function editar_cobrador()
			{
		            var formData = new FormData(document.getElementById("formuploadsolicitud"));
		            
		            formData.append("id_usuario",$("#id_usuario").val());
		            formData.append("cedula",$("#cedula").val());
					formData.append("nombre",$("#nombre").val());
					formData.append("apellido",$("#apellido").val());
					formData.append("telefono",$("#telefono").val());
					formData.append("celular",$("#celular").val());
					formData.append("direccion",$("#direccion").val());
					formData.append("referencia",$("#referencia").val());	
					formData.append("comision",$("#comision").val());
					//formData.append("estado",$("#estado").val());
					formData.append("user",$("#user").val());
					formData.append("clave",$("#clave").val());					

					if ($("#cedula").val()!="" || $("#nombre").val()!="" || $("#comision").val()!="" || $("#user").val()!="" || $("#clave").val()!="" )
					{		
					    /*for (var pair of formData.entries()) 
						{
	    					console.log(pair[0]+ ', ' + pair[1]); 
						}*/

					    $.ajax({
							url:"<?php echo base_url(); ?>index.php/validacion/actualizar_cobrador",
							type:'POST',						
							data: formData,
							cache: false,
	    					contentType: false,
	    					processData: false,
	    					async:false,
							success:function(result)
							{
								
								if (result=="0")
								{
									alert("Error al actualizar el Cobrador. No se pudo cargar la foto.");
								}		
								else
								{
									alert("Cobrador actualizado correctamente.");
								}
								limpiar();

							},
							error:function(result)
							{
								alert("Error. Verifique que el cobrador no este registrado. Si el error persiste consulte con el administrador");	
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
					<strong align="left">Actualización de cobrador</strong>
				</div>					

				<div class="myform-bottom">
                   	<div id="mostrar_foto" style="text-align:center;display: block;">			
					</div>
					<script type="text/javascript">
						var archivo_tmp = "<?php echo $ruta_foto?>";
						var path_tmp = "<?php echo base_url(); ?>";
						var path_tmp= path_tmp.concat('files/');
						var path_tmp= path_tmp.concat(archivo_tmp);
													
						document.getElementById('mostrar_foto').innerHTML = "<img src='"+path_tmp+"' width='95%'/>";
					</script>
                   	<table width="100%"> 	
						<tr>
							<td> Cédula: </td>
							<td><input type="text" id="cedula" name="cedula" value="<?php echo $cedula?>" required maxlength="15" onkeypress="return numeros(event)" style="height: 30px;width: 75%;font-size: 12px;border-color:gray;border-width:thin;line-height: 20px" /></td>
							<td><input type="text" name="id_usuario" id="id_usuario" value="<?php echo $id_usuario?>" style="display:none;"></td> 
						</tr>
						<tr>
							<td> Nombre: </td>
							<td><input type="text" id="nombre" name="nombre" value="<?php echo $nombre?>"required maxlength="45" onkeypress="return letras(event)" style="height: 30px;width: 100%;font-size: 12px;border-color:gray;border-width:thin;line-height: 20px" /></td>
						</tr>
						<tr>
							<td> Apellido: </td>
							<td><input type="text" id="apellido" name="apellido" value="<?php echo $apellido?>"required maxlength="45" onkeypress="return letras(event)" style="height: 30px;width: 100%;font-size: 12px;border-color:gray;border-width:thin;line-height: 20px" /></td>
		 				</tr>
						<tr>
							<td> Telf. Casa: </td>
							<td><input type="text" id="telefono" name="telefono" value="<?php echo $telefono?>"required maxlength="10" onkeypress="return numeros(event)" style="height: 30px;width: 100%;font-size: 12px;border-color:gray;border-width:thin;line-height: 20px" /></td>
						</tr>
						<tr>
							<td>Telf. Celular: </td>
							<td><input type="text" id="celular" name="celular" value="<?php echo $celular?>"required maxlength="10" onkeypress="return numeros(event)" style="height: 30px;width: 100%;font-size: 12px;border-color:gray;border-width:thin;line-height: 20px" /></td>
						</tr>
						<tr>
							<td> Dirección: </td>
							<td><textarea id="direccion" name="direccion" required maxlength="100" style="height: 60px;width: 100%;font-size: 12px;border-color:gray;border-width:thin;line-height: 20px;resize: none;"></textarea></td>
						</tr>
						<tr>
							<td> Referencia: </td>
							<td><textarea id="referencia" name="referencia" value="<?php echo $referencia?>"required maxlength="100" style="height: 60px;width: 100%;font-size: 12px;border-color:gray;border-width:thin;line-height: 20px;resize: none;"></textarea></td>
						</tr>
						<script type="text/javascript">								
								$('#direccion').val("<?php echo $direccion?>");	
								$('#referencia').val("<?php echo $referencia?>");	
						</script>
						<tr>
							<td>Comisión: </td>
							<td><input type="text" id="comision" name="comision" value="<?php echo $comision?>" required maxlength="10" onkeypress="return numeros(event)" align="right" style="height: 30px;width: 30%;font-size: 14px;text-align:center; border-color:gray;border-width:thin;line-height: 20px" />%</td>
						</tr>
						<tr>
							<td> Usuario: </td>
							<td><input type="text" id="user" name="user" value="<?php echo $user?>" required maxlength="10" style="height: 30px;width: 100%;font-size: 12px;border-color:gray;border-width:thin;line-height: 20px" /></td>
						</tr>
						<tr>
							<td> Clave: </td>
							<td><input type="text" id="clave" name="clave" value="<?php echo $clave?>"required maxlength="10"  style="height: 30px;width: 100%;font-size: 12px;border-color:gray;border-width:thin;line-height: 20px" /></td>
		 				</tr>
					</table>
					<br>
					<form enctype="multipart/form-data" id="formuploadsolicitud">	
						<div>
							<label for="user_file" class="subir"> Cambiar Foto Cobrador </label>
							<input id="user_file" name="user_file" onchange='cambiar()' accept=".jpg, .jpeg, .png" type="file" style='display: none;'/>
							<div id="info"></div>
							  	
						</div>
					</form>
					<table width="100%">
							<tr>
								<td><input type="submit" class="btn-sm" style="background-color: #C8216A;color: #FFFFFF;width: 95%" value="Guardar cambios" onclick="editar_cobrador()"/></td>
								<form action="<?= base_url() .'index.php/menu_principal/crear_cobrador'?>" method="post" class="">		
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
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/dataTables.select.min.js"></script>
</body>
</html>