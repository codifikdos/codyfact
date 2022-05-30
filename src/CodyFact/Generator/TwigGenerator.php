<?php

namespace CodyFact\Generator;

use CodyFact\CodyFact;
use Twig\Environment;
use Twig\Extension\CoreExtension;
use Twig\Loader\FilesystemLoader;

class TwigGenerator implements IDocumentGenerator
{
    /**
     * @var Environment
     */
    protected $environment;

    public function __construct(array $options = [])
    {
        $this->environment = $this->createTemplate($options);
    }

    public function render($template, array $data = [])
    {
        return $this->environment->render($template, $data);
    }

    private function createTemplate($options)
    {
        $filesystemLoader = new FilesystemLoader(__DIR__ . '/Templates');

        $env = new Environment($filesystemLoader, $options);
        $this->configureTimezone($env);

        return $env;
    }

    private function configureTimezone(Environment $twig)
    {
        $extension = $twig->getExtension(CoreExtension::class);
        if ($extension instanceof CoreExtension) {
            $extension->setTimezone(CodyFact::TIMEZONE_DEFAULT);
        }
    }
}