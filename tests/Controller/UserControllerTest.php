<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    public function testLoginPageLoadsSuccessfully(): void
    {
        $client = static::createClient();
        $client->request('GET', '/login');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Login');
    }

    public function testRestrictedPageAccess(): void
    {
        $client = static::createClient();
        $client->request('GET', '/admin/dashboard');

        $this->assertResponseRedirects('/login');
    }
}
