<?php

namespace CodyFact\Exception;

class InvalidEnvException extends CodyFactException
{

    protected $message = 'El entorno debe ser de las constantes definidas en la clase CodyFact o la implementación de IEnv';
}