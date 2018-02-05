<?php
namespace Api\Test\TestCase\Controller;

use Api\Controller\UsersController;
use Cake\TestSuite\IntegrationTestCase;

/**
 * Api\Controller\UsersController Test Case
 */
class UsersControllerTest extends IntegrationTestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.api.users'
    ];

    /**
     * Test index method
     *
     * @return void
     */
    public function testIndex()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test view method
     *
     * @return void
     */
    public function testView()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test add method
     *
     * @return void
     */
    public function testAdd()
    {
        $data = [
            "username"=>"spayc",
            "dob"=> "2000-11-12",
            "gender"=> "male",
            "phone"=> "XXXXXXXXXX",
            "address"=> "b-3 noida",
            "website_url"=>"www.spayc.com",
            "bio_data"=>"your bio data",
            "latitude"=> "28.535516",
            "longitude"=> "77.391026"
        ];
        $this->post('/api/users.json', $data);

        $this->assertResponseSuccess();
        $articles = TableRegistry::get('Users');
        $query = $articles->find();
        $this->assertEquals(1, $query->count());
        //$this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test edit method
     *
     * @return void
     */
    public function testEdit()
    {
        $data = [
            "id"=>5,
            "username"=>"spayc",
            "dob"=> "2000-11-12",
            "gender"=> "male",
            "phone"=> "XXXXXXXXXX",
            "address"=> "b-3 noida",
            "website_url"=>"www.spayc.com",
            "bio_data"=>"your bio data",
        ];
        $this->put('/api/add', $data);

        $this->assertResponseSuccess();
        $articles = TableRegistry::get('Users');
        $query = $articles->find()->where(['id' => $data['id']]);
        $this->assertEquals(1, $query->count());
        //$this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     */
    public function testDelete()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
