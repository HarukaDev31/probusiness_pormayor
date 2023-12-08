<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inicio extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->database('default');
		$this->load->library('session');
		$this->load->library('encryption');
		$this->load->model('InicioModel');
	}

	public function index(){
		//unset($_SESSION['cart']);//por mientras hasta que realice el quitar
		//unset($_SESSION['header']);//por mientras hasta que realice el quitar
		//unset($_SESSION['provincia']);//por mientras hasta que realice el quitar
		//unset($_SESSION['distrito']);//por mientras hasta que realice el quitar

		$arrParams = array();
		$arrImportacionGrupalProducto = $this->InicioModel->getImportacionGrupalProducto($arrParams);
		
		$arrBanner = array();
		$arrCategorias = array();
		if ($arrImportacionGrupalProducto['status'] == 'success') {
			$_arrImportacionGrupalProducto = $arrImportacionGrupalProducto['result'];
			$arrParams = array(
				'ID_Empresa' => $_arrImportacionGrupalProducto[0]->ID_Empresa
			);
			$arrBanner = $this->InicioModel->getBanner($arrParams);
		
			$arrCategorias = $this->InicioModel->getCategorias($arrParams);
		}
		$this->load->view('header');
		$this->load->view('menu', array('arrImportacionGrupalProducto' => $arrImportacionGrupalProducto));
		$this->load->view('inicio',
			array(
				'arrImportacionGrupalProducto' => $arrImportacionGrupalProducto,
				'arrBanner' => $arrBanner,
				'arrCategorias' => $arrCategorias
			)
		);
		$this->load->view('footer_data');
		$this->load->view('footer');
	}

	public function agregarItem(){
		$arrParams = $this->input->post('arrParams');

		$result = array();
		$count = 0;
		if( !empty($arrParams['id_item']) && !empty($arrParams['cantidad_item']) ) {
			$id = $arrParams['id_item'];
			$id_item_bd = $arrParams['id_item_bd'];
			$id_unidad_medida = $arrParams['id_unidad_medida'];
			$id_unidad_medida_2 = $arrParams['id_unidad_medida_2'];
			$nombre_item = $arrParams['nombre_item'];
			$url_imagen_item = $arrParams['url_imagen_item'];
			$cantidad_item = $arrParams['cantidad_item'];
			$precio_item = $arrParams['precio_item'];
			$total_item = $arrParams['total_item'];
			if(isset($_SESSION['cart'])) {
				$existProduct = false;
				foreach ($_SESSION['cart'] as $key => $product) {
					if($product['id_item'] == $id) {
						$_SESSION['cart'][$key]['cantidad_item'] += $cantidad_item;
						$_SESSION['cart'][$key]['id_item_bd'] = $id_item_bd;
						$_SESSION['cart'][$key]['id_unidad_medida'] = $id_unidad_medida;
						$_SESSION['cart'][$key]['id_unidad_medida_2'] = $id_unidad_medida_2;
						$_SESSION['cart'][$key]['precio_item'] = $precio_item;
						$_SESSION['cart'][$key]['total_item'] += $total_item;
						$_SESSION['cart'][$key]['nombre_item'] = $nombre_item;
						$_SESSION['cart'][$key]['url_imagen_item'] = $url_imagen_item;
						$existProduct = true;
						break;
					}
				}
				if(!$existProduct) {
					array_push($_SESSION['cart'], [
						'id_item' => $id,
						'id_item_bd' => $id_item_bd,
						'id_unidad_medida' => $id_unidad_medida,
						'id_unidad_medida_2' => $id_unidad_medida_2,
						'cantidad_item' => $cantidad_item,
						'precio_item' => $precio_item,
						'total_item' => $total_item,
						'nombre_item' => $nombre_item,
						'url_imagen_item' => $url_imagen_item
					]);
				}
			} else {
				$_SESSION['cart'][] = [
					'id_item' => $id,
					'id_item_bd' => $id_item_bd,
					'id_unidad_medida' => $id_unidad_medida,
					'id_unidad_medida_2' => $id_unidad_medida_2,
					'cantidad_item' => $cantidad_item,
					'precio_item' => $precio_item,
					'total_item' => $total_item,
					'nombre_item' => $nombre_item,
					'url_imagen_item' => $url_imagen_item
				];
			}

			$responseItemCartShopActual = searchForIdItem($_SESSION['cart'], $id);

			$result['status'] = 'success';
			$result['id_item'] = $responseItemCartShopActual['id_item'];//id por item
			$result['count_item'] = $responseItemCartShopActual['cantidad_item'];//cantidad por item
			$result['count'] = countBooks($_SESSION['cart']);
			$result['total_item'] = amountBooks($_SESSION['cart']);
		} else {
			$result['status'] = 'error';
			$result['message'] = 'Problemas al agregar';
		}
		echo json_encode($result);
	}

	function quitarItem() {
		$arrParams = $this->input->post('arrParams');
		
		$result = array();
		$count = 0;
		if( !empty($arrParams['id_item']) ) {
			$id = $arrParams['id_item'];
			foreach ($_SESSION["cart"] as $key => $product) {
				if($product["id_item"] == $id) {
					unset($_SESSION['cart'][$key]);
					break;
				}
			}
			
			$responseItemCartShopActual = searchForIdItem($_SESSION['cart'], $id);

			$result['status'] = 'success';

			if(!empty($responseItemCartShopActual)) {
				$result['id_item'] = $responseItemCartShopActual['id_item'];//id por item
				$result['count_item'] = $responseItemCartShopActual['cantidad_item'];//cantidad por item
			}

			$result['count'] = countBooks($_SESSION['cart']);
			$result['total_item'] = amountBooks($_SESSION['cart']);
		} else {
			$result['status'] = 'error';
			$result['message'] = 'Problemas al agregar';
		}
		echo json_encode($result);
	}

	public function modalCartShop(){
		if(isset($_SESSION['cart'])) {
			$result['status'] = 'success';
			$result['result'] = $_SESSION['cart'];
			$result['count'] = countBooks($_SESSION['cart']);
			$result['total_item'] = amountBooks($_SESSION['cart']);
		} else {
			$result['status'] = 'error';
			$result['message'] = 'No hay datos';
		}
		echo json_encode($result);
	}

	public function terminos(){
		$arrParams = array();
		$arrImportacionGrupalProducto = $this->InicioModel->getImportacionGrupalProducto($arrParams);
		$this->load->view('header');
		$this->load->view('menu', array('arrImportacionGrupalProducto' => $arrImportacionGrupalProducto));
		$this->load->view('terminos_y_condiciones');
		$this->load->view('footer_data');
		$this->load->view('footer');
	}

	public function products(){
		$arrParams = array();
		$arrImportacionGrupalProducto = $this->InicioModel->getImportacionGrupalProducto($arrParams);

		$id_item = (!empty($this->uri->segment(2)) ? $this->uri->segment(2) : 0);
		//$id_item=0;
		if($id_item>0) {
			//buscar item
			$arrParams = array(
				'ID_Producto' => $id_item
			);
			$arrItem = $this->InicioModel->getItem($arrParams);

			if ($arrItem['status']=='success') {
				$this->load->view('header');
				$this->load->view('menu', array('arrImportacionGrupalProducto' => $arrImportacionGrupalProducto));
				$arrImportacionGrupalProducto = $arrImportacionGrupalProducto['result'];
				$this->load->view('products', array(
					'arrImportacionGrupalProducto' => $arrImportacionGrupalProducto,
					'item' => $arrItem['result']
				));
				$this->load->view('footer_data');
				$this->load->view('footer');
			} else {
				redirect('Inicio', 'index');
			}
		} else {
			redirect('Inicio', 'index');
		}
	}
}
