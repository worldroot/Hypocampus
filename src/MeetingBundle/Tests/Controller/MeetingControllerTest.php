<?php

namespace MeetingBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MeetingControllerTest extends WebTestCase
{
    public function testCreatemeeting()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/createMeeting');
    }

    public function testReadmeeting()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/readMeeting');
    }

    public function testUpdatemeeting()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/updateMeeting');
    }

    public function testDeletemeeting()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/deleteMeeting');
    }

}
