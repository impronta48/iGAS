<?php


use Phinx\Migration\AbstractMigration;

class Cespiticalendario extends AbstractMigration
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
        $cespitiCalendario = $this->table('cespiticalendario', ['engine' => 'MyISAM']);
        $cespitiCalendario->addColumn('user_id', 'integer', ['null' => true])
                    ->addColumn('cespite_id', 'integer', ['null' => false])
                    ->addColumn('event_type_id', 'integer', ['null' => true])
                    ->addColumn('utilizzatore_esterno', 'string', ['limit' => 255, 'null' => true])
                    ->addColumn('start', 'datetime', ['null' => false])
                    ->addColumn('end', 'datetime', ['null' => true])
                    ->addColumn('repeated', 'boolean', ['null' => false])
                    ->addColumn('note', 'string', ['limit' => 255, 'null' => true])
                    ->create();
    }
}
