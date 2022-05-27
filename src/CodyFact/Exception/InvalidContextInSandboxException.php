<?php

namespace CodyFact\Exception;

class InvalidContextInSandboxException extends CodyFactException
{

    protected $message = 'El contexto no es válido en un entorno de pruebas';
}