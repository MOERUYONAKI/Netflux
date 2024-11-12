<?php

namespace App\Tests\Security;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AccessControlTest extends WebTestCase
{
    public function testAccessToProtectedRouteWithoutAuthentication(): void
    {
        $client = static::createClient();
        $client->request('GET', '/admin');
        $this->assertResponseRedirects('/login', 302);
    }

    public function testUserCannotAccessAdminRoute(): void
    {
        $client = static::createClient();
        $user = $this->createUserWithRole('ROLE_USER');
        $client->loginUser($user);
        $client->request('GET', '/admin');
        $this->assertResponseStatusCodeSame(403);
    }

    private function createUserWithRole(string $role): \App\Entity\User
    {
        $user = new \App\Entity\User();
        $user->setEmail('user@test.com');
        $user->setRoles([$role]);
        $user->setPassword(password_hash('password', PASSWORD_BCRYPT));
        return $user;
    }
}
