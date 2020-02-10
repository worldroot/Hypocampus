<?php

namespace EventBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class EventAdminControllerTest extends WebTestCase
{
    public function testAddevent()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/addeventA');
    }

    public function testAfficherevent()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/afficherevent');
    }

    public function testUpdateevents()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/updateEvents');
    }

    public function testDeleteevents()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/deleteevents');
    }

    public function testSearchevents()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/searchevents');
    }

}
