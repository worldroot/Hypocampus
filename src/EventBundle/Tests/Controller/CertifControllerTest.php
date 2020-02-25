<?php

namespace EventBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CertifControllerTest extends WebTestCase
{
    public function testAddcertif()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/addcertif');
    }

    public function testReadcertif()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/readcertif');
    }

    public function testUpdatecertif()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/updatecertif');
    }

    public function testDeletecertif()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/deletecertif');
    }

}
