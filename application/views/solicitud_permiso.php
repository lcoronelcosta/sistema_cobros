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
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/custom.css">	
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/jquery.dataTables.min.css">	
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.21.0/moment.min.js"></script>

    <script type="text/javascript">
	    function showContent() {
	        content_dias = document.getElementById("content_dias");
	        content_horas = document.getElementById("content_horas");
	        content_fecha_hora = document.getElementById("content_fecha_hora");
	        check = document.getElementById("dias");
	        if (check.checked) {
	            content_dias.style.display='block';
	            content_horas.style.display='none';
	            content_fecha_hora.style.display='none';
	        }
	        else {
	            content_dias.style.display='none';
	            content_horas.style.display='block';
	            content_fecha_hora.style.display='block';
	        }	
	    }

	    function showDiasHabiles(){
	    	
	    	var fecha1 = moment($("#fecha_d").val());
	    	var fecha2 = moment($("#fecha_h1").val());
			var fecha_diferencia =  fecha2.diff(fecha1, 'days');
			

			if (fecha_diferencia == 0)
			{
				var fecha_tmp = new Date($("#fecha_d").val());				
				if (fecha_tmp.getDay() ==5 || fecha_tmp.getDay() ==6){
					dias_no_habiles.value = 1;
					dias_habiles.value = 0;		
				}
				else{
					dias_no_habiles.value = 0;
					dias_habiles.value = 1;		
				}
				
			}
			else	    
			{	
						
			    days = 0;
			    daysNo = 0;
			    			    
			  	while (!fecha1.isAfter(fecha2)) 
			  	{
			    	// Si no es sabado ni domingo
			    	if (fecha1.isoWeekday() !== 6 && fecha1.isoWeekday() !== 7) {
			      		days++;
			    	}
			    	else
			    	{
			    		daysNo++;
			    	}
			    	fecha1.add(1, 'days');
			  	}

			  	dias_no_habiles.value = daysNo;
			  	dias_habiles.value = days;
			}

	    }

	    function cuenta(){ 
	    	caracteres = document.getElementById("caracteres");
	    	caracteres.value = 500 - document.getElementById("descripcion").value.length;      		
		}

		
		function enviar()
		{
	            var formData = new FormData(document.getElementById("formuploadsolicitud"));
	            
	            formData.append("descripcion",$("#descripcion").val());
				formData.append("empleado","<?php echo $id_empleado?>");
				formData.append("motivo",$("#motivo").val());

				motivo_temporal = $("#motivo").val();
				if (motivo_temporal == "Seleccionar")
				{
					alert("Debe seleccionar cual es el motivo del permiso.");
					return 0;
				}


				//***********************************************************************
				//Obtener la fecha del dia del permiso o por horas según lo seleccionado
				//***********************************************************************
				check = document.getElementById("dias");
				
				if (check.checked)
				{

					if ($("#fecha_d").val() <= $("#fecha_h1").val())
					{
						formData.append("fecha_permiso_inicio",$("#fecha_d").val() + " " + "00:00");
						formData.append("fecha_permiso_fin",$("#fecha_h1").val() + " " + "23:59");
						formData.append("dia_completo",1);

					}
					else
					{
						alert("Verificar las fechas del permiso.");
						return 0;
					}
									
				}
				else{
					if ($("#tiempo_i").val() < $("#tiempo_f").val())
					{

						if (($("#tiempo_f").val().replace(":", ".") - $("#tiempo_i").val().replace(":", ".")) <= 2)
						{
							formData.append("fecha_permiso_inicio",$("#fecha_h").val() + " " + $("#tiempo_i").val());
							formData.append("fecha_permiso_fin",$("#fecha_h").val() + " " + $("#tiempo_f").val());
							formData.append("dia_completo",0);
						}
						else
						{
							alert("Horas de permiso máximo de 2 horas. Favor revisar la hora.");
							return 0;
						}

					}
					else
					{
						alert("Verificar las horas de permiso.");
						return 0;
					}
				}

				if ($("#descripcion").val()!="")
				{		
				    /*for (var pair of formData.entries()) 
					{
    					console.log(pair[0]+ ', ' + pair[1]); 
					}*/

				    $.ajax({
						url:"<?php echo base_url(); ?>index.php/validacion/ingresar_solicitud",
						type:'POST',						
						data: formData,
						cache: false,
    					contentType: false,
    					processData: false,
    					async:false,
						success:function(result)
						{
							//$("#mens").html(result);
							alert("Solicitud ingresada correctamente.");
							limpiar();
						},
						error:function(result)
						{
							alert("Error al ingresar la solicitud. Intente más tarde.");	
						}					
					});
				}else{				    
					alert("No pueden existir campos vacios.");
				}

	    }

	    function limpiar()
	    {
	    	document.getElementById("dias").checked = true;
	    	document.getElementById("content_dias").style.display='block';
	        document.getElementById("content_horas").style.display='none';
	        document.getElementById("content_fecha_hora").style.display='none';	        
	        $('#motivo').val("Seleccionar");
	        $("#descripcion").val('');
	        document.getElementById("user_file").value="";   
	        document.getElementById("caracteres").value = 500;     
	    } 

	    window.onload=showDiasHabiles();
	
	</script>

</head>

