<?php

namespace CodyFact\Merchant;

use CodyFact\Exception\InvalidCredentialsException;
use CodyFact\CodyFact;

class Credentials implements \Serializable
{

    private $credentials;

    private function __construct(callable $closure)
    {
        $this->credentials = $closure;
    }

    public function __invoke()
    {
        $closure = $this->credentials;
        return $closure();
    }

    public function serialize()
    {
        return serialize($this->__invoke());
    }

    public function unserialize($serialized)
    {
        $data = unserialize($serialized);

        $usernname = $data['apiUsername'];
        $password = $data['apiPasssword'];
        $pathCertificate = $data['pathCertificate'];

        $this->credentials = (function () use ($usernname, $password, $pathCertificate) {
            return ['apiUsername' => $usernname, 'apiPasssword' => $password, 'pathCertificate' => $pathCertificate];
        });

        return $this;
    }

    public static function factory($usernname, $password, $pathCertificate)
    {
        $credentials = new self(function () use ($usernname, $password, $pathCertificate) {
            return ['apiUsername' => $usernname, 'apiPasssword' => $password, 'pathCertificate' => $pathCertificate];
        });

        $result = CodyFact::validateCredentialsAndCertificate($credentials);

        if ($result) {
            return $credentials;
        } else {
            throw new InvalidCredentialsException();
        }
    }
}