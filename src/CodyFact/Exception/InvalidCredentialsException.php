<?php

namespace CodyFact\Exception;

class InvalidCredentialsException extends CodyFactException
{

    protected $message = 'El usuario, clave o certificado digital no son válidos';
}