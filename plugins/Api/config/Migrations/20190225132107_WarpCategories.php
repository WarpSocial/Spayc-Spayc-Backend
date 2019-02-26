<?php

use Migrations\AbstractMigration;

class WarpCategories extends AbstractMigration {

    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     * @return void
     */
    public function change() {
        $table = $this->table('warp_categories');
        $table->addColumn('spayc_id', 'integer', [
            'default' => null,
            'limit' => 100,
            'null' => false,
        ]);
        $table->addColumn('spayc_category_id', 'integer', [
            'default' => null,
            'limit' => 100,
            'null' => false,
        ]);
        $table->addColumn('created', 'datetime', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('modified', 'datetime', [
            'default' => null,
            'null' => false,
        ]);
        $table->create();
    }

}
