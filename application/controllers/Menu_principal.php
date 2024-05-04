<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu_principal extends CI_Controller {

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
	public function inicio()
	{
		//******************************************************
		//Leo la variable de sesión para leer los datos internos
		//******************************************************
		$array = $this->session->userdata('usuario_data');
		if ($array['tipo_usuario'] == "administrador")
		{
			$this->load->view('rol_admin', $array);
		}elseif ($array['tipo_usuario'] == "cobrador")
		{
			$this->load->view('rol_cobrador', $array);
		}else
		{
			redirect(base_url());
		}			
	}

	public function solicitud_permiso()
	{
		//******************************************************
		//Leo la variable de sesión para leer los datos internos
		//******************************************************							
		$array = $this->session->userdata('usuario_data');				
		$this->load->view('solicitud_permiso',$array);
	}

	public function historial_permisos_solicitados()
	{
		$array = $this->session->userdata('usuario_data');		
		$this->load->view('historial_permisos_solicitados',$array);
	}

	public function aprobar_solicitudes()
	{
		$array = $this->session->userdata('usuario_data');		
		$this->load->view('aprobar_solicitudes',$array);
	}

	public function historial_solicitudes_tramitadas()
	{
		$array = $this->session->userdata('usuario_data');		
		$this->load->view('historial_solicitudes_tramitadas',$array);	
	}

	public function reportes()
	{
		$array = $this->session->userdata('usuario_data');		
		$this->load->view('reportes',$array);	
	}

	public function crear_cliente()
	{
		$listado_cliente = $this->session->userdata('listado_cliente');		
		$this->load->view('crear_cliente',$listado_cliente);	

		//***************************************************************
		//Envia la lista de clientes para que aparezca en el combobox
		//***************************************************************
		//$this->load->model('validacion_model');
		//$result=$this->validacion_model->consulta_clientes($array_tmp['id_usuario']); 
		//$cliente = array('clientes' => $result );
		

		/* 
		$this->load->model('validacion_model');
		$query =$this->validacion_model->consulta_detalle_credito($_POST['id_detalle_credito']);

		$this->load->model('categorias_mdl');
	    $result = $this->categorias_mdl->getCategorias();
	    $cat = array('categorias' => $result);

	    $this->load->model('productos_mdl');
	    $result = $this->productos_mdl->getProductos();
	    $prod = array('productos' => $result);

	    $this->load->view('header');
	    $this->load->view('categorias', $cat);
	    $this->load->view('principal', $prod);
	    $this->load->view('footer');*/

	}

	public function cuadre_semanal_administrador()
	{
		
		//***************************************************************
		//Envia la lista de cobradores para que aparezca en el combobox
		//***************************************************************
		$listado = $this->session->userdata('listado_usuario');
		$this->load->view('cuadre_semanal_administrador',$listado);	
	
	}

	public function ganancia()
	{
		
		//***************************************************************
		//Envia la lista de cobradores para que aparezca en el combobox
		//***************************************************************
		$listado = $this->session->userdata('listado_usuario');
		$this->load->view('ganancia',$listado);	
	
	}

	public function cuadre_caja()
	{
		
		//***************************************************************
		//Envia la lista de cobradores para que aparezca en el combobox
		//***************************************************************
		$listado = $this->session->userdata('listado_usuario');
		$this->load->view('cuadre_caja',$listado);	
	
	}

	public function crear_prestamo()
	{
		$listado_cliente = $this->session->userdata('listado_cliente');		
		$this->load->view('crear_prestamo',$listado_cliente);	
	}

	public function crear_cobrador()
	{
		$array = $this->session->userdata('usuario_data');		
		$this->load->view('crear_cobrador',$array);	
	}

	public function abono()
	{
		$array = $this->session->userdata('detalle_credito');		
		$this->load->view('abono',$array);	
	}

	public function abonos_realizados()
	{
		$array = $this->session->userdata('detalle_credito');		
		$this->load->view('abonos_realizados',$array);	
	}
	
	public function consultar_abonos()
	{
		$array = $this->session->userdata('usuario_data');		
		$this->load->view('consultar_abonos',$array);	
	}

	public function menu_reporte()
	{
		$array = $this->session->userdata('usuario_data');		
		$this->load->view('menu_reportes',$array);	
	}

	public function ingresar_gastos_administrador()
	{
		//***************************************************************
		//Envia la lista de cobradores para que aparezca en el combobox
		//***************************************************************
		$listado = $this->session->userdata('listado_usuario');
		$this->load->view('ingresar_gastos',$listado);	
	}

	public function ingresar_caja()
	{
		//***************************************************************
		//Envia la lista de cobradores para que aparezca en el combobox
		//***************************************************************
		$listado = $this->session->userdata('listado_usuario');
		$this->load->view('ingresar_caja',$listado);	
	}

	public function ingresar_gastos_cobradores()
	{
	    //***************************************************************
		//Envia la lista de cobradores para que aparezca en el combobox
		//***************************************************************
		$listado = $this->session->userdata('listado_usuario');
		$this->load->view('ingresar_gastos_cobrador',$listado);
		//$this->load->view('ingresar_gastos_cobrador');	
	}
	public function editar_cliente()
	{
		$array = $this->session->userdata('id_cliente');		
		$listado_cliente = $this->session->userdata('listado_cliente');		
		$datos['cliente']=$array;
		$datos['listado']=$listado_cliente;
		$this->load->view('editar_cliente',$datos);		
	}
	public function editar_cobrador()
	{
		$array = $this->session->userdata('cobrador');		
		$this->load->view('editar_cobrador',$array);			
	}
	public function amortizacion()
	{
		$array = $this->session->userdata('usuario_data');		
		$this->load->view('consulta_amortizacion',$array);	
	}
	
	public function consulta_informacion_credito()
	{
		$array = $this->session->userdata('cab_credito');		
		$this->load->view('consulta_informacion_credito',$array);	
	}
	public function consultar_cuadre_caja()
	{	
		//***************************************************************
		//Envia la lista de cobradores para que aparezca en el combobox
		//***************************************************************
		$listado = $this->session->userdata('listado_usuario');
		$this->load->view('consultar_cuadre_caja',$listado);	
	}

	public function consultar_cuadre_caja_det()
	{
		$id_cuadre_caja = $this->session->userdata('id_cuadre_caja');		
		$fecha_inicio = $this->session->userdata('fecha_inicio');		
		$fecha_fin = $this->session->userdata('fecha_fin');		
		$cobrador = $this->session->userdata('cobrador');		
		$datos['id_cuadre_caja']=$id_cuadre_caja;
		$datos['fecha_inicio']=$fecha_inicio;
		$datos['fecha_fin']=$fecha_fin;
		$datos['cobrador']=$cobrador;

		$this->load->view('consultar_cuadre_caja_det',$datos);	
	}
	public function menu_reporte_cobradores()
	{
		$array = $this->session->userdata('usuario_data');		
		$this->load->view('menu_reportes_cobradores',$array);	
	}
	public function consultar_abonos_cobradores()
	{
		$array = $this->session->userdata('usuario_data');		
		$this->load->view('consultar_abonos_cobradores',$array);	
	}
	public function amortizacion_cobradores()
	{
		$array = $this->session->userdata('usuario_data');		
		$this->load->view('consulta_amortizacion_cobradores',$array);	
	}
	public function consulta_informacion_credito_cobradores()
	{
		$array = $this->session->userdata('cab_credito');		
		$this->load->view('consulta_informacion_credito_cobradores',$array);	
	}
	public function historial()
	{
		$array = $this->session->userdata('usuario_data');		
		$this->load->view('historial_cliente',$array);	
	}
	
	public function historial_cliente_det()
	{
		$array = $this->session->userdata('cliente');		
		$this->load->view('historial_cliente_det',$array);	
	}
}?>