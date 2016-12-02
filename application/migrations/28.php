<?php
class Migration_28 extends Doctrine_Migration_Base {
    public function up(){
        $this->addColumn('cuenta', 'client_id', 'string', 128, array('notnull'=>1));
        $this->addColumn('cuenta', 'client_secret', 'string', 128, array('notnull'=>1));
    }
    public function down(){
        $this->removeColumn('cuenta', 'client_id');
        $this->removeColumn('cuenta', 'client_secret');
    }
}