<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('America/Bogota');
?><!DOCTYPE html>
<html lang="es">
<head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">

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
</head>	
<body  class="body_alterno">
	<div class="containers">
		<div class="row">
			<div class="col-md-6 offset-md-3 myform-cont" >				
				<div class="myform-top">
					<strong align="left">Consulta Historial Cliente</strong>
				</div>
				<div class="myform-bottom table-responsive">    
				<table style="width: 100%">
       				<tr>
                		<form action="<?= base_url() .'index.php/validacion/historial_cliente_det'?>" method="post" class="">
	                		<td><input type="submit" id="btn_detalle" disabled name="btn_detalle"class="btn-sm" style="background-color: #C8216A; opacity: 0.5;color: #FFFFFF;width: 100%;" value="Ver detalle"/></td>
	                		<td><input type="text" style="display: none;" name="id_cliente" id="id_cliente"></td>        		
	                   	</form>
	                   	<form action="<?= base_url() .'index.php/menu_principal/menu_reporte'?>" method="post" class="">		
									<td ><input type="submit" id="btn_regresar" name="btn_regresar"class="btn-sm" style="width: 100%;background-color: #C8216A;color: #FFFFFF;" value="Regresar" onclick="regresar()"/></td>
						</form>

                	</tr>

                </table> 

                    <table id="tabla_clientes" width="100%" style="text-align: center;font-family:sans-serif; font-size: 13px;">
						<colgroup>
		       				<col style="width: 5%;">
		       				<col style="width: 40%;">
		       				
		       			</colgroup>
						<thead>
							<tr style="color:#FFFFFF; background-color: #2E86C1;">
								<th>Id</th>
								<th>Cliente</th>
								
							</tr>
						</thead>
					</table>
					
                </div>

			</div>
			
		</div>
	</div>

<script src="<?php echo base_url(); ?>tether/js/tether.min.js"></script>
<script src="<?php echo base_url(); ?>js/jquery.js"></script>
<script src="<?php echo base_url(); ?>js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>js/moment.min.js"></script>
<script type="text/javascript">
	
	var path;
	

	$(document).ready(function(e) {

        path="<?php echo base_url(); ?>index.php/validacion/consulta_allclientes";
        listar();
        		
		$('#tabla_clientes').on( 'click', 'tr', function () {
	       if ( $(this).hasClass('selected') ) {
	            $(this).removeClass('selected');
	            document.getElementById("btn_detalle").disabled = true;
	            document.getElementById("btn_detalle").style.opacity = "0.5";
	            
	        }
	        else {
	            table.$('tr.selected').removeClass('selected');
	            $(this).addClass('selected');
	            
	            var data = $(this).find("td:eq(0)").text();
	            if (data!="No hay datos disponibles en la tabla") 
	            {
					$("#id_cliente").val(data);
		            document.getElementById("btn_detalle").disabled = false;
		            document.getElementById("btn_detalle").style.opacity = "1";
		           
		        }
	        }
	    } );

    });

	var listar = function()
	{
				table = $('#tabla_clientes').DataTable();
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
						"url":path,
												
					},

					"columns":[
						{"data":"id_cliente"},
						{"render":
							function ( data, type, row ) {
						  		return (row["nombre"] + " " + row["apellido"]) ;        				         					
						  	}
						}						  											
					],
					//select: true,					
					"buttons": [
			            
			        ]
				});
				
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