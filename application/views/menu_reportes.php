<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('America/Bogota');
?><!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistema de crédito</title>
    
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
	<div class="container formulario">
		<div class="row">
			<div class="col-md-6 offset-md-3 myform-cont" >				
				<div class="myform-top">
					<div class="myform-topmenu-left">
						<form action="<?= base_url() .'index.php/validacion/ingresar_gastos'?>">
							<input type="image" src="<?= base_url()?>/images/gastos.jpg" width="100" height="100"> 
						</form>
					</div>

					<div class="myform-topmenu-right">
                        <form action="<?= base_url() .'index.php/validacion/cuadre_semanal'?>">
							<input type="image" src="<?= base_url()?>/images/cuadre.png" width="100" height="100"> 
						</form>
                    </div>
                    <div class="myform-topmenu-left">
						<form action="<?= base_url() .'index.php/validacion/ingresar_caja'?>" method="post" class="">
							<input type="image" src="<?= base_url()?>/images/base.png" width="100" height="100"> 
						</form>
					</div>

					<div class="myform-topmenu-right">
                        <form action="<?= base_url() .'index.php/validacion/cuadre_caja'?>" method="post" class="">
							<input type="image" src="<?= base_url()?>/images/cuadre_caja.png" width="100" height="100"> 
						</form>
                    </div>
                   <div class="myform-topmenu-right">
                        <form action="<?= base_url() .'index.php/validacion/consultar_abonos'?>" method="post" class="">
							<input type="image" src="<?= base_url()?>/images/abonos.png" width="100" height="100"> 
						</form>
                    </div>
                    <div class="myform-topmenu-left">
                        <form action="<?= base_url() .'index.php/validacion/amortizacion'?>" method="post" class="">
							<input type="image" src="<?= base_url()?>/images/credito6.jpg" width="100" height="100"> 
						</form>
                    </div>
                    
                    <div class="myform-topmenu-left">
                        <form action="<?= base_url() .'index.php/validacion/ganancia'?>" method="post" class="">
							<input type="image" src="<?= base_url()?>/images/ganancia.png" width="100" height="100"> 
						</form>
                    </div>
                    <div class="myform-topmenu-right">
                        <form action="<?= base_url() .'index.php/menu_principal/inicio'?>" method="post" class="">
							<input type="image" src="<?= base_url()?>/images/inicio.png" width="100" height="100"> 
						</form>						
                    </div>
                    <div class="myform-topmenu-left">                    	
                        <form action="<?= base_url() .'index.php/menu_principal/historial'?>" method="post" class="">
							<input type="image" src="<?= base_url()?>/images/historial2.png" width="100" height="100"> 
						</form>
                    </div>
                </div>
				

			</div>
			
		</div>
	</div>

<script src="<?php echo base_url(); ?>tether/js/tether.min.js"></script>
<script src="<?php echo base_url(); ?>js/jquery.js"></script>
<script src="<?php echo base_url(); ?>js/bootstrap.min.js"></script>
<script type="text/javascript">
	
/*
	$(document).ready(function(e) {
        listar($("#fecha_i").val());
        //listar();
        $("#buscar").click(function(){
		   	listar($("#fecha_i").val());
		});

		$('#tabla_cobros').on( 'click', 'tr', function () {
	       if ( $(this).hasClass('selected') ) {
	            $(this).removeClass('selected');
	            document.getElementById("btn_abonar").disabled = true;
	        }
	        else {
	            table.$('tr.selected').removeClass('selected');
	            $(this).addClass('selected');
	            
	            var data = $(this).find("td:eq(0)").text();
	            $("#id_detalle_credito").val(data);
	            document.getElementById("btn_abonar").disabled = false;
	        }
	    } );

    });


		
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
						"url":"<?php echo base_url(); ?>index.php/validacion/consulta_clientes_cobrar",
						"data" : {"fecha_i": fecha_i
								 }						
					},

					"columns":[
						{"data":"id_det_credito"},
						{"render":
							function ( data, type, row ) {
						  		return (row["nombre"] + " " + row["apellido"]) ;        				         					
						  	}
						},
						{"render":
						  	function ( data, type, row ) {
						  		return ("$ " + (row["v_cuota"] - row["abono"]));         					
						  	}
						},						
						{"render":
						  	function ( data, type, row ) {
						  		return 0;
        						//return (fecha + " ( " + tiempo_inicio + " - " + tiempo_final + " ) ");	
         					
						  	}
						},
						{"data":"mora"},
						{"render":
						  	function ( data, type, row ) {
						  		return ("$ " + (row["totalapagar"] - row["totalpagado"]));
        						//return (fecha + " ( " + tiempo_inicio + " - " + tiempo_final + " ) ");	
         					
						  	}
						}						  											
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
*/

</script>
<script src="<?php echo base_url(); ?>tether/js/tether.min.js"></script>
<script src="<?php echo base_url(); ?>js/jquery.js"></script>
<script src="<?php echo base_url(); ?>js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/dataTables.select.min.js"></script>
</body>
</html>