<?php

namespace AppBundle\Tests\Controller;

use Doctrine\ORM\Tools\SchemaTool;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    public static function setUpBeforeClass()
    {

        parent::setUpBeforeClass();

        $kernel = static::createKernel();
        $kernel->boot();
        $em = $kernel->getContainer()->get('doctrine')->getManager();
        $schemaTool = new SchemaTool($em);
        $metadata = $em->getMetadataFactory()->getAllMetadata();

        // Drop and recreate tables for all entities
        $schemaTool->dropSchema($metadata);
        $schemaTool->createSchema($metadata);
    }

    public static function tearDownAfterClass()
    {
        parent::setUpBeforeClass();

        $kernel = static::createKernel();
        $kernel->boot();
        $em = $kernel->getContainer()->get('doctrine')->getManager();
        $schemaTool = new SchemaTool($em);
        $metadata = $em->getMetadataFactory()->getAllMetadata();

        // Drop tables for all entities
        $schemaTool->dropSchema($metadata);
    }

    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        self::bootKernel();

        $this->em = static::$kernel->getContainer()
            ->get('doctrine')
            ->getManager();
        $this->em->getConnection()->setAutoCommit(false);
        $this->em->getConnection()->beginTransaction();
    }

    /**
     * {@inheritDoc}
     */
    protected function tearDown()
    {
        parent::tearDown();

        $this->em->getConnection()->rollback();
        $this->em->close();
        $this->em = null;
    }


    public function testUsersList()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/users/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('[]', $client->getResponse()->getContent());

    }

    public function testGroupCreation()
    {
        $client = static::createClient();

        $data = [
            'name' => 'test group',
        ];

        $crawler = $client->request('POST', '/groups/', $data);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('{"id":1,"name":"test group"}', $client->getResponse()->getContent());

    }

    public function testUserCreation()
    {
        $client = static::createClient();

        $data = [
            'email' => 'john2@test.com',
            'firstname' => 'Johnny',
            'lastname' => 'Smith',
            'group' => 1,
            'isActive' => true,
        ];

        $crawler = $client->request('POST', '/users/', $data);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $response = json_decode($client->getResponse()->getContent());
        $this->assertEquals($data['email'], $response->email);
        $this->assertEquals($data['firstname'], $response->firstname);
        $this->assertEquals($data['lastname'], $response->lastname);
        $this->assertEquals($data['group'], $response->group->id);
        $this->assertEquals($data['isActive'], $response->is_active);
    }
}
