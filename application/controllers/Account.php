<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Account extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->database('default');
		$this->load->library('session');
		$this->load->library('encryption');
		$this->load->model('InicioModel');
	}

	public function register(){
		$arrParams = array();
		$arrImportacionGrupalProducto = $this->InicioModel->getImportacionGrupalProducto($arrParams);
		$this->load->view('header');
		$this->load->view('menu', array('arrImportacionGrupalProducto' => $arrImportacionGrupalProducto));
		$this->load->view('user/registro');
		$this->load->view('footer_data');
		$this->load->view('footer');
	}

	public function login(){
		$arrParams = array();
		$arrImportacionGrupalProducto = $this->InicioModel->getImportacionGrupalProducto($arrParams);
		$this->load->view('header');
		$this->load->view('menu', array('arrImportacionGrupalProducto' => $arrImportacionGrupalProducto));
		$this->load->view('user/login');
		$this->load->view('footer_data');
		$this->load->view('footer');
	}
}
