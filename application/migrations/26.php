<?php
class Migration_26 extends Doctrine_Migration_Base {
    public function up(){
        $this->addColumn( 'usuario_backend', 'procesos', 'varchar' ,150);
        
    }
    
    public function down(){
        $this->removeColumn( 'usuario_backend', 'procesos' );
    }
}
?>