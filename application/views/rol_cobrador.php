<?php defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('America/Bogota');?>
<!DOCTYPE html>
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
	<script src="<?php echo base_url(); ?>js/moment.min.js"></script>
</head>	
<body  class="body_alterno">
	<div class="container formulario">
		<div class="row">
			<div class="col-md-6 offset-md-3 myform-cont" >				
				<div class="myform-top">
					
						<table style="width: 100%;">
		                	<tr>
		                		<td style="width: 80%;"></td>
		                		<form action="<?= base_url() .'index.php/validacion/cerrar_sesion'?>">
									<td  style="align:right">
										<input type="image" src="<?= base_url()?>/images/cerrar_sesion_2.png" width="50" height="50">
									</td> 
								</form>
							</tr>
	                	</table>
					
					<div class="myform-topmenu-left">
						<form action="<?= base_url() .'index.php/validacion/crear_prestamo'?>">
							<input type="image" src="<?= base_url()?>/images/credito2.png" width="100" height="100"> 
						</form>
					</div>

					<div class="myform-topmenu-right">
                        <form action="<?= base_url() .'index.php/validacion/crear_cliente'?>">
							<input type="image" src="<?= base_url()?>/images/cliente2.png" width="100" height="100"> 
						</form>
                    </div>
                   
					<div class="myform-topmenu-right">
                        <form action="<?= base_url() .'index.php/validacion/menu_reporte'?>" method="post" class="">
							<input type="image" src="<?= base_url()?>/images/reporte2.png" width="100" height="100"> 
						</form>
                    </div>
                </div>
				<div class="myform-bottom2" style="width: 100%">    
				<table>
                	<tr>
	                	<td>Fecha: </td>
	                		<td><input type="date" name="fecha_i"  id="fecha_i" value="<?php echo date("Y-m-d")?>" style="height: 30px;width: 100%;font-size: 13px;">
	                		</td>
						<td>							
							<input type="image" id="buscar" name="buscar" src="<?= base_url()?>/images/buscar.png" width="30" height="30">
						</td>	
                	</tr>
                	<tr style="height: 15px"></tr>
                	<tr>                		
	                		<td align="center"><input type="submit" id="buscar_t" name="buscar_t"class="btn-sm" style="background-color: #f7cb15;color: #FFFFFF;width: 100%;" value="Mostrar Todos" /></td>
	                </tr>
                    <tr style="height: 15px"></tr>
                	<form action="<?= base_url() .'index.php/validacion/abono'?>" method="post" class="">
	                	<tr>                		
	                		<td align="center"><input type="submit" id="btn_abonar" disabled name="btn_abonar"class="btn-sm" style="background-color: #C8216A; opacity: 0.5;color: #FFFFFF;width: 110px;" value="Abonar"/></td>
	                		<td><input type="text" style="display: none;" value="ad" name="id_detalle_credito" id="id_detalle_credito"></td>        		
	                	</tr>
	                <tr style="height: 15px"></tr>

                	</form>
                	
                	<td align="center"><input type="submit" id="reprogramar" disabled name="reprogramar"class="btn-sm" style="background-color: #C8216A; opacity: 0.5 ;color: #FFFFFF;width: 110px;" value="Reprogramar" /></td>
	                <table id="reprogramar_fecha" style="display: none">
                	<tr >
	                	<td>Próxima Fecha: </td>
	                	<td><input type="date" name="fecha_r"  id="fecha_r" value="<?php echo date("Y-m-d")?>" style="height: 30px;width: 100%;font-size: 13px;">
	                		</td>
						<td>							
							<input type="image" id="guardar" name="guardar" src="<?= base_url()?>/images/guardar.png" width="30" height="30">
						</td>
							
                	</tr>
                	</table> 

                </table> 

                    <table class="table-responsive" id="tabla_cobros" width="100%" style="font-family:sans-serif; font-size: 10px;">
						<colgroup>
		       				<col style="width: 10%;">
		       				<col style="width: 30%;">
		       				<col style="width: 10%;">
		       				<col style="width: 10%;">
		       				<col style="width: 10%;">
		       				<col style="width: 10%;">
		       				
		       			</colgroup>
						<thead>
							<tr style="color:#FFFFFF; background-color: #2E86C1;font-size: 10px;">
								<th>Fecha</th>
								<th>Cliente</th>
								<th>Cuota</th>
								<th>Mora</th>						
								<th>Saldo</th>
								<th>Id</th>
							</tr>
						</thead>
					</table>
					
					<table style="width: 100%">	
							<tr>
								<td style="width: 60%;font-size: 14px;font-weight: 1000;text-align: right;
    								background-color: #BDC3C7"> ( + ) Total   por cobrar: $</td>
								<td style="width: 40%;background-color: #BDC3C7"><input type="text" readonly="true" id="t_cuota" name="t_cuota" required maxlength="45"style="font-size: 14px;font-weight: 1000;text-align: right; height: 30px;width: 100%;line-height: 20px" /></td>
							</tr>
					</table>



                </div>


			</div>

		</div>

	</div>

