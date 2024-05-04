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



</head>

<body>  
<br>
<div style="padding-left: 25px">	
	<legend><h3><b>Reportes/Estadística</b></h3></legend>	
</div>
<br>
<div style="padding-left: 25px;">
<strong><h4> Filtros de reportes: </h4></strong>

<div style="padding-left: 25px; border:1px solid black; width:70%">	
	<br>
	<table>				
		<tr>
			<td><input type="radio" name="ranking" id="ranking_motivo" value="ranking_motivo" onchange="javascript:showContent()"> Ranking por motivos de permisos : </td>			 	
		</tr>
		<tr>
			<td style="height: 10px"></td>
		</tr>
		<tr id="fecha_motivo" style="display: none;">	 		 	
		 	<td>
		 		Fecha Inicio: <input type="date" name="fecha_i_motivo_filtro" id="fecha_i_motivo_filtro" value="<?php echo date("Y-m-d")?>" style="height: 30px;width: 120px;font-size: 13px;">		 	
		 	</td>
		 	<td>
		 		Fecha Fin: <input type="date" name="fecha_f_motivo_filtro" id="fecha_f_motivo_filtro" value="<?php echo date("Y-m-d")?>" style="height: 30px;width: 120px;font-size: 13px;">	 
		 	</td>		 		 
		</tr>
		<tr>
			<td><input type="radio" name="ranking" id="id_mas_permisos" value="id_mas_permisos" onchange="javascript:showContent()"> Personal Administrativo/Docente con más solicitudes de permisos realizadas</td>			 	
		</tr>
		<tr>
			<td style="height: 10px"></td>
		</tr>
		<tr id="fecha_motivo1" style="display: none;">	 		 	
		 	<td>
		 		Fecha Inicio: <input type="date" name="fecha_i_mas_permisos" id="fecha_i_mas_permisos" value="<?php echo date("Y-m-d")?>" style="height: 30px;width: 120px;font-size: 13px;">		 	
		 	</td> 
		 	<td>
		 		Fecha Fin: <input type="date" name="fecha_f_mas_permisos" id="fecha_f_mas_permisos" value="<?php echo date("Y-m-d")?>" style="height: 30px;width: 120px;font-size: 13px;">	 
		 	</td> 
		 	<td>
			 	<td>Estado de solicitud
			 		<select id="estado_filtro" name="estado_filtro" style="height: 30px;width: 200px;font-size: 13px;">
			 		  <option value="Seleccionar">Seleccionar</option>
					  <option value="Aprobado">Aprobado</option>
					  <option value="No Aprobado">No Aprobado</option>	
					  <option value="Pendiente">Pendiente</option>					  
					</select>
			</td>		 		 
		</tr>
		<tr>
			<td><input type="radio" name="ranking" id="id_solicitadas_aprobadas" value="id_solicitadas_aprobadas" onchange="javascript:showContent()"> Estado de las solicitudes del Personal Administrativo/Docente
			</td>
			<tr>
				<td style="height: 10px"></td>
			</tr>
			<tr id="fecha_motivo2" style="display: none;">	 		 	
			 	<td>
			 		Fecha Inicio: <input type="date" name="fecha_i_aprobadas" id="fecha_i_aprobadas" value="<?php echo date("Y-m-d")?>" style="height: 30px;width: 120px;font-size: 13px;">		 	
			 	</td>
			 	<td>
			 		Fecha Fin: <input type="date" name="fecha_f_aprobadas" id="fecha_f_aprobadas" value="<?php echo date("Y-m-d")?>" style="height: 30px;width: 120px;font-size: 13px;">	 
			 	</td>		 		 
			</tr>			 	
		</tr>
								
</table>
<br>
<input type="submit" value="Buscar" style="background-color: #C8216A;color: #FFFFFF;width: 150px;font-size: 14px" onclick="buscar_filtros()"/>
</div>
</div>

<br>

<canvas id="myChart" width="75" height="25"></canvas>
<div id="mens"></div>
<button type="button" id="download-pdf" onclick="downloadPDF()">Download PDF</button>
<script src="<?php echo base_url(); ?>tether/js/tether.min.js"></script>
<script src="<?php echo base_url(); ?>js/jquery.js"></script>
<script src="<?php echo base_url(); ?>js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>js/jspdf.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.dataTables.min.js"></script>

