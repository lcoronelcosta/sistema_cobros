<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('America/Bogota');
?><!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Historial de Permisos Solicitados</title>
	
	<link rel="stylesheet" href="<?php echo base_url(); ?>font-awesome/css/font-awesome.min.css"> <!--Iconos--> 
	<link href="https://fonts.googleapis.com/css?family=Raleway:100,300,400,500" rel="stylesheet">  
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap.min.css"> 
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/custom.css">	
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/jquery.dataTables.min.css">	

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.21.0/moment.min.js"></script>
</head>

<body>  
<br>
<div style="padding-left: 25px">	
	<legend><h3><b>Historial de Solicitudes de Permisos</b></h3></legend>	
</div>
<br>
<div class="container">
    <div class="row">  
		<div class="col-md-12">
			<table id="historial_solicitud_permiso" class="order-column table-hover" width="100%" style="font-family:sans-serif; font-size: 13px;">
				<colgroup>
       				<col>
       				<col>
       				<col>
       				<col style="width: 18%;">
       				<col style="width: 12%;"> 
       				<col style="width: 15%;">
    			</colgroup>
				<thead>
					<tr style="color:#FFFFFF; background-color: #2E86C1;">
						<th># Solicitud</th>
						<th>Fecha de Solicitud</th>
						<th>Fecha del Permiso</th>						
						<th>Categoría del Permiso</th>						
						<th>Estado</th>
						<th></th>						
					</tr>
				</thead>
			</table>
		</div>
	</div>
</div>

<!-- Ventana Modal para Editar Solicitud-->

<div class="modal fade" id="modalEditarSolicitud" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
  	<!-- Modal Content-->
    <div class="modal-content"> 
      <div class="modal-header" style="background-color: #2E86C1; color:#FFFFFF">        
        <h3 class="modal-title">Editar Solicitud</h3>        
       
      </div>

      <div class="modal-body" style="background-color: #F7F9F9;">
	     <table> 	
			 <tr>
			 	<td> Número de Solicitud: </td>			 	
			 	<td><input type="text" name="id_num_solicitud" id="id_num_solicitud" readonly style="border-color:gray;border-width:thin;height: 30px;width: 200px;font-size: 13px;" /></td>			 	
			 </tr>
			 <tr>
			 	<td> Fecha de Solicitud: </td>			 	
			 	<td><input type="text" name="fecha_solicitud" id="fecha_solicitud" readonly style="border-color:gray;border-width:thin;height: 30px;width: 200px;font-size: 13px;" /></td>			 	
			 </tr>
			 <tr>
			 	<td> Solicitante: </td>			 	
			 	<td><input type="text" name="solicitante" id="solicitante" value="<?php echo $nombre?> <?php echo $apellido?>" readonly style="border-color:gray;border-width:thin;height: 30px;width: 200px;font-size: 13px;" /></td>			 	
			 </tr>
			 <tr>
			 	<td>Tipo de Contrato: </td>
				<td><input type="text" name="tipo_contrato" name="tipo_contrato" value="<?php echo $tipo_contrato?>" readonly style="border-color:gray;border-width:thin;height: 30px;width: 200px;font-size: 13px;" /></td>
			 </tr>
			 <tr>
			 	<td>Motivo del Permiso: </td>
			 	<td><select id="m_motivo" name="m_motivo" style="height: 30px;width: 200px;font-size: 13px;">
					  <option id="Enfermedad" value="Enfermedad">Enfermedad</option>
					  <option id="Calamidad Doméstica" value="Calamidad Doméstica">Calamidad Doméstica</option>
					  <option id="Emergencia" value="Emergencia">Emergencia</option>
					  <option id="Cita Medica" value="Cita Medica">Cita Médica</option>
					  <option id="Estudios" value="Estudios">Estudios</option>
					  <option id="Conferencias" value="Conferencias">Conferencias</option>					  	
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
		 		<input type="radio" name="dias_horas" value="dias" id="dias" checked="checked" onchange="javascript:showContent()"> Permiso por día completo<br>  			
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
		<!--Muestra los archivos adjuntos -->
		<div id="archivo_cargado" style="display: none;">
			Archivo adjuntado:<br>
			<label id="nombre_archivo"></label>
			<a href="#" class="delete_file_link">Eliminar</a><br>                           
			<a id="view_imagen" href="#" class="view_file_link">Ver imagen</a>
			<a id="ocultar_imagen" href="#" class="ocultar_file_link" style="display: none">Ocultar</a>

		</div>

		<div id="mostrar_imagen" style="display: none;">			

		</div>

		<form enctype="multipart/form-data" id="formuploadsolicitud">
			<div id="archivo_nuevo" style="display: block;"">
		    	Escoja el archivo a cargar: ( JPG|PNG Máximo 2 Mb )
		    	<input type="file" id="user_file" name="user_file" accept=".jpg, .jpeg, .png">
			</div>
		</form>

      </div>

      <div class="modal-footer">
        <button type="button" id="mbtnCerrarModal" data-dismiss="modal" style="background-color: #C8216A;color: #FFFFFF;width: 150px;font-size: 14px">Cancelar</button>
        <input type="submit" style="background-color: #2E86C1;color: #FFFFFF;width: 150px;font-size: 14px" value="Actualizar Solicitud" id="actualizarSolicitud"  onclick="actualizar_solicitud()"/>
      </div>
    </div>
  </div>