<script src="<?php echo base_url(); ?>tether/js/tether.min.js"></script>
<script src="<?php echo base_url(); ?>js/jquery.js"></script>
<script src="<?php echo base_url(); ?>js/bootstrap.min.js"></script>
<script type="text/javascript">
	
	var path;
	var b_rep=0;

	$(document).ready(function(e) {
	   	actualizar_mora();
	    $("#t_cuota").val("0");
        path="<?php echo base_url(); ?>index.php/validacion/consulta_clientes_cobrar";
        listar($("#fecha_i").val());
        //listar();
        $("#buscar").click(function(){
		   	path="<?php echo base_url(); ?>index.php/validacion/consulta_clientes_cobrar";
		   	listar($("#fecha_i").val());
		});

		$("#buscar_t").click(function(){
			path="<?php echo base_url(); ?>index.php/validacion/consulta_todos_creditos";
		 	listar($("#fecha_i").val());
		 	document.getElementById("reprogramar_fecha").style.display='none';
			document.getElementById("btn_abonar").disabled = true;
	        document.getElementById("btn_abonar").style.opacity = "0.5";
	        document.getElementById("reprogramar").disabled = true;
	        document.getElementById("reprogramar").style.opacity = "0.5";
		});

		$("#reprogramar").click(function(){
			
			rep = document.getElementById("reprogramar_fecha");
			if (b_rep==0) 
			{
				rep.style.display='block';
				b_rep=1
			}
			else
			{
				rep.style.display='none';
				b_rep=0
			}
		});

		$("#guardar").click(function(){
		        //alert ($("#id_detalle_credito").val())
		        
		    var hoy= new Date().toJSON().slice(0,10);
		    if ($("#fecha_r").val()<hoy)
		    {
		       	alert("Fecha debe ser mayor a hoy.");
		    }
		    else
		    {
		        $.post("<?= base_url() .'index.php/validacion/reprogramar_fecha'?>",
		        {
		          id_det_credito: $("#id_detalle_credito").val(),
		          fecha_r: $("#fecha_r").val()
		        },
		        function(data,status){
		            if (data == "1")
		            {
		            	alert("Fecha reprogramada con éxito.");
		            	path="<?php echo base_url(); ?>index.php/validacion/consulta_clientes_cobrar";
		   				listar($("#fecha_i").val());
						document.getElementById("reprogramar_fecha").style.display='none';
						document.getElementById("btn_abonar").disabled = true;
	            		document.getElementById("btn_abonar").style.opacity = "0.5";
	            		document.getElementById("reprogramar").disabled = true;
	            		document.getElementById("reprogramar").style.opacity = "0.5";
		            	
		            }
		            else
		            {
		            	alert("La fecha no ha sido reprogramada. Favor intente nuevamente.");
		            	path="<?php echo base_url(); ?>index.php/validacion/consulta_clientes_cobrar";
		   				listar($("#fecha_i").val());
						document.getElementById("reprogramar_fecha").style.display='none';
						document.getElementById("btn_abonar").disabled = true;
	            		document.getElementById("btn_abonar").style.opacity = "0.5";
	            		document.getElementById("reprogramar").disabled = true;
	            		document.getElementById("reprogramar").style.opacity = "0.5";
		            }
		        });
		    }

		});
		

		$('#tabla_cobros').on( 'click', 'tr', function () {
	       if ( $(this).hasClass('selected') ) {
	            $(this).removeClass('selected');
	            document.getElementById("btn_abonar").disabled = true;
	            document.getElementById("btn_abonar").style.opacity = "0.5";
	            document.getElementById("reprogramar").disabled = true;
	            document.getElementById("reprogramar").style.opacity = "0.5";
	            b_rep=0;
	            document.getElementById("reprogramar_fecha").style.display='none';
	        }
	        else {
	            table.$('tr.selected').removeClass('selected');
	            $(this).addClass('selected');
	            
	            var data = $(this).find("td:eq(5)").text();
	            if (data!="No hay datos disponibles en la tabla") 
	            {
					$("#id_detalle_credito").val(data);
		            document.getElementById("btn_abonar").disabled = false;
		            document.getElementById("btn_abonar").style.opacity = "1";
		            document.getElementById("reprogramar").disabled = false;
		            document.getElementById("reprogramar").style.opacity = "1";
		        }
	        }
	    } );

    });

	function actualizar_mora()
	{
	    $.post("<?= base_url() .'index.php/validacion/actualizar_mora'?>",
		        
		 function(data,status){  });
	}

	var listar = function(fecha_i)
	{
				table = $('#tabla_cobros').DataTable();
				table.destroy();
				
				table = $('#tabla_cobros').DataTable({
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
						"url":path,
						"data" : {"fecha_i": fecha_i
								 }						
					},

					"columns":[
					    {"render":
							function ( data, type, row ) {
								return (moment(String(row["fecha_i"])).format('YYMMDD'))    				         					
						 	}
						},
						//{"data":"fecha_i"},
					    {"render":
							function ( data, type, row ) {
						  		return (row["nombre"] + " " + row["apellido"]) ;    
						  		        					
						  	}
						},
						{"render":
						  	function ( data, type, row ) {
						  		var total = row["t_cuota"]; 
								$("#t_cuota").val(total);
						  		return (parseFloat(row["v_cuota"] - row["abono"]).toFixed(2));          					
						  	}
						},
						 {"render":
							function ( data, type, row ) {
						  		return (row["d_mora"] + "D-$" + row["mora"]) ;    
						  		        					
						  	}
						},		
						//{"data":"d_mora"},
						//{"data":"mora"},
						{"render":
						  	function ( data, type, row ) {
						  		return (parseFloat(parseFloat(row["totalapagar"]) - parseFloat(row["totalpagado"])).toFixed(2));
        						//return (fecha + " ( " + tiempo_inicio + " - " + tiempo_final + " ) ");	
         					
						  	}
						},
						{"data":"id_det_credito"},
						
					],
					//select: true,					
					"buttons": [
			            
			        ]
				});
				//Cambiar color al fondo del boton, tambien a la letra
				//table.button(0).nodes().css('background', '#C8216A');
				//table.button(0).nodes().css('color', '#FFFFFF');
				//table.button(1).nodes().css('background', '#C8216A');
				//table.button(1).nodes().css('color', '#FFFFFF');	
	}

</script>
<script src="<?php echo base_url(); ?>tether/js/tether.min.js"></script>
<script src="<?php echo base_url(); ?>js/jquery.js"></script>
<script src="<?php echo base_url(); ?>js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/dataTables.select.min.js"></script>
<script src="<?php echo base_url(); ?>js/moment.min.js"></script>
</body>
</html>