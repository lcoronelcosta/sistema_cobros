<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

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
	public function index()
	{		
		//$this->load->helper('url');
		//$this->load->database(); //Cargo los archivos para realizar metodos CRUD a la BD
		$this->load->view('welcome_message');
	}

	public function login()
	{
		if (isset($_POST['password'])) //Verifica que no se haya ubicado la pagína directamente, sin pasar por el login
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
				//redirect(base_url().'index.php/menu_principal/inicio');
				$this->load->view('rol_admin');
			}
			else
			{
				//redirect(base_url());
				$this->load->view('rol_admin');
			}
		}
		else
		{			
			redirect(base_url()); // en caso que presionen el boton sin ingresar los datos, simplemente se recarga la página
		}	
	}
}?>