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
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/custom.css">  
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/jquery.dataTables.min.css">
    <script src="<?php echo base_url(); ?>js/jquery.js"></script>	

	<!-- Select2 -->
	<link href="<?php echo base_url(); ?>css/select2.css" rel="stylesheet"/>
    <script src="<?php echo base_url(); ?>js/select2.min.js" defer></script>
	<!-- Select2 -->

	<!-- CDN Sweet alert-->
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

	<!-- Toast -->
	<link href="<?php echo base_url(); ?>css/toastify.min.css" rel="stylesheet"/>
    <script src="<?php echo base_url(); ?>js/toastify.min.js" defer></script>

    <style type="text/css">
    	#cabecera { height: 200px; }
	</style>

 	<script type="text/javascript">

 		$detalle_credito="";
 		var b_rep=0;

		$(document).ready(function(e) {
		
			$("#otros_plazos").click(function(){
				
				rep = document.getElementById("numero_dias");	
				rep1 = document.getElementById("plazo");
							
				if (b_rep==0) 
				{
					rep.style.display='table-row';
					rep1.disabled=true;					
					b_rep=1
				}
				else
				{
					rep.style.display='none';
					rep1.disabled=false;
					b_rep=0
				}
			});

			//Select 2
  			$(".select2").select2();

	    });

 		function cambiar(){
		    var pdrs = document.getElementById('user_file').files[0].name;
		    document.getElementById('info').innerHTML = pdrs;
		}

 		function numeros(e){
		    key = e.keyCode || e.which;
		    tecla = String.fromCharCode(key).toLowerCase();
		    numero = "0123456789";
		    especiales = [46];
		 
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
	        $("#valor").val('');
	        $("#totalapagar").val('');
	        $("#fecha_i").val(moment(new Date()).format('YYYY-MM-DD'));
	        $("#fecha_f").val(moment(new Date()).format('YYYY-MM-DD'));
	        $("#tabla_amortizacion_tmp tr").remove();
	        document.getElementById("cabecera").style.display='none';
	        document.getElementById("btn_calcular").style.display='block';
		    document.getElementById("btn_guardar").style.display='none';
			$("#btn_compartir").prop("disabled", true);
		    document.getElementById("seleccionar").selected = true;  
	    }

	    function calcular()
	    {
			if ($("#valor").val()!="" && $("#tasa").val()!="" && $("#plazo").val()!="" && $("#fecha_i").val()!="")
			{
				forma_pago = $("#formadepago").val();
				if (forma_pago == "Seleccionar")
				{
					alert("Debe seleccionar la forma de pago del préstamo.");
					return 0;
				}

				if ((b_rep==1) && $("#n_dias").val()=="")
				{
					alert("Eligió otros plazos, debe ubicar el numero de dias para el crédito.");
					return 0;
				}

				//Elimino los valores de tabla para el nuevo cálculo

				$("#tabla_amortizacion_tmp tr").remove();

				if (forma_pago == "Diario")
				{
					if (b_rep==1)
					{
						calcular_totalapagar($("#valor").val(),$("#tasa").val(),$("#plazo").val());
						var datos = calcular_diario($("#valor").val(),$("#tasa").val(),$("#n_dias").val(),$("#fecha_i").val(),$("#totalapagar").val());

						tabla_amortizacion(datos);
						$detalle_credito = datos;
						document.getElementById("btn_guardar").style.display='block';
						return 0;
							
					}

					if (($("#plazo").val() == "30") || ($("#plazo").val() == "45"))
					{
						calcular_totalapagar($("#valor").val(),$("#tasa").val(),$("#plazo").val());
						
						var datos = calcular_diario($("#valor").val(),$("#tasa").val(),$("#plazo").val(),$("#fecha_i").val(),$("#totalapagar").val());

						tabla_amortizacion(datos);
						$detalle_credito = datos;
						document.getElementById("btn_guardar").style.display='block';
					} 
					else
					{
						alert("La forma de pago no es válida para 60 días.");
						return 0;		
					}
				}

				if (forma_pago == "Semanal")
				{
					if (b_rep==1)
					{
						
						if (parseInt($("#n_dias").val())<7)
						{
							alert("No se puede escoger esa forma de pago, numero de dias insuficientes.");
							
						}
						else
						{
							calcular_totalapagar($("#valor").val(),$("#tasa").val(),$("#plazo").val());
							var datos = calcular_semanal($("#valor").val(),$("#tasa").val(),$("#n_dias").val(),$("#fecha_i").val(),$("#totalapagar").val());
							tabla_amortizacion(datos);
							$detalle_credito = datos;
							document.getElementById("btn_guardar").style.display='block';
							
						}
						
						return 0;
							
					}

					if (($("#plazo").val() == "30") || ($("#plazo").val() == "45") || ($("#plazo").val() == "60"))
					{
						calcular_totalapagar($("#valor").val(),$("#tasa").val(),$("#plazo").val());
						var datos = calcular_semanal($("#valor").val(),$("#tasa").val(),$("#plazo").val(),$("#fecha_i").val(),$("#totalapagar").val());
						tabla_amortizacion(datos);
						$detalle_credito = datos;
						document.getElementById("btn_guardar").style.display='block';
					} 
					else
					{
						alert("La forma de pago no es válida.");
						return 0;		
					}
				}

				if (forma_pago == "Quincenal")
				{
					
					if (b_rep==1)
					{
						
						if (parseInt($("#n_dias").val())<15)
						{
							alert("No se puede escoger esa forma de pago, numero de dias insuficientes.");

						}
						else
						{
							calcular_totalapagar($("#valor").val(),$("#tasa").val(),$("#plazo").val());
							var datos = calcular_quincenal($("#valor").val(),$("#tasa").val(),$("#n_dias").val(),$("#fecha_i").val(),$("#totalapagar").val());
							tabla_amortizacion(datos);
							$detalle_credito = datos;
							document.getElementById("btn_guardar").style.display='block';

						}
						return 0;
					}


					if (($("#plazo").val() == "30") || ($("#plazo").val() == "45") || ($("#plazo").val() == "60"))
					{
						calcular_totalapagar($("#valor").val(),$("#tasa").val(),$("#plazo").val());
						var datos = calcular_quincenal($("#valor").val(),$("#tasa").val(),$("#plazo").val(),$("#fecha_i").val(),$("#totalapagar").val());
						tabla_amortizacion(datos);
						$detalle_credito = datos;
						document.getElementById("btn_guardar").style.display='block';
					} 
					else
					{
						alert("La forma de pago no es válida.");
						return 0;		
					}
				}

				if (forma_pago == "Mensual")
				{

					if (b_rep==1)
					{
						
						if (parseInt($("#n_dias").val())<30)
						{
							alert("No se puede escoger esa forma de pago, numero de dias insuficientes.");

						}
						else
						{
							calcular_totalapagar($("#valor").val(),$("#tasa").val(),$("#plazo").val());
							var datos = calcular_mensual($("#valor").val(),$("#tasa").val(),$("#n_dias").val(),$("#fecha_i").val(),$("#totalapagar").val());
							tabla_amortizacion(datos);
							$detalle_credito = datos;
							document.getElementById("btn_guardar").style.display='block';
						}
						return 0;
					}


					if (($("#plazo").val() == "30") || ($("#plazo").val() == "45") || ($("#plazo").val() == "60"))
					{
						calcular_totalapagar($("#valor").val(),$("#tasa").val(),$("#plazo").val());
						var datos = calcular_mensual($("#valor").val(),$("#tasa").val(),$("#plazo").val(),$("#fecha_i").val(),$("#totalapagar").val());
						tabla_amortizacion(datos);
						$detalle_credito = datos;
						document.getElementById("btn_guardar").style.display='block';
					} 
					else
					{
						alert("La forma de pago no es válida.");
						return 0;		
					}
				}

	    	}else
	    	{				    
				alert("Faltan datos. Verifique.");
			}
	    }

	    function calcular_diario($valor_t,$tasa_t,$plazo_t,$fecha_i_t,$total_pagar_t)
	    {
	    	var data  = [];
			var objeto = {};

			if (b_rep==0)
			{
		    	if ($plazo_t == 45)
				{
					$plazo_t = 40;
				}
			}

			$i = 1;
			//Obtener un formato tipo YYYY/MM/DD, evitando el error de DATE de un dia menos
			var mod_date = new Date($fecha_i_t.replace(/-/g, '\/'));
			$valor_c = parseFloat($total_pagar_t/$plazo_t).toFixed(2);
			$ultima_cuota = parseFloat($total_pagar_t - ($valor_c * ($plazo_t-1))).toFixed(2); 

			while ($i <= $plazo_t)
			{
				//Incrementar un dia
				var dias = 1;
				if ($i == $plazo_t)
				{
					$valor_c = $ultima_cuota
				}

				
				//Obtengo el dia Domingo = 6
				$date_t = mod_date.getDay(); 
				if ($date_t == 6) 
				{				   	
				   	//Incrementa dos dias en caso de que sea un domingo
				   	dias = 2;				   	
				}
				//Creo la arquitectura tipo JSON
				data.push({
					"cuota"	: $i,
					"fecha"	: moment(mod_date.setDate(mod_date.getDate() + dias)).format('YYYY-MM-DD'),
					"valor"	: $valor_c
				});



				$i++;
			}
	        return data;
	    }


	    function calcular_semanal($valor_t,$tasa_t,$plazo_t,$fecha_i_t,$total_pagar_t)
	    {
	    	var data  = [];
			var objeto = {};

			$n_cuota = $plazo_t / 7;
			$n_cuota = Math.floor($n_cuota);
			
			$i = 1;
			//Obtener un formato tipo YYYY/MM/DD, evitando el error de DATE de un dia menos
			var mod_date = new Date($fecha_i_t.replace(/-/g, '\/'));
			$valor_c = Math.round($total_pagar_t/$n_cuota);
			$ultima_cuota = $total_pagar_t - ($valor_c * ($n_cuota-1)); 

			mod_date.setDate(mod_date.getDate() + 1);
			$band = 0;

			while ($i <= $n_cuota)
			{
				//Incrementar un dia
				var dias = 7;
				
				if ($i == $n_cuota)
				{
					$valor_c = $ultima_cuota;
				}
				//Obtengo el dia Domingo = 6
				$date_t = mod_date.getDay();
				if ($date_t == 0) 
				{				   	
				   	//Incrementa dos dias en caso de que sea un domingo
				   	dias = 8;
				   	$band = 1;				   	
				}
				//Creo la arquitectura tipo JSON
				data.push({
					"cuota"	: $i,
					"fecha"	: moment(mod_date.setDate(mod_date.getDate() + dias)).format('YYYY-MM-DD'),
					"valor"	: $valor_c
				});

				if ($band == 1)
				{
					$band = 0;
					mod_date.setDate(mod_date.getDate() - 1);
				}

				$i++;
			}
	        
	        return data;
	    }

	    function calcular_quincenal($valor_t,$tasa_t,$plazo_t,$fecha_i_t,$total_pagar_t)
	    {
	    	var data  = [];
			var objeto = {};

			$n_cuota = $plazo_t / 15;
			$n_cuota = Math.floor($n_cuota);
			
			$i = 1;
			//Obtener un formato tipo YYYY/MM/DD, evitando el error de DATE de un dia menos
			var fecha_original = new Date($fecha_i_t.replace(/-/g, '\/'));
			var mod_date = new Date($fecha_i_t.replace(/-/g, '\/'));
			
			$valor_c = Math.round($total_pagar_t/$n_cuota);
			$ultima_cuota = $total_pagar_t - ($valor_c * ($n_cuota-1)); 
			
			//mod_date.setDate(mod_date.getDate() + 1);
			$band = 0;
			$is_mes = 0;

			while ($i <= $n_cuota)
			{				
				if ($i == $n_cuota)
				{
					if ($plazo_t==30) 
					{
						//Incrementando 1 mes
						var dias_mes = 1;
						$is_mes = 1;					
					}
					else
					{
						if ($plazo_t==60) 
						{
							//Incrementando 2 meses
							var dias_mes = 2;
							$is_mes = 1;
						}
						else
						{
							//Incrementando 15 dia
							var dias_mes = 15;
							$is_mes = 0;
						}
					}

					$valor_c = $ultima_cuota;	
				}
				else	
				{
					//Incrementando 15 dia
					var dias_mes = 15;
					$is_mes = 0;
				}


				if ($is_mes == 0)
				{ 
					$f = moment(mod_date.setDate(mod_date.getDate() + dias_mes)).format('YYYY-MM-DD');
				}
				else
				{ $f = moment(fecha_original.setMonth(fecha_original.getMonth() + dias_mes)).format('YYYY-MM-DD');
				}

				//Obtengo el dia Domingo = 0
				var f_tmp = moment($f);
				var date_t = moment($f).day();
				
				if (date_t == 0) 
				{				   	
				   	//Incrementa un dia en caso de que sea un domingo
				   	var dias_mes = 1;
				   	f_tmp = f_tmp.add(1,'days');
				   	$f = f_tmp.format('YYYY-MM-DD');
				   	
				   	$band = 1;				   	
				}
				//Creo la arquitectura tipo JSON

				data.push({
					"cuota"	: $i,
					"fecha"	: $f,
					"valor"	: $valor_c
				});

				if ($band == 1)
				{
					$band = 0;
					mod_date.setDate(mod_date.getDate() - 1);
				}

				$i++;
			}
	        
	        return data;
	    }

	    function calcular_mensual($valor_t,$tasa_t,$plazo_t,$fecha_i_t,$total_pagar_t)
	    {
	    	var data  = [];
			var objeto = {};

			if ($plazo_t == 45) 
			{
				alert("Forma de pago No válida.");
				return 0;
			}

			$n_cuota = $plazo_t / 30;
			$n_cuota = Math.floor($n_cuota);
			
			$i = 1;
			//Obtener un formato tipo YYYY/MM/DD, evitando el error de DATE de un dia menos
			//var fecha_original = new Date($fecha_i_t.replace(/-/g, '\/'));
			var mod_date = new Date($fecha_i_t.replace(/-/g, '\/'));
			var mod_date_tmp;

			$valor_c = Math.round($total_pagar_t/$n_cuota);
			$ultima_cuota = $total_pagar_t - ($valor_c * ($n_cuota-1)); 

			$is_mes = 0;
			dia_tmp = mod_date.getDate();
			mes_tmp = mod_date.getMonth()+1;
			anio_tmp = mod_date.getFullYear();

			while ($i <= $n_cuota)
			{	
				var dias_mes = 1;
				
				if ($i == $n_cuota)
				{
					$valor_c = $ultima_cuota;
				}
				//Se verifica que haya escogido el mes de diciembre para el crédito
				//porque hay que validar el mes de febrero para que salgan bein las fechas
				if (mes_tmp == 12 && (dia_tmp>28 && dia_tmp<31))
				{
						var mod_date_tmp = new Date(mod_date.getFullYear(),mod_date.getMonth()+ $i,mod_date.getDate());
						mes_tmp = 1;
				}
				else
				{
					if (mes_tmp == 1 && (dia_tmp>28 && dia_tmp<31))
					{
							var mod_date_tmp = new Date(mod_date.getFullYear(),mod_date.getMonth()+ ($i+1),0);
							mes_tmp = 2;
					}
					else
					{
						//**************************************************************************************
						//Si es fecha con 31, entonces se considera que los demás meses serán fin de mes siempre
						//**************************************************************************************
						if (dia_tmp == 31)
						{	
							var mod_date_tmp = new Date(mod_date.getFullYear(),mod_date.getMonth()+ ($i+1),0);
						}
						else
						{	
							var mod_date_tmp = new Date(mod_date.getFullYear(),mod_date.getMonth()+ $i,mod_date.getDate());
						}
					}
				}

				$f = moment(mod_date_tmp).format('YYYY-MM-DD');

				//Obtengo el dia Domingo = 6
				var f_tmp = new Date($f);
				$date_t = f_tmp.getDay();
				if ($date_t == 6) 
				{				   	
				   	//Incrementa un dia en caso de que sea un domingo
				   	$f = moment(mod_date_tmp.setDate(mod_date_tmp.getDate() + 1)).format('YYYY-MM-DD');
				}

				//Creo la arquitectura tipo JSON
				data.push({
					"cuota"	: $i,
					"fecha"	: $f,
					"valor"	: $valor_c
				});

				$i++;
			}
	        
	        return data;
	    }

	    function tabla_amortizacion(datos)
	    {
	    				
			var d ='';
			var data_whatsapp = '*DETALLE*'+'%0A';
			$("#data_whatsapp").val('');
			for (var i = 0; i < datos.length; i++) {
				 //Cambio el formato de fecha dd-mm-yyyy
				 fecha_conc = datos[i].fecha.substring(8,10) + datos[i].fecha.substring(4,8) + datos[i].fecha.substring(0,4);
				 d+= '<tr width="100%">'+
				 '<td width="20%" style="text-align:center;">'+datos[i].cuota+'</td>'+
				 '<td width="50%" style="text-align:center;">'+fecha_conc+'</td>'+
				 '<td width="30%" style="text-align:center;">$ '+datos[i].valor+'</td>'+
				 '</tr>';

				 data_whatsapp += '*Pago'+datos[i].cuota+'*'+'%0A' +
				 '*Fecha*:' + fecha_conc +'%0A' +
				 '*Valor*: $' + datos[i].valor +'%0A';

				 //Actualizo la fecha final con la ultima cuota
				 if (i == datos.length - 1)
				 {
				 	$('#fecha_f').val(datos[i].fecha);
				 } 
			 }

			$("#tabla_amortizacion_tmp").append(d);
			document.getElementById("cabecera").style.display='block';
			$("#data_whatsapp_detalle").val(data_whatsapp);

	    }

	    function prueba()
	    {
	    	var valores = [];
	    	var datosResult= '';
	    	var rows = $("#tabla_amortizacion").dataTable().fnGetData();
	    	//$('#fecha_f').val(rows[rows.length - 1].fecha);	
	    	var fecha_tmp = rows[rows.length - 1].fecha;
	    	$('#fecha_f').val(fecha_tmp.substring(6,10) + fecha_tmp.substring(2,6) + fecha_tmp.substring(0,2));
	    }

	    function calcular_totalapagar ($valor_t, $tasa_t, $plazo_t)
	    {
			$('#data_whatsapp_cabecera').val('');
			($("#valor").val(),$("#tasa").val(),$("#plazo").val())
	    	$totalapagar_t = parseInt($valor_t) + parseInt($valor_t * $tasa_t/100)
	    	$('#totalapagar').val($totalapagar_t);
	    	$('#interes').val(parseInt($valor_t * $tasa_t/100));
			 var data_whatsapp_cabecera = 
				'*Credito*: $' + $("#valor").val() + '%0A' +
				'*Tipo Pago*: ' + $("#formadepago").val() + '%0A' + 
				'*Tasa interes*: ' + $("#tasa").val() + '%' + '%0A' +
				'*Interes*: $' + $("#interes").val() + '%0A' +
				'*Total Pagar*: $' + $totalapagar_t;
			$('#data_whatsapp_cabecera').val(data_whatsapp_cabecera);
	    }
		


	    function guardar()
		{
			
		    if ($("#formadepago").val() == "Diario")
		    {
		    	$forma = 1; 
		    }
		    if ($("#formadepago").val() == "Semanal")
		    {
		        $forma = 2; 
		    }    
		    if ($("#formadepago").val() == "Quincenal")
		    {
		       	$forma = 3; 
		    }    
		    if ($("#formadepago").val() == "Mensual")
		    {
		       	$forma = 4; 
		    }        

		    var formData = new FormData();
		    var id_cliente = document.getElementById("cliente").value;
            //alert(id_cliente + "-" + $("#motivo").val() + "-" + $("#valor").val() + "-" + $("#tasa").val() + "-" + $("#plazo").val() + "-" + $forma + "-" + $("#fecha_i").val() + "-" + $("#fecha_f").val() + "-" + $("#interes").val() + "-" + $("#totalapagar").val() + "- 0 -" + "pendiente");
            
		    
		    
		    //formData.append("id_cliente",$("#id_cliente").val());
		    formData.append("id_cliente",id_cliente);
			formData.append("valor",$("#valor").val());
			formData.append("tasa",$("#tasa").val());
			formData.append("plazo", (b_rep==1) ? $("#n_dias").val() : $("#plazo").val());
			formData.append("formadepago",$forma);
			formData.append("fecha_i",$("#fecha_i").val());
			formData.append("fecha_f",$("#fecha_f").val());
			formData.append("interes",$("#interes").val());
			formData.append("totalapagar",$("#totalapagar").val());	
			formData.append("mora",0);
			formData.append("estado","pendiente");
			formData.append("motivo",$("#motivo").val());
			var credito = {};
			credito.detalle = $detalle_credito;
			formData.append("detalle",JSON.stringify(credito));	
				

			$.ajax({
				url:"<?php echo base_url(); ?>index.php/validacion/guardar_credito",
				type:'POST',						
				data: formData,
				cache: false,
	    		contentType: false,
	    		processData: false,
	    		async:false,
				success:function(result)
				{
					Swal.fire({
						title: "Excelente!",
						text: "Credito guardado correctamente!",
						icon: "success",
					});
					$("#btn_compartir").prop("disabled", false);
					document.getElementById("btn_guardar").style.display='none';
					document.getElementById("btn_calcular").style.display='none';
					//limpiar();
				},
				error:function(xhr, status, error)
				{
					alert("Error al grabar el crédito. Favor intentar de nuevo.");	
					//alert(xhr.responseText);
					//alert(error.responseText);
				}					
			});				
		}

		/**Obtener numero de celular */
		function obtenerCelular(el){ // recibimos por parametro el elemento select
			var celular = $('option:selected', el).attr('atr_celular');
			var mensaje = (celular != "") 
				? 'Perfecto!. Cliente si tiene celular registrado' 
				: 'Error!. Cliente no tiene celular registrado';
			var background = (celular != "") ? '#06AC0E' : '#CC2906';
			Toastify({
				text: mensaje,
				duration: 3000,
				newWindow: true,
				close: true,
				gravity: "top", // `top` or `bottom`
				position: "right", // `left`, `center` or `right`
				stopOnFocus: true, // Prevents dismissing of toast on hover
				style: {
					background: background,
				}
			}).showToast();
		}

		/**Funcion compartir el detalle de saldos por wahatsapp */
		function compartir(){
			var celular = $( "#cliente option:selected" ).attr('atr_celular');
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
				var cabecera = $("#data_whatsapp_cabecera").val();
				var detalle = $("#data_whatsapp_detalle").val();
				let url = 'https://api.whatsapp.com/send?phone=+'+celular+'&text='+detalle;
				window.open(url, '_blank');
				//location.href = url;
			}
		}

	</script>

