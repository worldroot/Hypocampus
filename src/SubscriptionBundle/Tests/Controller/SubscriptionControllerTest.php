<?php

namespace SubscriptionBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SubscriptionControllerTest extends WebTestCase
{
    public function testReadsub()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/readsub');
    }

    public function testCreatesub()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/createsub');
    }

    public function testDeletesub()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/deletesub');
    }

    public function testUpadatesub()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/upadatesub');
    }

}
