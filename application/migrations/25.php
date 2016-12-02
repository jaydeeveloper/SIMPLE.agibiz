<?php

class Migration_25 extends Doctrine_Migration_Base {

    public function up() {
        $this->addColumn('cuenta', 'descarga_masiva', 'boolean', null, array('notnull'=>1, 'default' => 1));
    }

    public function down() {
        $this->removeColumn('cuenta', 'descarga_masiva');
    }
}
?>