</div>


<!-- Ventana Modal para Editar Solicitud-->

<div class="modal fade" id="modalConsultarSolicitud" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
  	<!-- Modal Content-->
    <div class="modal-content"> 
      <div class="modal-header" style="background-color: #2E86C1; color:#FFFFFF">        
        <h3 class="modal-title">Consulta de Solicitud</h3>        
       
      </div>

      <div class="modal-body" style="background-color: #F7F9F9;">
	     <table> 	
			 <tr>
			 	<td> Número de Solicitud: </td>			 	
			 	<td><input type="text" name="id_num_solicitud_1" id="id_num_solicitud_1" readonly style="border-color:gray;border-width:thin;height: 30px;width: 200px;font-size: 13px;" /></td>			 	
			 </tr>
			 <tr>
			 	<td> Fecha de Solicitud: </td>			 	
			 	<td><input type="text" name="fecha_solicitud_1" id="fecha_solicitud_1" readonly style="border-color:gray;border-width:thin;height: 30px;width: 200px;font-size: 13px;" /></td>			 	
			 </tr>
			 <tr>
			 	<td> Solicitante: </td>			 	
			 	<td><input type="text" name="solicitante" id="solicitante" value="<?php echo $nombre?> <?php echo $apellido?>" readonly style="border-color:gray;border-width:thin;height: 30px;width: 200px;font-size: 13px;" /></td>			 	
			 </tr>
			 <tr>
			 	<td>Tipo de Contrato: </td>
				<td><input type="text" name="tipo_contrato" name="tipo_contrato" value="<?php echo $tipo_contrato?>" readonly style="border-color:gray;border-width:thin;height: 30px;width: 200px;font-size: 13px;" /></td>
			 </tr>
			 <tr>
			 	<td>Motivo del Permiso: </td>
			 	<td><select id="m_motivo" name="m_motivo" disabled style="height: 30px;width: 200px;font-size: 13px;">
					  <option id="Enfermedad 1" value="Enfermedad">Enfermedad</option>
					  <option id="Calamidad Doméstica 1" value="Calamidad Doméstica">Calamidad Doméstica</option>
					  <option id="Emergencia 1" value="Emergencia">Emergencia</option>
					  <option id="Cita Medica 1" value="Cita Medica">Cita Médica</option>
					  <option id="Estudios 1" value="Estudios">Estudios</option>
					  <option id="Conferencias 1" value="Conferencias">Conferencias</option>					  	
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
		 		<input type="radio" name="dias_horas" value="dias" id="dias_1" checked="checked" disabled onchange="javascript:showContent()"> Permiso por día completo<br>  			
		 		</td>
			</tr>	 
			<tr id="content_dias_1" style="display: block;">	 	 
			 	<td>
			 		Desde: <input type="date" name="fecha_d1" id="fecha_d1" readonly onchange="javascript:showDiasHabiles1()" value="<?php echo date("Y-m-d")?>" style="height: 30px;width: 130px;font-size: 13px;">			 		
			 	</td>
			 	<td>
				 	Hasta: <input type="date" name="fecha_h11" id="fecha_h11" readonly onchange="javascript:showDiasHabiles1()" value="<?php echo date("Y-m-d")?>" style="height: 30px;width: 130px;font-size: 13px;">			 		
				 </td>		 	
				 <td>
				 	Dias Hábiles: <input type="text" name="dias_habiles1" id="dias_habiles1" readonly value="5" style="height: 30px;width: 30px;font-size: 13px;">
				 </td>
				 <td>
				 	Dias No Hábiles: <input type="text" name="dias_no_habiles1" id="dias_no_habiles1" readonly value="7" style="height: 30px;width: 30px;font-size: 13px;">			 		
				 </td>

			</tr>
		</table>

		<table>
			<tr>
			 	<td>	 		
		  		<input type="radio" name="dias_horas" value="horas" id="horas_1" disabled onchange="javascript:showContent()"> Permiso por horas<br>  	 
			 	</td>
			</tr>
			<tr id="content_fecha_hora_1" style="display: none;">	 	 	
			 	<td>
			 	Día del permiso: <input type="date" name="fecha_h" id="fecha_h_1" readonly value="<?php echo date("Y-m-d")?>" style="height: 30px;width: 120px;font-size: 13px;">	 		
			 	</td>	 	
			</tr>			
			<tr>
			 	<td style="height: 10px"></td>
			</tr>
			<tr id="content_horas_1" style="display: none;">	 		 	
			 	<td>
			 	Hora Inicio: <input type="time" name="tiempo_i" id="tiempo_i_1" readonly value="<?php echo date("H:i")?>" style="height: 30px;width: 80px;font-size: 13px;">
			 	Hora Fin: <input type="time" name="tiempo_f" id="tiempo_f_1" readonly value="<?php echo date("H:i")?>" style="height: 30px;width: 80px;font-size: 13px;">	 
			 	</td>	 	
			</tr>
			<tr>
			 	<td style="height: 10px"></td>
			</tr>
		</table> 
		
		Descripción: Máximo <input type="text" name="caracteres1" id="caracteres1" readonly value="500" style="height: 20px;width: 30px;font-size: 10px;"> caracteres
		<table>
			<tr>
			 	
			 	<td><textarea name="descripcion_1" id="descripcion_1" required readonly maxlength="500" onKeyDown="javascript:cuenta()" onKeyUp="javascript:cuenta()" style="border-color:gray;border-width:thin;line-height: 20px;width:600px;height:170px;font-size: 13px;resize: none;"></textarea></td>	 		
			</tr>
		</table>
		<!--Muestra los archivos adjuntos -->
		<div id="archivo_cargado_1" style="display: none;">
			Archivo adjuntado:<br>
			<label id="nombre_archivo_1"></label>			                          
			<a id="view_imagen_1" href="#" class="view_file_link_1">Ver imagen</a>
			<a id="ocultar_imagen_1" href="#" class="ocultar_file_link_1" style="display: none">Ocultar</a>

		</div>

		<div id="mostrar_imagen_1" style="display: none;">			

		</div>

		<form enctype="multipart/form-data" id="formuploadsolicitud">
			<div id="archivo_nuevo_1" style="display: block;"">

			</div>
		</form>
		<br>
		<div id="datos_aprobacion" style="display: none;">
			<legend><h3>Resolución de Aprobación</h3></legend>
			<table>
				<tr>
					<td><b>Número de Resolución:</b></td>
					<td><label id="numero_a"></label></td>
				</tr>
				<tr>					
					<td><b>Estado de Solicitud:</b></td>
					<td><label id="estado_a"></label></td>
				</tr>
				<tr>
					<td><b>Gestionado por:</b></td>
					<td><label id="gestionado_a"></label></td>
				</tr>
				<tr>
					<td><b>Fecha de Resolución:</b></td>
					<td><label id="fecha_a"></label></td>
				</tr>
			</table>
		</div>

      </div>

      <div class="modal-footer">
        <button type="button" id="mbtnCerrarModal" data-dismiss="modal" style="background-color: #C8216A;color: #FFFFFF;width: 150px;font-size: 14px">Cerrar</button>        
      </div>
    </div>
  </div>
