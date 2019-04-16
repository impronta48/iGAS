<?php


use Phinx\Migration\AbstractMigration;

class AggiuntaVendutoUnitaFaseattivita extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    addCustomColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Any other destructive changes will result in an error when trying to
     * rollback the migration.
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        // I double non sono supportati da questa versione di PHINX
        /*
        $table = $this->table('faseattivita');
        $table->addColumn('vendutou', 'double')
                ->update();
        */
        //$this->execute("SHOW COLUMNS FROM `faseattivita` LIKE 'vendutou'");
        //$result = $this->fetchAll();
        //var_dump($result);die();//DEBUG
        //if($result != 0){
            $this->execute('ALTER TABLE faseattivita DROP COLUMN vendutou');
        //} else {
        //    $this->execute('ALTER TABLE faseattivita ADD COLUMN vendutou DOUBLE NULL AFTER `costou`');
        //}
    }
}
