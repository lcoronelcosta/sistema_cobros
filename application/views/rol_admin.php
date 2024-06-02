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
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/scroller.dataTables.min.css">
    <script src="<?php echo base_url(); ?>js/jquery.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/dataTables.buttons.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>js/dataTables.select.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>js/dataTables.scroller.min.js"></script>	
	<script src="<?php echo base_url(); ?>js/moment.min.js"></script>

	<!-- Toast -->
	<link href="<?php echo base_url(); ?>css/toastify.min.css" rel="stylesheet"/>
    <script src="<?php echo base_url(); ?>js/toastify.min.js" defer></script>

	<link href="<?php echo base_url(); ?>css/popper.css" rel="stylesheet"/>

	<!-- CDN Sweet alert-->
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>	
<body  class="body_alterno">
	<div class="container formulario">
		<div class="row">
			<div class="col-md-6 offset-md-3 myform-cont" >				
				<div class="myform-top">
				    <table style="width: 100%;">
		                	<tr>
		                		<td style="width: 75%;"></td>
		                		<form action="<?= base_url() .'index.php/validacion/cerrar_sesion'?>">
									<td>
										<input align="right" type="image" src="<?= base_url()?>/images/cerrar_sesion_2.png" width="30" height="30">
									</td> 
								</form>
							</tr>
	                </table>
					<div class="myform-topmenu-left">
						<form action="<?= base_url() .'index.php/validacion/crear_prestamo'?>">
							<input type="image" src="<?= base_url()?>/images/credito2.png" width="60" height="60"> 
						</form>
					</div>

					<div class="myform-topmenu-right">
                        <form action="<?= base_url() .'index.php/validacion/crear_cliente'?>">
							<input type="image" src="<?= base_url()?>/images/cliente2.png" width="60" height="60"> 
						</form>
                    </div>
                    <div class="myform-topmenu-left">
						<form action="<?= base_url() .'index.php/validacion/crear_cobrador'?>" method="post" class="">
							<input type="image" src="<?= base_url()?>/images/cobrador.png" width="60" height="60"> 
						</form>
					</div>

					<div class="myform-topmenu-right">
                        <form action="<?= base_url() .'index.php/validacion/menu_reporte'?>" method="post" class="">
							<input type="image" src="<?= base_url()?>/images/reporte2.png" width="60" height="60"> 
						</form>
                    </div>
                </div>
				<div class="myform-bottom2" style="width: 100%">  
				
				<!--<table id="tabla_cobros" class="display" style="width:100%">
					<thead>
						<tr>
							<th>Fecha</th>
							<th>Cliente</th>
							<th>Cuota</th>
							<th>Mora</th>						
							<th>Saldo</th>
							<th>Id</th>
							<th>Opción</th>
							<th></th>
						</tr>
					</thead>
					<tfoot>
						<tr>
							<th>Fecha</th>
							<th>Cliente</th>
							<th>Cuota</th>
							<th>Mora</th>						
							<th>Saldo</th>
							<th>Id</th>
							<th>Opción</th>
							<th></th>
						</tr>
					</tfoot>
				</table>-->

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

	                		<td align="center"><input type="image" id="btn_refresh" name="submit" src="<?= base_url()?>/images/actualizar.png" border="0" alt="Submit" style="width: 25px;" /> </td>	                			
	                </tr>
                    <tr style="height: 15px"></tr>
                	<form action="<?= base_url() .'index.php/validacion/abono'?>" method="post" class="" onsubmit="target_popup(this)">
	                	<tr>                		
	                		<td align="center"><input type="submit" id="btn_abonar" disabled name="btn_abonar"class="btn-sm" style="background-color: #C8216A; opacity: 0.5;color: #FFFFFF;width: 110px;" value="Abonar"/></td>
	                		<td><input type="text" style="display: none;" value="ad" name="id_detalle_credito" id="id_detalle_credito"></td>

	                	</tr>	                
                	</form>

	                
                	
                	</table> 

                </table> 

                <!-- Modal -->
				<div class="modal fade" id="myModal" role="dialog">
				    <div class="modal-dialog modal-m">
				      <div class="modal-content">
				        <div class="modal-header">				          
				          <h6 class="modal-title">Reprogramar</h46>
				        </div>
				        <div class="modal-body">
				        	<table width="100%">
				        		<tr>
				        			<td>Indice:</td>
				        			<td><input type="text" id="id_detalle_cred" /></td>
				        		</tr>
				        		<tr>
				        			<td>Nombre:</td>
				        			<td><input type="text" id="id_nombre" /></td>
				        		</tr>
				        		<tr>
				        			<td>Apellido:</td>
				        			<td><input type="text" id="id_apellido" /></td>
				        		</tr>
				        		<tr>
				        			<td>Valor Cuota:</td>
				        			<td><input type="text" id="id_v_cuota" /></td>
				        		</tr>


			                	<tr >
				                	<td>Próxima Fecha: </td>
				                	<td><input type="date" name="fecha_r"  id="fecha_r" value="<?php echo date("Y-m-d")?>" style="height: 30px;width: 100%;font-size: 13px;">
				                		</td>
									<td>							
										<input type="image" id="guardar" name="guardar" src="<?= base_url()?>/images/guardar.png" width="30" height="30">
									</td>
										
			                	</tr>
                	
				        	</table>

				        </div>
				        <div class="modal-footer">
				          <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
						</div>
				      </div>
				    </div>
				</div>


                    <table class="table-responsive" id="tabla_cobros" width="100%" style="font-family:sans-serif; font-size: 10px;">
						<colgroup>
		       				<col style="width: 10%;">
		       				<col style="width: 40%;">
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
								<th>Opción</th>
								<th></th>
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

