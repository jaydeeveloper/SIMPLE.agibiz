<?php

class Migration_24 extends Doctrine_Migration_Base {

    public function up() {
    
    	$columns = array(
    			'idpar' => array(
    					'type' => 'int(10) unsigned',
    					'notnull' =>1
    			),
    			'config_id' => array(
    					'type' => 'int(10) unsigned',
    					'notnull' => 1
    			),
    			'cuenta_id' => array(
    					'type' => 'int(10) unsigned',
    					'notnull' => 1
    			)		
    	);
    	
    	$this->createTable('cuenta_has_config', $columns);	
    }

    public function down() {
		$this->dropTable('cuenta_has_config');
    }

}
?>