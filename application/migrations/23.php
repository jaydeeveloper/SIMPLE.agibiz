<?php

class Migration_23 extends Doctrine_Migration_Base {

    public function up() {
    
        $columns = array(
                'id' => array(
                        'type' => 'int(10) unsigned AUTO_INCREMENT',
                        'notnull' =>1
                ),
                'idpar' => array(
                        'type' => 'int(10) unsigned',
                        'notnull' => 1
                ),
                'endpoint' => array(
                        'type' => 'varchar(50)',
                        'notnull' => true
                ),
                'nombre' => array(
                        'type' => 'varchar(50)',
                        'notnull' => true
                ),
                'nombre_visible' => array(
                        'type' => 'varchar(50)',
                ),
                'cuenta_id' => array(
                        'type' => 'int(10) unsigned',
                        'notnull' => 0
                )
        );
        $this->createTable('config', $columns, array('primary' => array('id')));
        
    }

    public function down() {
        $this->dropTable('config');
    }


    public function postUp() {
       $q = Doctrine_Manager::getInstance()->getCurrentConnection();
       $q->execute("INSERT INTO config values(1,1,'plantilla','default','Plantilla por defecto',0)");
       $q->execute("INSERT INTO config values(2,2,'Connectors','Bezier','Curvo',0)");
       $q->execute("INSERT INTO config values(3,2,'Connectors','Straight','Recto',0)");
       $q->execute("INSERT INTO config values(4,2,'Connectors','Flowchart','Diagrama de flujo',0)");
       $q->execute("INSERT INTO config values(5,2,'Connectors','StateMachine','Curvo Ligero',0)");
    }
}
?>