</head>

<body  class="body_alterno">
	<div class="container">
		<div class="row">
			<div class="col-md-6 offset-md-3 myform-cont" >				
				<div class="myform-top">
					<strong align="left">Registro de Crédito</strong>
				</div>					

				<div class="myform-bottom">
                   	<table width="100%"> 	
						<tr>
							<td>Cliente: </td> 
							<td>
								<select class="select2" name="cliente" id="cliente" style="width: 100%;" onchange="obtenerCelular(this);">
								<?php
									foreach($clientes as $fila)
										 {
										 ?>
										 <option atr_celular="<?=$fila->celular?>" id="<?=$fila->id_cliente?>" value="<?=$fila->id_cliente?>"><?=$fila->nombre?> <?=$fila->apellido?></option>
										 <?php
										 }
										?> 
								</select>
							</td>
							
						</tr>
						<tr>
							<td> Motivo: </td>
							<td><input type="text" readonly="true" id="motivo" value="Venta de Producto" name="motivo" required maxlength="100"style="height: 30px;width: 100%;font-size: 12px;border-color:gray;border-width:thin;line-height: 20px" /></td>
						</tr>
						<tr>
							<td>Valor: </td>
							<td><input type="number" id="valor" name="valor" required maxlength="10" onkeypress="return numeros(event)" style="height: 30px;width: 30%;text-align:center; font-size: 14px;border-color:gray;border-width:thin;line-height: 20px" /></td>
						</tr>
						<tr>
							<td>Tasa: </td>
							<td><input type="number" id="tasa" name="tasa" value="20" required maxlength="10" onkeypress="return numeros(event)" style="height: 30px;width: 30%;font-size: 14px;text-align:center; border-color:gray;border-width:thin;line-height: 20px" />%</td>
						</tr>
						<tr>
							<td>Plazo: </td>
							<td>
								<select id="plazo" name="plazo" style="text-align-last:center;height: 30px;width: 30%;font-size: 13px;">
							 		<option value="30">30</option>
									<option value="45">45</option>
									<option value="60">60</option>							
								</select>
								días
								<input type="submit" id="otros_plazos" name="otros_plazos"class="btn-sm" style="background-color: #C8216A; opacity: 0. ;color: #FFFFFF;width: 110px;" value="Otros plazos" />
							</td>
														
						</tr>

	                	<tr id="numero_dias" style="display: none; width: 100%">
		                	<td>Número de días: </td>
		                	<td>
		                		<input type="number" id="n_dias" name="n_dias" required maxlength="10" onkeypress="return numeros(event)" style="height: 30px;width: 30%;font-size: 14px;text-align:center; border-color:gray;border-width:thin;line-height: 20px" /></td>
		                </tr>
	                	
						<tr>
							<td>Forma de pago: </td>
							<td>
								<select id="formadepago" name="formadepago" style="height: 30px;width: 100%;font-size: 13px;">
									<option id="seleccionar" value="Seleccionar">Seleccionar</option>
									<option value="Diario">Diario</option>
									<option value="Semanal">Semanal</option>
									<option value="Quincenal">Quincenal</option>
									<option value="Mensual">Mensual</option>	  
								</select>
							</td>
						</tr>						
						<tr>	 	 	
						 	<td>Fecha Inicio</td>
						 	<td><input type="date" name="fecha_i"  id="fecha_i" value="<?php echo date("Y-m-d")?>" style="height: 30px;width: 100%;font-size: 13px;">	 		
						 	</td>	 	
						</tr>
						<tr>
							<td>Fecha Fin</td>
							<td><input type="date" name="fecha_f" readonly="true" id="fecha_f" value="<?php echo date("Y-m-d")?>" style="height: 30px;width: 100%;font-size: 13px;">	 		
						 	</td>
		 				</tr>
						<tr>
							<td>Total a pagar: </td>
							<td>
								<input type="text" readonly="true" id="interes" name="interes" required maxlength="45" onkeypress="return letras(event)" style="display: none" />
								<input type="text" readonly="true" id="totalapagar" name="totalapagar" required maxlength="45" onkeypress="return letras(event)" style="height: 30px;width: 100%;font-size: 12px;border-color:gray;border-width:thin;line-height: 20px" /></td>
						</tr>
						
					</table>
					<br>
					<table id="cabecera_tmp" width="100%" style="font-family:sans-serif; font-size: 13px;">
						<th width="20%" style="color:#FFFFFF; background-color: #2E86C1;text-align: center;"># Cuota</th>
						<th width="50%" style="color:#FFFFFF; background-color: #2E86C1;text-align: center;">Fecha</th>
						<th width="30%" style="color:#FFFFFF; background-color: #2E86C1;text-align: center;">Valor</th>
					</table>

					<div class="table-responsive" id="cabecera" style="display: none;">		    
						<table id="tabla_amortizacion_tmp" width="100%" style="font-family:sans-serif; font-size: 13px;">
					
						</table>
					</div>
					
					<table width="100%">
							 <tr style="height: 15px"></tr>
							 <tr>
							 	<td><input type="submit" id="btn_calcular" name="btn_calcular" class="btn-sm" style="background-color: #C8216A;color: #FFFFFF;width: 100%;display: block;" value="Calcular" onclick="calcular()"/></td>
							 						 	 	
							 	<td><input type="submit" id="btn_guardar" name="btn_guardar"class="btn-sm" style="background-color: #C8216A;color: #FFFFFF;width: 100%;display: none;" value="Guardar" onclick="guardar()"/></td>
							 	
							 </tr>
							 <tr style="height: 15px"></tr>
							 <tr>	 	
								<td><input type="submit" id="btn_limpiar" name="btn_limpiar"class="btn-sm" style="background-color: #C8216A;color: #FFFFFF;width: 100%;" value="Limpiar" onclick="limpiar()"/></td>
	     						<form action="<?= base_url() .'index.php/menu_principal/inicio'?>" method="post" class="">		
									<td><input type="submit" id="btn_regresar" name="btn_regresar"class="btn-sm" style="width: 100%;background-color: #C8216A;color: #FFFFFF;" value="Regresar" onclick="regresar()"/></td>
								</form>
     						</tr>
							<tr style="height: 15px"></tr>
							<tr>
								<td><input type="submit" id="btn_compartir" name="btn_guardar"class="btn btn-success btn-sm" disabled style="width: 100%; margin-left:50%" value="Compartir" onclick="compartir()"/></td>
							</tr>
					</table>
                </div>
			</div>
			
		</div>
	</div>
	<input type="hidden" name="data_whatsapp_cabecera" id="data_whatsapp_cabecera" value="">
	<input type="hidden" name="data_whatsapp_detalle" id="data_whatsapp_detalle" value="">

<script src="<?php echo base_url(); ?>tether/js/tether.min.js"></script>
<script src="<?php echo base_url(); ?>js/jquery.js"></script>
<script src="<?php echo base_url(); ?>js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>js/moment.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.dataTables.min.js"></script>
</body>
</html>