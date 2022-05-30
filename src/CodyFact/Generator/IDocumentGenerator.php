<?php

namespace CodyFact\Generator;

interface IDocumentGenerator
{
    public function render($template, array $data);
}