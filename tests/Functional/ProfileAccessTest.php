<?php

namespace App\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProfileAccessTest extends WebTestCase
{
    public function testUnauthenticatedUserCannotAccessProfile(): void
    {
        $client = static::createClient();
        $client->request('GET', '/profile');
        $this->assertResponseRedirects('/login');
    }

    public function testAuthenticatedUserCanAccessProfile(): void
    {
        $client = static::createClient();
        $user = $this->createAuthenticatedUser();
        $client->loginUser($user);
        $client->request('GET', '/profile');
        $this->assertResponseIsSuccessful();
    }

    private function createAuthenticatedUser(): \App\Entity\User
    {
        $user = new \App\Entity\User();
        $user->setEmail('auth@test.com');
        $user->setRoles(['ROLE_USER']);
        $user->setPassword(password_hash('password', PASSWORD_BCRYPT));
        return $user;
    }
}