<script src="<?php echo base_url(); ?>tether/js/tether.min.js"></script>
<script src="<?php echo base_url(); ?>js/jquery.js"></script>
<script src="<?php echo base_url(); ?>js/bootstrap.min.js"></script>
<script type="text/javascript">
	
	var path;
	var b_rep=0;
	var raw_select=-1;

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
		 	
			document.getElementById("btn_abonar").disabled = true;
	        document.getElementById("btn_abonar").style.opacity = "0.5";
		});

		$("#btn_refresh").click(function(){
			$.when(reload1()).done(function(a1){
				setTimeout(function(){
    			var table = $('#tabla_cobros').DataTable();
				table.row(raw_select).scrollTo();
				}, 2000);
			});			
		});

		// Evita que se deseleccione la fila al dar click en los botones
		$('#tabla_cobros').on('click', '.reprogramar', function(event){
			var fila = $(this).closest('tr'); 
			if (!fila.hasClass('selected')) {
				// Si la fila no está seleccionada, seleccionarla
				$('#tabla_cobros tr').removeClass('selected');
				fila.addClass('selected');
			}else{
				event.stopPropagation();
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
		          id_det_credito: $("#id_detalle_cred").val(),
		          fecha_r: $("#fecha_r").val()
		        },
		        function(data,status){
		            if (data == "1")
		            {
		            	alert("Fecha reprogramada con éxito.");
						document.getElementById("btn_abonar").disabled = true;
	            		document.getElementById("btn_abonar").style.opacity = "0.5";
						cierraPopup();
		            	
		            }
		            else
		            {
		            	alert("La fecha no ha sido reprogramada. Favor intente nuevamente.");
						document.getElementById("btn_abonar").disabled = true;
	            		document.getElementById("btn_abonar").style.opacity = "0.5";
		            }
		        });


		    }

		});
		
		$('#tabla_cobros').on('click', 'button.form', function () 
		{
			var data = table.row( $(this).parents("tr") ).data();
			console.log(data)

			$("#id_detalle_cred").val(data['id_det_credito']);
			$("#id_nombre").val(data['nombre']);
			$("#id_apellido").val(data['apellido']);
			$("#id_v_cuota").val(data['v_cuota']);
			$('#myModal').modal();			
		});


		$('#tabla_cobros').on( 'click', 'tr', function () {

	       if ( $(this).hasClass('selected') ) {
	            $(this).removeClass('selected');
	            document.getElementById("btn_abonar").disabled = true;
	            document.getElementById("btn_abonar").style.opacity = "0.5";
	            b_rep=0;
	            raw_select=-1;
	        }
	        else {
	            table.$('tr.selected').removeClass('selected');
	            $(this).addClass('selected');
	            raw_select=table.row(this).index();
	            var data = $(this).find("td:eq(5)").text();
	            if (data!="No hay datos disponibles en la tabla") 
	            {
					$("#id_detalle_credito").val(data);
		            document.getElementById("btn_abonar").disabled = false;
		            document.getElementById("btn_abonar").style.opacity = "1";
		        }
	        }
	    } );

		// Escucha el evento de búsqueda del DataTable
		$('#tabla_cobros').DataTable().on('search.dt', function() {
			sumarColumna();
		});

		// Llama a la función para calcular la suma al cargar la página
		sumarColumna();

		console.log(path)

		function cierraPopup() {
			$("#myModal").modal('hide');//ocultamos el modal
			$('body').removeClass('modal-open');//eliminamos la clase del body para poder hacer scroll
			$('.modal-backdrop').remove();//eliminamos el backdrop del modal
		}
		


    });

