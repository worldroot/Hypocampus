<?php

namespace TeamBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class teamControllerTest extends WebTestCase
{
    public function testCreateteam()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/createteam');
    }

    public function testReadteam()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/readteam');
    }

    public function testUpdateteam()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/updateteam');
    }

    public function testDeleteteam()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/deleteteam');
    }

}
