<?php

declare(strict_types=1);

namespace App\Services\Mercure;

use Lcobucci\JWT\Token\Builder;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Encoding\ChainedFormatter;
use Lcobucci\JWT\Encoding\JoseEncoder;

class JWTProvider
{
    private string $key;

    public function __construct(string $key)
    {
        $this->key = $key;
    }

    public function __invoke(): string
    {
        $signer = new Sha256();
        $signingKey = InMemory::plainText($this->key);

        $encoder = new JoseEncoder();
        $formatter = ChainedFormatter::default();

        $tokenBuilder = new Builder($encoder, $formatter);

        return $tokenBuilder
            ->withClaim('mercure', ['publish' => ['*']])
            ->getToken($signer, $signingKey)
            ->toString();
    }
}