<?php

namespace App\Tests\Security;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PasswordHashingTest extends KernelTestCase
{
    public function testPasswordIsHashed(): void
    {
        $kernel = self::bootKernel();
        $passwordHasher = $kernel->getContainer()->get('security.password_hasher');
        $password = 'plaintextpassword';
        $hashedPassword = $passwordHasher->hashPassword(new \App\Entity\User(), $password);
        $this->assertNotSame($password, $hashedPassword);
        $this->assertStringStartsWith('$2y$', $hashedPassword);
    }
}