<body>  
<br>
	<div style="padding-left: 25px">
	<fieldset>
	<legend><strong>Formulario de Solicitud de Permiso</strong></legend>	
		<table> 	
			<tr>
			 	<td> Fecha de Solicitud: </td>
			 	<td><input type="text" id="fecha_solicitud" name="fecha_solicitud" value="<?php echo date("d/m/Y")?>"  readonly style="height: 30px;width: 200px;font-size: 13px;border-color:gray;border-width:thin;" /></td>
			 </tr>
			 <tr>
			 	<td> Solicitante: </td>
			 	<td><input type="text" id="solicitante" name="solicitante" value="<?php echo $nombre?> <?php echo $apellido?>"  readonly style="height: 30px;width: 200px;font-size: 13px;border-color:gray;border-width:thin;" /></td>
			 </tr>
			 <tr>
			 	<td>Tipo de Contrato: </td>
				<td><input type="text" id="tipo_contrato" name="tipo_contrato" value="<?php echo $tipo_contrato?>" readonly style="height: 30px;width: 200px;font-size: 13px;border-color:gray;border-width:thin;" /></td>
			 </tr>
			 <tr>
			 	<td>Motivo del Permiso: </td>
			 	<td><select id="motivo" name="motivo" style="height: 30px;width: 200px;font-size: 13px;">
			 		  <option value="Seleccionar">Seleccionar</option>
					  <option value="Enfermedad">Enfermedad</option>
					  <option value="Calamidad Doméstica">Calamidad Doméstica</option>
					  <option value="Emergencia">Emergencia</option>
					  <option value="Cita Medica">Cita Médica</option>
					  <option value="Estudios">Estudios</option>
					  <option value="Conferencias">Conferencias</option>					  					  
					</select>
				</td>
			 </tr>
			 <tr>
			 	<td style="height: 10px"></td>
			 </tr>
		</table>

		<table>
			 <tr>
			 	<td>
			 		<input type="radio" name="dias_horas" value="dias" id="dias" checked="checked" onchange="javascript:showContent()"> Permiso por días completo<br>  			
			 	</td>
			 </tr>	 
			 <tr id="content_dias" style="display: block;">	 	 

				 	<td>
				 		Desde: <input type="date" name="fecha_d" id="fecha_d" onchange="javascript:showDiasHabiles()" value="<?php echo date("Y-m-d")?>" style="height: 30px;width: 130px;font-size: 13px;">			 		
				 	</td>	 
				 	<td>
				 		Hasta: <input type="date" name="fecha_h1" id="fecha_h1" onchange="javascript:showDiasHabiles()" value="<?php echo date("Y-m-d")?>" style="height: 30px;width: 130px;font-size: 13px;">			 		
				 	</td>		 	
				 	<td>
				 		Dias Hábiles: <input type="text" name="dias_habiles" id="dias_habiles" readonly value="5" style="height: 30px;width: 30px;font-size: 13px;">			 		
				 	</td>
				 	<td>
				 		Dias No Hábiles: <input type="text" name="dias_no_habiles" id="dias_no_habiles" readonly value="7" style="height: 30px;width: 30px;font-size: 13px;">			 		
				 	</td>
			</tr>
		</table>

		<table>
			<tr>
			 	<td>	 		
		  			<input type="radio" name="dias_horas" value="horas" id="horas" onchange="javascript:showContent()"> Permiso por horas<br>  			 
			 	</td>
			</tr>
			<tr id="content_fecha_hora" style="display: none;">	 	 	
			 	<td>
			 		Día del permiso: <input type="date" name="fecha_h" id="fecha_h" value="<?php echo date("Y-m-d")?>" style="height: 30px;width: 120px;font-size: 13px;">	 		
			 	</td>	 	
			 </tr>
			 </tr>
			 <tr>
			 	<td style="height: 10px"></td>
			 </tr>
			 <tr id="content_horas" style="display: none;">	 		 	
			 	<td>
			 		Hora Inicio: <input type="time" name="tiempo_i" id="tiempo_i" value="<?php echo date("H:i")?>" style="height: 30px;width: 80px;font-size: 13px;">
			 		Hora Fin: <input type="time" name="tiempo_f" id="tiempo_f" value="<?php echo date("H:i")?>" style="height: 30px;width: 80px;font-size: 13px;">	 
			 	</td>	 	
			 </tr>
			 <tr>
			 	<td style="height: 10px"></td>
			 </tr>
		</table> 
		
		Descripción: Máximo <input type="text" name="caracteres" id="caracteres" readonly value="500" style="height: 20px;width: 30px;font-size: 10px;"> caracteres
		<table>
			 <tr>
			 	
			 	<td><textarea name="descripcion" id="descripcion" required maxlength="500" onKeyDown="javascript:cuenta()" onKeyUp="javascript:cuenta()" style="border-color:gray;border-width:thin;line-height: 20px;width:600px;height:170px;font-size: 13px;resize: none;"></textarea></td>	 		
			 </tr>
		</table>
	<form enctype="multipart/form-data" id="formuploadsolicitud">	
		<div>
		    <label for="profile_pic">Escoja el archivo a cargar: ( JPG|PNG Máximo 2 Mb ) </label>
		    <input type="file" id="user_file" name="user_file" accept=".jpg, .jpeg, .png">
		</div>
	</form>
		<table>
			 <tr>
			 <br>	 	
			 	<td><input type="submit" class="btn-sm" style="background-color: #C8216A;color: #FFFFFF;width: 150px" value="Enviar solicitud" onclick="enviar()"/></td>
			 </tr>
		</table>
	
	</fieldset>
	</div>
	<div id="mens"></div>

<script src="<?php echo base_url(); ?>tether/js/tether.min.js"></script>
<script src="<?php echo base_url(); ?>js/jquery.js"></script>
<script src="<?php echo base_url(); ?>js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.dataTables.min.js"></script>

</body>
</html>
