<?php
class PaymentModel extends CI_Model{
	public function __construct(){
		parent::__construct();
    }
    
	// Obtener informacion de tienda laeshop
	public function getInformationWarehouse( $arrParams ){
		$query = "SELECT
ALMA.ID_Almacen,
ALMA.Txt_Direccion_Almacen,
D.No_Departamento,
P.No_Provincia,
DTR.No_Distrito,
'S/' AS No_Signo
FROM
almacen AS ALMA
JOIN organizacion AS ORG ON(ORG.ID_Organizacion = ALMA.ID_Organizacion)
JOIN distrito AS DTR ON(DTR.ID_Distrito = ALMA.ID_Distrito)
JOIN provincia AS P ON(P.ID_Provincia = ALMA.ID_Provincia)
JOIN departamento AS D ON(D.ID_Departamento = ALMA.ID_Departamento)
WHERE
ALMA.ID_Almacen=" . $arrParams['ID_Empresa'] . " LIMIT 1";

		if ( !$this->db->simple_query($query) ){
			$error = $this->db->error();
			return array(
				'status' => 'error',
				'message' => '¡Oops! Algo salió mal. Inténtalo mas tarde',
				//'error' => $error
			);
		}
		$arrResponseSQL = $this->db->query($query);
		if ( $arrResponseSQL->num_rows() > 0 ){
			return array(
				'status' => 'success',
				'result' => $arrResponseSQL->result(),
			);
		}

		return array(
			'status' => 'error',
			'message' => 'No se encontró registro(s)',
		);
	}
  
    public function getDepartamento(){
        //aqui falta que me envíen ID caso contrario no pueden ingresar aquí
        $query = "SELECT * FROM departamento WHERE Nu_Estado=1 ORDER BY No_Departamento";

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
            return array(
                'status' => 'success',
                'message' => 'Si hay registros',
                'result' => $arrResponseSQL->result()
            );
        }
        
