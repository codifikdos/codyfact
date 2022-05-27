<?php

namespace CodyFact\Api\Request;

use CodyFact\Api\IContext;
use CodyFact\CodyFact;

interface IRequest extends IContext
{

    public function __construct($command);

    public function compile(CodyFact $codyFact);
}