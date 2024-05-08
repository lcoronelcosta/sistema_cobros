<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Validacion_model extends CI_Model {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	
	public function login($user,$clave)
	{
		
		$result = $this->db->query("SELECT U.id_usuario,U.comision,U.cedula, U.nombre, U.apellido, TU.descripcion AS tipo_usuario FROM usuario U, tipo_usuario TU WHERE U.USER = '".$user ."' AND U.CLAVE = '".$clave."' AND U.id_tipo_usuario=TU.id_tipo_usuario");

		return $result;
	}

	public function insertar_cliente($archivo)
	{
		$this->load->helper('url');      
		$array = $this->session->userdata('usuario_data');
		$id_antecesor=$this->input->post('id_antecesor');

		$data = array(         
                 
         'cedula' => $this->input->post('cedula'),         
         'nombre' => $this->input->post('nombre'),
         'apellido' => $this->input->post('apellido'),
         'telefono' => $this->input->post('telefono'),
         'celular' => $this->input->post('celular'),
         'direccion' => $this->input->post('direccion'),
         'referencia' => $this->input->post('referencia'),
         'id_usuario' => $array['id_usuario'],
         'fecha' => date("Y/m/d"),
         'ruta_foto' => $archivo,  
         'antecesor' => $id_antecesor 
      	);

      	return $this->db->insert('cliente', $data);

	}

	public function insertar_cobrador($archivo)
	{
		$this->load->helper('url');      
		$array = $this->session->userdata('usuario_data');

		$data = array(         
                 
         'cedula' => $this->input->post('cedula'),         
         'nombre' => $this->input->post('nombre'),
         'apellido' => $this->input->post('apellido'),
         'telefono' => $this->input->post('telefono'),
         'direccion' => $this->input->post('direccion'),
         'celular' => $this->input->post('celular'),         
         'referencia' => $this->input->post('referencia'),
         'comision' => $this->input->post('comision'),
         'estado' => "Activo",
         'user' => $this->input->post('user'),
         'clave' => $this->input->post('clave'),
         'id_tipo_usuario' => 2,
         'fecha' => date("Y/m/d"),
         'ruta_foto' => $archivo         
      	);

      	return $this->db->insert('usuario', $data);

	}

	public function calcular_amortizacion_diaria()
	{
		/*
		Se conecta con una llama del Script por AJAX
		*/			
		$valor_t = $_POST ['valor_t'];
		$tasa_t = $_POST ['tasa_t'];
		$plazo_t = $_POST ['plazo_t'];
		$fecha_i_t = $_POST ['fecha_i_t'];

		if ($plazo_t == 45)
		{
			$plazo_t = 40;
		}

		$i = 1;
		$mod_date = $fecha_i_t; 
		$row = "";
		$valor_c = ($valor_t + ($valor_t * $tasa_t)/100)/$plazo_t;
		while ($i <= $plazo_t)
		{
			//Incrementando 1 dia
			$mod_date = strtotime($mod_date."+ 1 day");
			
			// Si es domingo
			//$dia = strtotime('w', $mod_date);
			$date_t = date('w', $mod_date); 
			if ($date_t == 0) 
			{
			   	$mod_date = date("d-m-Y",$mod_date);
			   	$mod_date = strtotime($mod_date."+ 1 day");
			}
			$mod_date = date("d-m-Y",$mod_date);
			
			$row .='{"cuota":"' . $i. '","fecha":"' . $mod_date . '","valor":"$ ' . $valor_c . '"},';
			$i++;
		}
		$row = substr($row, 0,strlen($row) - 1);
        echo '{"data":['.$row.']}';

	}

	public function calcular_amortizacion_semanal()
	{
		/*
		Se conecta con una llama del Script por AJAX
		*/			
		$valor_t = $_POST ['valor_t'];
		$tasa_t = $_POST ['tasa_t'];
		$plazo_t = $_POST ['plazo_t'];
		$fecha_i_t = $_POST ['fecha_i_t'];

		$n_cuota = $plazo_t / 7;
		$n_cuota = floor($n_cuota);
		
		$i = 1;

		$mod_date = $fecha_i_t; 
		$row = "";
		$valor_c = ($valor_t + ($valor_t * $tasa_t)/100)/$n_cuota;
				
		$mod_date = strtotime($mod_date."+ 1 day");
		$mod_date = date("d-m-Y",$mod_date);
		
		$band = 0;

		while ($i <= $n_cuota)
		{
			//Incrementando 7 dia
			$mod_date = strtotime($mod_date."+ 7 days");
			
			// Si es domingo
			//$dia = strtotime('w', $mod_date);
			$date_t = date('w', $mod_date); 
			if ($date_t == 0) 
			{
			   	$mod_date = date("d-m-Y",$mod_date);
			   	$mod_date = strtotime($mod_date."+ 1 day");
			   	$band = 1;
			}
			$mod_date = date("d-m-Y",$mod_date);
			
			$row .='{"cuota":"' . $i. '","fecha":"' . $mod_date . '","valor":"$ ' . $valor_c . '"},';

			if ($band == 1)
			{
				$mod_date = strtotime($mod_date."- 1 day");
				$mod_date = date("d-m-Y",$mod_date);
			   	$band = 0;	
			}

			$i++;
		}
		$row = substr($row, 0,strlen($row) - 1);
        echo '{"data":['.$row.']}';

	}

	public function calcular_amortizacion_quincenal()
	{
		/*
		Se conecta con una llama del Script por AJAX
		*/			
		$valor_t = $_POST ['valor_t'];
		$tasa_t = $_POST ['tasa_t'];
		$plazo_t = $_POST ['plazo_t'];
		$fecha_i_t = $_POST ['fecha_i_t'];

		$n_cuota = $plazo_t / 15;
		$n_cuota = floor($n_cuota);

		$i = 1;
		$mod_date = $fecha_i_t; 
		$mod_date2 = $fecha_i_t; 
		$row = "";
		$valor_c = ($valor_t + ($valor_t * $tasa_t)/100)/$n_cuota;
		
		$band = 0;

		while ($i <= $n_cuota)
		{
			if ($i == $n_cuota)
			{
				if ($plazo_t==30) 
				{
					$mod_date = strtotime($fecha_i_t."+ 1 month");
				}
				else
				{
					if ($plazo_t==60) 
					{
						$mod_date = strtotime($fecha_i_t."+ 2 month");
					}
					else
					{
						//Incrementando 15 dia
						$mod_date = strtotime($mod_date."+ 15 days");
					}
				}	
			}	
			else	
			{
				//Incrementando 15 dia
				$mod_date = strtotime($mod_date."+ 15 days");
				
			}
			// Si es domingo
			$date_t = date('w', $mod_date); 
			
			if ($date_t == 0) 
			{
			   	$mod_date = date("d-m-Y",$mod_date);
			   	$mod_date = strtotime($mod_date."+ 1 day");
			   	$band = 1;
			}
			$mod_date = date("d-m-Y",$mod_date);
			
			$row .='{"cuota":"' . $i. '","fecha":"' . $mod_date . '","valor":"$ ' . $valor_c . '"},';
			if ($band == 1)
			{
				$mod_date = strtotime($mod_date."- 1 day");
				$mod_date = date("d-m-Y",$mod_date);
			   	$band = 0;	
			}

			$i++;
		}
		$row = substr($row, 0,strlen($row) - 1);
        echo '{"data":['.$row.']}';

	}

	public function calcular_amortizacion_mensual()
	{
		/*
		Se conecta con una llama del Script por AJAX
		*/			
		$valor_t = $_POST ['valor_t'];
		$tasa_t = $_POST ['tasa_t'];
		$plazo_t = $_POST ['plazo_t'];
		$fecha_i_t = $_POST ['fecha_i_t'];

		$n_cuota = $plazo_t / 30;
		$n_cuota = floor($n_cuota);
		
		$i = 1;
		$mod_date = $fecha_i_t; 
		$row = "";
		$valor_c = ($valor_t + ($valor_t * $tasa_t)/100)/$n_cuota;
		$band = 0;
		while ($i <= $n_cuota)
		{
			//Incrementando 1 mes
			$mod_date = strtotime($mod_date."+ 1 month");
			
			// Si es domingo
			//$dia = strtotime('w', $mod_date);
			$date_t = date('w', $mod_date); 
			if ($date_t == 0) 
			{
			   	$mod_date = date("d-m-Y",$mod_date);
			   	$mod_date = strtotime($mod_date."+ 1 day");
			   	$band = 1;
			}
			$mod_date = date("d-m-Y",$mod_date);
			
			$row .='{"cuota":"' . $i. '","fecha":"' . $mod_date . '","valor":"$ ' . $valor_c . '"},';
			
			if ($band == 1)
			{
				$mod_date = strtotime($mod_date."- 1 day");
				$mod_date = date("d-m-Y",$mod_date);
			   	$band = 0;	
			}

			$i++;
		}
		$row = substr($row, 0,strlen($row) - 1);
        echo '{"data":['.$row.']}';

	}

	public function busqueda_cliente($cedula)
	{
		
		$result = $this->db->query("SELECT C.id_cliente, C.nombre, C.apellido FROM cliente C WHERE C.cedula = '".$cedula ."'");

		return $result;
	}

	public function insertar_credito()
	{
		$this->load->helper('url');      
        
		$data = array(         
                 
         'id_cliente' => $this->input->post('id_cliente'),   
         'valor' => $this->input->post('valor'),
         'tasa' => $this->input->post('tasa'),
         'plazo' => $this->input->post('plazo'),
         'id_formadepago' => $this->input->post('formadepago'),
         'fecha_i' => $this->input->post('fecha_i'),
         'fecha_f' => $this->input->post('fecha_f'),
         'interes' => $this->input->post('interes'),
         'totalapagar' => $this->input->post('totalapagar'),
         'mora' => $this->input->post('mora'),
         'estado' => $this->input->post('estado'),
         'motivo' => $this->input->post('motivo')
      	);
		
	    $this->db->insert('cab_credito', $data);

        
		$result = $this->db->query("SELECT C.id_cab_credito FROM cab_credito C WHERE C.id_cliente=". $this->input->post('id_cliente'). " and C.id_formadepago=".$this->input->post('formadepago')." and C.fecha_i = '".$this->input->post('fecha_i')."' and C.fecha_f = '".$this->input->post('fecha_f')."'and C.valor=". $this->input->post('valor'). " and C.totalapagar=". $this->input->post('totalapagar'));

		$cab_credito = $result->row_array();
		
		

		//******************************************
		//Se inserta el detalle del credito (cuotas)
		//******************************************
		
		
		$detalle_tmp = $this->input->post('detalle');
		$detalle_tmp = json_decode($detalle_tmp,true);	
		foreach ($detalle_tmp["detalle"] as $key => $value) 
		{
		 	$registro = array(
	      	 	'id_cab_credito' => $cab_credito["id_cab_credito"],
	      	 	'n_cuota' => $value["cuota"],
	      	 	'fechapago' => $value["fecha"],
	      	 	'v_cuota' => round($value["valor"],2),
	      	 	'abono' => 0,
	      	 	'estado' => "pendiente"	
	     	);	
	    
	     	$this->db->insert('det_credito', $registro);
		}
		
		
	}

	public function consulta_clientes_cobrar($id_usuario)
	{
		/*
		Se conecta con una llama del Script por AJAX
		*/
		$result = $this->db->query("SELECT DC.id_det_credito ,CI.nombre, CI.apellido, CI.celular, round(DC.v_cuota,2) as v_cuota, round(DC.abono,2) as abono, CC.d_mora, CC.fecha_i, CC.mora, CC.totalapagar,CC.totalpagado, (SELECT round(sum(DC1.v_cuota - DC1.abono),2) FROM cliente CI1, cab_credito CC1, det_credito DC1 WHERE CI1.id_cliente=CC1.id_cliente and CC1.id_cab_credito=DC1.id_cab_credito and CI1.id_usuario = CI.id_usuario and DC1.estado='pendiente' and  DC1.fechapago = '". $this->input->post('fecha_i'). "' and DC1.n_cuota !=0) as t_cuota FROM cliente CI, cab_credito CC, det_credito DC WHERE CI.id_cliente=CC.id_cliente and CC.id_cab_credito=DC.id_cab_credito and CI.id_usuario =". $id_usuario. " and DC.estado='pendiente' and DC.fechapago = '". $this->input->post('fecha_i'). "' and DC.n_cuota !=0 order by CI.antecesor");


		$arreglo = null;		
		foreach ($result->result_array() as $row) {
			$arreglo["data"][] = $row;
		}

		//****************************************************************
		//En caso que no exista informaci�n de solicitudes para el usuario
		//****************************************************************
		if ( $result->num_rows() <= 0 )
		{
			$arreglo["data"]=[];
		}

		echo json_encode($arreglo);

	}
	
	public function consulta_todos_creditos($id_usuario)
	{
		/*
		Se conecta con una llama del Script por AJAX
		*/
		$result = $this->db->query("
			SELECT min(DC.id_det_credito) AS id_det_credito, 
				CI.nombre, 
				CI.apellido, 
				CI.celular,
				round(DC.v_cuota,2) as v_cuota, 
				round(DC.abono,2) as abono, 
				CC.fecha_i, 
				CC.d_mora, 
				CC.mora, 
				CC.totalapagar,
				CC.totalpagado,
					(SELECT round(sum(CC1.totalapagar - CC1.totalpagado),2) 
						FROM cliente CI1, cab_credito CC1 
						WHERE CI1.id_cliente=CC1.id_cliente 
							and CI1.id_usuario = CI.id_usuario 
							and CC1.estado='pendiente') as t_cuota 
					FROM cliente CI, cab_credito CC, det_credito DC 
					WHERE CI.id_cliente=CC.id_cliente 
						and CC.id_cab_credito=DC.id_cab_credito 
						and CI.id_usuario =". $id_usuario. " 
						and DC.estado='pendiente' 
						AND (CC.totalapagar - CC.totalpagado) > 0
						GROUP BY DC.id_cab_credito"
		);

		$arreglo = null;		
		foreach ($result->result_array() as $row) {
			$arreglo["data"][] = $row;
		}
		
		//****************************************************************
		//En caso que no exista informaci�n de solicitudes para el usuario
		//****************************************************************
		if ( $result->num_rows() <= 0 )
		{
			$arreglo["data"]=[];
		}

		echo json_encode($arreglo);

	}

	public function reprogramar_fecha($id_det_credito,$fecha_r)
	{	
		/*
		Se conecta a la BD para actualizar fecha
		*/
		$this->db->set('fechapago', $fecha_r);
      	$this->db->where('id_det_credito', $id_det_credito);
      	$this->db->update('det_credito');

      	return 1;
	}

	public function consulta_gastos_validar()
	{
		/*
		Se conecta con una llama del Script por AJAX
		*/
		$result = $this->db->query("SELECT G.id_gasto, u.nombre, u.apellido, G.fecha_gasto, G.detalle, G.valor FROM gasto G, usuario u where G.id_usuario = u.id_usuario and G.estado='pendiente'");

		$arreglo = null;		
		foreach ($result->result_array() as $row) {
			$arreglo["data"][] = $row;
		}
		
		//********************************************
		//En caso que no exista informaci�n de gastos 
		//********************************************
		if ( $result->num_rows() <= 0 )
		{
			$arreglo["data"]=[];
		}

		echo json_encode($arreglo);

	}
	
	public function consulta_ingreso_caja()
	{
		/*
		Se conecta con una llama del Script por AJAX
		*/
		$result = $this->db->query("SELECT c.id_caja, c.fecha_entrega, u.nombre, u.apellido, c.valor FROM caja c, usuario u where c.id_usuario = u.id_usuario and c.estado='pendiente' order by c.fecha_entrega");

		$arreglo = null;		
		foreach ($result->result_array() as $row) {
			$arreglo["data"][] = $row;
		}
		
		//********************************************
		//En caso que no exista informaci�n de caja
		//********************************************
		if ( $result->num_rows() <= 0 )
		{
			$arreglo["data"]=[];
		}

		echo json_encode($arreglo);

	}

	public function consulta_caja()
	{
		/*
		Se conecta con una llama del Script por AJAX
		*/
		$result = $this->db->query("SELECT c.id_caja, c.fecha_entrega, c.detalle, c.valor, (select sum(c1.valor) from caja c1 where c1.id_usuario=". $this->input->post('id_cobrador'). " and c1.estado='pendiente' and c1.fecha_entrega>='". $this->input->post('fecha_i'). "' and c1.fecha_entrega<='". $this->input->post('fecha_f'). "' ) as total_caja FROM caja c, usuario u where c.id_usuario = u.id_usuario and c.id_usuario=". $this->input->post('id_cobrador'). " and c.estado='pendiente' and c.fecha_entrega>='". $this->input->post('fecha_i'). "' and c.fecha_entrega<='". $this->input->post('fecha_f'). "' order by c.fecha_entrega");

		$arreglo = null;		
		foreach ($result->result_array() as $row) {
			$arreglo["data"][] = $row;
		}
		
		//********************************************
		//En caso que no exista informaci�n de caja
		//********************************************
		if ( $result->num_rows() <= 0 )
		{
			$arreglo["data"]=[];
		}

		echo json_encode($arreglo);

	}

    public function consulta_gastos_validar_cobrador($id_usuario)
	{
		/*
		Se conecta con una llama del Script por AJAX
		*/
		$result = $this->db->query("SELECT G.id_cab_gasto, u.nombre, u.apellido, G.fecha_gasto, G.detalle, G.valor FROM cab_gasto G, usuario u where G.id_ingresado_por = u.id_usuario and G.estado='pendiente' and G.id_ingresado_por=" . $id_usuario );

		$arreglo = null;		
		foreach ($result->result_array() as $row) {
			$arreglo["data"][] = $row;
		}
		
		//********************************************
		//En caso que no exista informaci�n de gastos 
		//********************************************
		if ( $result->num_rows() <= 0 )
		{
			$arreglo["data"]=[];
		}

		echo json_encode($arreglo);

	}

	public function consulta_detalle_credito($id_det_credito)
	{
		
		$result = $this->db->query("SELECT cc.id_cab_credito,dc.id_det_credito, c.cedula, c.nombre, c.apellido, c.telefono, cc.fecha_i, cc.fecha_f,cc.totalapagar,dc.v_cuota,cc.totalpagado,cc.mora, (select dc1.fechapago from det_credito dc1 where dc1.id_det_credito = dc.id_det_credito + 1 and dc1.id_cab_credito = cc.id_cab_credito) as proxima_fecha, (select sum(dc2.v_cuota - dc2.abono) from det_credito dc2 where dc2.id_cab_credito= cc.id_cab_credito and dc2.estado='pendiente' and dc2.fechapago<'" . date("Y/m/d") ."') as cuotas_atrasadas FROM det_credito dc, cliente c, cab_credito cc WHERE dc.id_det_credito = " . $id_det_credito . " and dc.id_cab_credito = cc.id_cab_credito and cc.id_cliente = c.id_cliente");

		return $result;

	}

	public function consulta_abonos_realizados ($id_det_credito)
	{
		
		$result = $this->db->query("SELECT cc.id_cab_credito,dc.id_det_credito, c.cedula, c.nombre, c.apellido, c.telefono, cc.fecha_i, cc.fecha_f,cc.totalapagar,cc.totalpagado, (select dc1.fechapago from det_credito dc1 where dc1.id_det_credito = dc.id_det_credito + 1 and dc1.id_cab_credito = cc.id_cab_credito) as proxima_fecha, (select sum(dc2.v_cuota - dc2.abono) from det_credito dc2 where dc2.id_cab_credito= cc.id_cab_credito and dc2.estado='pendiente' and dc2.fechapago<'" . date("Y/m/d") ."')as cuotas_atrasadas FROM det_credito dc, cliente c, cab_credito cc, abono a WHERE dc.id_det_credito =  " . $id_det_credito . " and dc.id_cab_credito = cc.id_cab_credito and cc.id_cliente = c.id_cliente");

		return $result;

	}

	public function consulta_abonos_realizados_tabla($id_det_credito)
	{
		/*
		Se conecta con una llama del Script por AJAX
		*/
		$result = $this->db->query(
			"SELECT cc.id_cab_credito,dc.id_det_credito, c.cedula, c.nombre, c.apellido, c.telefono, cc.fecha_i, cc.fecha_f,cc.totalapagar,cc.totalpagado, (select dc1.fechapago from det_credito dc1 where dc1.id_det_credito = dc.id_det_credito + 1 and dc1.id_cab_credito = cc.id_cab_credito) as proxima_fecha, (select sum(dc2.v_cuota - dc2.abono) from det_credito dc2 where dc2.id_cab_credito= cc.id_cab_credito and dc2.estado='pendiente' and dc2.fechapago<'" . date("Y/m/d") ."')as cuotas_atrasadas, a.id_abono, a.fecha, a.valor FROM det_credito dc, cliente c, cab_credito cc, abono a WHERE dc.id_det_credito =  " . $id_det_credito . " and dc.id_cab_credito = cc.id_cab_credito and cc.id_cliente = c.id_cliente and a.id_cab_credito = cc.id_cab_credito");

		$arreglo = null;		
		foreach ($result->result_array() as $row) {
			
			$arreglo["data"][] = $row;
		}

		//****************************************************************
		//En caso que no exista informaci�n de creditos para el usuario
		//****************************************************************
		if ( $result->num_rows() <= 0 )
		{
			$arreglo["data"]=[];
		}

		echo json_encode($arreglo);

	}


	public function abonar_al_credito($id_cobrador, $porcentaje_comision)
	{
		//$this->load->helper('url');      	    
		$id_cab_credito = $this->input->post('id_cab_credito');
		$id_det_credito = $this->input->post('id_det_credito');
		$valor_abono = $this->input->post('valor_abono');
		$liquidar = $this->input->post('liquidar');

      	$this->db->set('totalpagado','totalpagado +'. (float)$valor_abono, FALSE);
      	$this->db->where('id_cab_credito', $id_cab_credito);
      	$this->db->update('cab_credito');

      	/*
      	//****************************************************************
		//Registrar en tabla abono 
		//*/
      	$dataabono = array(                          
         'id_cab_credito' => $id_cab_credito,
         'valor' => $valor_abono,
         'fecha' => date("Y/m/d"),
         'id_usuario' => $id_cobrador
         
      	);
			    
		$this->db->insert('abono', $dataabono);

		$query1 = $this->db->query("SELECT concat('MORA: ',c.nombre, ' ', c.apellido) as nombre FROM cliente c, cab_credito cc where cc.id_cliente = c.id_cliente and cc.id_cab_credito = " . $id_cab_credito . " ");
		$result1 = $query1->row_array();
		$cliente = $result1['nombre'];

		$query = $this->db->query("SELECT (cc.totalapagar-cc.totalpagado) as saldo, cc.interes, cc.mora FROM cab_credito cc where cc.id_cab_credito = " . $id_cab_credito . " ");

		$result = $query->row_array();
		$saldo_liquidar = $result['saldo'];
		$interes = $result['interes'];
		$mora = $result['mora'];

      	$valor = round(($interes * $porcentaje_comision) / 100, 2);
      	$comision_mora_completo = round(($mora * $porcentaje_comision) / 100, 2);

      	$band = $this->validacion_model->abonar_al_credito_detalle($id_cab_credito, $valor_abono, $id_cobrador,$valor, true, $comision_mora_completo);
		
		//****************************************************************
		//Cuando quiera liquidar la cuenta del cliente, Estado->Cancelado
		//****************************************************************

		$query_estado = $this->db->query("SELECT cc.estado FROM cab_credito cc where cc.id_cab_credito = " . $id_cab_credito . " ");    
		$result_estado = $query_estado->row_array();  	

		if ($result_estado['estado'] != 'cancelado')
		{

			if ($liquidar == "true")
			{
						
				$this->db->set('totalpagado','totalpagado +'. (float)$saldo_liquidar, FALSE);
				$this->db->set('estado',"cancelado");
	      		$this->db->where('id_cab_credito', $id_cab_credito);
	      		$this->db->update('cab_credito');


				$band1 = $this->validacion_model->abonar_al_credito_detalle($id_cab_credito, $saldo_liquidar, $id_cobrador,$valor,false, $comision_mora_completo);

				//****************************************************************
				//Se guarda la liquidacion de la cuenta para el cuadre de caja
				//del cobrador (debe / haber)
				//****************************************************************
					
				$this->validacion_model->liquidar_cuenta($id_cobrador,$id_cab_credito,$valor,'C',"COMISION");

				
				//****************************************************************************
	      		// Para registrar los diferentes casos cuando la MORA no es totalmente pagada
	      		//****************************************************************************
	      		if (($saldo_liquidar-$mora)>0)
	      		{
	      			//********************************************************************
	      			//Inserto la MORA al gasto para que sea validado por el administrador
	      			//********************************************************************
	      			
	      			$this->validacion_model->registrar_gasto_mora($id_cobrador, $mora, $id_cab_credito, $cliente);


	      			//********************************************************************
	      			//Actualizo para que solo ubique el faltante sin considerar la mora
	      			//********************************************************************
	      			
	      			$saldo_liquidar = ($saldo_liquidar-$mora); 

	      		}
	      		else
	      		{
	      			if (($saldo_liquidar-$mora)<0)
	      			{
	      				$this->validacion_model->registrar_gasto_mora($id_cobrador, $saldo_liquidar, $id_cab_credito, $cliente);

	      				$comision_mora = round((($mora - $saldo_liquidar) * $porcentaje_comision) / 100, 2);

	      				$this->validacion_model->liquidar_cuenta($id_cobrador,$id_cab_credito,$comision_mora,'C',"COMISION");

						//*************************************
	      				//Actualizo a 0 ya que no hay faltante
	      				//*************************************      			
	      				$saldo_liquidar = 0;
	      				$band = 1;

	      			}
	      			else
	      			{
	      				$this->validacion_model->registrar_gasto_mora($id_cobrador, $mora, $id_cab_credito, $cliente);

	      				//*************************************
	      				//Actualizo a 0 ya que no hay faltante
	      				//*************************************
	      				$saldo_liquidar = 0;
	      				$band = 1;

	      			}
	      		}

				//**************************************************************************************
				//D�bito al cobrador porque liquid� la cuenta, pero a�n ten�a saldo por cobrar
				//**************************************************************************************
				if ($band == 0)
				{
					$this->validacion_model->liquidar_cuenta($id_cobrador,$id_cab_credito,$saldo_liquidar,'D',"FALTANTE");
				}

			}
		}

	}
	
	public function liquidar_cuenta($id_cobrador,$id_cab_credito,$valor,$balance,$descripcion)
	{
		
		$registro = array(
	      	'id_usuario' => $id_cobrador,
	      	'id_cab_credito' => $id_cab_credito,
	      	'valor' => round($valor,2),
	      	'fecha' => date("Y/m/d"),
	      	'balance' => $balance,
	      	'descripcion' => $descripcion   	
	    );	
	    
	    $this->db->insert('liquidacion', $registro);	
	}

	public function abonar_al_credito_detalle($id_cab_credito, $valor_abono, $id_cobrador, $valor, $sinliquidar, $comision_mora_completo)
	{
		//*****************************************************
		//Cada cuota se va cancelando seg�n el abono realizado
		//*****************************************************
		$this->load->helper('url'); 

		$query = $this->db->query("SELECT id_det_credito, v_cuota, abono FROM det_credito dc WHERE dc.id_cab_credito = " . $id_cab_credito . " and dc.estado='pendiente'");
		

		foreach ($query->result_array() as $row) {
			$cuota = round($row["v_cuota"],2);
			$abono_t = round($row["abono"],2);
			$id_det_credito_t = $row["id_det_credito"];

			
			if (! $sinliquidar)
			{			
				$this->db->set('estado',"cancelado");
		      	$this->db->where('id_det_credito', $id_det_credito_t);
	    	  	$this->db->update('det_credito');

			}
			if (($valor_abono - ($cuota - $abono_t)) >= 0)
			{
				$this->db->set('abono',$cuota);
				$this->db->set('estado',"cancelado");
				$this->db->set('fechaabono',date("Y/m/d"));
	      		$this->db->where('id_det_credito', $id_det_credito_t);
    	  		$this->db->update('det_credito');

    	  		$valor_abono = round($valor_abono - ($cuota - $abono_t),2);				
			}
			else
			{
				$this->db->set('abono','abono +'. (float)$valor_abono, FALSE);
				$this->db->set('fechaabono',date("Y/m/d"));
	      		$this->db->where('id_det_credito', $id_det_credito_t);
    	  		$this->db->update('det_credito');

    	  		$valor_abono = round($valor_abono - ($cuota - $abono_t),2);
    	  				
    	  		break;			
			}			
		}

		

		if ($valor_abono >= 0 and $sinliquidar)
		{
			
			$this->db->set('estado',"cancelado");
      		$this->db->where('id_cab_credito', $id_cab_credito);
      		$this->db->update('cab_credito');

			//**************************************************************************************
			//D�bito al cobrador porque liquid� la cuenta, pero a�n ten�a saldo por cobrar
			//**************************************************************************************			
			$this->validacion_model->liquidar_cuenta($id_cobrador,$id_cab_credito,$valor,'C',"COMISION");
			$this->validacion_model->liquidar_cuenta($id_cobrador,$id_cab_credito,$comision_mora_completo,'C',"COMISION");
			$this->validacion_model->liquidar_cuenta($id_cobrador,$id_cab_credito,$valor_abono,'C',"SOBRANTE");
			return 1;
		}
		else
		{
			return 0;
		}
	}

    public function registrar_gasto($id_usuario_tmp)
	{
		//$this->load->helper('url');      
		//Verifica si es un gasto compartido, en caso que lo fuera
		//el ID_Usuario va cambiando seg�n lo que tenga el combobox

		$id_cobrador = $this->input->post('id_usuario');

		//**************************************************************************
		//Si $id_cobrador == -1 significa que est� logeado como un usuario cobrador
		//y se debe registrar el gasto solo para el usuario logeado 
		//**************************************************************************
		if ($id_cobrador == -1)
		{
			$id_cobrador = $id_usuario_tmp;
		}
		
		$data = array(                          
         'detalle' => $this->input->post('detalle'),
         'valor' => $this->input->post('valor'),
         'fecha_gasto' => $this->input->post('fecha_gasto'),
         'id_usuario' => $id_cobrador,
         'fecha_ingreso' => date("Y/m/d"),
         'id_cab_gasto' => $this->input->post('id_cabecera_gastos')
      	);
			    
		$this->db->insert('gasto', $data);
	}

	public function registrar_caja($id_usuario_tmp)
	{
		$this->load->helper('url');      
		//Verifica si es un gasto compartido, en caso que lo fuera
		//el ID_Usuario va cambiando seg�n lo que tenga el combobox

		$id_cobrador = $this->input->post('id_usuario');

		$data = array(                          
         'detalle' => $this->input->post('detalle'),
         'valor' => $this->input->post('valor'),
         'fecha_entrega' => $this->input->post('fecha_entrega'),
         'id_usuario' => $id_cobrador,
         'fecha_ingreso' => date("Y/m/d")
      	);
		
	    
		$this->db->insert('caja', $data);

	}

	public function validar_gasto($id_cab_gasto,$estado)
	{	
		$this->db->set('estado',$estado);
      	$this->db->where('id_cab_gasto', $id_cab_gasto);
      	$this->db->update('cab_gasto');

      	$this->db->set('estado',$estado);
      	$this->db->where('id_cab_gasto', $id_cab_gasto);
      	$this->db->update('gasto');

      	return 1;
	}

	public function eliminar_caja($id_caja,$estado)
	{	
		$this->db->set('estado',$estado);
      	$this->db->where('id_caja', $id_caja);
      	$this->db->update('caja');

      	return 1;
	}

	public function cuadre_comision($id_liquidacion)
	{	
		$this->db->set('estado',"cancelado");
      	$this->db->where('id_liquidacion', $id_liquidacion);
      	$this->db->update('liquidacion');

      	return 1;
	}


	public function cuadre_ingreso_caja($id_caja, $fecha, $detalle, $valor, $id_cuadre_caja)
	{	
		$this->db->set('estado',"cancelado");
      	$this->db->where('id_caja', $id_caja);
      	$this->db->update('caja');

      	//****************************************
      	// Inserta el detalle del Cuadre de Caja
      	//****************************************
      	$data = array(         
         'id' => $id_caja,
         'fecha' => $fecha,         
         'detalle' => $detalle,
         'valor' => $valor,
         'tipo' => 'IC',
         'id_cuadre_caja' => $id_cuadre_caja,            
      	);

      	$this->db->insert('detalle_cuadre_caja', $data);

      	return 1;
	}

	public function cuadre_faltante_sobrante($id_liquidacion)
	{	
		$this->db->set('estado',"cancelado");
      	$this->db->where('id_liquidacion', $id_liquidacion);
      	$this->db->update('liquidacion');

      	return 1;
	}

	public function cuadre_gastos($id_gasto)
	{	
		$this->db->set('estado',"cancelado");
      	$this->db->where('id_gasto', $id_gasto);
      	$this->db->update('gasto');

      	return 1;
	}

	public function registrar_cuadre($fecha_i,$fecha_f,$id_cobrador,$t_comision,$t_faltante_sobrante,$t_gastos,$t_liquidacion)
	{	
		$this->load->helper('url');      

		$data = array(         
           
         'fecha_i' => $fecha_i,         
         'fecha_f' => $fecha_f,
         'id_cobrador' => $id_cobrador,
         't_comision' => $t_comision,
         't_faltante_sobrante' => $t_faltante_sobrante,
         't_gastos' => $t_gastos,
         't_total' => $t_liquidacion
               
      	);

      	$this->db->insert('cuadre_semanal', $data);

      	return 1;


	}

	public function registrar_cuadre_caja($fecha_i,$fecha_f,$id_cobrador,$t_caja,$t_abono,$t_credito,$t_gastos,$t_liquidacion)
	{	

		$data = array(         
           
         'fecha_i' => $fecha_i,         
         'fecha_f' => $fecha_f,
         'id_cobrador' => $id_cobrador,
         't_ingreso' => $t_caja,
         't_cobro' => $t_abono,
         't_credito' => $t_credito,
         't_gastos' => $t_gastos,
         't_cuadre_caja' => $t_liquidacion
               
      	);

      	$this->db->insert('cuadre_caja', $data);

		//****************************************************
		//Obtengo el ID del ultimo cuadre de caja ingresado
		//****************************************************
		$result = $this->db->query("SELECT max(c.id_cuadre_caja) as id_cuadre_caja FROM cuadre_caja c WHERE c.id_cobrador=" .$id_cobrador); 

		$cuadre_caja = $result->row_array();
		return $cuadre_caja["id_cuadre_caja"];      				
	}

	public function consulta_cobradores()
	{
		$query = $this->db->query("SELECT u.id_usuario, u.nombre, u.apellido FROM usuario u");	
		return $query->result();
	}

	public function consulta_clientes($id_usuario)
	{
		$query = $this->db->query("
			SELECT 
				c.id_cliente, 
				c.nombre, 
				c.apellido,
				c.celular
			FROM cliente c, usuario u 
			WHERE 
				u.id_usuario=c.id_usuario 
				and u.id_usuario= " . $id_usuario . " 
				order by c.nombre");	
		return $query->result();
	}

	//***********************************************************************************
	//Muestra cuales son los nuevos creditos en esa semana
	//***********************************************************************************
	public function consulta_creditos()
	{
		/*
		Se conecta con una llama del Script por AJAX
		*/
		$result = $this->db->query(
			"SELECT cc.id_cab_credito, cc.fecha_i as fecha, cl.nombre, cl.apellido, cc.valor, round((select sum(cc1.valor) from cab_credito cc1, cliente c1, usuario u1 where cc1.estado!='eliminado' and u1.id_usuario =". $this->input->post('id_cobrador')." and cc1.cuadre_caja='pendiente' and cc1.id_cliente=c1.id_cliente and c1.id_usuario=u1.id_usuario and cc1.fecha_i>='". $this->input->post('fecha_i'). "' and cc1.fecha_i<='". $this->input->post('fecha_f'). "'),2) as total_credito FROM cab_credito cc, cliente cl, usuario u where cc.estado!='eliminado' and u.id_usuario = ". $this->input->post('id_cobrador')." and cc.cuadre_caja='pendiente' and cc.id_cliente=cl.id_cliente and cl.id_usuario=u.id_usuario and cc.fecha_i>='". $this->input->post('fecha_i'). "' and cc.fecha_i<='".$this->input->post('fecha_f'). "' order by cc.fecha_i");

		$arreglo = null;		
		foreach ($result->result_array() as $row) {
			
			$arreglo["data"][] = $row;
		}

		//****************************************************************
		//En caso que no exista informaci�n de creditos para el usuario
		//****************************************************************
		if ( $result->num_rows() <= 0 )
		{
			$arreglo["data"]=[];
		}

		echo json_encode($arreglo);

	}

	//***********************************************************************************
	//Muestra cuales son los nuevos abonos de la semana
	//***********************************************************************************
	public function consulta_abonos()
	{
		/*
		Se conecta con una llama del Script por AJAX
		*/
	$result = $this->db->query(
			"SELECT a.id_abono, a.fecha, cl.nombre, cl.apellido, a.valor, round((select sum(a1.valor) from cab_credito cc1, cliente c1, usuario u1, abono a1 where u1.id_usuario = ". $this->input->post('id_cobrador')." and a1.cuadre_caja='pendiente' and cc1.id_cliente=c1.id_cliente and c1.id_usuario=u1.id_usuario and a1.id_cab_credito=cc1.id_cab_credito and a1.fecha>='". $this->input->post('fecha_i'). "' and a1.fecha<='". $this->input->post('fecha_f'). "'
				),2) as total_abono FROM cab_credito cc, cliente cl, usuario u, abono a where u.id_usuario = ". $this->input->post('id_cobrador')." and a.cuadre_caja='pendiente' and cc.id_cliente=cl.id_cliente and cl.id_usuario=u.id_usuario and a.id_cab_credito=cc.id_cab_credito and a.fecha>='". $this->input->post('fecha_i'). "' and a.fecha<='". $this->input->post('fecha_f'). "' order by a.fecha");

		$arreglo = null;		
		foreach ($result->result_array() as $row) {
			
			$arreglo["data"][] = $row;
		}

		//****************************************************************
		//En caso que no exista informaci�n de creditos para el usuario
		//****************************************************************
		if ( $result->num_rows() <= 0 )
		{
			$arreglo["data"]=[];
		}

		echo json_encode($arreglo);

	}


	//***********************************************************************************
	//Muestra cuales son los valores que ha ganado el cobrador por la gesti�n realizada
	//***********************************************************************************
	public function consulta_comision()
	{
		/*
		Se conecta con una llama del Script por AJAX
		*/
		$result = $this->db->query(
			"SELECT l.id_liquidacion, l.fecha, cl.nombre, cl.apellido, cc.interes, l.valor, round((select sum(l1.valor) from liquidacion l1 where l1.id_usuario = ". $this->input->post('id_cobrador'). " and l1.descripcion ='COMISION' and l1.estado='pendiente' and l1.fecha>='". $this->input->post('fecha_i'). "' and l1.fecha<='". $this->input->post('fecha_f'). "'),2) as total_pagar FROM liquidacion l, cab_credito cc, cliente cl where l.id_usuario = ". $this->input->post('id_cobrador'). " and l.descripcion='COMISION' and l.estado='pendiente' and l.valor<>0 and l.id_cab_credito = cc.id_cab_credito and cc.id_cliente = cl.id_cliente and l.fecha>='". $this->input->post('fecha_i'). "' and l.fecha<='". $this->input->post('fecha_f'). "'");
			
		$arreglo = null;		
		foreach ($result->result_array() as $row) {
			$arreglo["data"][] = $row;
		}
		
		//****************************************************************
		//En caso que no exista informaci�n de solicitudes para el usuario
		//****************************************************************
		if ( $result->num_rows() <= 0 )
		{
			$arreglo["data"]=[];
		}

		echo json_encode($arreglo);

	}

	//***********************************************************************************
	//Muestra cuales son los valores que sobrante y faltante de los cobros realizados
	//***********************************************************************************
	public function consulta_sobrante_faltante()
	{
		/*
		Se conecta con una llama del Script por AJAX
		*/
		$result = $this->db->query("SELECT l.id_liquidacion, l.fecha, cl.nombre, cl.apellido, l.descripcion, l.valor, round((select sum(l1.valor) from liquidacion l1 where l1.id_usuario = ". $this->input->post('id_cobrador'). " and l1.descripcion='SOBRANTE' and l1.estado='pendiente' and l1.fecha>='". $this->input->post('fecha_i'). "' and l1.fecha<='". $this->input->post('fecha_f'). "'),2) as sum_sobrante, (select sum(l1.valor) from liquidacion l1 where l1.id_usuario = ". $this->input->post('id_cobrador'). " and l1.descripcion='FALTANTE' and l1.estado='pendiente' and l1.fecha>='". $this->input->post('fecha_i'). "' and l1.fecha<='". $this->input->post('fecha_f'). "') as sum_faltante FROM liquidacion l, cab_credito cc, cliente cl where l.id_usuario = ". $this->input->post('id_cobrador'). " and (l.descripcion='SOBRANTE' or l.descripcion='FALTANTE') and l.id_cab_credito = cc.id_cab_credito and cc.id_cliente = cl.id_cliente and l.estado='pendiente' and l.fecha>='". $this->input->post('fecha_i'). "' and l.fecha<='". $this->input->post('fecha_f'). "' and l.valor<>0");
			
		$arreglo = null;		
		foreach ($result->result_array() as $row) {
			$arreglo["data"][] = $row;
		}
		
		//****************************************************************
		//En caso que no exista informaci�n de solicitudes para el usuario
		//****************************************************************
		if ( $result->num_rows() <= 0 )
		{
			$arreglo["data"]=[];
		}

		echo json_encode($arreglo);

	}

	//**********************************************************
	//Muestra cuales son los valores que ha gastado el cobrador 
	//**********************************************************

	public function consulta_gastos_cuadre()
	{
		/*
		Se conecta con una llama del Script por AJAX
		*/
		$result = $this->db->query("select id_gasto,fecha_gasto, detalle, valor, round((select sum(g1.valor) from gasto g1  where g1.estado='validado' and g1.id_usuario=". $this->input->post('id_cobrador'). " and g1.fecha_gasto>='". $this->input->post('fecha_i'). "' and g1.fecha_gasto<='". $this->input->post('fecha_f'). "'),2) as sum_gasto from gasto where estado='validado' and id_usuario=". $this->input->post('id_cobrador'). " and fecha_gasto>='". $this->input->post('fecha_i'). "'and fecha_gasto<='". $this->input->post('fecha_f'). "'");
			
		$arreglo = null;		
		foreach ($result->result_array() as $row) {
			$arreglo["data"][] = $row;
		}
		
		//****************************************************************
		//En caso que no exista informaci�n de solicitudes para el usuario
		//****************************************************************
		if ( $result->num_rows() <= 0 )
		{
			$arreglo["data"]=[];
		}

		echo json_encode($arreglo);

	}

	public function consulta_ganancia()
	{
		/*
		Se conecta con una llama del Script por AJAX
		*/	
		$result = $this->db->query("SELECT nombre, apellido, ganancia, numero_credito, (SELECT sum(ganancia) FROM (SELECT u.nombre, u.apellido, ((select ifnull(sum(l1.valor),0) from liquidacion l1, usuario u1 where l1.estado='cancelado' and (l1.descripcion='COMISION' or l1.descripcion='SOBRANTE') and u1.id_usuario = l.id_usuario and u1.id_tipo_usuario = 1 and (l1.fecha>='". $this->input->post('fecha_i'). "' and l1.fecha<='". $this->input->post('fecha_f'). "')) - (select ifnull(sum(l1.valor),0) from liquidacion l1, usuario u1 where l1.estado='cancelado' and (l1.descripcion='FALTANTE') and u1.id_usuario = l.id_usuario and u1.id_tipo_usuario = 1 and (l1.fecha>='". $this->input->post('fecha_i'). "' and l1.fecha<='". $this->input->post('fecha_f'). "')) - (select sum(g1.valor) from gasto g1  where g1.estado='cancelado' and g1.id_usuario=u.id_usuario and g1.fecha_gasto>='". $this->input->post('fecha_i'). "' and g1.fecha_gasto<='". $this->input->post('fecha_f'). "')) as ganancia,count(*) as numero_credito from liquidacion l, usuario u where l.estado='cancelado' and l.descripcion='COMISION'and u.id_usuario = l.id_usuario and u.id_tipo_usuario = 1 and (l.fecha>='". $this->input->post('fecha_i'). "' and l.fecha<='". $this->input->post('fecha_f'). "') UNION ALL select u.nombre, u.apellido, (sum(l.valor) * (100 - (select u1.comision from usuario u1 where u1.id_usuario = u.id_usuario and u1.id_tipo_usuario=u.id_tipo_usuario))) / (select u2.comision from usuario u2 where u2.id_usuario = u.id_usuario and u2.id_tipo_usuario=u.id_tipo_usuario) as ganancia, count(*) as numero_credito from liquidacion l, usuario u where l.estado='cancelado' and l.descripcion='COMISION' and u.id_usuario = l.id_usuario and u.id_tipo_usuario <> 1 and (l.fecha>='". $this->input->post('fecha_i'). "' and l.fecha<='". $this->input->post('fecha_f'). "') group by u.nombre, u.apellido) as T1) as total_ganancia FROM (SELECT u.nombre, u.apellido, ((select ifnull(sum(l1.valor),0) from liquidacion l1, usuario u1 where l1.estado='cancelado' and (l1.descripcion='COMISION' or l1.descripcion='SOBRANTE') and u1.id_usuario = l.id_usuario and u1.id_tipo_usuario = 1 and (l1.fecha>='". $this->input->post('fecha_i'). "' and l1.fecha<='". $this->input->post('fecha_f'). "')) - (select ifnull(sum(l1.valor),0) from liquidacion l1, usuario u1 where l1.estado='cancelado' and (l1.descripcion='FALTANTE') and u1.id_usuario = l.id_usuario and u1.id_tipo_usuario = 1 and (l1.fecha>='". $this->input->post('fecha_i'). "' and l1.fecha<='". $this->input->post('fecha_f'). "')) - (select sum(g1.valor) from gasto g1  where g1.estado='cancelado' and g1.id_usuario=u.id_usuario and g1.fecha_gasto>='". $this->input->post('fecha_i'). "' and g1.fecha_gasto<='". $this->input->post('fecha_f'). "')) as ganancia,count(*) as numero_credito from liquidacion l, usuario u where l.estado='cancelado' and l.descripcion='COMISION'and u.id_usuario = l.id_usuario and u.id_tipo_usuario = 1 and (l.fecha>='". $this->input->post('fecha_i'). "' and l.fecha<='". $this->input->post('fecha_f'). "') UNION ALL select u.nombre, u.apellido, (sum(l.valor) * (100 - (select u1.comision from usuario u1 where u1.id_usuario = u.id_usuario and u1.id_tipo_usuario=u.id_tipo_usuario))) / (select u2.comision from usuario u2 where u2.id_usuario = u.id_usuario and u2.id_tipo_usuario=u.id_tipo_usuario) as ganancia, count(*) as numero_credito from liquidacion l, usuario u where l.estado='cancelado' and l.descripcion='COMISION' and u.id_usuario = l.id_usuario and u.id_tipo_usuario <> 1 and (l.fecha>='". $this->input->post('fecha_i'). "' and l.fecha<='". $this->input->post('fecha_f'). "') group by u.nombre, u.apellido) as T");
		
		$arreglo = null;		
		foreach ($result->result_array() as $row) {
			$arreglo["data"][] = $row;
		}
		
		//****************************************************************
		//En caso que no exista informaci�n de solicitudes para el usuario
		//****************************************************************
		if ( $result->num_rows() <= 0 )
		{
			$arreglo["data"]=[];
		}

		echo json_encode($arreglo);
	}
	public function consulta_allclientes()
	{
		/*
		Se conecta con una llama del Script por AJAX
		*/	
		$result = $this->db->query("SELECT id_cliente,cedula, nombre,apellido, celular FROM cliente");

		$arreglo = null;		
		foreach ($result->result_array() as $row) {
			$arreglo["data"][] = $row;
		}
		
		//****************************************************************
		//En caso que no exista informaci�n de solicitudes para el usuario
		//****************************************************************
		if ( $result->num_rows() <= 0 )
		{
			$arreglo["data"]=[];
		}
		echo json_encode($arreglo);
	}

	public function editar_cliente ($id_cliente)
	{
		
		$result = $this->db->query("SELECT c.id_cliente, c.cedula, c.nombre, c.apellido,c.direccion,c.telefono,c.celular,c.referencia,c.ruta_foto,c.antecesor FROM cliente c WHERE c.id_cliente = '".$id_cliente ."'");
			return $result;
	}

	public function actualizar_cliente($archivo)
	{
		$this->db->set('nombre', $this->input->post('nombre'));
      	$this->db->set('apellido', $this->input->post('apellido'));
      	$this->db->set('telefono', $this->input->post('telefono'));
      	$this->db->set('celular', $this->input->post('celular'));
      	$this->db->set('direccion', $this->input->post('direccion'));
      	$this->db->set('referencia', $this->input->post('referencia'));
      	$this->db->set('antecesor', $this->input->post('id_antecesor'));
      	$this->db->set('ruta_foto', $archivo);
      	
      	$this->db->where('cedula', $this->input->post('cedula'));
      	$this->db->update('cliente');

      	return 1;

	}
	
	public function consulta_allcobradores()
	{
		$result = $this->db->query("SELECT u.id_usuario, u.cedula, u.nombre, u.apellido, u.celular FROM usuario u");
		$arreglo = null;		
		foreach ($result->result_array() as $row) {
			$arreglo["data"][] = $row;
		}
		//****************************************************************
		//En caso que no exista informaci�n de solicitudes para el usuario
		//****************************************************************
		if ( $result->num_rows() <= 0 )
		{
			$arreglo["data"]=[];
		}
		echo json_encode($arreglo);
	}

	public function editar_cobrador ($id_usuario)
	{
		$result = $this->db->query("SELECT u.id_usuario, u.cedula, u.nombre, u.apellido, u.direccion, u.telefono, u.user, u.clave, u.comision, u.celular, u.referencia, u.ruta_foto FROM usuario u WHERE u.id_usuario = '".$id_usuario ."'");	
		return $result;
	}
	
	public function actualizar_cobrador($archivo)
	{
		$this->db->set('cedula', $this->input->post('cedula'));
		$this->db->set('nombre', $this->input->post('nombre'));
      	$this->db->set('apellido', $this->input->post('apellido'));
      	$this->db->set('direccion', $this->input->post('direccion'));
      	$this->db->set('telefono', $this->input->post('telefono'));
      	$this->db->set('user', $this->input->post('user'));
      	$this->db->set('clave', $this->input->post('clave'));
      	$this->db->set('comision', $this->input->post('comision'));
      	$this->db->set('celular', $this->input->post('celular'));
      	$this->db->set('referencia', $this->input->post('referencia'));
      	$this->db->set('ruta_foto', $archivo);
      	
      	$this->db->where('id_usuario', $this->input->post('id_usuario'));
      	$this->db->update('usuario');

      	return 1;

	}
	
	public function registrar_cab_gasto($id_ingresado_por)
	{
		$this->load->helper('url');      
		//Verifica si es un gasto compartido, en caso que lo fuera
		//el ID_Usuario va cambiando seg�n lo que tenga el combobox

		$id_generado_por = $this->input->post('id_generado_por');

		//**************************************************************************
		//Si $id_generado_por == -1 significa que est� logeado como un usuario cobrador
		//y se debe registrar el gasto solo para el usuario logeado 
		//**************************************************************************
		if ($id_generado_por == -1)
		{
			$id_generado_por = $id_ingresado_por;
		}
		
		$data = array(                          
         'detalle' => $this->input->post('detalle'),
         'valor' => $this->input->post('valor'),
         'fecha_gasto' => $this->input->post('fecha_gasto'),
         'id_generado_por' => $id_generado_por,
         'fecha_ingreso' => date("Y/m/d"),
         'id_ingresado_por' => $id_ingresado_por
      	);
			    
		$this->db->insert('cab_gasto', $data);

		$result = $this->db->query("SELECT max(c.id_cab_gasto) as id_cab_gasto FROM cab_gasto c WHERE c.id_ingresado_por=" .$id_ingresado_por); 

			//"SELECT c.id_cab_gasto FROM cab_gasto c WHERE c.detalle='".$this->input->post('detalle')."' and c.valor=". $this->input->post('valor') ." and c.fecha_gasto ='". $this->input->post('fecha_gasto') ."' and c.id_generado_por =". $id_generado_por ." and c.fecha_ingreso= '". date("Y/m/d") ."' and c.id_ingresado_por=". $id_ingresado_por);
		$cab_gasto = $result->row_array();
		return $cab_gasto["id_cab_gasto"];
	}

	public function consulta_cab_gastos_validar()
	{
		/*
		Se conecta con una llama del Script por AJAX
		*/
		$result = $this->db->query("SELECT G.id_cab_gasto, u.nombre, u.apellido, G.fecha_gasto, G.detalle, G.valor FROM cab_gasto G, usuario u where G.id_generado_por = u.id_usuario and G.estado='pendiente' and G.valor<>0");

		$arreglo = null;		
		foreach ($result->result_array() as $row) {
			$arreglo["data"][] = $row;
		}
		
		//********************************************
		//En caso que no exista informaci�n de gastos 
		//********************************************
		if ( $result->num_rows() <= 0 )
		{
			$arreglo["data"]=[];
		}

		echo json_encode($arreglo);

	}
	
		public function consulta_cab_gastos_cuadre()
	{
		/*
		Se conecta con una llama del Script por AJAX
		*/
		$result = $this->db->query("SELECT c.id_cab_gasto, c.fecha_gasto, c.detalle, c.valor, round((select sum(c1.valor) from cab_gasto c1 where c1.id_generado_por=". $this->input->post('id_cobrador'). " and c1.estado='validado' and c1.fecha_gasto>='". $this->input->post('fecha_i'). "' and c1.fecha_gasto<='". $this->input->post('fecha_f'). "'),2) as t_cab_gasto FROM cab_gasto c WHERE c.detalle NOT LIKE 'MORA:%' and c.estado='validado' and c.fecha_gasto <='". $this->input->post('fecha_f'). "' and c.fecha_gasto >='". $this->input->post('fecha_i'). "' and c.id_generado_por =". $this->input->post('id_cobrador'));


		$arreglo = null;		
		foreach ($result->result_array() as $row) {
			
			$arreglo["data"][] = $row;
		}

		//****************************************************************
		//En caso que no exista informaci�n de creditos para el usuario
		//****************************************************************
		if ( $result->num_rows() <= 0 )
		{
			$arreglo["data"]=[];
		}

		echo json_encode($arreglo);

	}

	public function cuadre_ingreso_abono($id_abono,$fecha,$detalle,$valor,$id_cuadre_caja)
	{	
		//***************************************************
		//Actualiza el estado de Cuadre_Caja a 'cancelado' 
		//***************************************************
		$this->db->set('cuadre_caja',"cancelado");
      	$this->db->where('id_abono', $id_abono);
      	$this->db->update('abono');

      	//****************************************
      	// Inserta el detalle del Cuadre de Caja
      	//****************************************
      	$data = array(         
         'id' => $id_abono,
         'fecha' => $fecha,         
         'detalle' => $detalle,
         'valor' => $valor,
         'tipo' => 'AC',
         'id_cuadre_caja' => $id_cuadre_caja,            
      	);

      	$this->db->insert('detalle_cuadre_caja', $data);

      	return 1;
	}

	public function cuadre_ingreso_credito($id_cab_credito,$fecha,$detalle,$valor,$id_cuadre_caja)
	{	
		//***************************************************
		//Actualiza el estado de Cuadre_Caja a 'cancelado' 
		//***************************************************
		$this->db->set('cuadre_caja',"cancelado");
      	$this->db->where('id_cab_credito', $id_cab_credito);
      	$this->db->update('cab_credito');

      	//****************************************
      	// Inserta el detalle del Cuadre de Caja
      	//****************************************
      	$data = array(         
         'id' => $id_cab_credito,   
         'fecha' => $fecha,         
         'detalle' => $detalle,
         'valor' => $valor,
         'tipo' => 'NC',
         'id_cuadre_caja' => $id_cuadre_caja,            
      	);

      	$this->db->insert('detalle_cuadre_caja', $data);

      	return 1;
	}

	public function cuadre_ingreso_cab_gastos($id_cab_gasto,$fecha,$detalle,$valor,$id_cuadre_caja)
	{	
		//***************************************************
		//Actualiza el estado de Cuadre_Caja a 'cancelado' 
		//***************************************************
		$this->db->set('estado',"cancelado");
      	$this->db->where('id_cab_gasto', $id_cab_gasto);
      	$this->db->update('cab_gasto');

      	//****************************************
      	// Inserta el detalle del Cuadre de Caja
      	//****************************************
      	$data = array(         
         'id' => $id_cab_gasto,   
         'fecha' => $fecha,         
         'detalle' => $detalle,
         'valor' => $valor,
         'tipo' => 'DG',
         'id_cuadre_caja' => $id_cuadre_caja,            
      	);

      	$this->db->insert('detalle_cuadre_caja', $data);

      	return 1;
	}
	
		//***********************************************************************************
	//Muestra cuales son los creditos 
	//***********************************************************************************
	public function listar_todos_creditos($id_usuario)
	{
		/*
		Se conecta con una llama del Script por AJAX
		*/
		$result = $this->db->query("
			SELECT CC.id_cab_credito, 
			CC.fecha_i, 
			CI.nombre, 
			CI.apellido, 
			CC.mora, 
			CC.totalapagar,
			CC.totalpagado,
			CC.estado, 
			CC.d_mora, 
			(SELECT round(sum(CC1.totalapagar - CC1.totalpagado),2) 
				FROM cliente CI1, cab_credito CC1 
				WHERE CI1.id_cliente=CC1.id_cliente 
				and CI1.id_usuario = CI.id_usuario 
				and CC1.estado='pendiente') as t_saldo 
			FROM cliente CI, cab_credito CC 
			WHERE CI.id_cliente=CC.id_cliente 
			and CI.id_usuario =". $id_usuario. "
			and estado!='eliminado' 
			AND (CC.totalapagar - CC.totalpagado) > 0
			AND CC.estado = 'pendiente'
			ORDER BY CC.estado DESC");

		$arreglo = null;		
		foreach ($result->result_array() as $row) {
			$arreglo["data"][] = $row;
		}
		
		//****************************************************************
		//En caso que no exista informaci�n de solicitudes para el usuario
		//****************************************************************
		if ( $result->num_rows() <= 0 )
		{
			$arreglo["data"]=[];
		}

		echo json_encode($arreglo);

	}

	public function consulta_informacion_credito($id_cab_credito)
	{
		//*************************************************************************
		//Busca toda la infomaci�n de la cabecera del cr�dito que esta seleccionado
		//*************************************************************************
		$result = $this->db->query("SELECT cc.id_cab_credito, c.nombre, c.apellido, cc.valor, cc.tasa, cc.plazo, cc.fecha_i, cc.fecha_f, cc.interes, cc.totalapagar, cc.mora, cc.estado, cc.totalpagado, f.descripcion FROM cab_credito cc, cliente c, formadepago f WHERE cc.id_cliente=c.id_cliente and cc.id_formadepago=f.id_formadepago and cc.id_cab_credito=" . $id_cab_credito);
		return $result;

	}

	public function consulta_informacion_credito_det($id_cab_credito)
	{
		//*************************************************************************
		//Busca toda la infomaci�n de la cabecera del cr�dito que esta seleccionado
		//*************************************************************************
		$result = $this->db->query("SELECT * FROM det_credito WHERE id_cab_credito=" . $id_cab_credito);
		$arreglo = null;		
		foreach ($result->result_array() as $row) {
			$arreglo["data"][] = $row;
		}
		
		//****************************************************************
		//En caso que no exista informaci�n de solicitudes para el usuario
		//****************************************************************
		if ( $result->num_rows() <= 0 )
		{
			$arreglo["data"]=[];
		}
		echo json_encode($arreglo);
	}

	public function eliminar_credito($id_cab_credito,$estado)
	{	
		$this->db->set('estado',$estado);
      	$this->db->where('id_cab_credito', $id_cab_credito);
      	$this->db->update('cab_credito');

      	$this->db->set('estado',$estado);
      	$this->db->where('id_cab_credito', $id_cab_credito);
      	$this->db->update('det_credito');

      	return 1;
	}
	public function listar_cuadre_caja()
	{
		//*************************************************************************
		//Busca toda la infomaci�n de la cabecera del cr�dito que esta seleccionado
		//*************************************************************************
		$result = $this->db->query("SELECT cc.id_cuadre_caja, cc.fecha_i, cc.fecha_f, cc.t_cuadre_caja, u.nombre, u.apellido FROM cuadre_caja cc, usuario u WHERE cc.id_cobrador=u.id_usuario");
		$arreglo = null;		
		foreach ($result->result_array() as $row) {
			$arreglo["data"][] = $row;
		}
		
		//****************************************************************
		//En caso que no exista informaci�n de solicitudes para el usuario
		//****************************************************************
		if ( $result->num_rows() <= 0 )
		{
			$arreglo["data"]=[];
		}
		echo json_encode($arreglo);
	}

	public function consulta_cuadre_caja_anterior()
	{
		//*************************************************************************
		//Busca toda la infomaci�n de la cabecera del cr�dito que esta seleccionado
		//*************************************************************************
		$id_cuadre_caja = $this->input->post('id_cuadre_caja');
		$tipo = $this->input->post('tipo');
		$campo_tabla = $this->input->post('campo_tabla');

		$result = $this->db->query("SELECT dcc.id,dcc.fecha,dcc.detalle,dcc.valor," . $campo_tabla. ",cc.t_cuadre_caja FROM detalle_cuadre_caja dcc, cuadre_caja cc WHERE cc.id_cuadre_caja = dcc.id_cuadre_caja and dcc.id_cuadre_caja=" . $id_cuadre_caja . " and dcc.tipo='" . $tipo ."' ORDER BY dcc.id");
		$arreglo = null;		
		foreach ($result->result_array() as $row) {
			$arreglo["data"][] = $row;
		}
		
		//****************************************************************
		//En caso que no exista informaci�n de solicitudes para el usuario
		//****************************************************************
		if ( $result->num_rows() <= 0 )
		{
			$arreglo["data"]=[];
		}
		echo json_encode($arreglo);
	}
	
	public function actualizar_mora()
	{
		//*****************************************************
		//Consulta todos los creditos vencidos y actualiza la mora
		//*****************************************************
		$query = $this->db->query("SELECT cc.id_cab_credito, (DATEDIFF(CURDATE(),cc.fecha_f)) as d_vencidos, 	round(((cc.interes/cc.plazo)*(DATEDIFF(CURDATE(),cc.fecha_f))),2) as mora, cc.valor, cc.interes FROM cab_credito cc where cc.fecha_f < CURDATE() and cc.estado='pendiente'");
		
		foreach ($query->result_array() as $row) {
			$d_mora = $row["d_vencidos"];
			$mora = round($row["mora"],2);
			$totalapagar = $row["valor"] + $row["interes"] + $mora;
			$id_cab_credito = $row["id_cab_credito"];

			$this->db->set('d_mora',$d_mora);
			$this->db->set('mora',$mora);
			$this->db->set('totalapagar',$totalapagar);
      		$this->db->where('id_cab_credito', $id_cab_credito);
      		$this->db->update('cab_credito');

      		//*****************************************************
			//Ingresa cuota de mora 
			//*****************************************************
      		$result = $this->db->query("SELECT id_det_credito FROm det_credito where n_cuota=0 and id_cab_credito=" . $id_cab_credito);
			//****************************************************************
			//En caso que no exista couta de mora
			//****************************************************************
			if ( $result->num_rows() <= 0 )
			{
				//******************************************
				//Se inserta el detalle del credito (cuota mora)
				//******************************************
				 	$registro = array(
			      	 	'id_cab_credito' => $id_cab_credito,
			      	 	'n_cuota' => 0,
			      	 	'fechapago' => date("Y/m/d"),
			      	 	'v_cuota' => $mora,
			      	 	'abono' => 0,
			      	 	'estado' => "pendiente"	
			     	);	
			    
			     	$this->db->insert('det_credito', $registro);
				 
			}
			else
			{	

				$query = $result->row_array();				
				$id_det_credito = $query['id_det_credito'];
				$this->db->set('fechapago', date("Y/m/d"));
				$this->db->set('v_cuota',$mora);
	      		$this->db->where('id_det_credito', $id_det_credito);
	      		$this->db->update('det_credito');
			}

		}
		
	}

	public function registrar_gasto_mora($id_cobrador, $valor, $id_cab_credito, $cliente)
	{
		//****************************************************
		//Inserta como un gasto la MORA que no se ha cobrado
		//****************************************************
		$data = array(                          
         'detalle' => $cliente,
         'valor' => $valor,
         'fecha_gasto' => date("Y/m/d"),
         'id_generado_por' => $id_cobrador,
         'fecha_ingreso' => date("Y/m/d"),
         'id_ingresado_por' => $id_cobrador
      	);
			    
		$this->db->insert('cab_gasto', $data);

		$result = $this->db->query("SELECT max(c.id_cab_gasto) as id_cab_gasto FROM cab_gasto c WHERE c.id_ingresado_por=" .$id_cobrador); 

		$cab_gasto = $result->row_array();
		
		$data = array(                          
         'detalle' => $cliente,
         'valor' => $valor,
         'fecha_gasto' => date("Y/m/d"),
         'id_usuario' => $id_cobrador,
         'fecha_ingreso' => date("Y/m/d"),
         'id_cab_gasto' => $cab_gasto["id_cab_gasto"]
      	);
			    
		$this->db->insert('gasto', $data);
	}
    public function consulta_allclientes_cobrador($id_usuario)
	{
		/*
		Se conecta con una llama del Script por AJAX
		*/	
		$result = $this->db->query("SELECT id_cliente,cedula, nombre,apellido, celular FROM cliente WHERE id_usuario=".$id_usuario);

		$arreglo = null;		
		foreach ($result->result_array() as $row) {
			$arreglo["data"][] = $row;
		}
		
		//****************************************************************
		//En caso que no exista informaci�n de solicitudes para el usuario
		//****************************************************************
		if ( $result->num_rows() <= 0 )
		{
			$arreglo["data"]=[];
		}
		echo json_encode($arreglo);
	}
	public function historial_cliente_det($id_cliente)
	{
		//*************************************************************************
		//Busca la infomaci�n del Cliente que esta seleccionado
		//*************************************************************************
		$result = $this->db->query("SELECT c.id_cliente, c.nombre, c.apellido FROM cliente c WHERE c.id_cliente=" . $id_cliente);
		return $result;
	}

	//***********************************************************************************
	//Muestra cuales son los creditos cancelados para el historial 
	//***********************************************************************************
	public function historial_cliente_cancelados($id_cliente)
	{
		/*
		Se conecta con una llama del Script por AJAX
		*/
		$result = $this->db->query("SELECT CC.id_cab_credito, CC.fecha_i, CC.interes, CC.mora, (SELECT round(sum(CC1.interes),2) FROM cliente CI1, cab_credito CC1 WHERE CI1.id_cliente=CC1.id_cliente and CC1.id_cliente =". $id_cliente. " and CC1.estado='cancelado') as t_interes, (SELECT round(sum(CC1.mora),2) FROM cliente CI1, cab_credito CC1 WHERE CI1.id_cliente=CC1.id_cliente and CC1.id_cliente =". $id_cliente. " and CC1.estado='cancelado') as t_mora FROM cliente CI, cab_credito CC WHERE CI.id_cliente=CC.id_cliente and CC.id_cliente =". $id_cliente. " and estado='cancelado'");

		$arreglo = null;		
		foreach ($result->result_array() as $row) {
			$arreglo["data"][] = $row;
		}
		
		//****************************************************************
		//En caso que no exista informaci�n de solicitudes para el usuario
		//****************************************************************
		if ( $result->num_rows() <= 0 )
		{
			$arreglo["data"]=[];
		}

		echo json_encode($arreglo);

	}

		//***********************************************************************************
	//Muestra cuales son los creditos pendientes para el historial 
	//***********************************************************************************
	public function historial_cliente_pendientes($id_cliente)
	{
		/*
		Se conecta con una llama del Script por AJAX
		*/
		$result = $this->db->query("SELECT CC.id_cab_credito, CC.fecha_i, CC.valor, CC.interes, CC.mora, CC.totalpagado, CC.totalapagar, (SELECT round(sum(CC1.totalapagar - CC1.totalpagado),2) FROM cliente CI1, cab_credito CC1 WHERE CI1.id_cliente=CC1.id_cliente and CC1.id_cliente =". $id_cliente. " and CC1.estado='pendiente') as t_saldo FROM cliente CI, cab_credito CC WHERE CI.id_cliente=CC.id_cliente and CC.id_cliente =". $id_cliente. " and estado='pendiente'");

		$arreglo = null;		
		foreach ($result->result_array() as $row) {
			$arreglo["data"][] = $row;
		}
		
		//****************************************************************
		//En caso que no exista informaci�n de solicitudes para el usuario
		//****************************************************************
		if ( $result->num_rows() <= 0 )
		{
			$arreglo["data"]=[];
		}

		echo json_encode($arreglo);

	}

	/**Compartir detalle del credito actual */
	public function compartirDetalleCredito($id_det_credito)
	{	
		$result = $this->db->query("SELECT cc.d_mora, dc.*, c.celular FROM det_credito AS dc
			INNER JOIN cab_credito AS cc ON cc.id_cab_credito = dc.id_cab_credito
			INNER JOIN cliente AS c ON c.id_cliente = cc.id_cliente
			WHERE cc.id_cab_credito = (SELECT id_cab_credito FROM det_credito WHERE id_det_credito = $id_det_credito)
		");
		
		$arreglo = null;
		$detalleString = "*DETALLE*".'%0A';
		$num_celular = isset($result->result_array()[0]['celular']) ? $result->result_array()[0]['celular'] : '';
		$diasMora = isset($result->result_array()[0]['d_mora']) ? $result->result_array()[0]['d_mora'] : '';
		foreach ($result->result_array() as $row) {
			$saldo = $row['v_cuota']-$row['abono'];
			if($row['n_cuota'] == 0){
				$detalleString = $detalleString.'*Mora*'.'%0A';
				$detalleString = $detalleString.'- Días: '.$diasMora.'%0A';
			}else{
				$detalleString = $detalleString.'*Cuota'.$row['n_cuota'].'*'.'%0A';
			}
			$detalleString = $detalleString.'- Fecha: '.$row['fechapago'].'%0A';
			$detalleString = $detalleString.'- Valor: $'.$row['v_cuota'].'%0A';
			$detalleString = $detalleString.'- Saldo: $'.$saldo.'%0A';
			$detalleString = $detalleString.'- Estado: '.$row['estado'].'%0A';
		}
		$resultData = array(
			'success' => true,
			'data' => $detalleString,
			'celular' => $num_celular
		);

		return $resultData;
		
	}

}?>