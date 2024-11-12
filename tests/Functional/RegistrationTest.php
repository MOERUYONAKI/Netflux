<?php

namespace App\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RegistrationTest extends WebTestCase
{
    public function testRegistrationFormDisplaysCorrectly(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/signin');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('form[name="registration_form"]');
    }

    public function testSuccessfulRegistration(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/signin');
        $form = $crawler->selectButton('Register')->form([
            'registration_form[email]' => 'test@example.com',
            'registration_form[plainPassword][first]' => 'password123',
            'registration_form[plainPassword][second]' => 'password123',
        ]);
        $client->submit($form);
        $this->assertResponseRedirects('/index');
    }
}
