<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Validacion extends CI_Controller {

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
	public function mostrar_ranking_motivo()
	{
		$this->load->model('validacion_model');		
		$query = $this->validacion_model->mostrar_ranking_motivo();
	}

	public function mostrar_mas_permisos()
	{
		$this->load->model('validacion_model');		
		$query = $this->validacion_model->mostrar_mas_permisos();
	}	

	public function ingresadasvsaprobadas()
	{
		$this->load->model('validacion_model');		
		$query = $this->validacion_model->ingresadasvsaprobadas();
	}	

	public function consulta()
	{
		
		$this->load->model('validacion_model');
		$array_tmp = $this->session->userdata('usuario_data');
		$this->validacion_model->consulta_datos($array_tmp['id_empleado']);
	}

	public function consulta_tramitadas()
	{
		
		$this->load->helper('array');

		$this->load->model('validacion_model');		
		$query = $this->validacion_model->consulta_solicitudes_tramitadas();


	}

	public function consulta_tramitadas_filtros()
	{
		$this->load->model('validacion_model');		
		$query = $this->validacion_model->consulta_solicitudes_tramitadas_filtros();


		

		//print element('color', $array);
	}

	public function datos_aprobacion()
	{
		$this->load->model('validacion_model');
		//$array_tmp = $this->session->userdata('usuario_data');
		$query = $this->validacion_model->datos_aprobacion();
										
	}

	public function consulta_datos_aprobar()
	{
		
		$this->load->model('validacion_model');
		$array_tmp = $this->session->userdata('usuario_data');
		$this->validacion_model->consulta_datos_aprobar();
	}

	

	public function salir()
	{
		echo "verficado";
		$this->session->unset_userdata('usuario_data');
		//redirect(base_url());
	}

	/*public function ingresar_solicitud()
	{
		//$this->load->view('welcome_message');
		$this->load->model('validacion_model');

		//***********************************
		//Upload del archivo al servidor web
		//***********************************		 	

        $config['upload_path']          = './files/';
        $config['allowed_types']        = 'jpg|png';
        $config['max_size']             = 1024*2;
        $config['encrypt_name'] 		= TRUE;
        $config['overwrite']	 		= FALSE;
        $config['remove_spaces'] 		= TRUE;
        
        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        
        if(isset($_FILES['user_file']) && $_FILES['user_file']['size'] > 0)
        {
	        if($this->upload->do_upload('user_file'))
	        {
	        	//*********************************************************************************
				//Realiza la inserci�n de la solicitud al Model con el nombre del archivos adjunto
				//*********************************************************************************
	        	$data_file = $this->upload->data();        	
	        	$query = $this->validacion_model->insertar_solicitud($data_file['file_name']);
	        	
	        }
	        else
	        {        		        	
	        	alert("Existe un problema con el archivo. Intente m�s tarde.");
	        	return 0;	        		       
	        }
	    }
	    else
	    {
	    	//********************************************************************
			//Realiza la inserci�n de la solicitud al Model sin archivos adjuntos
			//********************************************************************
	    	$query = $this->validacion_model->insertar_solicitud("");	    		    	
	    }
		
	}*/

	public function eliminar_solicitud()
	{
		//$this->load->view('welcome_message');
		$this->load->model('validacion_model');
		//***********************************************
		//Realiza la eliminaci�n de la solicitud al Model 
		//***********************************************
		$query = $this->validacion_model->eliminar_solicitud();
		
		
	}

	public function actualizar_solicitud()
	{
		//$this->load->view('welcome_message');
		$this->load->model('validacion_model');

		//***********************************
		//Upload del archivo al servidor web
		//***********************************		 	

        $config['upload_path']          = './files/';
        $config['allowed_types']        = 'jpg|png';
        $config['max_size']             = 1024*2;
        $config['encrypt_name'] 		= TRUE;
        $config['overwrite']	 		= FALSE;
        $config['remove_spaces'] 		= TRUE;
        
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if(isset($_FILES['user_file']) && $_FILES['user_file']['size'] > 0)
        {
        	if($this->upload->do_upload('user_file'))
	        {
				//***************************************
	        	//Se elimina el anterior archivo adjunto
	        	//***************************************
	        	$path = "files/".$this->input->post('archivo_tmp');
				if (file_exists($path))
				{
					unlink($path);	
				}
				
				//********************************************************************
				//Realiza la actualizaci�n de la solicitud al Model sin archivos adjuntos
				//********************************************************************
				$data_file = $this->upload->data();        	
	        	$query = $this->validacion_model->actualizar_solicitud($data_file['file_name']);
	        }	        
	        else
	        {        		        	
	        	alert("Existe un problema con el archivo. Intente m�s tarde.");
	        	return 0;	        		       
	        }
        }
        else
	    {
	    	//******************************************************
	    	//Se verifica si el usuario elimin� el archivo adjunto
	    	//******************************************************
	    	$var = $this->input->post('elimino_archivo');
	    	if ($var == 1)
	    	{
	    		//***************************************
	        	//Se elimina el anterior archivo adjunto
	        	//***************************************
	        	$path = "files/".$this->input->post('archivo_tmp');
				if (file_exists($path))
				{
					unlink($path);	
				}

		    	//********************************************************************
				//Realiza la actualizaci�n de la solicitud al Model sin archivos adjuntos
				//********************************************************************

				$query = $this->validacion_model->actualizar_solicitud("");	
	    	}
	    	else
	    	{
   		    	//********************************************************************
				//Realiza la actualizaci�n de la solicitud al Model sin archivos adjuntos
				//********************************************************************

	    		$query = $this->validacion_model->actualizar_solicitud("no_eliminar");	
	    	}

	    	    		    	
	    }
		//***********************************************
		//Realiza la inserci�n de la solicitud al Model 
		//***********************************************
		//$query = $this->validacion_model->actualizar_solicitud();
		
	}

	public function aprobar_solicitud()
	{
		//$this->load->view('welcome_message');
		$this->load->model('validacion_model');

		$query = $this->validacion_model->aprobar_solicitud();

		//***********************************
		//Upload del archivo al servidor web
		//***********************************		 	

        /*
        $config['upload_path']          = './files/';
        $config['allowed_types']        = 'jpg|png';
        $config['max_size']             = 1024*2;
        $config['encrypt_name'] 		= TRUE;
        $config['overwrite']	 		= FALSE;
        $config['remove_spaces'] 		= TRUE;
        
        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        
        if(isset($_FILES['user_file']) && $_FILES['user_file']['size'] > 0)
        {
	        if($this->upload->do_upload('user_file'))
	        {
	        	//*********************************************************************************
				//Realiza la inserci�n de la solicitud al Model con el nombre del archivos adjunto
				//*********************************************************************************
	        	$data_file = $this->upload->data();        	
	        	$query = $this->validacion_model->insertar_solicitud($data_file['file_name']);
	        	
	        }
	        else
	        {        		        	
	        	alert("Existe un problema con el archivo. Intente m�s tarde.");
	        	return 0;	        		       
	        }
	    }
	    else
	    {
	    	//********************************************************************
			//Realiza la inserci�n de la solicitud al Model sin archivos adjuntos
			//********************************************************************
	    	$query = $this->validacion_model->insertar_solicitud("");	    		    	
	    }*/
		
	}

	public function login()
	{
		if (isset($_POST['password'])) //Verifica que no se haya ubicado la pag�na directamente, sin pasar por el login
		{
			$this->load->model('validacion_model');
			
			//*************************************************************************************
			//Realiza la consulta al Model para que verificar si el usuario y la clave corresponde		
			//*************************************************************************************			
			$query = $this->validacion_model->login($_POST['username'],$_POST['password']); 
			if($query->num_rows()>0)
			{				
				$usuario_data = $query->row_array(); //El resultado del Query lo convierto en un Array.				
				$this->session->set_userdata('usuario_data',$usuario_data);
				redirect(base_url().'index.php/menu_principal/inicio');
			}
			else
			{
				redirect(base_url());
			}
		}
		else
		{			
			redirect(base_url()); // en caso que presionen el boton sin ingresar los datos, simplemente se recarga la p�gina
		}	
	}

	public function crear_cliente()
	{
		$array_tmp = $this->session->userdata('usuario_data');
		//$this->session->set_userdata('usuario_data',$array_tmp);	
		$this->load->model('validacion_model');
		$data['clientes'] =$this->validacion_model->consulta_clientes($array_tmp['id_usuario']);
		$this->session->set_userdata('listado_cliente',$data);
		redirect(base_url().'index.php/menu_principal/crear_cliente');
	}
	

	public function cuadre_semanal()
	{
		$array_tmp = $this->session->userdata('usuario_data');
		//$this->session->set_userdata('usuario_data',$array_tmp);	
		$this->load->model('validacion_model');

		if ($array_tmp['id_usuario'] == 1)
		{
			$data['cobradores'] =$this->validacion_model->consulta_cobradores();
			$this->session->set_userdata('listado_usuario',$data);
			redirect(base_url().'index.php/menu_principal/cuadre_semanal_administrador');	
		}

	}

	public function cuadre_caja()
	{
		$array_tmp = $this->session->userdata('usuario_data');
		//$this->session->set_userdata('usuario_data',$array_tmp);	
		$this->load->model('validacion_model');

		if ($array_tmp['id_usuario'] == 1)
		{
			$data['cobradores'] =$this->validacion_model->consulta_cobradores();
			$this->session->set_userdata('listado_usuario',$data);
			redirect(base_url().'index.php/menu_principal/cuadre_caja');	
		}

	}

	public function ganancia()
	{
		$array_tmp = $this->session->userdata('usuario_data');
		//$this->session->set_userdata('usuario_data',$array_tmp);	
		$this->load->model('validacion_model');

		if ($array_tmp['id_usuario'] == 1)
		{
			$data['cobradores'] =$this->validacion_model->consulta_cobradores();
			$this->session->set_userdata('listado_usuario',$data);
			redirect(base_url().'index.php/menu_principal/ganancia');	
		}

	}

	public function consultar_abonos()
	{
		$array_tmp = $this->session->userdata('usuario_data');
		//$this->session->set_userdata('usuario_data',$array_tmp);	
		$this->load->model('validacion_model');
		
		if ($array_tmp['id_usuario'] == 1)
		{
			redirect(base_url().'index.php/menu_principal/consultar_abonos');
		}
		else
		{
			redirect(base_url().'index.php/menu_principal/consultar_abonos_cobradores');	
		}
	}

	public function crear_prestamo()
	{
		$array_tmp = $this->session->userdata('usuario_data');	
		$this->load->model('validacion_model');
		$data['clientes'] =$this->validacion_model->consulta_clientes($array_tmp['id_usuario']);
		$this->session->set_userdata('listado_cliente',$data);

		redirect(base_url().'index.php/menu_principal/crear_prestamo');
	}

	public function crear_cobrador()
	{
		//$array_tmp = $this->session->userdata('usuario_data');
		//$this->session->set_userdata('usuario_data',$array_tmp);	
		redirect(base_url().'index.php/menu_principal/crear_cobrador');
	}

	public function menu_reporte()
	{
		$array_tmp = $this->session->userdata('usuario_data');
		//$this->session->set_userdata('usuario_data',$array_tmp);	
		$this->load->model('validacion_model');

		if ($array_tmp['id_usuario'] == 1)
		{
			redirect(base_url().'index.php/menu_principal/menu_reporte');	
		}
		else
		{
			redirect(base_url().'index.php/menu_principal/menu_reporte_cobradores');	
		}	
		
	}

	public function ingresar_gastos()
	{
		$array_tmp = $this->session->userdata('usuario_data');
		//$this->session->set_userdata('usuario_data',$array_tmp);	
		$this->load->model('validacion_model');

		if ($array_tmp['id_usuario'] == 1)
		{
			$data['cobradores'] =$this->validacion_model->consulta_cobradores();
			$this->session->set_userdata('listado_usuario',$data);
			redirect(base_url().'index.php/menu_principal/ingresar_gastos_administrador');	
		}
		else
		{
			$data['cobradores'] =$this->validacion_model->consulta_cobradores();
			$this->session->set_userdata('listado_usuario',$data);
			redirect(base_url().'index.php/menu_principal/ingresar_gastos_cobradores');	
		}
		
	}

	public function ingresar_caja()
	{
		$array_tmp = $this->session->userdata('usuario_data');
		//$this->session->set_userdata('usuario_data',$array_tmp);	
		$this->load->model('validacion_model');

		if ($array_tmp['id_usuario'] == 1)
		{
			$data['cobradores'] =$this->validacion_model->consulta_cobradores();
			$this->session->set_userdata('listado_usuario',$data);
			redirect(base_url().'index.php/menu_principal/ingresar_caja');	
		}
		else
		{
			redirect(base_url().'index.php/menu_principal/ingresar_caja');	
		}
		
	}

	public function abono()
	{
		$this->load->model('validacion_model');
		$query =$this->validacion_model->consulta_detalle_credito($_POST['id_detalle_credito']);
		$detalle_credito = $query->row_array(); //El resultado del Query lo convierto en un Array.				
		$this->session->set_userdata('detalle_credito',$detalle_credito);
		redirect(base_url().'index.php/menu_principal/abono');
	}

	public function mostrar_abonos()
	{
		$this->load->model('validacion_model');
		$query =$this->validacion_model->consulta_abonos_realizados($_POST['id_detalle_credito']);
		$detalle_credito = $query->row_array(); //El resultado del Query lo convierto en un Array.				
		$this->session->set_userdata('detalle_credito',$detalle_credito);
		redirect(base_url().'index.php/menu_principal/abonos_realizados');
	}

	/*
	public function validar_gasto()
	{
		$this->load->model('validacion_model');
		$query =$this->validacion_model->consulta_detalle_credito($_POST['id_detalle_credito']);
		$detalle_credito = $query->row_array(); //El resultado del Query lo convierto en un Array.				
		$this->session->set_userdata('detalle_credito',$detalle_credito);
		redirect(base_url().'index.php/menu_principal/abono');
	}*/

	public function abonar_al_credito()
	{
		$this->load->model('validacion_model');
		$array_tmp = $this->session->userdata('usuario_data');
		$query =$this->validacion_model->abonar_al_credito($array_tmp['id_usuario'], $array_tmp['comision']);			
	}

	public function guardar_cliente()
	{
		$this->load->model('validacion_model');

		//***********************************
		//Guardar cliente
		//***********************************		 	
	    //***********************************
		//Upload del archivo al servidor web
		//***********************************		 	

        $config['upload_path']          = './files/';
        $config['allowed_types']        = 'jpg|png|jpeg';
        $config['max_size']             = 1024*6;
        $config['encrypt_name'] 		= TRUE;
        $config['overwrite']	 		= FALSE;
        $config['remove_spaces'] 		= TRUE;
        
        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        
        if(isset($_FILES['user_file']) && $_FILES['user_file']['size'] > 0)
        {
	        if($this->upload->do_upload('user_file'))
	        {
	        	//*********************************************************************************
				//Realiza la inserci�n de la solicitud al Model con el nombre del archivos adjunto
				//*********************************************************************************
	        	$data_file = $this->upload->data();        	
	        	$query = $this->validacion_model->insertar_cliente($data_file['file_name']);
	        	echo "1";
	        }
	        else
	        {        		        	
	        	//alert("Existe un problema con el archivo. Intente m�s tarde.");
	        	echo "0";	        		       
	        }
	    }
	    else
	    {
			$query = $this->validacion_model->insertar_cliente("");	    		    	
			echo "1";
	    }
		
	}

	public function guardar_cobrador()
	{
		$this->load->model('validacion_model');

		//***********************************
		//Guardar cobrador
		//***********************************		 	
	    //***********************************
		//Upload del archivo al servidor web
		//***********************************		 	

        $config['upload_path']          = './files/';
        $config['allowed_types']        = 'jpg|png|jpeg';
        $config['max_size']             = 1024*6;
        $config['encrypt_name'] 		= TRUE;
        $config['overwrite']	 		= FALSE;
        $config['remove_spaces'] 		= TRUE;
        
        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        
        if(isset($_FILES['user_file']) && $_FILES['user_file']['size'] > 0)
        {
	        if($this->upload->do_upload('user_file'))
	        {
	        	//*********************************************************************************
				//Realiza la inserci�n de la solicitud al Model con el nombre del archivos adjunto
				//*********************************************************************************
	        	$data_file = $this->upload->data();        	
	        	$query = $this->validacion_model->insertar_cobrador($data_file['file_name']);
	        	echo "1";
	        }
	        else
	        {        		        	
	        	//alert("Existe un problema con el archivo. Intente m�s tarde.");
	        	echo "0";		        		       
	        }
	    }
	    else
	    {
			$query = $this->validacion_model->insertar_cobrador("");	
			echo "1";	    		    	
	    }
		
	}

	public function calcular_amortizacion_diaria()
	{
		$this->load->model('validacion_model');		
		$query = $this->validacion_model->calcular_amortizacion_diaria();
	}

	public function calcular_amortizacion_semanal()
	{
		$this->load->model('validacion_model');		
		$query = $this->validacion_model->calcular_amortizacion_semanal();
	}

	public function calcular_amortizacion_quincenal()
	{
		$this->load->model('validacion_model');		
		$query = $this->validacion_model->calcular_amortizacion_quincenal();
	}

	public function calcular_amortizacion_mensual()
	{
		$this->load->model('validacion_model');		
		$query = $this->validacion_model->calcular_amortizacion_mensual();
	}

	public function busqueda_cliente()
	{
		$this->load->model('validacion_model');
			
		//*************************************************************************************
		//Realiza la consulta al Model para que verificar si el cliente existe		
		//*************************************************************************************			
		$query = $this->validacion_model->busqueda_cliente($_POST['cedula']); 
		if($query->num_rows()>0)
		{				
			$resu = $query->row_array(); //El resultado del Query lo convierto en un Array.	
			echo $resu["id_cliente"],';',$resu["nombre"], ' ',$resu["apellido"] ;
		}
		
	}

	public function guardar_credito()
	{
		$this->load->model('validacion_model');

		//***********************************
		//Guardar cr�dito
		//***********************************		 	
		$query = $this->validacion_model->insertar_credito();	    		    	
	    		
	}

	public function consulta_clientes_cobrar()
	{
		
		$this->load->model('validacion_model');
		$array_tmp = $this->session->userdata('usuario_data');
		$this->validacion_model->consulta_clientes_cobrar($array_tmp['id_usuario']);
	}

	public function consulta_todos_creditos()
	{
		
		$this->load->model('validacion_model');
		$array_tmp = $this->session->userdata('usuario_data');
		$this->validacion_model->consulta_todos_creditos($array_tmp['id_usuario']);
	}

	public function reprogramar_fecha()
	{
		$this->load->model('validacion_model');
			
		//*************************************************************************************
		//Realiza la consulta al Model para cambiar fecha		
		//*************************************************************************************			
		$result =$this->validacion_model->reprogramar_fecha($_POST['id_det_credito'],$_POST['fecha_r']); 
		if ($result == 1)
		{	echo "1";	}
		else
		{	echo "error";	}
				
	}

	public function consulta_gastos_validar()
	{
		//******************************************************************
		//Para mostrar todos los gastos ingresados por todos los cobradores
		//******************************************************************
		$this->load->model('validacion_model');
		$this->validacion_model->consulta_gastos_validar();
	}

	public function consulta_ingreso_caja()
	{
		//******************************************************************
		//Para mostrar todos los ingresos de caja a todos los cobradores
		//******************************************************************
		$this->load->model('validacion_model');
		$this->validacion_model->consulta_ingreso_caja();
	}

	public function consulta_caja()
	{
		//******************************************************************
		//Para mostrar todos los creditos ingresados por los cobradores
		//******************************************************************
		$this->load->model('validacion_model');
		$this->validacion_model->consulta_caja();
	}

	public function consulta_creditos()
	{
		//******************************************************************
		//Para mostrar todos los creditos ingresados por los cobradores
		//******************************************************************
		$this->load->model('validacion_model');
		$this->validacion_model->consulta_creditos();
	}

	public function consulta_abonos()
	{
		//******************************************************************
		//Para mostrar todos los creditos ingresados por los cobradores
		//******************************************************************
		$this->load->model('validacion_model');
		$this->validacion_model->consulta_abonos();
	}

	public function consulta_abonos_realizados_tabla()
	{
		//******************************************************************
		//Para mostrar todos los abonos realizados del credito
		//******************************************************************
	
		$this->load->model('validacion_model');
		$query =$this->validacion_model->consulta_abonos_realizados_tabla($_POST['id_det_credito']);
		//$id_det_credito = $query->row_array(); //El resultado del Query lo convierto en un Array.				
		//$this->session->set_userdata('detalle_credito',$detalle_credito);
		
	}

	public function consulta_comision()
	{
		//******************************************************************
		//Para mostrar todos los gastos ingresados por todos los cobradores
		//******************************************************************
		$this->load->model('validacion_model');
		$this->validacion_model->consulta_comision();
	}

	public function consulta_sobrante_faltante()
	{
		//******************************************************************
		//Para mostrar todos los gastos ingresados por todos los cobradores
		//******************************************************************
		$this->load->model('validacion_model');
		$this->validacion_model->consulta_sobrante_faltante();
	}

	public function consulta_gastos_cuadre()
	{
		//******************************************************************
		//Para mostrar todos los gastos ingresados por todos los cobradores
		//******************************************************************
		$this->load->model('validacion_model');
		$this->validacion_model->consulta_gastos_cuadre();
	}

	public function consulta_ganancia()
	{
		//******************************************************************
		//Para mostrar todos los gastos ingresados por todos los cobradores
		//******************************************************************
		$this->load->model('validacion_model');
		$this->validacion_model->consulta_ganancia();
	}

	public function consulta_gastos_validar_cobrador()
	{
		
		$this->load->model('validacion_model');
		$array_tmp = $this->session->userdata('usuario_data');
		$this->validacion_model->consulta_gastos_validar_cobrador($array_tmp['id_usuario']);
	}

	public function registrar_gasto()
	{
		$this->load->model('validacion_model');
	
		$array_tmp = $this->session->userdata('usuario_data');
		//***********************************
		//Guardar gasto
		//***********************************		 	
		$query = $this->validacion_model->registrar_gasto($array_tmp['id_usuario']);	    		    	
	
	}

	public function registrar_caja()
	{
		$this->load->model('validacion_model');
	
		$array_tmp = $this->session->userdata('usuario_data');
		//***********************************
		//Guardar caja
		//***********************************		 	
		$query = $this->validacion_model->registrar_caja($array_tmp['id_usuario']);	    		    	
	
	}

	public function validar_gasto()
	{
		$this->load->model('validacion_model');
			
		//*************************************************************************************
		//Realiza la consulta al Model para que verificar si el usuario y la clave corresponde		
		//*************************************************************************************			
		$result = $this->validacion_model->validar_gasto($_POST['id_cab_gasto'], $_POST['estado']);
		if ($result == 1)
		{	echo "validado";	}
		else
		{	echo "error";	}
		
	}

	public function eliminar_caja()
	{
		$this->load->model('validacion_model');
			
		//*************************************************************************************
		//Realiza la consulta al Model para que verificar si el usuario y la clave corresponde		
		//*************************************************************************************			
		$result = $this->validacion_model->eliminar_caja($_POST['id_caja'], $_POST['estado']);
		if ($result == 1)
		{	echo "validado";	}
		else
		{	echo "error";	}
		
	}

	public function cuadre_comision()
	{
		$this->load->model('validacion_model');
			
		//*************************************************************************************
		//Realiza la consulta al Model para que verificar si el usuario y la clave corresponde		
		//*************************************************************************************			
		$result = $this->validacion_model->cuadre_comision($_POST['id_liquidacion']);
		if ($result == 1)
		{   echo "validado"; }
		else
		{	echo "error";	}
		
	}

    public function cuadre_ingreso_caja()
	{
		$this->load->model('validacion_model');
			
		//*************************************************************************************
		//Realiza la consulta al Model para que verificar si el usuario y la clave corresponde		
		//*************************************************************************************			
		$result = $this->validacion_model->cuadre_ingreso_caja($_POST['id_caja'],$_POST['fecha'],$_POST['detalle'],$_POST['valor'],$_POST['id_cuadre_caja']);
		if ($result == 1)
		{   echo "validado"; }
		else
		{	echo "error";	}
		
	}

	public function cuadre_faltante_sobrante()
	{
		$this->load->model('validacion_model');
			
		//*************************************************************************************
		//Realiza la consulta al Model para que verificar si el usuario y la clave corresponde		
		//*************************************************************************************			
		$result = $this->validacion_model->cuadre_faltante_sobrante($_POST['id_liquidacion']);
		if ($result == 1)
		{	echo "validado";	}
		else
		{	echo "error";	}
		
	}

	public function cuadre_gastos()
	{
		$this->load->model('validacion_model');
			
		//*************************************************************************************
		//Realiza la consulta al Model para que verificar si el usuario y la clave corresponde		
		//*************************************************************************************			
		$result = $this->validacion_model->cuadre_gastos($_POST['id_gasto']);
		if ($result == 1)
		{	echo "validado";	}
		else
		{	echo "error";	}
		
	}

	
	public function registrar_cuadre()
	{
		$this->load->model('validacion_model');
			
		//*************************************************************************************
		//Realiza la consulta al Model para que verificar si el usuario y la clave corresponde		
		//*************************************************************************************			
		$result = $this->validacion_model->registrar_cuadre($_POST['fecha_i'],$_POST['fecha_f'],$_POST['id_cobrador'],$_POST['t_comision'],$_POST['t_faltante_sobrante'],$_POST['t_gastos'],$_POST['t_liquidacion']);
		if ($result == 1)
		{	echo "validado";	}
		else
		{	echo "error";	}
		
	}

	public function registrar_cuadre_caja()
	{
		$this->load->model('validacion_model');
			
		//*************************************************************************************
		//Realiza la consulta al Model para que verificar si el usuario y la clave corresponde		
		//*************************************************************************************			
		$result = $this->validacion_model->registrar_cuadre_caja($_POST['fecha_i'],$_POST['fecha_f'],$_POST['id_cobrador'],$_POST['t_caja'],$_POST['t_abono'],$_POST['t_credito'],$_POST['t_gastos'],$_POST['t_liquidacion']);

		echo $result;			
	}
	
		//mostrar todos los clientes registrados
	public function consulta_allclientes()
	{
		//******************************************************************
		//Para mostrar todos los clientes ingresados por todos los cobradores
		//******************************************************************
		$this->load->model('validacion_model');
		$this->validacion_model->consulta_allclientes(); 
	}

	//Devuelvo la informaci�n del cliente 
	public function editar_cliente()
	{
		$this->load->model('validacion_model');
		$query =$this->validacion_model->editar_cliente($_POST['id_cliente']);
		$cliente = $query->row_array(); //El resultado del Query lo convierto en un Array.				
		$this->session->set_userdata('id_cliente',$cliente);
		redirect(base_url().'index.php/menu_principal/editar_cliente');
	}

	//Actualizo clientes si han ingresado cambios
	public function actualizar_cliente()
	{
		$this->load->model('validacion_model');

		//***********************************
		//Guardar cliente
		//***********************************		 	
	    //***********************************
		//Upload del archivo al servidor web
		//***********************************		 	

        $config['upload_path']          = './files/';
        $config['allowed_types']        = 'jpg|png|jpeg';
        $config['max_size']             = 1024*6;
        $config['encrypt_name'] 		= TRUE;
        $config['overwrite']	 		= FALSE;
        $config['remove_spaces'] 		= TRUE;
        
        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        
        if(isset($_FILES['user_file']) && $_FILES['user_file']['size'] > 0)
        {
	        if($this->upload->do_upload('user_file'))
	        {
	        	//*********************************************************************************
				//Realiza la inserci�n de la solicitud al Model con el nombre del archivos adjunto
				//*********************************************************************************
	        	$data_file = $this->upload->data();        	
	        	$query = $this->validacion_model->actualizar_cliente($data_file['file_name']);
	        	echo "1";
	        }
	        else
	        {        		        	
	        	//alert("Existe un problema con el archivo. Intente m�s tarde.");
	        	echo "0";	        		       
	        }
	    }
	    else
	    {
			$query = $this->validacion_model->actualizar_cliente("");	    		    	
			echo "1";
	    }
		
	}
		public function consulta_allcobradores()
	{
		//******************************************************************
		//Para mostrar todos los cobradores ingresados
		//******************************************************************
		$this->load->model('validacion_model');
		$this->validacion_model->consulta_allcobradores();
	}

	public function editar_cobrador()
	{
		//******************************************************************
		//Para mostrar nuevo view editar los cobradores
		//******************************************************************
		$this->load->model('validacion_model');
		$query =$this->validacion_model->editar_cobrador($_POST['id_usuario']);
		$cobrador = $query->row_array(); //El resultado del Query lo convierto en un Array.				
		$this->session->set_userdata('cobrador',$cobrador);
		redirect(base_url().'index.php/menu_principal/editar_cobrador');
	}

	public function actualizar_cobrador()
	{
		$this->load->model('validacion_model');

		//***********************************
		//Guardar cliente
		//***********************************		 	
	    //***********************************
		//Upload del archivo al servidor web
		//***********************************		 	

        $config['upload_path']          = './files/';
        $config['allowed_types']        = 'jpg|png|jpeg';
        $config['max_size']             = 1024*6;
        $config['encrypt_name'] 		= TRUE;
        $config['overwrite']	 		= FALSE;
        $config['remove_spaces'] 		= TRUE;
        
        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        
        if(isset($_FILES['user_file']) && $_FILES['user_file']['size'] > 0)
        {
	        if($this->upload->do_upload('user_file'))
	        {
	        	//*********************************************************************************
				//Realiza la inserci�n de la solicitud al Model con el nombre del archivos adjunto
				//*********************************************************************************
	        	$data_file = $this->upload->data();        	
	        	$query = $this->validacion_model->actualizar_cobrador($data_file['file_name']);
	        	echo "1";
	        }
	        else
	        {        		        	
	        	//alert("Existe un problema con el archivo. Intente m�s tarde.");
	        	echo "0";	        		       
	        }
	    }
	    else
	    {
			$query = $this->validacion_model->actualizar_cobrador("");	    		    	
			echo "1";
	    }
		
	}
	
	public function registrar_cab_gasto()
	{
		$this->load->model('validacion_model');
		$array_tmp = $this->session->userdata('usuario_data');
		//***********************************
		//Guardar gasto
		//***********************************		 	
		$query = $this->validacion_model->registrar_cab_gasto($array_tmp['id_usuario']);
		echo $query;	    		    	
	
	}

	public function consulta_cab_gastos_validar()
	{
		//******************************************************************
		//Para mostrar todos los gastos ingresados por todos los cobradores
		//******************************************************************
		$this->load->model('validacion_model');
		$this->validacion_model->consulta_cab_gastos_validar();
	}
	
	public function consulta_cab_gastos_cuadre()
	{
		//******************************************************************
		//Para mostrar todos los creditos ingresados por los cobradores
		//******************************************************************
		$this->load->model('validacion_model');
		$this->validacion_model->consulta_cab_gastos_cuadre();
	}

	public function cuadre_ingreso_abono()
	{
		$this->load->model('validacion_model');
			
		//********************************************************************
		//Actualiza el estado de Cuadre_Caja de la tabla ABONO a 'cancelado' 		
		//********************************************************************			
		$result = $this->validacion_model->cuadre_ingreso_abono($_POST['id_abono'],$_POST['fecha'],$_POST['detalle'],$_POST['valor'],$_POST['id_cuadre_caja']);
		if ($result == 1)
		{   echo "validado"; }
		else
		{	echo "error";	}
		
	}

	public function cuadre_ingreso_credito()
	{
		$this->load->model('validacion_model');
			
		//*************************************************************************
		//Actualiza el estado de Cuadre_Caja de la tabla CAB_CREDITO a 'cancelado' 		
		//*************************************************************************			
		$result = $this->validacion_model->cuadre_ingreso_credito($_POST['id_cab_credito'],$_POST['fecha'],$_POST['detalle'],$_POST['valor'],$_POST['id_cuadre_caja']);
		if ($result == 1)
		{   echo "validado"; }
		else
		{	echo "error";	}
		
	}

	public function cuadre_ingreso_cab_gastos()
	{
		$this->load->model('validacion_model');
			
		//*************************************************************************
		//Actualiza el estado de Cuadre_Caja de la tabla GASTOS a 'cancelado' 		
		//*************************************************************************			
		$result = $this->validacion_model->cuadre_ingreso_cab_gastos($_POST['id_cab_gastos'],$_POST['fecha'],$_POST['detalle'],$_POST['valor'],$_POST['id_cuadre_caja']);
		if ($result == 1)
		{   echo "validado"; }
		else
		{	echo "error";	}
		
	}
	
	public function amortizacion()
	{
		//$array_tmp = $this->session->userdata('usuario_data');
		//$this->session->set_userdata('usuario_data',$array_tmp);	
		redirect(base_url().'index.php/menu_principal/amortizacion');
	}

	public function listar_todos_creditos()
	{
		$this->load->model('validacion_model');
		$array_tmp = $this->session->userdata('usuario_data');
		$this->validacion_model->listar_todos_creditos($array_tmp['id_usuario']);
	}

	public function consulta_informacion_credito()
	{		
		$this->load->model('validacion_model');
		$query =$this->validacion_model->consulta_informacion_credito($_POST['id_cab_credito']);
		$cab_credito = $query->row_array(); //El resultado del Query lo convierto en un Array.
		$this->session->set_userdata('cab_credito',$cab_credito);
		redirect(base_url().'index.php/menu_principal/consulta_informacion_credito');
	}

	public function consulta_informacion_credito_det()
	{		
		$this->load->model('validacion_model');
		$query =$this->validacion_model->consulta_informacion_credito_det($_POST['id_cab_credito']);
				
	}
	
	public function eliminar_credito()
	{
		$this->load->model('validacion_model');
			
		//*************************************************************************************
		//Realiza cambio de estado a los credios "eliminado"
		//*************************************************************************************			
		$result = $this->validacion_model->eliminar_credito($_POST['id_cab_credito'], $_POST['estado']);
		if ($result == 1)
		{	echo "eliminado";	}
		else
		{	echo "error";	}
		
	}
	public function listar_cuadre_caja()
	{		
		$this->load->model('validacion_model');
		$query =$this->validacion_model->listar_cuadre_caja();
	}

	public function consultar_cuadre_caja_det()
	{			
		$this->session->set_userdata('id_cuadre_caja',$_POST['id_cuadre_caja']);
		$this->session->set_userdata('fecha_inicio',$_POST['fecha_inicio']);
		$this->session->set_userdata('fecha_fin',$_POST['fecha_fin']);
		$this->session->set_userdata('cobrador',$_POST['cobrador']);
		redirect(base_url().'index.php/menu_principal/consultar_cuadre_caja_det');
	}

	public function consulta_cuadre_caja_anterior()
	{		
		$this->load->model('validacion_model');
		$query =$this->validacion_model->consulta_cuadre_caja_anterior();
	}
	
	public function actualizar_mora()
	{		
		$this->load->model('validacion_model');
		$query =$this->validacion_model->actualizar_mora();
	}

	public function cerrar_sesion()
	{		
		$this->session->sess_destroy();
		redirect(base_url().'index.php/menu_principal/inicio');
	}

	//mostrar todos los clientes registrados por el usuario
	public function consulta_allclientes_cobrador()
	{
		//******************************************************************
		//Para mostrar todos los clientes ingresados por el cobrador
		//******************************************************************
		$this->load->model('validacion_model');
		$array_tmp = $this->session->userdata('usuario_data');
		$this->validacion_model->consulta_allclientes_cobrador($array_tmp['id_usuario']);   
	}

	public function amortizacion_cobradores()
	{
		//$array_tmp = $this->session->userdata('usuario_data');
		//$this->session->set_userdata('usuario_data',$array_tmp);	
		redirect(base_url().'index.php/menu_principal/amortizacion_cobradores');
	}

	public function consulta_informacion_credito_cobradores()
	{		
		$this->load->model('validacion_model');
		$query =$this->validacion_model->consulta_informacion_credito($_POST['id_cab_credito']);
		$cab_credito = $query->row_array(); //El resultado del Query lo convierto en un Array.
		$this->session->set_userdata('cab_credito',$cab_credito);
		redirect(base_url().'index.php/menu_principal/consulta_informacion_credito_cobradores');
	}
	public function historial_cliente_det()
	{
		$this->load->model('validacion_model');
		$query =$this->validacion_model->historial_cliente_det($_POST['id_cliente']);
		$cliente = $query->row_array(); //El resultado del Query lo convierto en un Array.
		$this->session->set_userdata('cliente',$cliente);
		redirect(base_url().'index.php/menu_principal/historial_cliente_det');
	}
	public function historial_cliente_cancelados()
	{
		$this->load->model('validacion_model');
		//$array_tmp = $this->session->userdata('usuario_data');
		$this->validacion_model->historial_cliente_cancelados($_POST['id_cliente']);
	}
	public function historial_cliente_pendientes()
	{
		$this->load->model('validacion_model');
		//$array_tmp = $this->session->userdata('usuario_data');
		$this->validacion_model->historial_cliente_pendientes($_POST['id_cliente']);
	}

	/**Compartir detalle del credito */
	public function compartirDetalleCredito()
	{
		$this->load->model('validacion_model');
		$result =$this->validacion_model->compartirDetalleCredito($_POST['id_det_credito']); 
		//return $result;

		echo json_encode($result);

	}

}?>