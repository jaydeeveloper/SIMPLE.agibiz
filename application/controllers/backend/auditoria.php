<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Auditoria extends MY_BackendController {

	public function __construct() {
		parent::__construct();
	
		UsuarioBackendSesion::force_login();
	
		//        if(UsuarioBackendSesion::usuario()->rol!='super' && UsuarioBackendSesion::usuario()->rol!='gestion'){
		if(!in_array('super', explode(',',UsuarioBackendSesion::usuario()->rol) )){
			echo 'No tiene permisos para acceder a esta seccion.';
			exit;
		}
	}
	
	
	public function index(){
		
		$order = $this->input->get('order');
		$direction = $this->input->get('direction');
		$offset = $this->input->get('offset') ? $this->input->get('offset') : 0;
		$per_page = 25;
		
		$query = Doctrine_Query::create()
			->select('id, fecha, motivo, operacion, usuario, proceso')
			->from("AuditoriaOperaciones")
			->where("cuenta_id = ?",UsuarioBackendSesion::usuario()->cuenta_id)
			->limit($per_page)
			->offset($offset);
			
		if ($order && $direction){	
			$query = $query->orderBy($order .' '. $direction);
			
		}
		
		
		
		$registros_auditoria= $query->execute();
		$this->load->library ( 'pagination' );
		$this->pagination->initialize ( array (
				'base_url' => site_url ( 'backend/auditoria?order=' . $order . '&direction=' . $direction),
				'total_rows' => $query->count(),
				'per_page' => $per_page
		) );
		
		$data['registros']=$registros_auditoria;
		$data['order'] = $order;
		$data['direction'] = $direction;
		$data['title'] = 'Auditoría';
		$data['content'] = 'backend/auditoria/index';
		
		$this->load->view('backend/template', $data);
	}
	
	public function ver_detalles($registro_id){
		
		$registro_auditoria = Doctrine::getTable("AuditoriaOperaciones")->find($registro_id);
		$registro_auditoria->detalles = json_decode($registro_auditoria->detalles, true);
		
		if ($registro_auditoria->operacion == 'Retroceso a Etapa' || 
				$registro_auditoria->operacion == 'Cambio de Fecha de Vencimiento'){
			/* Compatibilidad con auditorias registradas antes de esta version */
			if (!isset($registro_auditoria->detalles['etapa'])){
				$detalles['tramite'] =$registro_auditoria->detalles['tramite'];
				$detalles['etapa'] = $registro_auditoria->detalles;
				$detalles['tarea'] = $detalles['etapa']['tarea'];
				$detalles['usuario'] = $detalles['etapa']['usuario'];
				if ($registro_auditoria->operacion == 'Retroceso a Etapa'){
					$detalles['datos_seguimiento'] = $detalles['etapa']['datos_seguimiento'];
					unset($detalles['etapa']['datos_seguimiento']);
				}
				unset($detalles['etapa']['tramite']);
				unset($detalles['etapa']['tarea']);
				unset($detalles['etapa']['usuario']);
				unset($detalles['etapa']['proceso']);
	
				$registro_auditoria->detalles = $detalles;
			}
		}
		$data['registro'] = $registro_auditoria;
		$data['title'] = 'Auditoría de ' . $registro_auditoria->operacion . ' en fecha '. $registro_auditoria->fecha;
		$data['content'] = 'backend/auditoria/ver_detalles';
		
		$this->load->view('backend/template',$data);
		
	}

}


?>