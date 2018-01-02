<?php

use Migrations\AbstractMigration;

class CreateUsers extends AbstractMigration {

    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     * @return void
     */
    public function change() {
        $table = $this->table('users');
        $table->addColumn('first_name', 'string', [
            'default'=>null,
            'limit' => 200,
            'null'=>true,
        ]);
        $table->addColumn('last_name', 'string', [
            'default' => null,
            'limit' => 200,
            'null'=>true,
        ]);
        $table->addColumn('user_name', 'string', [
            'default' => null,
            'limit' => 100,
            'null' => false,
        ]);        
        $table->addColumn('email', 'string', [
            'default' => null,
            'limit' => 150,
            'null' => false,
        ]);
        $table->addColumn('password', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
        $table->addColumn('gender', 'string', [
            'default' => null,
            'limit' => 50,
            'null' => true,
        ]);
        $table->addColumn('dob', 'date',[
            'null'=>true
        ]);
        $table->addColumn('phone', 'integer', [
            'default' => null,
            'limit' => 50,
            'null' => true,
        ]);
        $table->addColumn('status', 'string', [
            'default' => "pending",
            'limit' => 15,
            'null' => false,
        ]);
        $table->addColumn('website_url', 'string', [
            'default' => null,
            'limit' => 150,
            'null' => true,
        ]);
        $table->addColumn('address', 'text', [
            'default' => null,
            'null'=>true,
        ]);
        $table->addColumn('bio_data', 'text', [
            'default' => null,
            'null'=>true,
        ]);
        $table->addColumn('timezone', 'string', [
            'default' => null,
            'limit' =>100,
            'null' => true,
        ]);
        $table->addColumn('token_verification', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => true,
        ]);        
        $table->addColumn('created', 'datetime', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('modified', 'datetime', [
            'default' => null,
            'null' => false,
        ]);
         $table->addIndex([
             'email',
             'user_name',
             'phone'
            ], ['unique' => true,
        ]);
        $table->create();
    }

}
