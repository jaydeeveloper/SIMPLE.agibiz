<?php

class AuditoriaOperaciones extends Doctrine_Record {
	
	
	function setTableDefinition() {
		$this->hasColumn('id');
		$this->hasColumn('fecha');
		$this->hasColumn('motivo');
		$this->hasColumn('detalles');
		$this->hasColumn('operacion');
		$this->hasColumn('usuario');
		$this->hasColumn('proceso');
		$this->hasColumn('cuenta_id');
	}
		
	
}
