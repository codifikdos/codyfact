<?php

namespace CodyFact;

use CodyFact\Api\Request\BillServiceInvoiceRequest;
use CodyFact\Api\Request\IRequest;
use CodyFact\Api\Response\Builder\ResponseBuilder;
use CodyFact\Env\Production;
use CodyFact\Env\Sandbox;
use CodyFact\Exception\CodyFactException;
use CodyFact\Exception\InvalidBuilderException;
use CodyFact\Exception\InvalidCredentialsException;
use CodyFact\Exception\InvalidEnvException;
use CodyFact\Exception\InvalidLangException;
use CodyFact\Merchant\Credentials;
use CodyFact\TicketInvoice\TicketInvoice;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

use CodyFact\Api\ICommand;
use CodyFact\Api\Response\Builder\IBuilder;
use CodyFact\Env\IEnv;

class CodyFact
{

    const ENV_PRODUCTION = 'production';
    const ENV_SANDBOX = 'sandbox';
    const ENV_DEFAULT = self::ENV_PRODUCTION;

    const LANGUAGE_SPANISH = 'es';
    const LANGUAGE_DEFAULT = self::LANGUAGE_SPANISH;

    const TIMEZONE_PE = 'America/Lima';
    const TIMEZONE_DEFAULT = self::TIMEZONE_PE;

    /**
     * @var Client
     */
    protected $httpClient;

    /**
     * @var IEnv
     */
    protected $env;

    /**
     * @var IBuilder
     */
    protected $builder;

    /**
     * @var string
     */
    protected $lang;

    /**
     * @var Credentials
     */
    protected $credentials = null;


    public function __construct(IEnv $env, IBuilder $builder, $lang = self::LANGUAGE_DEFAULT)
    {
        $this->httpClient = new Client();

        $this->setEnv($env);
        $this->setBuilder($builder);
        $this->setLang($lang);
    }

    /**
     * @param string $lang
     */
    private function setLang($lang = self::LANGUAGE_DEFAULT)
    {
        switch ($lang) {
            case null:
                $this->lang = self::LANGUAGE_DEFAULT;
                break;
            case self::LANGUAGE_SPANISH:
                $this->lang = self::LANGUAGE_SPANISH;
                break;
            default:
                throw new InvalidLangException();
        }
    }

    /**
     * Get the current lang
     *
     * @return string
     */
    public function getLang()
    {
        return $this->lang;
    }

    /**
     * @param IEnv $env
     */
    private function setEnv(IEnv $env)
    {
        $this->env = $env;
    }

    /**
     * @return IEnv
     */
    public function getEnv()
    {
        return $this->env;
    }

    /**
     * @param IBuilder $builder
     */
    private function setBuilder(IBuilder $builder)
    {
        $this->builder = $builder;
    }

    /**
     * @return CodyFact
     */
    public function setCredentials(Credentials $credentials)
    {
        $this->credentials = $credentials;

        return $this;
    }

    /**
     * @return Credentials
     */
    public function getCredentials()
    {
        return $this->credentials;
    }

    public function sendTicketInvoice(TicketInvoice $ticketInvoice)
    {
        $request = new BillServiceInvoiceRequest(ICommand::STATEMENT_SEND_INVOICE);
        $request->setTicketInvoice($ticketInvoice);
        $request->compilePayload($this);

        return $this->request($request);
    }

    public function request(IRequest $request)
    {
        try {
            $url = $this->env->getRequestURI($request->getContext());

            $body = $request->compile($this);

            $headers = $this->env->getHTTPHeaders();

            $options = array_merge(['body' => $body], ['headers' => $headers], $this->env->getHTTPOptions());

            $response = $this->httpClient->post($url, $options);

            return $this->builder->build($request, $response);
        } catch (RequestException $e) {
            throw new CodyFactException('A request error occurred', 0, $e);
        }
    }

    public static function validateCredentialsAndCertificate(Credentials $credentials)
    {
        $credentials = $credentials();

        if (empty($credentials)) {
            throw new InvalidCredentialsException();
        }

        if (empty($credentials['apiUsername']) || empty($credentials['apiPasssword'])) {
            throw new InvalidCredentialsException();
        }

        if (empty($credentials['nameCertificate'])) {
            throw new CodyFactException('Especifica el nombre del certificado electr??nico');
        }

        if (empty($credentials['rootPath'])) {
            throw new CodyFactException('Especifica la carpeta raiz del proyecto');
        }

        if (!file_exists($credentials['rootPath'] . '/' . $credentials['nameCertificate'])) {
            throw new CodyFactException('El certificado no existe en: ' . $credentials['rootPath'] . '/' . $credentials['nameCertificate']);
        }

        if (!is_dir($credentials['rootPath'] . '/xml')) {
            mkdir($credentials['rootPath'] . '/xml', 0777);
        }
        if (!is_dir($credentials['rootPath'] . '/cdr')) {
            mkdir($credentials['rootPath'] . '/cdr', 0777);
        }

        putenv("CODYFACT_PATH_ROOT=" . $credentials['rootPath']);
        putenv("CODYFACT_PATH_CERTIFICATE=" . $credentials['rootPath'] . '/' . $credentials['nameCertificate']);
        putenv("CODYFACT_PATH_XML=" . getenv('CODYFACT_PATH_ROOT') . '/xml/');
        putenv("CODYFACT_PATH_CDR=" . getenv('CODYFACT_PATH_ROOT') . '/cdr/');

        return true;
    }

    /**
     * @return CodyFact
     */
    public static function factory($lang = self::LANGUAGE_DEFAULT, $env = self::ENV_DEFAULT, IBuilder $builder = null)
    {
        if (is_null($env)) {
            $env = self::ENV_DEFAULT;
        }

        if ($env == self::ENV_PRODUCTION) {
            $env = new Production();
        } elseif ($env == self::ENV_SANDBOX) {
            $env = new Sandbox();
        } elseif (!$env instanceof IEnv) {
            throw new InvalidEnvException();
        }

        if (is_null($builder)) {
            $builder = new ResponseBuilder();
        } elseif (!$builder instanceof IBuilder) {
            throw new InvalidBuilderException();
        }

        return new self($env, $builder, $lang);
    }
}