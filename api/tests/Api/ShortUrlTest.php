<?php

namespace App\Tests\Api;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\Greeting;

class ShortUrlTest extends ApiTestCase
{
    public function testCreateShortUrl()
    {
        $response = static::createClient()->request('POST', '/api/short_urls', ['json' => [
            'url' => 'http://www.sport.ro',
        ]]);

        self::assertResponseStatusCodeSame(201);
        self::assertJsonContains([
            '@context' => '/api/contexts/ShortUrl',
            '@type' => 'ShortUrl',
            'url' => 'http://www.sport.ro',
        ]);
    }
}
