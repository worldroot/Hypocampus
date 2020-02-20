<?php

namespace SubscriptionBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TarifControllerTest extends WebTestCase
{
    public function testReadtarif()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/readtarif');
    }

    public function testCreatetarif()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/createtarif');
    }

    public function testDeletetarif()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/deletetarif');
    }

    public function testUpdatetarif()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/updatetarif');
    }

}
