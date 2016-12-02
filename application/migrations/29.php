<?php
class Migration_29 extends Doctrine_Migration_Base {
    public function up(){
        $this->changeColumn('cuenta', 'client_id',"VARCHAR(64)",null,array('notnull'=>0));
        $this->changeColumn('cuenta', 'client_secret',"VARCHAR(64)",null,array('notnull'=>0));
    }
    public function down(){
        $this->changeColumn('cuenta', 'client_id',"VARCHAR(128)",null,array('notnull'=>1));
        $this->changeColumn('cuenta', 'client_secret',"VARCHAR(128)",null,array('notnull'=>1));
    }
}