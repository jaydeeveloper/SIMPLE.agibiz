<?php
class Migration_27 extends Doctrine_Migration_Base {
    public function up(){
        $this->addIndex('usuario', 'rut', array(
            'fields'=>array('rut')
        ));
    }
    public function down(){
        $this->removeIndex('usuario', 'rut' );
    }
}