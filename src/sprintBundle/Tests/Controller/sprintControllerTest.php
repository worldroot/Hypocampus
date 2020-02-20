<?php

namespace sprintBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class sprintControllerTest extends WebTestCase
{
    public function testCreatesprint()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/createsprint');
    }

    public function testAffichersprint()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/affichersprint');
    }

    public function testUpdatesprint()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/updatesprint');
    }

    public function testDeletesprint()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/deletesprint');
    }

}
