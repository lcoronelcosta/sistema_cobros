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

    <style type="text/css">
    	#cabecera { height: 200px; }
	</style>

 	<script type="text/javascript">

 		$detalle_credito="";

 		$(document).ready(function(){
		    $("#buscar").click(function(){
		        $.post("<?= base_url() .'index.php/validacion/busqueda_cliente'?>",
		        {
		          cedula: $("#cedula").val()
		        },
		        function(data,status){
		            if (data == "")
		            {
		            	alert("Cliente no válido.");
						document.getElementById("btn_calcular").style.display='none';
		            	document.getElementById("btn_guardar").style.display='none';
		            }
		            else
		            {
		            	$("#id_cliente").val(data.substring(0,data.indexOf(";")));
		            	$("#nombre").val(data.substring(data.indexOf(";")+1,data.length));

		            	document.getElementById("btn_calcular").style.display='block';
		            	document.getElementById("btn_guardar").style.display='block';
		            	document.getElementById("cedula").readOnly=true;
		            }
		        });
		    });
		});

 		
		function cierra_ventana(){
			window.close();
		}
		
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
	        $('#cedula').val('');
	        $("#nombre").val('');
	        $("#valor").val('');
	        $("#totalapagar").val('');
	        $("#fecha_i").val(moment(new Date()).format('YYYY-MM-DD'));
	        $("#fecha_f").val(moment(new Date()).format('YYYY-MM-DD'));
	        $("#tabla_amortizacion_tmp tr").remove();
	        document.getElementById("cabecera").style.display='none';
	        document.getElementById("btn_calcular").style.display='none';
		    document.getElementById("btn_guardar").style.display='none';
		    document.getElementById("cedula").readOnly=false;   
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

				//Elimino los valores de tabla para el nuevo cálculo

				$("#tabla_amortizacion_tmp tr").remove();

				if (forma_pago == "Diario")
				{
					if (($("#plazo").val() == "30") || ($("#plazo").val() == "45"))
					{
						calcular_totalapagar($("#valor").val(),$("#tasa").val(),$("#plazo").val());
						
						var datos = calcular_diario($("#valor").val(),$("#tasa").val(),$("#plazo").val(),$("#fecha_i").val(),$("#totalapagar").val());

						tabla_amortizacion(datos);
						$detalle_credito = datos;

					} 
					else
					{
						alert("La forma de pago no es válida para 60 días.");
						return 0;		
					}
				}

				if (forma_pago == "Semanal")
				{
					if (($("#plazo").val() == "30") || ($("#plazo").val() == "45") || ($("#plazo").val() == "60"))
					{
						calcular_totalapagar($("#valor").val(),$("#tasa").val(),$("#plazo").val());
						var datos = calcular_semanal($("#valor").val(),$("#tasa").val(),$("#plazo").val(),$("#fecha_i").val(),$("#totalapagar").val());
						tabla_amortizacion(datos);
						$detalle_credito = datos;

					} 
					else
					{
						alert("La forma de pago no es válida.");
						return 0;		
					}
				}

				if (forma_pago == "Quincenal")
				{
					if (($("#plazo").val() == "30") || ($("#plazo").val() == "45") || ($("#plazo").val() == "60"))
					{
						calcular_totalapagar($("#valor").val(),$("#tasa").val(),$("#plazo").val());
						var datos = calcular_quincenal($("#valor").val(),$("#tasa").val(),$("#plazo").val(),$("#fecha_i").val(),$("#totalapagar").val());
						tabla_amortizacion(datos);
						$detalle_credito = datos;

					} 
					else
					{
						alert("La forma de pago no es válida.");
						return 0;		
					}
				}

				if (forma_pago == "Mensual")
				{
					if (($("#plazo").val() == "30") || ($("#plazo").val() == "45") || ($("#plazo").val() == "60"))
					{
						calcular_totalapagar($("#valor").val(),$("#tasa").val(),$("#plazo").val());
						var datos = calcular_mensual($("#valor").val(),$("#tasa").val(),$("#plazo").val(),$("#fecha_i").val(),$("#totalapagar").val());
						tabla_amortizacion(datos);
						$detalle_credito = datos;

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


	    function tabla_amortizacion(datos)
	    {
	    				
			var d ='';
			for (var i = 0; i < datos.length; i++) {
				 //Cambio el formato de fecha dd-mm-yyyy
				 fecha_conc = datos[i].fecha.substring(8,10) + datos[i].fecha.substring(4,8) + datos[i].fecha.substring(0,4);
				 d+= '<tr width="100%">'+
				 '<td width="20%" style="text-align:center;">'+datos[i].cuota+'</td>'+
				 '<td width="50%" style="text-align:center;">'+fecha_conc+'</td>'+
				 '<td width="30%" style="text-align:center;">$ '+datos[i].valor+'</td>'+
				 '</tr>';

				 //Actualizo la fecha final con la ultima cuota
				 if (i == datos.length - 1)
				 {
				 	$('#fecha_f').val(datos[i].fecha);
				 }
			 }

			$("#tabla_amortizacion_tmp").append(d);
			document.getElementById("cabecera").style.display='block';

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
	    	$totalapagar_t = parseInt($valor_t) + parseInt($valor_t * $tasa_t/100)
	    	$('#totalapagar').val($totalapagar_t);
	    	$('#interes').val(parseInt($valor_t * $tasa_t/100));
	    }
		


	    function guardar()
		{
		    if (confirm("Esta seguro que desea abonar: $"+$('#abono').val()+" al crédito?"))
			{      
    		    if ($('#abono').val() == "")
    		    {
    		    	alert("Debe ingresar el valor del Abono.");
    		    	return 0;
    		    }
    
    		    check = document.getElementById("liquidar");
    		    $chequeado="";
    		    if (check.checked)
    		    {
    		    	$chequeado = "true";
    		    }
    		    else
    		    {
    		    	$chequeado = "false";
    		    }
    		    
    		    document.getElementById("btn_guardar").style.display='none';
    		    var formData = new FormData();
    		            
    		    formData.append("id_cab_credito",$("#id_cab_credito").val());
    		    formData.append("id_det_credito",$("#id_det_credito").val());
    		    formData.append("valor_abono",$("#abono").val());
    		    formData.append("liquidar",$chequeado);
				formData.append("edit",false);
    
    			$.ajax({
    				url:"<?php echo base_url(); ?>index.php/validacion/abonar_al_credito",
    				type:'POST',						
    				data: formData,
    				cache: false,
    	    		contentType: false,
    	    		processData: false,
    	    		async:false,
    				success:function(result)
    				{					
    					alert("Abono ingresado correctamente.");
    					cierra_ventana();
    					
    				},
    				error:function(result)
    				{					
    					alert("Error al grabar el abono. Favor intentar de nuevo.");
    					cierra_ventana();	
    				}					
    			});	
			}
			else
			{
				cierra_ventana();
			}
		}
	</script>

</head>

<body  class="body_alterno">
	<div class="container">
		<div class="row">
			<div class="col-md-6 offset-md-3 myform-cont" >				
				<div class="myform-top">
					<strong align="left">Registro de Abono</strong>
				</div>					

				<div class="myform-bottom">
                   	<table width="100%"> 	
						<tr>
							<td> Cédula: </td>
							<td><input type="text" readonly="true" id="cedula" value="<?php echo $cedula?>" name="cedula" required maxlength="45"style="height: 30px;width: 100%;font-size: 12px;border-color:gray;border-width:thin;line-height: 20px" /></td>
							
							<td><input type="text" readonly="true" id="id_cab_credito" value="<?php echo $id_cab_credito?>" name="id_cab_credito" style="display: none;" /></td>		
							<td><input type="text" readonly="true" id="id_det_credito" value="<?php echo $id_det_credito?>" name="id_det_credito" style="display: none;" /></td>													
						</tr>
						<tr>
							<td> Nombre: </td>
							<td><input type="text" readonly="true" value="<?php echo $nombre?> <?php echo $apellido?>" id="nombre" name="nombre" required maxlength="45"style="height: 30px;width: 100%;font-size: 12px;border-color:gray;border-width:thin;line-height: 20px" /></td>
						</tr>
						<tr>
							<td> Teléfono: </td>
							<td><input type="text" readonly="true" id="telefono" value="<?php echo $telefono?>" name="telefono" required maxlength="45"style="height: 30px;width: 100%;font-size: 12px;border-color:gray;border-width:thin;line-height: 20px" /></td>
						</tr>
						<tr>	 	 	
						 	<td>Fecha Inicio</td>
						 	<td><input type="text" readonly="true" name="fecha_i"  id="fecha_i" value="<?php echo $fecha_i?>" style="height: 30px;width: 100%;font-size: 12px;border-color:gray;border-width:thin;line-height: 20px">	 		
						 	</td>	 	
						</tr>
						<tr>
							<td>Fecha Fin</td>
							<td><input type="text" readonly="true"name="fecha_f" readonly="true" id="fecha_f" value="<?php echo $fecha_f?>" style="height: 30px;width: 100%;font-size: 12px;border-color:gray;border-width:thin;line-height: 20px">	 		
						 	</td>
		 				</tr>	

						<tr>
							<td>Crédito por: </td>
							<td><input type="text" readonly="true" id="valor" name="valor" value="$ <?php echo ($totalapagar - $mora)?>" required maxlength="10" onkeypress="return numeros(event)" style="height: 30px;width: 70%;text-align:center; font-size: 14px;border-color:gray;border-width:thin;line-height: 20px" /></td>
						</tr>
						<tr>
							<td>Cuota actual: </td>
							<td><input type="text" readonly="true" id="cuota" name="cuota" value="$ <?php echo $v_cuota?>" required maxlength="10" onkeypress="return numeros(event)" style="height: 30px;width: 70%;text-align:center; font-size: 14px;border-color:gray;border-width:thin;line-height: 20px" /></td>
						</tr>
						<tr>
							<td>Valor atrasado: </td>
							<td><input type="text" readonly="true" id="atrasadas" name="atrasadas" value="$ <?php echo $cuotas_atrasadas?>" required maxlength="10" onkeypress="return numeros(event)" style="height: 30px;width: 70%;text-align:center; font-size: 14px;border-color:gray;border-width:thin;line-height: 20px" /></td>
						</tr>
						<tr>
							<td>Valor Mora: </td>
							<td><input type="text" readonly="true" id="mora" name="mora" value="$ <?php echo $mora?>" required maxlength="10" onkeypress="return numeros(event)" style="height: 30px;width: 70%;text-align:center; font-size: 14px;border-color:gray;border-width:thin;line-height: 20px" /></td>
						</tr>
						<tr>
							<td>Dias Vencidos: </td>
							<td><input type="text" id="dias_mora" name="dias_mora" readonly="true" value="<?php 
									$resta = (strtotime(date("d-m-Y")) - strtotime($fecha_f)) / (60*60*24);
									if ($resta < 0)
										echo 0;
									else
										echo $resta;  									
								?>" 

								style="height: 30px;width: 70%;text-align:center; font-size: 14px;border-color:gray;border-width:thin;line-height: 20px" /></td>
						</tr>
						<tr>
							<td>Saldo a pagar: </td>
							<td><input type="text" readonly="true" id="saldo" name="saldo" value="$ <?php echo ($totalapagar - $totalpagado)?>" required maxlength="10" onkeypress="return numeros(event)" style="height: 30px;width: 70%;text-align:center; font-size: 14px;border-color:gray;border-width:thin;line-height: 20px" /></td>
						</tr>
							
						<tr>	 	 	
							<td>Próximo Pago</td>
							<td><input type="text" readonly="true" name="fecha_p"  id="fecha_p" value="<?php 
								if (is_null($proxima_fecha))
									echo date("Y-m-d");
								else
									echo $proxima_fecha;  
								?>" 
								style="height: 30px;width: 100%;font-size: 12px;border-color:gray;border-width:thin;line-height: 20px"></td>	 
						</tr>

					<form name="fs" action="<?= base_url() .'index.php/menu_principal/inicio'?>" method="post" class="" onsubmit="if (document.abono.value!='') {return true;} else {return false;}">
					<tr>
							<td>Abono: </td>
							<td><input type="number" id="abono" name="abono" onkeypress="return numeros(event)" required maxlength="10" style="height: 30px;width: 70%;text-align:center; font-size: 14px;border-color:gray;border-width:thin;line-height: 20px" /></td>
					</tr>
					<tr style="height: 20px;"></tr>
					<tr>
						<td>Liquidar cuenta: </td>
						<td><input type="checkbox" id="liquidar" value="liquidar" style="height: 30px;width: 30px"> </td>
					</tr>

					</table>
					<br>
					<table width="100%">
				
					<tr>
							<td align="center"><input type="submit" id="btn_guardar" name="btn_abonar"class="btn-sm" style="background-color: #C8216A;color: #FFFFFF;width: 98%;" value="Guardar" onclick="guardar()"/></td>
					</form>
					<form action="" method="" class="">		
							<td align="center"><input type="submit" id="btn_regresar" name="btn_regresar"class="btn-sm" style="background-color: #C8216A;color: #FFFFFF;width: 98%;" value="Regresar" onclick="cierra_ventana()"/></td>
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
<script src="<?php echo base_url(); ?>js/moment.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.dataTables.min.js"></script>
</body>
</html>