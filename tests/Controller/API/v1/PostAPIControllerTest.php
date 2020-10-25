<?php


namespace App\Tests\Controller\API\v1;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PostAPIControllerTest extends WebTestCase
{

    public function testPosts(): void
    {
        $client = static::createClient();

        //With empty category
        $client->request('POST', '/api/v1/posts', [
            'category' => 'Finance'
        ]);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('end', $client->getResponse()->getContent());

        //With category (normal test)
        $client->request('POST', '/api/v1/posts', [
            'category' => 'Science'
        ]);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertNotEquals('end', $client->getResponse()->getContent());
    }

    public function testPosts400(): void
    {
        $client = static::createClient();

        //Without category
        $client->request('POST', '/api/v1/posts');
        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $this->assertEquals('end', $client->getResponse()->getContent());

        //With not existed category
        $client->request('POST', '/api/v1/posts', [
            'category' => 'NOT_EXISTED_CATEGORY'
        ]);
        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $this->assertEquals('end', $client->getResponse()->getContent());
    }

}