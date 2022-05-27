<?php

namespace CodyFact\Exception;

class InvalidContextException extends CodyFactException
{
    protected $message = 'El contexto no es válido, revisa las contantes de IContext';
}