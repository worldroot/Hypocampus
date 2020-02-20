<?php

namespace projetsBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class projetsControllerTest extends WebTestCase
{
    public function testCreateprojet()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/createprojet');
    }

    public function testDeleteprojet()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/deleteprojet');
    }

    public function testUpdateprojet()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/updateprojet');
    }

    public function testAfficherprojet()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/afficherprojet');
    }

}
