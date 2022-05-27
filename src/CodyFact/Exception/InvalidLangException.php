<?php

namespace CodyFact\Exception;

class InvalidLangException extends CodyFactException
{

    protected $message = 'El idioma no es válido, por favor veficica las constantes en la clase CodyFact';
}