        return array(
            'status' => 'warning',
            'message' => 'No hay registros'
        );
    }
  
    public function getProvincia(){
        //aqui falta que me envíen ID caso contrario no pueden ingresar aquí
        $query = "SELECT * FROM provincia WHERE Nu_Estado=1 ORDER BY No_Provincia";

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
            return array(
                'status' => 'success',
                'message' => 'Si hay registros',
                'result' => $arrResponseSQL->result()
            );
        }
        
        return array(
            'status' => 'warning',
            'message' => 'No hay registros'
        );
    }
  
    public function getDistrito($arrParams){
        //aqui falta que me envíen ID caso contrario no pueden ingresar aquí
        $query = "SELECT * FROM distrito_tienda_virtual WHERE ID_Empresa=" . $arrParams['ID_Empresa'] . " AND Nu_Habilitar_Ecommerce=1 ORDER BY No_Distrito";

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
            return array(
                'status' => 'success',
                'message' => 'Si hay registros',
                'result' => $arrResponseSQL->result()
            );
        }
        
        return array(
            'status' => 'warning',
            'message' => 'No hay registros'
        );
    }

    public function getMedioPago($arrParams){
        //aqui falta que me envíen ID caso contrario no pueden ingresar aquí
        $query = "SELECT MP.*, CB.* FROM medio_pago AS MP JOIN cuenta_bancaria AS CB ON(MP.ID_Medio_Pago = CB.ID_Medio_Pago) WHERE MP.ID_Empresa = " . $arrParams['ID_Empresa'] . " AND MP.Nu_Tipo_Forma_Pago_Lae_Shop IN(1,2,3,4) AND MP.Nu_Activar_Medio_Pago_Lae_Shop=1";

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
            return array(
                'status' => 'success',
                'message' => 'Si hay registros',
                'result' => $arrResponseSQL->result()
            );
        }
        
        return array(
            'status' => 'warning',
            'message' => 'No hay registros'
        );
    }
  
    public function addPedido($arrPost){
		$this->db->trans_begin();
        
        $arrHeader = $arrPost['header'];
        $arrDetail = $arrPost['detail'];

        //crear cliente si no existe
        $sNombreEntidad = trim($arrHeader['No_Entidad']);
        $sNumeroDocumentoIdentidad = trim($arrHeader['Nu_Documento_Identidad']);
        $iTipoDocumentoIdentidad = '1';//1=OTROS
        $sTipoDocumentoIdentidad = 'OTROS';
        if ( strlen($sNumeroDocumentoIdentidad) == 8 ) {
            $iTipoDocumentoIdentidad = '2';//2=DNI
            $sTipoDocumentoIdentidad = 'DNI';
        } else if ( strlen($sNumeroDocumentoIdentidad) == 11 ) {
            $iTipoDocumentoIdentidad = '4';//4=RUC
            $sTipoDocumentoIdentidad = 'RUC';
        } else if ( strlen($sNumeroDocumentoIdentidad) == 12 ) {
            $iTipoDocumentoIdentidad = '3';//3=CARNET EXTRANJERIA
            $sTipoDocumentoIdentidad = 'CARNET EXTRANJERIA';
        }
        
        $query = "SELECT ID_Entidad FROM entidad WHERE ID_Empresa = 1 AND Nu_Tipo_Entidad = 0 AND ID_Tipo_Documento_Identidad = " . $iTipoDocumentoIdentidad . " AND Nu_Documento_Identidad = '" . $sNumeroDocumentoIdentidad . "' AND No_Entidad = '" . limpiarCaracteresEspeciales($sNombreEntidad) . "' LIMIT 1";
        $objVerificarCliente = $this->db->query($query)->row();
        if (is_object($objVerificarCliente)){
            $ID_Entidad = $objVerificarCliente->ID_Entidad;
        } else {
            $arrCliente = array(
                'ID_Empresa' => $arrHeader['id_empresa'],
                'ID_Organizacion' => $arrHeader['id_organizacion'],
                'Nu_Tipo_Entidad' => 0,//0=Cliente
                'ID_Tipo_Documento_Identidad' => $iTipoDocumentoIdentidad,
                'Nu_Documento_Identidad' => $sNumeroDocumentoIdentidad,
                'No_Entidad' => $sNombreEntidad,
                'Nu_Estado' => 1,
                'Txt_Direccion_Entidad' => $arrHeader['Txt_Direccion'],
                'Nu_Celular_Entidad' => $arrHeader['Nu_Celular_Entidad'],
                'Txt_Email_Entidad'	=> $arrHeader['Txt_Email_Entidad']
            );

            if ($arrHeader['nu_valor_tipo_shipping']==6) {//6=delivery
                $arrCliente = array_merge($arrCliente, array(
                        "ID_Departamento" => $arrHeader['id_departamento'],
                        "ID_Provincia" => $arrHeader['id_provincia'],
                        "ID_Distrito" => $arrHeader['id_distrito'],
                        "ID_Pais" => $arrHeader['id_pais']
                    )
                );
            }

            if ($this->db->insert('entidad', $arrCliente) > 0) {
                $ID_Entidad = $this->db->insert_id();
            } else {
                $this->db->trans_rollback();
                return array(
                    'status' => 'error',
                    'message' => 'No registro cliente'
                );
            }
        }
        //caso contrario ubicar id

        $dEmision = dateNow('fecha');
        $dRegistroHora = dateNow('fecha_hora');
//array_debug($arrHeader);
		$arrSaleOrder = array(
            'ID_Empresa' => $arrHeader['id_empresa'],
            'ID_Organizacion' => $arrHeader['id_organizacion'],
			'ID_Importacion_Grupal' => $arrHeader['id_importacion_grupal'],
			'Fe_Emision' => dateNow('fecha'),
            'ID_Entidad' => $ID_Entidad,
			'ID_Pais' => $arrHeader['id_pais'],//1=PERU
            'ID_Moneda' => $arrHeader['id_moneda'],
            'Ss_Total' => $arrHeader['importe_total'],
            'Qt_Total' => $arrHeader['cantidad_total'],
			'ID_Departamento' => $arrHeader['id_departamento'],
			'ID_Provincia' => $arrHeader['id_provincia'],
			'ID_Distrito' => $arrHeader['id_distrito'],
			'ID_Medio_Pago' => $arrHeader['id_medio_pago'],
            'Nu_Estado' => 1,//1=Pendiente, 2=Confirmado y 3=Finalizado
            'Fe_Registro' => $dRegistroHora,
			'Nu_Tipo_Recepcion' => $arrHeader['nu_valor_tipo_shipping'],
			'ID_Tabla_Dato_Tipo_Recepcion' => $arrHeader['tipo_shipping'],
			'ID_Almacen_Retiro_Tienda' => $arrHeader['id_almacen_retiro_tienda']
		);
		
		$this->db->insert('importacion_grupal_pedido_cabecera', $arrSaleOrder);
		$iIdHeader = $this->db->insert_id();
        
		foreach($arrDetail as $row) {
			$arrSaleOrderDetail[] = array(
                'ID_Empresa' => $arrHeader['id_empresa'],
                'ID_Organizacion' => $arrHeader['id_organizacion'],
				'ID_Pedido_Cabecera' => $iIdHeader,
				'ID_Producto' => $row['id_item_bd'],
				'ID_Unidad_Medida' => $row['id_unidad_medida'],
				'ID_Unidad_Medida_Precio' => $row['id_unidad_medida_2'],
				'Qt_Producto' => $row['cantidad_item'],
				'Ss_Precio' => $row['precio_item'],
				'Ss_SubTotal' => $row['total_item'],
				'Ss_Impuesto' => 0,
				'Ss_Total' => $row['total_item'],
			);
		}
		$this->db->insert_batch('importacion_grupal_pedido_detalle', $arrSaleOrderDetail);

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return array(
				'status' => 'error',
				'message' => '¡Oops! Algo salió mal. Inténtalo mas tarde detalle'
			);
		} else {
			$this->db->trans_commit();
			return array(
				'status' => 'success',
				'message' => 'Pedido creado',
                'result' => array(
                    'id_pedido' => $iIdHeader,
                    'tipo_documento_identidad' => $sTipoDocumentoIdentidad,
                    'fecha_registro' => $dRegistroHora,
                    'importe_total' => $arrHeader['importe_total'],
                    'cantidad_total' => $arrHeader['cantidad_total'],
                    'signo_moneda' => $arrHeader['signo_moneda'],
                    'id_medio_pago' => $arrHeader['id_medio_pago'],
                    'tipo_envio' => $arrHeader['nu_valor_tipo_shipping'],
                    'nombre_tipo_envio' => $arrHeader['nombre_tipo_envio'],
                    'departamento_cliente' => $arrHeader['departamento_cliente'],
                    'provincia_cliente' => $arrHeader['provincia_cliente'],
                    'distrito_cliente' => $arrHeader['distrito_cliente'],
                )
			);
		}
    }
  
    public function getPedido($arrParams){
        //aqui falta que me envíen ID caso contrario no pueden ingresar aquí
        $query = "SELECT
CAB.ID_Empresa,
CAB.ID_Pedido_Cabecera AS id_pedido,
CAB.Fe_Registro AS fecha_registro,
CAB.Qt_Total AS cantidad_total,
CAB.Ss_Total AS importe_total,
CAB.ID_Medio_Pago AS id_medio_pago,
CAB.Nu_Tipo_Recepcion AS tipo_envio,
CLI.No_Entidad,
CLI.Nu_Celular_Entidad,
TDI.No_Tipo_Documento_Identidad_Breve AS tipo_documento_identidad,
CLI.Nu_Documento_Identidad,
CLI.Txt_Direccion_Entidad AS Txt_Direccion,
DET.Qt_Producto AS cantidad_item,
ITEM.No_Producto AS nombre_item,
ITEM.No_Imagen_Item AS url_imagen_item,
DET.Ss_Precio AS precio_item,
DET.Ss_Total AS total_item,
MONE.No_Signo AS signo_moneda,
TDRECEP.No_Metodo_Entrega_Tienda_Virtual AS nombre_tipo_envio,
DEPCLI.No_Departamento AS departamento_cliente,
PROCLI.No_Provincia AS provincia_cliente,
DISCLI.No_Distrito AS distrito_cliente,
CAB.Txt_Url_Imagen_Deposito AS voucher_1,
CAB.Txt_Url_Imagen_Deposito_Segundo_Pago AS voucher_2
FROM
importacion_grupal_pedido_cabecera AS CAB
JOIN importacion_grupal_pedido_detalle AS DET ON(CAB.ID_Pedido_Cabecera = DET.ID_Pedido_Cabecera)
JOIN metodo_entrega_tienda_virtual AS TDRECEP ON(TDRECEP.ID_Metodo_Entrega_Tienda_Virtual = CAB.ID_Tabla_Dato_Tipo_Recepcion)
JOIN producto AS ITEM ON(ITEM.ID_Producto = DET.ID_Producto)
JOIN entidad AS CLI ON(CAB.ID_Entidad = CLI.ID_Entidad)
JOIN tipo_documento_identidad AS TDI ON(TDI.ID_Tipo_Documento_Identidad = CLI.ID_Tipo_Documento_Identidad)
JOIN moneda AS MONE ON(MONE.ID_Moneda = CAB.ID_Moneda)
LEFT JOIN departamento AS DEPCLI ON(DEPCLI.ID_Departamento = CAB.ID_Departamento)
LEFT JOIN provincia AS PROCLI ON(PROCLI.ID_Provincia = CAB.ID_Provincia)
LEFT JOIN distrito_tienda_virtual AS DISCLI ON(DISCLI.ID_Distrito = CAB.ID_Distrito)
WHERE
CAB.ID_Pedido_Cabecera=" . $arrParams['id_pedido'];

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
            return array(
                'status' => 'success',
                'message' => 'Si hay registros',
                'result' => $arrResponseSQL->result()
            );
        }
        
        return array(
            'status' => 'warning',
            'message' => 'No hay registros'
        );
    }

    public function addVoucherPedido($data, $where){
        if ( $this->db->update('importacion_grupal_pedido_cabecera', $data, $where) > 0 )
            return array('status' => 'success', 'message' => 'Se guardo correctamente');
		return array('status' => 'warning', 'message' => 'Problemas al guardar');
    }

	public function getShipping($arrParams){
		$query = "SELECT ID_Metodo_Entrega_Tienda_Virtual AS ID, Nu_Tipo_Metodo_Entrega_Tienda_Virtual AS Nu_Valor, No_Metodo_Entrega_Tienda_Virtual AS No_Tipo_Envio, ID_Estatus_Promo, Nu_Monto_Compra, Nu_Costo_Envio, Txt_Terminos, Txt_Instrucciones_Recojo_Tienda_Lae_Shop FROM metodo_entrega_tienda_virtual WHERE ID_Empresa = " . $arrParams['ID_Empresa'] . " AND Nu_Estado = 1";

		if ( !$this->db->simple_query($query) ){
			$error = $this->db->error();
			return array(
				'status' => 'error',
				'message' => '¡Oops! Algo salió mal. Inténtalo mas tarde'
			);
		}
		$arrResponseSQL = $this->db->query($query);
		if ( $arrResponseSQL->num_rows() > 0 ){
			return array(
				'status' => 'success',
				'result' => $arrResponseSQL->result(),
			);
		}

		return array(
			'status' => 'error',
			'message' => 'No se encontró registro(s)',
		);
	}

    public function generarMensajeWhatsApp($phone, $id, $arrDataWhatsApp){
        $arrCabecera = $arrDataWhatsApp['arrCabecera'];
        $arrDetalle = $arrDataWhatsApp['arrDetalle'];
        $arrMedioPago = $arrDataWhatsApp['arrMedioPago'];

        //Preparar array para envío de data de pedido para la aplicación
        $message = "*¡Hola ProBusiness*! 😁";
        $message .= "\n✅ Envío voucher de pago de " . $arrCabecera['documento']['signo_moneda'] . " " . number_format($arrCabecera['documento']['importe_total'] / 2, 2, '.', ',') . " .\n";
        $message .= "\n➡️ Link:\n" . $arrCabecera['documento']['voucher'];
        
        $message .= "\n\n👤 *CONTACTO*\n";
        $message .= "=============";
        $message .= "\n*Cliente:* " . $arrCabecera['cliente']['No_Entidad'];
        $message .= "\n*" . $arrCabecera['documento']['tipo_documento_identidad'] . "*: " . $arrCabecera['cliente']['Nu_Documento_Identidad'];
        
        $message .= "\n*Nro. Pedido:* " . $arrCabecera['documento']['id_pedido'];
        $message .= "\n*Fecha:* " . ToDateHourBD($arrCabecera['documento']['fecha_registro']);
        
        //Detalle de pedido
        $message .= "\n\n🛍️ *DETALLE DE PEDIDO*\n";
        $message .= "====================\n";
        foreach($arrDetalle as $row) {
          $row = (array)$row;
          $message .= "✅ " . round($row['cantidad_item'], 2) . " x *" . $row['nombre_item'] . "* - S/ " . number_format($row['total_item'], 2, '.', ',') . "\n";
        }
        
        //🛵 Tipo de envío: Delivery a Agencia
        //📍Ubigeo: Áncash - Huaraz - Huaraz
        if( $arrCabecera['documento']['tipo_envio'] == '6' ){
          $message .= "\n\n🛵 Tipo de envío: " . $arrCabecera['documento']['nombre_tipo_envio'];
          $message .= "\n📍 Ubigeo: " . $arrCabecera['documento']['departamento_cliente'] . " - " . $arrCabecera['documento']['provincia_cliente'] . " - " . strtoupper($arrCabecera['documento']['distrito_cliente']);
        } else if( $arrCabecera['documento']['tipo_envio'] == '7' ){
          $message .= "\n\n🛎️ Tipo de envío: " . $arrCabecera['documento']['nombre_tipo_envio'];
          $message .= "\n📍 Dirección: CAL. ALBERTO BARTON NRO 527 URB. SANTA CATALINA - LIMA - LIMA - La Victoria ";
        }

        $message = urlencode($message);

        return array(
            'status' => 'success',
            'link_whatsapp' => "https://api.whatsapp.com/send?phone=" . $phone . "&text=" . $message,
            'message_whatsapp' => $message
        );
    }
}