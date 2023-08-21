<?php

declare(strict_types=1);

namespace App\Services\Mercure;

use App\Entity\Channel;
use Lcobucci\JWT\Encoding\ChainedFormatter;
use Lcobucci\JWT\Encoding\JoseEncoder;
use Lcobucci\JWT\Token\Builder as TokenBuilder;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key;
use Lcobucci\JWT\Signer\Key\InMemory;

class CookieGenerator
{
    private string $key;

    public function __construct(string $key)
    {
        $this->key = $key;
    }

    public function __invoke(Channel $channel): string
    {
        $encoder = new JoseEncoder();
        $formatter = ChainedFormatter::default();
        $signer = new Sha256();
        $signingKey = InMemory::plainText($this->key); // Use your actual key here
        
        $tokenBuilder = new TokenBuilder($encoder, $formatter);

        return $tokenBuilder
            ->withClaim('mercure', ['subscribe' => [sprintf('http://astrochat.com/channel/%s', $channel->getId())]])
            ->getToken($signer, $signingKey)
            ->toString();
    }
}