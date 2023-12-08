<?php
class InicioModel extends CI_Model{
	public function __construct(){
		parent::__construct();
		$this->Url     = "https://intranet.probusiness.pe/assets/images/productos/20603287721/";
    }

    public function getImportacionGrupalProducto($arrParams){
        //aqui falta que me envíen ID caso contrario no pueden ingresar aquí
        $query = "SELECT
IGC.ID_Empresa,
IGC.ID_Organizacion,
IGC.ID_Moneda,
'1' AS ID_Pais,
IGC.ID_Importacion_Grupal,
IGC.No_Importacion_Grupal,
IGC.Txt_Importacion_Grupal,
IGC.Fe_Inicio,
IGC.Fe_Fin,
IGC.Nu_Estado AS estado_importacion_grupal,
ITEM.ID_Producto,
ITEM.No_Producto,
ITEM.No_Imagen_Item,
ITEM.Nu_Version_Imagen,
MONE.No_Signo,
ITEM.ID_Unidad_Medida,
ITEM.ID_Unidad_Medida_Precio AS ID_Unidad_Medida_2,
UM.No_Unidad_Medida,
ITEM.Qt_Unidad_Medida AS cantidad_item,
ITEM.Ss_Precio_Importacion AS precio_item,
UM2.No_Unidad_Medida AS No_Unidad_Medida_2,
ITEM.Qt_Unidad_Medida_2 AS cantidad_item_2,
ITEM.Ss_Precio_Importacion_2 AS precio_item_2,
ITEM.Nu_Activar_Item_Lae_Shop AS estado_item,
ITEM.Txt_Producto,
ITEM.Qt_Pedido_Minimo_Proveedor,
ITEM.Txt_Url_Video_Lae_Shop
FROM
importacion_grupal_cabecera AS IGC
JOIN importacion_grupal_detalle AS IGD ON(IGD.ID_Importacion_Grupal = IGC.ID_Importacion_Grupal)
JOIN producto AS ITEM ON(ITEM.ID_Producto = IGD.ID_Producto)
JOIN unidad_medida AS UM ON(UM.ID_Unidad_Medida = ITEM.ID_Unidad_Medida)
JOIN unidad_medida AS UM2 ON(UM2.ID_Unidad_Medida = ITEM.ID_Unidad_Medida_Precio)
JOIN moneda AS MONE ON(MONE.ID_Moneda = IGC.ID_Moneda)
WHERE
IGC.Nu_Estado = 1";

        if ( !$this->db->simple_query($query) ){
            $error = $this->db->error();
            return array(
                'status' => 'danger',
                'message' => 'Problemas al obtener datos',
                'code_sql' => $error['code'],
                'message_sql' => $error['message']
            );
        }
        $arrResponseSQL = $this->db->query($query);
        if ( $arrResponseSQL->num_rows() > 0 ){
            $result = $arrResponseSQL->result();
            foreach($result as $row){
                $query = "SELECT SUM(Qt_Producto) AS total_cantidad_item FROM
                importacion_grupal_pedido_cabecera AS IGPC
                JOIN importacion_grupal_pedido_detalle AS IGPD ON(IGPD.ID_Pedido_Cabecera = IGPC.ID_Pedido_Cabecera)
                WHERE IGPC.Nu_Estado=2 AND IGPC.ID_Importacion_Grupal = " . $row->ID_Importacion_Grupal . " AND IGPD.ID_Producto = " . $row->ID_Producto;
                
                $objItem = $this->db->query($query)->row();
                $iTotalCantidadItem = 0;
                if(is_object($objItem)){
                    $iTotalCantidadItem = $objItem->total_cantidad_item;
                }

                $row->total_cantidad_vendida = $iTotalCantidadItem;
                $row->imagenes = $this->getProductoImagen($row->ID_Producto);
                //array_debug($this->getProductoImagen($row->ID_Producto));
				//array_debug($this->getProductoImagen($row->ID_Producto,$rows[0]->Nu_Documento_Identidad));
            }
            return array(
                'status' => 'success',
                'message' => 'Si hay registros',
                'result' => $result
            );
        }
        
        return array(
            'status' => 'warning',
            'message' => 'No hay registros'
        );
    }
    
	public function getProductoImagen($ID_Producto){
		$Path 			= 	$this->Url;
		$query 			=	"SELECT CONCAT(\"{$Path}\",No_Producto_Imagen) AS No_Producto_Imagen FROM producto_imagen WHERE ID_Producto = {$ID_Producto} ORDER BY ID_Predeterminado DESC";
		$arrResponseSQL =	$this->db->query($query);
		return $arrResponseSQL->result();
	}

