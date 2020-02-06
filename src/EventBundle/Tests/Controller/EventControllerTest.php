<?php

namespace EventBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class EventControllerTest extends WebTestCase
{
    public function testAddevent()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/Addevent');
    }

    public function testUpdatevent()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/Updatevent');
    }

    public function testReadevent()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/Readevent');
    }

    public function testDeletevent()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/Deletevent');
    }

    public function testSearchevent()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/Searchevent');
    }

}
