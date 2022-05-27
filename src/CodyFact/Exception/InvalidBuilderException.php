<?php

namespace CodyFact\Exception;

class InvalidBuilderException extends CodyFactException
{

    protected $message = 'El builder no es válido, el builder debe ser implementado de IBuilder';
}