<script>
		var xhrCount = 0; //Bandera de eliminación de registros
		var archivo_tmp; //nombre de archivo temporal en caso de eliminar
		var elimino_archivo=0;
		var table; //DataTable global para poder actualizar los datos sin Listar de nuevo

		var estado_filtro = "NO";
		var cedula_filtro = "NO";

		var myChart=null;

		function showContent() {
	        fecha_motivo = document.getElementById("fecha_motivo");	        
	        fecha_motivo1 = document.getElementById("fecha_motivo1");	      
	        fecha_motivo2 = document.getElementById("fecha_motivo2");	        
	        mov_ranking = document.getElementById("ranking_motivo");
	        personal_mas_permiso = document.getElementById("id_mas_permisos");
	        solicitudes_aprobadasvs = document.getElementById("id_solicitadas_aprobadas");
	        			
	        if (mov_ranking.checked == true) {
	            fecha_motivo.style.display='block';	           
	        }
	        else {
	            fecha_motivo.style.display='none';
	        }

	        if (personal_mas_permiso.checked == true)
	        {
				fecha_motivo1.style.display='block';	           
	        }	
	        else{
	        	fecha_motivo1.style.display='none';	           	
	        }	

			if (solicitudes_aprobadasvs.checked == true)
	        {
				fecha_motivo2.style.display='block';	           
	        }	
	        else{
	        	fecha_motivo2.style.display='none';	           	
	        }	        
	       
	    }

		function mostrar_ranking_motivo(motivo_get_bd,count_motivo_bd,title)
		{

			if (myChart!=null){
				myChart.destroy();
			}

			var red = '#FE2E2E';
			var ctx = document.getElementById("myChart").getContext('2d');		
			

			myChart = new Chart(ctx, {
			    type: 'bar',
			    data: {
			        labels: motivo_get_bd,
			        datasets: [{
			            label: '# de solicitudes',
			            data: count_motivo_bd,
			            backgroundColor: [
			                'rgba(255, 99, 132, 0.2)',
			                'rgba(54, 162, 235, 0.2)',
			                'rgba(255, 206, 86, 0.2)',			                
			                'rgba(153, 102, 255, 0.2)',
			                'rgba(255, 159, 64, 0.2)'
			            ],
			            borderColor: [
			                'rgba(255,99,132,1)',
			                'rgba(54, 162, 235, 1)',
			                'rgba(255, 206, 86, 1)',			                
			                'rgba(153, 102, 255, 1)',
			                'rgba(255, 159, 64, 1)'
			            ],
			            borderWidth: 1
			        }]
			    },
			    options: {
			        scales: {
			            yAxes: [{
			            	scaleLabel: {
						        display: true,
						        labelString: 'Número de solicitudes'
						    },

			                ticks: {
			                    beginAtZero:true
			                }
			            }]
			        },			        

			        title: {
			        	display: true,
            			text: title,
            			fontSize:16
			        },

			        legend: {
            			display: false
            		},

            		showTooltip: true            		

			    }
			});

			ctx.clearRect(0, 0,75, 25);	
			
		}

		function downloadPDF() 
		{
		 	var canvas = document.querySelector('#myChart');
			//creates image
			var canvasImg = canvas.toDataURL("image/png", 1.0);
		  
			//creates PDF from img
			var doc = new jsPDF();
			doc.setFontSize(14);
			doc.text("Universidad de Guayaquil",105,15,'center')
			doc.setFontSize(12);			
			doc.text("Impresión de Reporte",105,25,'center');
			doc.addImage(canvasImg, 'png', 25, 50, 165, 75 );
			doc.save('canvas.pdf');
		}



		function buscar_filtros()
		{
			
			fecha_motivo = document.getElementById("fecha_motivo");	        
	        fecha_motivo1 = document.getElementById("fecha_motivo1");	        
	        mov_ranking = document.getElementById("ranking_motivo");
	        personal_mas_permiso = document.getElementById("id_mas_permisos");
	        solicitudes_aprobadasvs = document.getElementById("id_solicitadas_aprobadas");
	        
	        motivo_get_bd = new Array();	        
	        count_motivo_bd = new Array();
	        			
	        if (mov_ranking.checked == true) {
	            
	            fecha_i_motivo_filtro = $("#fecha_i_motivo_filtro").val();
				fecha_f_motivo_filtro = $("#fecha_f_motivo_filtro").val();			

				if (fecha_i_motivo_filtro > fecha_f_motivo_filtro)
				{
					alert("Verifique las fechas para poder realizar la consulta");					
					return 0;
				}
				else
				{

		            fecha_i_motivo_filtro=fecha_i_motivo_filtro.replace(/-/g,"/");
					fecha_f_motivo_filtro=fecha_f_motivo_filtro.replace(/-/g,"/");

		            var date = new Date(fecha_i_motivo_filtro);
	        		var month = date.getMonth() + 1;
	        		var dia_tmp = date.getDate();

	        		fecha_i_motivo_filtro = (date.getFullYear() + "-" + (month > 9 ? month : "0" + month) + "-" + (dia_tmp > 9 ? dia_tmp : "0" + dia_tmp));


	        		date = new Date(fecha_f_motivo_filtro);
	        		month = date.getMonth() + 1;
	        		dia_tmp = date.getDate();

	        		fecha_f_motivo_filtro = (date.getFullYear() + "-" + (month > 9 ? month : "0" + month) + "-" + (dia_tmp > 9 ? dia_tmp : "0" + dia_tmp));
	        		fecha_f_motivo_filtro = fecha_f_motivo_filtro + " " + "23:59:00"; 
	        		

		            var formData = new FormData();		            
		            formData.append("fecha_i",fecha_i_motivo_filtro);
					formData.append("fecha_f",fecha_f_motivo_filtro);
					$.ajax({
							url:"<?php echo base_url(); ?>index.php/validacion/mostrar_ranking_motivo",
							type:'POST',						
							data: formData,
							cache: false,
	    					contentType: false,
	    					processData: false,
	    					async:false,
							success:function(result)
							{
								//$("#mens").html(result);

								//Parseamos para convertir en un arreglo
								var valores = JSON.parse(result);						
								
								for(i=0;i<valores.data.length;i++) 
								{							    
								    motivo_get_bd.push(valores.data[i].motivo);
								    count_motivo_bd.push(valores.data[i].cantidad);
								}														
								
							},
							error:function(result)
							{
								alert("Error al consultar información. Intente más tarde.");	
							}					
						});
					}

		            mostrar_ranking_motivo(motivo_get_bd, count_motivo_bd,"Ranking por motivos de permisos");
		    }


	        if (personal_mas_permiso.checked == true) 
	        {
	            
	            fecha_i_mas_permisos = $("#fecha_i_mas_permisos").val();
				fecha_f_mas_permisos = $("#fecha_f_mas_permisos").val();	
				estado_filtro = document.getElementById("estado_filtro").value;
				

				if (fecha_i_mas_permisos > fecha_f_mas_permisos || estado_filtro == "Seleccionar")
				{
					alert("Verifique las fechas para poder realizar la consulta y/o seleccione un estado de solicitud");					
					return 0;
				}
				else
				{

		            fecha_i_mas_permisos=fecha_i_mas_permisos.replace(/-/g,"/");
					fecha_f_mas_permisos=fecha_f_mas_permisos.replace(/-/g,"/");

		            var date = new Date(fecha_i_mas_permisos);
	        		var month = date.getMonth() + 1;
	        		var dia_tmp = date.getDate();

	        		fecha_i_mas_permisos = (date.getFullYear() + "-" + (month > 9 ? month : "0" + month) + "-" + (dia_tmp > 9 ? dia_tmp : "0" + dia_tmp));


	        		date = new Date(fecha_f_mas_permisos);
	        		month = date.getMonth() + 1;
	        		dia_tmp = date.getDate();

	        		fecha_f_mas_permisos = (date.getFullYear() + "-" + (month > 9 ? month : "0" + month) + "-" + (dia_tmp > 9 ? dia_tmp : "0" + dia_tmp));
	        		fecha_f_mas_permisos = fecha_f_mas_permisos + " " + "23:59:00"; 
	        			        		

		            var formData = new FormData();		            
		            formData.append("fecha_i",fecha_i_mas_permisos);
					formData.append("fecha_f",fecha_f_mas_permisos);
					formData.append("estado_solicitud",estado_filtro);

					$.ajax({
							url:"<?php echo base_url(); ?>index.php/validacion/mostrar_mas_permisos",
							type:'POST',						
							data: formData,
							cache: false,
	    					contentType: false,
	    					processData: false,
	    					async:false,
							success:function(result)
							{
								//$("#mens").html(result);

								//Parseamos para convertir en un arreglo
								var valores = JSON.parse(result);						
								
								for(i=0;i<valores.data.length;i++) 
								{							    
								    motivo_get_bd.push(valores.data[i].nombre);
								    count_motivo_bd.push(valores.data[i].cantidad);
								}														
								
							},
							error:function(result)
							{
								alert("Error al consultar información. Intente más tarde.");	
							}					
						});
				mostrar_ranking_motivo(motivo_get_bd, count_motivo_bd,"Solicitudes de permisos realizadas por el Personal Administrativo/Docente ( " + estado_filtro + " )");
				}		         		          
		    }


		    if (solicitudes_aprobadasvs.checked == true) {
	            
	            fecha_i_aprobadas = $("#fecha_i_aprobadas").val();
				fecha_f_aprobadas = $("#fecha_f_aprobadas").val();			

				if (fecha_i_aprobadas > fecha_f_aprobadas)
				{
					alert("Verifique las fechas para poder realizar la consulta");					
					return 0;
				}
				else
				{

		            fecha_i_aprobadas=fecha_i_aprobadas.replace(/-/g,"/");
					fecha_f_aprobadas=fecha_f_aprobadas.replace(/-/g,"/");

		            var date = new Date(fecha_i_aprobadas);
	        		var month = date.getMonth() + 1;
	        		var dia_tmp = date.getDate();

	        		fecha_i_aprobadas = (date.getFullYear() + "-" + (month > 9 ? month : "0" + month) + "-" + (dia_tmp > 9 ? dia_tmp : "0" + dia_tmp));


	        		date = new Date(fecha_f_aprobadas);
	        		month = date.getMonth() + 1;
	        		dia_tmp = date.getDate();

	        		fecha_f_aprobadas = (date.getFullYear() + "-" + (month > 9 ? month : "0" + month) + "-" + (dia_tmp > 9 ? dia_tmp : "0" + dia_tmp));
	        		fecha_f_aprobadas = fecha_f_aprobadas + " " + "23:59:00"; 
	        		

		            var formData = new FormData();		            
		            formData.append("fecha_i",fecha_i_aprobadas);
					formData.append("fecha_f",fecha_f_aprobadas);
					$.ajax({
							url:"<?php echo base_url(); ?>index.php/validacion/ingresadasvsaprobadas",
							type:'POST',						
							data: formData,
							cache: false,
	    					contentType: false,
	    					processData: false,
	    					async:false,
							success:function(result)
							{
								//$("#mens").html(result);

								//Parseamos para convertir en un arreglo
								var valores = JSON.parse(result);						
								
								for(i=0;i<valores.data.length;i++) 
								{							    
								    motivo_get_bd.push(valores.data[i].nombre);
								    count_motivo_bd.push(valores.data[i].cantidad);
								}														
								
							},
							error:function(result)
							{
								alert("Error al consultar información. Intente más tarde.");	
							}					
						});
					}

		            mostrar_ranking_motivo(motivo_get_bd, count_motivo_bd,"Estado de solicitudes del Personal Administrativo/Docente");
		    }
		}
	        

			//table = $('#historial_solicitud_permiso').DataTable();			
			
			/*	
			var cbox4 = document.getElementById("cbox4");
			if (cbox4.checked ==true )
			{
				fecha_d_filtro = $("#fecha_d_filtro").val();
				fecha_h_filtro = $("#fecha_h_filtro").val();

				if (fecha_d_filtro > fecha_h_filtro)
				{
					alert("Verifique las fechas para poder realizar la consulta");
					fecha_d_filtro = "NO";
					return 0;
				}
				else
				{
					var date = new Date(fecha_d_filtro);
	        		var month = date.getMonth() + 1;
	        		var dia_tmp = date.getDate() + 1;

	        		fecha_d_filtro = (date.getFullYear() + "-" + (month > 9 ? month : "0" + month) + "-" + (dia_tmp > 9 ? dia_tmp : "0" + dia_tmp));

	        		console.log(fecha_h_filtro);
	        		date = new Date(fecha_h_filtro);
	        		month = date.getMonth() + 1;
	        		dia_tmp = date.getDate() + 1;

	        		fecha_h_filtro = (date.getFullYear() + "-" + (month > 9 ? month : "0" + month) + "-" + (dia_tmp > 9 ? dia_tmp : "0" + dia_tmp));
	        		fecha_h_filtro = fecha_h_filtro + " " + "23:59:00"; 

	        		console.log(fecha_h_filtro);

				}			
			}
			else
			{
				fecha_d_filtro = "NO";
			}	



			var cbox1 = document.getElementById("cbox1");
			if (cbox1.checked ==true )
			{
				cedula_filtro = document.getElementById("cedula_filtro").value;
				if (cedula_filtro.trim() == "")
				{
					alert("Debe ubicar la cedula del solicitante que desea buscar")
					cedula_filtro = "NO";
					return 0;
				}

			}
			else
			{
				cedula_filtro = "NO";
			}			

			var cbox3 = document.getElementById("cbox3");
			if (cbox3.checked ==true )
			{
				apellido_filtro = document.getElementById("apellido_filtro").value;
				if (apellido_filtro.trim() == "")
				{
					alert("Debe ubicar el apellido del solicitante que desea buscar")
					apellido_filtro = "NO";
					return 0;
				}

			}
			else
			{
				apellido_filtro = "NO";
			}			

			if (cbox2.checked ==true )
			{
				estado_filtro = document.getElementById("estado_filtro").value;
				//estado_filtro = $("#estado_filtro").val()
				if (estado_filtro == "Seleccionar")
				{
					alert("Debe seleccionar el estado de las solicitudes a buscar")
					estado_filtro = "NO";
					return 0;
					
				}

			}
			else
			{
				estado_filtro = "NO";
			}			
			
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
            		"bFilter": false,            		
					"ajax":{
						
						"type":"POST",
						"url":"<?php echo base_url(); ?>index.php/validacion/consulta_tramitadas_filtros",									
						"data" : {"estado_filtro": estado_filtro,
								  "cedula_filtro": cedula_filtro,
								  "apellido_filtro": apellido_filtro,
								  "fecha_d_filtro": fecha_d_filtro,
								  "fecha_h_filtro": fecha_h_filtro
								 }
										
					},

					"columns":[
						{"data":"id_num_solicitud"},
						{"data":"fecha_solicitud"},	
						{"data":"cedula"},						
						{"render":
						  function (data, type, row){
						  	var nombre_completo = row["nombre"] + " " + row["apellido"];
						  	return nombre_completo;
						  }	

						},
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

        						return (date.getFullYear() + "-" + (month > 9 ? month : "0" + month) + "-" + (dia_tmp > 9 ? dia_tmp : "0" + dia_tmp));
 
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

				consultar_data("#historial_solicitud_permiso tbody");

				*/
			//table.destroy();
		//}

		

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
            		"bFilter": false,
					"ajax":{
						"method":"POST",
						"url":"<?php echo base_url(); ?>index.php/validacion/consulta_tramitadas"						
					},


					"columns":[
						{"data":"id_num_solicitud"},
						{"data":"fecha_solicitud"},	
						{"data":"cedula"},						
						{"render":
						  function (data, type, row){
						  	var nombre_completo = row["nombre"] + " " + row["apellido"];
						  	return nombre_completo;
						  }	

						},
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

        						return (date.getFullYear() + "-" + (month > 9 ? month : "0" + month) + "-" + (dia_tmp > 9 ? dia_tmp : "0" + dia_tmp));
 
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

						
						

				//obtener_data_editar("#historial_solicitud_permiso tbody", table);
				//eliminar_data("#historial_solicitud_permiso tbody", table);	
				
				consultar_data("#historial_solicitud_permiso tbody");	
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

		var consultar_data = function(tbody)
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

				if (data['dia_completo'] == 1)
				{
						//*******************************************************************
						//Selecciona en caso que haya registrado un permiso por dia completo
						//*******************************************************************
						document.getElementById("dias_1").checked = true;		
						showContent1();     			
						document.getElementById("fecha_d_1").value = fecha;
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
				formData.append("fecha_permiso_fin",$("#fecha_d").val() + " " + "23:59");
				formData.append("dia_completo",1);			
			}
			else{
				if ($("#tiempo_i").val() < $("#tiempo_f").val())
				{
					formData.append("fecha_permiso_inicio",$("#fecha_h").val() + " " + $("#tiempo_i").val());
					formData.append("fecha_permiso_fin",$("#fecha_h").val() + " " + $("#tiempo_f").val());
					formData.append("dia_completo",0);
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
<script src="<?php echo base_url(); ?>js/Chart.min.js"></script>
</body>
</html>
	