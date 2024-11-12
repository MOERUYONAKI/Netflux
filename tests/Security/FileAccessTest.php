<?php

namespace App\Tests\Security;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FileAccessTest extends WebTestCase
{
    public function testFileAccessIsRestricted(): void
    {
        $client = static::createClient();
        $client->request('GET', '/uploads/private-file.pdf');
        $this->assertResponseRedirects('/login');
    }
}
