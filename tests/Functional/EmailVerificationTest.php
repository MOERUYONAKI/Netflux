<?php

namespace App\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class EmailVerificationTest extends WebTestCase
{
    public function testInvalidEmailVerificationLink(): void
    {
        $client = static::createClient();
        $client->request('GET', '/verify/email?token=invalid-token');
        $this->assertResponseStatusCodeSame(400);
    }

    public function testValidEmailVerificationLink(): void
    {
        $client = static::createClient();
        $user = $this->createUserWithVerifiedEmail();
        $client->loginUser($user);
        $client->request('GET', '/verify/email?token=valid-token');
        $this->assertResponseRedirects('/index');
    }

    private function createUserWithVerifiedEmail(): \App\Entity\User
    {
        $user = new \App\Entity\User();
        $user->setEmail('verified@test.com');
        $user->setRoles(['ROLE_USER']);
        $user->setPassword(password_hash('password', PASSWORD_BCRYPT));
        $user->setVerified(true);
        return $user;
    }
}