</div>

<div id="mens"></div>
<script src="<?php echo base_url(); ?>tether/js/tether.min.js"></script>
<script src="<?php echo base_url(); ?>js/jquery.js"></script>
<script src="<?php echo base_url(); ?>js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.dataTables.min.js"></script>

<script type="text/javascript">
		var xhrCount = 0; //Bandera de eliminación de registros
		var archivo_tmp; //nombre de archivo temporal en caso de eliminar
		var elimino_archivo=0;
		var table; //DataTable global para poder actualizar los datos sin Listar de nuevo	

		function cuenta(){ 
	    	caracteres = document.getElementById("caracteres1");
	    	document.getElementById("caracteres1").value = 500 - document.getElementById("descripcion_1").value.length;      		

	    	console.log(500 - document.getElementById("descripcion_1").value.length);
		}	

		function showDiasHabiles(){
	    	
	    	var fecha1 = moment($("#fecha_d").val());
	    	var fecha2 = moment($("#fecha_h1").val());
			var fecha_diferencia =  fecha2.diff(fecha1, 'days');
						

			if (fecha_diferencia == 0)
			{
				var fecha_tmp = new Date($("#fecha_d").val());				
				if (fecha_tmp.getDay() ==5 || fecha_tmp.getDay() ==6){
					document.getElementById("dias_no_habiles").value =1;					
					document.getElementById("dias_habiles").value =0;
						
				}
				else{					
					document.getElementById("dias_no_habiles").value =0;					
					document.getElementById("dias_habiles").value =1;		
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

			  	document.getElementById("dias_no_habiles").value = daysNo;					
				document.getElementById("dias_habiles").value = days;
							  	
			}

	    }

	    function showDiasHabiles1(){
	    	
	    	var fecha1 = moment($("#fecha_d1").val());
	    	var fecha2 = moment($("#fecha_h11").val());
			var fecha_diferencia =  fecha2.diff(fecha1, 'days');
						

			if (fecha_diferencia == 0)
			{
				var fecha_tmp = new Date($("#fecha_d1").val());				
				if (fecha_tmp.getDay() ==5 || fecha_tmp.getDay() ==6){

					document.getElementById("dias_no_habiles1").value =1;					
					document.getElementById("dias_habiles1").value =0;
						
				}
				else{					

					document.getElementById("dias_no_habiles1").value =0;					
					document.getElementById("dias_habiles1").value =1;	
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

				document.getElementById("dias_no_habiles1").value = daysNo;					
				document.getElementById("dias_habiles1").value = days;
			  	
			}

	    }

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

	    function showContent1() {
	        content_dias = document.getElementById("content_dias_1");
	        content_horas = document.getElementById("content_horas_1");
	        content_fecha_hora = document.getElementById("content_fecha_hora_1");
	        check = document.getElementById("dias_1");
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


		$(document).ready(function(e) {
            xhrCount = 0;
            listar();
        });

		
		var listar = function(){
								
				table = $('#historial_solicitud_permiso').DataTable();
				table.destroy();
				
				table = $('#historial_solicitud_permiso').DataTable({
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
						"url":"<?php echo base_url(); ?>index.php/validacion/consulta"						
					},

					"columns":[
						{"data":"id_num_solicitud"},
						{"data":"fecha_solicitud"},						
						{"render":
						  function ( data, type, row ) {
						  	if (row["dia_completo"] == 1)
						  	{
						     	//*******************************************
						     	//Formato adecuado para presentar YYYY-MM-DD
						     	//*******************************************
						     	var date = new Date(row["fecha_permiso_inicio"]);
        						var month = date.getMonth() + 1;
								var dia_tmp = date.getDate();

								var date1 = new Date(row["fecha_permiso_fin"]);
        						var month1 = date1.getMonth() + 1;
								var dia_tmp1 = date1.getDate();

        						return (date.getFullYear() + "-" + (month > 9 ? month : "0" + month) + "-" + (dia_tmp > 9 ? dia_tmp : "0" + dia_tmp) + " / " + date1.getFullYear() + "-" + (month1 > 9 ? month1 : "0" + month1) + "-" + (dia_tmp1 > 9 ? dia_tmp1 : "0" + dia_tmp1));
 
						  	}
						  	else
						  	{
						  		//*******************************************
						  		//Formato adecuado para presentar YYYY-MM-DD
						  		//*******************************************
						     	var date = new Date(row["fecha_permiso_inicio"]);
        						var month = date.getMonth() + 1;
        						var dia_tmp = date.getDate();

        						var fecha = (date.getFullYear() + "-" + (month > 9 ? month : "0" + month) + "-" + (dia_tmp > 9 ? dia_tmp : "0" + dia_tmp));
        						//***************************
        						//Obtengo la hora de inicio	
        						//***************************
        						var hora_inicio = date.getHours();
        						var minuto_inicio = date.getMinutes();

        						var tiempo_inicio = (hora_inicio > 9 ? hora_inicio : "0" + hora_inicio) + ":" + (minuto_inicio > 9 ? minuto_inicio : "0" + minuto_inicio);
        						//***************************
        						//Obtengo la hora final	
        						//***************************
        						var date = new Date(row["fecha_permiso_fin"]);
        						var hora_final = date.getHours();
        						var minuto_final = date.getMinutes();

        						var tiempo_final = (hora_final > 9 ? hora_final : "0" + hora_final) + ":" + (minuto_final > 9 ? minuto_final : "0" + minuto_final);

        						return (fecha + " ( " + tiempo_inicio + " - " + tiempo_final + " ) ");	
         					
						  	}
						  }						  	
						}, 
						{"data":"motivo"},
						{"data":"estado"},
						{"render":
							function( data, type, row ){

								//**************************************************************
								//Se generan los botones dependiendo del estado de la solicitud
								//**************************************************************
								if (row["estado"] == 'Pendiente')
								{									
									return "<button type='button' class=' editar btn btn-warning btn-xs' data-toggle='modal' data-target='#modalEditarSolicitud'><span class='glyphicon glyphicon-pencil'></span> </button> <button type='button' class='eliminar btn btn-danger btn-xs'><span class='glyphicon glyphicon-remove'></span> </button> <button type='button' class='consultar btn btn-info btn-xs' data-toggle='modal' data-target='#modalConsultarSolicitud'><span class='glyphicon glyphicon-search'></span> </button>";
								}
								else
								{									
									return "<button type='button' class='consultar btn btn-info btn-xs' data-toggle='modal' data-target='#modalConsultarSolicitud'><span class='glyphicon glyphicon-search'></span> </button>";
								}
							}
						},				
					]
				});				

						
						

				obtener_data_editar("#historial_solicitud_permiso tbody", table);
				eliminar_data("#historial_solicitud_permiso tbody", table);		
				consultar_data("#historial_solicitud_permiso tbody", table);	
		}
		

		$('.delete_file_link').on('click', function(e) {
			e.preventDefault();
			if (confirm('¿Está seguro de eliminar el archivo?'))			
			{
				//***************************************************************
				//archivo_tmp ya contiene el nombre del archivo que ha eliminado
				//***************************************************************
				document.getElementById("archivo_cargado").style.display = 'none';				
				document.getElementById("archivo_nuevo").style.display = 'block';
				document.getElementById('user_file').value="";

				document.getElementById("mostrar_imagen").style.display = 'none';


				elimino_archivo=1;
			}
		});

		$('.view_file_link').on('click', function(e) {
			e.preventDefault();
			
			//***************************************************************
			//archivo_tmp ya contiene el nombre del archivo que ha eliminado
			//***************************************************************			
			document.getElementById("mostrar_imagen").style.display = 'block';					
			document.getElementById("view_imagen").style.display = 'none';					
			document.getElementById("ocultar_imagen").style.display = 'block';
			
		});

		$('.view_file_link_1').on('click', function(e) {
			e.preventDefault();
			
			//***************************************************************
			//archivo_tmp ya contiene el nombre del archivo que ha eliminado
			//***************************************************************			
			document.getElementById("mostrar_imagen_1").style.display = 'block';					
			document.getElementById("view_imagen_1").style.display = 'none';					
			document.getElementById("ocultar_imagen_1").style.display = 'block';
			
		});

		$('.ocultar_file_link').on('click', function(e) {
			e.preventDefault();
			
			//***************************************************************
			//archivo_tmp ya contiene el nombre del archivo que ha eliminado
			//***************************************************************			
			document.getElementById("mostrar_imagen").style.display = 'none';
			document.getElementById("view_imagen").style.display = 'block';					
			document.getElementById("ocultar_imagen").style.display = 'none';					
			
		});

		$('.ocultar_file_link_1').on('click', function(e) {
			e.preventDefault();
			
			//***************************************************************
			//archivo_tmp ya contiene el nombre del archivo que ha eliminado
			//***************************************************************			
			document.getElementById("mostrar_imagen_1").style.display = 'none';
			document.getElementById("view_imagen_1").style.display = 'block';					
			document.getElementById("ocultar_imagen_1").style.display = 'none';					
			
		});


		function formato(texto)
		{
 			 return texto.replace(/^(\d{4})-(\d{2})-(\d{2})$/g,'$3/$2/$1');
		}

		var obtener_data_editar = function(tbody,table)
		{			
			//***********************************************************************
			//Permite visualizar la ventana modal donde se puede editar la solicitud
			//***********************************************************************
			$(tbody).on("click","button.editar",function(){
				var elimino_archivo=0;
				var data = table.row( $(this).parents("tr")).data();	
				if (data['archivo'] != "")
				{
					document.getElementById("nombre_archivo").innerHTML = data['archivo'];						
					document.getElementById("archivo_cargado").style.display = 'block';
					document.getElementById("archivo_nuevo").style.display = 'none';
					//***********************************************
					//Permite obtener el nombre del archivo adjunto
					//***********************************************
					archivo_tmp = data['archivo'];

					var path_tmp = '<?php echo base_url(); ?>';
					var path_tmp= path_tmp.concat('files/');
					var path_tmp= path_tmp.concat(archivo_tmp);
												
					document.getElementById('mostrar_imagen').innerHTML = "<img src='"+path_tmp+"' width='100%'/>";
				}
				else
				{
					document.getElementById("archivo_cargado").style.display = 'none';
					document.getElementById("archivo_nuevo").style.display = 'block';
					archivo_tmp = "";	
				}
								
				document.getElementById('mostrar_imagen').style.display='none';
				document.getElementById("view_imagen").style.display = 'block';					
				document.getElementById("ocultar_imagen").style.display = 'none';
				

				$('#id_num_solicitud').val(data['id_num_solicitud']);
				$('#descripcion').val(data['descripcion']);				

				document.getElementById(data['motivo']).selected = true;

				//******************************
				//Obtengo la fecha de solicitud
				//******************************				
				var date_fs = formato(data["fecha_solicitud"]);
				document.getElementById("fecha_solicitud").value = date_fs;
				
				
				//****************************
				//Obtengo la fecha de permiso
				//****************************
				var date = new Date(data["fecha_permiso_inicio"]);
	        	var month = date.getMonth() + 1;
	        	var dia_tmp = date.getDate();

	        	var fecha = (date.getFullYear() + "-" + (month > 9 ? month : "0" + month) + "-" + (dia_tmp > 9 ? dia_tmp : "0" + dia_tmp));   

				var date_ = new Date(data["fecha_permiso_fin"]);
	        	var month_ = date_.getMonth() + 1;
	        	var dia_tmp_ = date_.getDate();

	        	var fecha_fin = (date_.getFullYear() + "-" + (month_ > 9 ? month_ : "0" + month_) + "-" + (dia_tmp_ > 9 ? dia_tmp_ : "0" + dia_tmp_));   

				if (data['dia_completo'] == 1)
				{
						//*******************************************************************
						//Selecciona en caso que haya registrado un permiso por dia completo
						//*******************************************************************
						document.getElementById("dias").checked = true;		
						showContent();  						   		
						document.getElementById("fecha_d").value = fecha;
						document.getElementById("fecha_h1").value = fecha_fin;
						showDiasHabiles();
				}
				else
				{
						//************************************************************
						//Selecciona en caso que haya registrado un permiso por horas
						//************************************************************
						document.getElementById("horas").checked = true;
						showContent();	   			
						document.getElementById("fecha_h").value = fecha;

						var hora_inicio = date.getHours();
	        			var minuto_inicio = date.getMinutes();
	        			var tiempo_inicio = (hora_inicio > 9 ? hora_inicio : "0" + hora_inicio) + ":" + (minuto_inicio > 9 ? minuto_inicio : "0" + minuto_inicio);	

	        			document.getElementById("tiempo_i").value = tiempo_inicio;

	        			var date = new Date(data["fecha_permiso_fin"]);
	        			var hora_final = date.getHours();
	        			var minuto_final = date.getMinutes();
	        			var tiempo_final = (hora_final > 9 ? hora_final : "0" + hora_final) + ":" + (minuto_final > 9 ? minuto_final : "0" + minuto_final);

	        			document.getElementById("tiempo_f").value = tiempo_final;
				}				
			});
		}

		var consultar_data = function(tbody,table)
		{			
			//***********************************************************************
			//Permite visualizar la ventana modal donde se puede editar la solicitud
			//***********************************************************************
			$(tbody).on("click","button.consultar",function(){
				var elimino_archivo=0;
				var data = table.row( $(this).parents("tr")).data();	
							
				var formData = new FormData();
				formData.append("id_num_solicitud",data['id_num_solicitud']);


				$.ajax({
						url:"<?php echo base_url(); ?>index.php/validacion/datos_aprobacion",
						type:'POST',						
						data: formData,
						cache: false,
    					contentType: false,
    					processData: false,
    					async:false,
						success:function(result)
						{
							//echo result;
							if (result == "no")
							{
								document.getElementById("datos_aprobacion").style.display = 'none';
							

							}
							else
							{
								document.getElementById("datos_aprobacion").style.display = 'block';

								var valores = JSON.parse(result);

								$.each(valores, function(i, item) {
								    

									document.getElementById("numero_a").innerHTML = item[0].idresolucion_solicitudes;
									document.getElementById("estado_a").innerHTML = item[0].resolucion;
									document.getElementById("gestionado_a").innerHTML = item[0].nombre + " " + item[0].apellido;
									document.getElementById("fecha_a").innerHTML = item[0].fecha_aprobacion;

								});
								
							}												
							
						},
						error:function(result)
						{
							alert("Error al recuperar información de la solicitud. Intente más tarde.");	
						}					
					});


				if (data['archivo'] != "")
				{
					document.getElementById("nombre_archivo_1").innerHTML = data['archivo'];						
					document.getElementById("archivo_cargado_1").style.display = 'block';
					document.getElementById("archivo_nuevo_1").style.display = 'none';
					//***********************************************
					//Permite obtener el nombre del archivo adjunto
					//***********************************************
					archivo_tmp = data['archivo'];

					var path_tmp = '<?php echo base_url(); ?>';
					var path_tmp= path_tmp.concat('files/');
					var path_tmp= path_tmp.concat(archivo_tmp);
												
					document.getElementById('mostrar_imagen_1').innerHTML = "<img src='"+path_tmp+"' width='100%'/>";
				}
				else
				{
					document.getElementById("archivo_cargado_1").style.display = 'none';
					document.getElementById("archivo_nuevo_1").style.display = 'block';
					archivo_tmp = "";	
				}
								
				document.getElementById('mostrar_imagen_1').style.display='none';
				document.getElementById("view_imagen_1").style.display = 'block';					
				document.getElementById("ocultar_imagen_1").style.display = 'none';
				

				$('#id_num_solicitud_1').val(data['id_num_solicitud']);
				$('#descripcion_1').val(data['descripcion']);	

				cuenta();

				var motivo_tmp;
				if (data['motivo'] == "Enfermedad"){
					motivo_tmp = "Enfermedad 1";
				}else if (data['motivo'] == "Emergencia") {
					motivo_tmp = "Emergencia 1";
				}else if (data['motivo'] == "Cita Medica") {
					motivo_tmp = "Cita Medica 1";
				}else if (data['motivo'] == "Estudios") {
					motivo_tmp = "Estudios 1";
				}else if (data['motivo'] == "Conferencias") {
					motivo_tmp = "Conferencias 1";
				}else if (data['motivo'] == "Calamidad Doméstica") {
					motivo_tmp = "Calamidad Doméstica 1";
				}
					

				document.getElementById(motivo_tmp).selected = true;

				//******************************
				//Obtengo la fecha de solicitud
				//******************************				
				var date_fs = formato(data["fecha_solicitud"]);
				document.getElementById("fecha_solicitud_1").value = date_fs;
				
				
				//****************************
				//Obtengo la fecha de permiso
				//****************************
				var date = new Date(data["fecha_permiso_inicio"]);
	        	var month = date.getMonth() + 1;
	        	var dia_tmp = date.getDate();

	        	var fecha = (date.getFullYear() + "-" + (month > 9 ? month : "0" + month) + "-" + (dia_tmp > 9 ? dia_tmp : "0" + dia_tmp));   

	        	var date_ = new Date(data["fecha_permiso_fin"]);
	        	var month_ = date_.getMonth() + 1;
	        	var dia_tmp_ = date_.getDate();

	        	var fecha_fin = (date_.getFullYear() + "-" + (month_ > 9 ? month_ : "0" + month_) + "-" + (dia_tmp_ > 9 ? dia_tmp_ : "0" + dia_tmp_));   

				if (data['dia_completo'] == 1)
				{
						//*******************************************************************
						//Selecciona en caso que haya registrado un permiso por dia completo
						//*******************************************************************
						document.getElementById("dias_1").checked = true;		
						showContent1();     			
						document.getElementById("fecha_d1").value = fecha;
						document.getElementById("fecha_h11").value = fecha_fin;
						showDiasHabiles1();

				}
				else
				{
						//************************************************************
						//Selecciona en caso que haya registrado un permiso por horas
						//************************************************************
						document.getElementById("horas_1").checked = true;
						showContent1();	   			
						document.getElementById("fecha_h_1").value = fecha;

						var hora_inicio = date.getHours();
	        			var minuto_inicio = date.getMinutes();
	        			var tiempo_inicio = (hora_inicio > 9 ? hora_inicio : "0" + hora_inicio) + ":" + (minuto_inicio > 9 ? minuto_inicio : "0" + minuto_inicio);	

	        			document.getElementById("tiempo_i_1").value = tiempo_inicio;

	        			var date = new Date(data["fecha_permiso_fin"]);
	        			var hora_final = date.getHours();
	        			var minuto_final = date.getMinutes();
	        			var tiempo_final = (hora_final > 9 ? hora_final : "0" + hora_final) + ":" + (minuto_final > 9 ? minuto_final : "0" + minuto_final);
	        			
	        			document.getElementById("tiempo_f_1").value = tiempo_final;
				}	

							
			});
		}

		var eliminar_data = function(tbody,table)
		{			
			//*******************************************
			//Permite eliminar la solicitud seleccionada
			//*******************************************						
			$(tbody).on("click","button.eliminar",function(e){
								
				if (xhrCount == 0)
				{
					if (confirm('¿Está seguro de eliminar la solicitud?'))			
					{

						var data = table.row( $(this).parents("tr")).data();				
						//****************************************
						// Para eliminar el registro seleccionado
						//****************************************
						$.ajax({
								url:"<?php echo base_url(); ?>index.php/validacion/eliminar_solicitud",
								type:'POST',
								data:{
									id_num_solicitud:data["id_num_solicitud"]						
								},						    				
								success:function(result)
								{						
									alert("Solicitud eliminada correctamente.");									
									//table.ajax.reload(); //Actualiza la tabla de historial de solicitud											

									listar(); //Refresco todas el DataTable
								},
								error:function(result)
								{
									alert("Error al eliminar la solicitud. Intente más tarde.");	
								}					
						});
					}
					xhrCount = 1;					
				}
				else
				{
					xhrCount = 0;
				}
								
			});
		}
		
		function actualizar_solicitud(){
					       						
			//*****************************************************************************************
			//Obtengo todos los datos de los campos correspondientes para insertar en la Base de Datos
			//*****************************************************************************************
			var formData = new FormData(document.getElementById("formuploadsolicitud"));

			formData.append("id_num_solicitud",$("#id_num_solicitud").val());
			formData.append("descripcion",$("#descripcion").val());
			formData.append("empleado","<?php echo $id_empleado?>");
			formData.append("motivo",$("#m_motivo").val());
			formData.append("elimino_archivo",elimino_archivo);
			formData.append("archivo_tmp",archivo_tmp);

			descripcion_tmp=$("#descripcion").val();

			//***********************************************************************
			//Obtener la fecha del dia del permiso o por horas según lo seleccionado
			//***********************************************************************
			check = document.getElementById("dias");
			
			if (check.checked)
			{			
				formData.append("fecha_permiso_inicio",$("#fecha_d").val() + " " + "00:00");
				formData.append("fecha_permiso_fin",$("#fecha_h1").val() + " " + "23:59");
				formData.append("dia_completo",1);			
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

			if (descripcion_tmp!="")
			{		
			    $.ajax({
					url:"<?php echo base_url(); ?>index.php/validacion/actualizar_solicitud",
					type:'POST',
					data: formData,
					cache: false,
    				contentType: false,
    				processData: false,
    				async:false,
					success:function(result)
					{
						
						alert("Solicitud se actualizó correctamente.");

  						$('#modalEditarSolicitud').modal('toggle');  						
						$("#mbtnCerrarModal").click()
						
						table.ajax.reload(); //Actualiza la tabla de historial de solicitud	
						
					},
					error:function(result)
					{
						alert("Error al actualizar la solicitud. Intente más tarde.");	
					}					
				});
			}else{				    
				alert("No pueden existir campos vacios.");
			}			   
		}
</script>

</body>
</html>
