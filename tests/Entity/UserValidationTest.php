<?php

namespace App\Tests\Entity;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserValidationTest extends KernelTestCase
{
    private function validateUser(User $user): array
    {
        $container = static::getContainer();
        $validator = $container->get('validator');
        return $validator->validate($user);
    }

    public function testValidUser(): void
    {
        $user = new User();
        $user->setUsername('ValidUsername');
        $user->setEmail('valid@example.com');
        $user->setIsAdmin(false);
        $user->setIsMinor(false);

        $errors = $this->validateUser($user);
        $this->assertCount(0, $errors);
    }

    public function testInvalidEmail(): void
    {
        $user = new User();
        $user->setUsername('ValidUsername');
        $user->setEmail('invalid-email');
        $user->setIsAdmin(false);
        $user->setIsMinor(false);

        $errors = $this->validateUser($user);
        $this->assertGreaterThan(0, $errors);
        $this->assertStringContainsString('This value is not a valid email address.', (string)$errors[0]->getMessage());
    }

    public function testBlankUsername(): void
    {
        $user = new User();
        $user->setUsername('');
        $user->setEmail('valid@example.com');
        $user->setIsAdmin(false);
        $user->setIsMinor(false);

        $errors = $this->validateUser($user);
        $this->assertGreaterThan(0, $errors);
        $this->assertStringContainsString('This value should not be blank.', (string)$errors[0]->getMessage());
    }
}
