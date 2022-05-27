<?php

namespace CodyFact\Api\Response\Builder;

use CodyFact\Api\Request\IRequest;
use Psr\Http\Message\ResponseInterface;

interface IBuilder
{
    public function build(IRequest $request, ResponseInterface $response, $context = null);
}