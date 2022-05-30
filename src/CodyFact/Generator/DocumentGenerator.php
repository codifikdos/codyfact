<?php

namespace CodyFact\Generator;

class DocumentGenerator
{
    /** @var IDocumentGenerator $documentGenerator */
    private $documentGenerator;

    public function setGenerator(IDocumentGenerator $documentGenerator)
    {
        $this->documentGenerator = $documentGenerator;
    }

    public function render($template, $data)
    {
        return $this->documentGenerator->render($template, $data);
    }
}