/*	var listar = function (fecha_inicial){
		table = $('#tabla_cobros').DataTable().destroy();

		$('#tabla_cobros').DataTable({
			dom: "Bfrtip",
			rowId: 'id_det_credito',
			responsive: true,
			select: true,
			deferRender: true,
			scrollY: '330px',
			scrollX: true,
			scrollCollapse: true,
			scroller: true,
			animate: true,
			paging: true,

			ajax:{
				"method":"POST",
				"url":path,
				"data" : {"fecha_i": fecha_inicial}						
			},

			columns:[
				{"render":
					function ( data, type, row ) {
						return (moment(String(row["fecha_i"])).format('YYMMDD'))    				         					
					}
				},
				{"data":"nombre_completo"},
				{"data": "cuota_pendiente"},
				{"data": "mora_pendiente"},
				{"data": "saldo_total"},
				{"data":"id_det_credito"},
				{"render":
					function ( data, type, row ) {
						//return (parseFloat(parseFloat(row["totalapagar"]) - parseFloat(row["totalpagado"])).toFixed(2));
						$("#t_cuota").val(row["t_cuota"]);
						return (`
						<div>
							<button class='form btn btn-lg' style='background-color:transparent;'> 
								<div style='text-align:center; color:black;'>
									<i class="fa fa-registered" aria-hidden="true"></i>
								</div>
							</button>
							<button class='btn btn-lg' style='background-color:transparent;' onclick='acuerdoDePago("${row["celular"]}")'> 
								<div style='text-align:center; color:green;'>
									<i class='fa fa-whatsapp'></i>
								</div>
							</button>
						</div>`);
					}
				},
				{"render":
					function ( data, type, row ) {
						//return (parseFloat(parseFloat(row["totalapagar"]) - parseFloat(row["totalpagado"])).toFixed(2));
						return (`
						<details class="dropdown">
							<summary role="button">
								<i class="fa fa-ellipsis-v" aria-hidden="true"></i>
							</summary>
							<ul >
								<li style="font-size:12px; margin-left: 10px" onclick='compartirDetalleCredito("${row["id_det_credito"]}")'>
									<span>
										<a style='color:green;'>
											<i class='fa fa-share-alt'>&emsp;Compartir</i>
										</a>
									<span/>
								</li>
								<li style="font-size:12px">
									<span>
										<a href='tel:${row["celular"]}' style='color:blue;'>
											<i class='fa fa-phone'>&emsp;Llamar</i>
										</a>
									<span/>
								</li>
							</ul>
						</details>
						`);
					}
				}
			],
			"buttons": [
					
					]
		});
	}
*/
	function sumarColumna() {
		var suma = 0;
		$('#tabla_cobros').DataTable().column(4, { search: 'applied' }).data().each(function(value) {
			var cuota = parseFloat(value.replace(/,/g, ""));
			suma += cuota;
		});
		//suma = parseFloat(suma).toFixed(2)
		console.log("La suma de la columna es: " + suma);
		$("#t_cuota").val(suma.toFixed(2));
		// Puedes mostrar la suma donde quieras, por ejemplo, en un elemento HTML
		//$('#sumaColumna').text("La suma de la columna es: " + suma);
	}

	function reload1()
	{
		return $('#tabla_cobros').DataTable().ajax.reload();
	}

    function target_popup(form) {
    	window.open('', 'formpopup', 'width=400,height=400,resizeable,scrollbars');
    	form.target = 'formpopup';
	}


	function actualizar_mora()
	{
	    $.post("<?= base_url() .'index.php/validacion/actualizar_mora'?>",
		        
		 function(data,status){  });
	}

	function acuerdoDePago(celular){
		if(celular == ""){
			Toastify({
				text: 'Error!. Cliente no tiene celular registrado',
				duration: 3000,
				newWindow: true,
				close: true,
				gravity: "top", // `top` or `bottom`
				position: "right", // `left`, `center` or `right`
				stopOnFocus: true, // Prevents dismissing of toast on hover
				style: {
					background: '#CC2906',
				}
			}).showToast();
		}else{
			if(celular.length == 10){
				celular = '593'+celular.substring(1);
			}
			let url = 'https://api.whatsapp.com/send?phone=+'+celular+'&text=*Hola,* hoy le toca su pago';
			//window.open(url, '_blank');
			location.href = url;
		}
	}

	function compartirDetalleCredito(id_det_credito){
		$.post("<?= base_url() .'index.php/validacion/compartirDetalleCredito'?>",
		{
			id_det_credito: id_det_credito,
		},
		function(data,status){
			if(data){
				var resutlData = JSON.parse(data);
				var celular = resutlData.celular;
				if(!resutlData.success){
					Swal.fire({
						icon: "error",
						title: "Oops...",
						text: "Lo sentimos ocurrio un error interno, la cantidad de cuotas de la tabla de amortizacion, no coincide con la cantidad de detalles encontrados en los registros!",
					});
				}else{
					if(celular == ""){
						Toastify({
							text: 'Error!. Cliente no tiene celular registrado',
							duration: 3000,
							newWindow: true,
							close: true,
							gravity: "top", // `top` or `bottom`
							position: "right", // `left`, `center` or `right`
							stopOnFocus: true, // Prevents dismissing of toast on hover
							style: {
								background: '#CC2906',
							}
						}).showToast();
					}else{
						if(celular.length == 10){
							celular = '593'+celular.substring(1);
						}
						var dropdowns = document.querySelectorAll('.dropdown');
						dropdowns.forEach(function(dropdown) {
							dropdown.removeAttribute('open');
						});
						let url = 'https://api.whatsapp.com/send?phone=+'+celular+'&text='+resutlData.data;
						//window.open(url, '_blank');
						location.href = url;
					}
				}
			}
		});
	}

	var listar = function(fecha_i)
	{
				table = $('#tabla_cobros').DataTable();
				table.destroy();
				
				table = $('#tabla_cobros').DataTable({
					"dom": "Bfrtip",
					"rowId": 'id_det_credito',
        			"select": true,
        			'deferRender': true,
					"scrollY": "330px",
        			"scrollCollapse": true,
        			'scroller': true,
        			"animate": true,
					"paging": true,
					scrollX: true,
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

					columns:[
						{"render":
							function ( data, type, row ) {
								return (moment(String(row["fecha_i"])).format('YYMMDD'))    				         					
							}
						},
						{"data":"nombre_completo"},
						{"data": "cuota_pendiente"},
						{"data": "mora_pendiente"},
						{"data": "saldo_total"},
						{"data":"id_det_credito"},
						{"render":
							function ( data, type, row ) {
								//return (parseFloat(parseFloat(row["totalapagar"]) - parseFloat(row["totalpagado"])).toFixed(2));
								return (`
								<div>
									<button class='form btn btn-lg reprogramar' style='background-color:transparent;'> 
										<div style='text-align:center; color:black;'>
											<i class="fa fa-registered" aria-hidden="true"></i>
										</div>
									</button>
									<button class='btn btn-lg' style='background-color:transparent;' onclick='acuerdoDePago("${row["celular"]}")'> 
										<div style='text-align:center; color:green;'>
											<i class='fa fa-whatsapp'></i>
										</div>
									</button>
								</div>`);
							}
						},
						{"render":
							function ( data, type, row ) {
								//return (parseFloat(parseFloat(row["totalapagar"]) - parseFloat(row["totalpagado"])).toFixed(2));
								return (`
								<details class="dropdown">
									<summary role="button">
										<i class="fa fa-ellipsis-v" aria-hidden="true"></i>
									</summary>
									<ul >
										<li style="font-size:12px; margin-left: 10px" onclick='compartirDetalleCredito("${row["id_det_credito"]}")'>
											<span>
												<a style='color:green;'>
													<i class='fa fa-share-alt'>&emsp;Compartir</i>
												</a>
											<span/>
										</li>
										<li style="font-size:12px">
											<span>
												<a href='tel:${row["celular"]}' style='color:blue;'>
													<i class='fa fa-phone'>&emsp;Llamar</i>
												</a>
											<span/>
										</li>
									</ul>
								</details>
								`);
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

</script>
<script src="<?php echo base_url(); ?>tether/js/tether.min.js"></script>
<script src="<?php echo base_url(); ?>js/jquery.js"></script>
<script src="<?php echo base_url(); ?>js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/dataTables.select.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/dataTables.scroller.min.js"></script>
<script src="<?php echo base_url(); ?>js/moment.min.js"></script>
</body>
</html>