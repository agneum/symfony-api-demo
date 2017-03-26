<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class UserControllerTest extends WebTestCase
{

    public function testUsersList()
    {
        $client = static::createClient();
        $client->request('GET', '/users/');
        $response = json_decode($client->getResponse()->getContent());

        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        $this->assertGreaterThan(0, count($response));
        $this->assertInternalType('array', $response);
        $this->assertArrayNotHasKey('error', $response);
    }
}