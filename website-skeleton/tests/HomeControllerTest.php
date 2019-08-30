<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomeControllerTest extends WebTestCase
{
    public function testSomething()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $test = $crawler -> filter('main h1');
        $this -> assertCount(1, $test);
        $this->assertEquals('Hello World', $test -> text());

        $link = $crawler -> selectLink('Actuality') -> link();
        $crawler = $client -> click($link);
        $h1 = $crawler -> filter('main h1');
        $this -> assertEquals('Actu index', $h1->text());
        

    }

}
