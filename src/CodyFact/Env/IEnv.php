<?php

namespace CodyFact\Env;

interface IEnv
{

    public function getRequestURI($context);

    public function isEnvTest();

    public function getHTTPHeaders();

    public function getHTTPOptions();

    public function __toString();
}