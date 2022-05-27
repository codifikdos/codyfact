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

        $this->credentials = (function () use ($usernname, $password) {
            return ['apiUsername' => $usernname, 'apiPasssword' => $password];
        });

        return $this;
    }

    public static function factory($usernname, $password)
    {
        $credentials = new self(function () use ($usernname, $password) {
            return ['apiUsername' => $usernname, 'apiPasssword' => $password];
        });

        $result = CodyFact::validateCredentialsAndCertificate($credentials);

        if ($result) {
            return $credentials;
        } else {
            throw new InvalidCredentialsException();
        }
    }
}