    public function getBanner( $arrParams ){
		$query = "SELECT
No_Slider,
No_Imagen_Url_Inicio_Slider,
No_Url_Accion,
Nu_Orden_Slider,
Nu_Version_Imagen,
Nu_Tipo_Inicio
FROM
ecommerce_inicio
WHERE
ID_Empresa = " . $arrParams['ID_Empresa'] . "
AND Nu_Estado_Slider = 1
AND Nu_Tipo_Inicio != 2
ORDER BY
Nu_Tipo_Inicio,
Nu_Orden_Slider;";

        if ( !$this->db->simple_query($query) ){
            $error = $this->db->error();
            return array(
                'status' => 'danger',
                'message' => 'Problemas al obtener datos',
                'code_sql' => $error['code'],
                'message_sql' => $error['message']
            );
        }

        $arrResponseSQL = $this->db->query($query);
        if ( $arrResponseSQL->num_rows() > 0 ){
            $result = $arrResponseSQL->result();
            return array(
                'status' => 'success',
                'message' => 'Si hay registros',
                'result' => $result
            );
        }

        return array(
        'status' => 'warning',
        'message' => 'No hay registros'
        );
    }
    
    public function getCategorias( $arrParams ){
		$query = "SELECT
ID_Familia,
Nu_Orden,
No_Familia,
No_Imagen_Categoria,
No_Html_Color,
No_Imagen_Url_Categoria,
Nu_Activar_Familia_Lae_Shop,
Nu_Version_Imagen
FROM
familia
WHERE
ID_Empresa = " . $arrParams['ID_Empresa'] . "
AND Nu_Activar_Familia_Lae_Shop = 1
ORDER BY
Nu_Orden;";

        if ( !$this->db->simple_query($query) ){
            $error = $this->db->error();
            return array(
                'status' => 'danger',
                'message' => 'Problemas al obtener datos',
                'code_sql' => $error['code'],
                'message_sql' => $error['message']
            );
        }

        $arrResponseSQL = $this->db->query($query);
        if ( $arrResponseSQL->num_rows() > 0 ){
            $result = $arrResponseSQL->result();
            return array(
                'status' => 'success',
                'message' => 'Si hay registros',
                'result' => $result
            );
        }

        return array(
        'status' => 'warning',
        'message' => 'No hay registros'
        );
    }

    public function getItem( $arrParams ){
		$query = "SELECT
ITEM.ID_Producto,
ITEM.No_Producto,
ITEM.No_Imagen_Item,
ITEM.Nu_Version_Imagen,
ITEM.ID_Unidad_Medida,
ITEM.ID_Unidad_Medida_Precio AS ID_Unidad_Medida_2,
UM.No_Unidad_Medida,
ITEM.Qt_Unidad_Medida AS cantidad_item,
ITEM.Ss_Precio_Importacion AS precio_item,
UM2.No_Unidad_Medida AS No_Unidad_Medida_2,
ITEM.Qt_Unidad_Medida_2 AS cantidad_item_2,
ITEM.Ss_Precio_Importacion_2 AS precio_item_2,
ITEM.Nu_Activar_Item_Lae_Shop AS estado_item,
ITEM.Txt_Producto,
ITEM.Qt_Pedido_Minimo_Proveedor,
ITEM.Txt_Url_Video_Lae_Shop
FROM
producto AS ITEM
JOIN unidad_medida AS UM ON(UM.ID_Unidad_Medida = ITEM.ID_Unidad_Medida)
JOIN unidad_medida AS UM2 ON(UM2.ID_Unidad_Medida = ITEM.ID_Unidad_Medida_Precio)
WHERE ITEM.ID_Producto = " . $arrParams['ID_Producto'];

        if ( !$this->db->simple_query($query) ){
            $error = $this->db->error();
            return array(
                'status' => 'danger',
                'message' => 'Problemas al obtener datos',
                'code_sql' => $error['code'],
                'message_sql' => $error['message'],
                'sql' => $query,
            );
        }

        $arrResponseSQL = $this->db->query($query);
        if ( $arrResponseSQL->num_rows() > 0 ){
            $result = $arrResponseSQL->row();
            $result->imagenes = $this->getProductoImagen($result->ID_Producto);
            return array(
                'status' => 'success',
                'message' => 'Si hay registros',
                'result' => $result
            );
        }

        return array(
        'status' => 'warning',
        'message' => 'No hay registros'
        );
    }
}