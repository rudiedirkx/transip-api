<?php

namespace Transip;

use Transip\Exception\ApiException;
use Transip\Exception\InvalidArgumentException;

/**
 * Class Client
 *
 * @package Transip
 * @class   Client
 * @author  TransIP (support@transip.nl)
 * @author  Mitchel Verschoof (mitchel@verschoof.net)
 * @author  Sander Krul (sander@dope-e.nl)
 * @version 20170413 15:20
 */
class Client
{
    /**
     * The mode in which the API operates, can be either:
     *      readonly
     *      readwrite
     *
     * In readonly mode, no modifying functions can be called.
     * To make persistent changes, readwrite mode should be enabled.
     */
    protected $mode = 'readwrite';

    /**
     * Available modes for the API
     */
    public static $availableModes = array(
        'readonly',
        'readwrite'
    );

    /**
     * TransIP API endpoint to connect to.
     *
     * e.g.:
     *      'api.transip.nl'
     *      'api.transip.be'
     *      'api.transip.eu'
     */
    protected $endpoint = 'api.transip.nl';

    /**
     * @var string
     */
    protected $protocol = 'https://';

    /**
     * Your login name on the TransIP website.
     */
    protected $login;

    /**
     * One of your private keys; these can be requested via your Controlpanel
     */
    protected $privateKey;

    /**
     * @param string $login
     * @param string $privateKey
     * @param bool   $debug
     * @param string $endpoint
     * @param string $protocol
     */
    public function __construct($login, $privateKey, $debug = false, $endpoint = 'https://api.transip.nl', $protocol = 'https//')
    {
        $this->login      = $login;
        $this->privateKey = $privateKey;
        $this->endpoint   = $endpoint;
        $this->protocol   = $protocol;

        if ($debug) {
            $this->mode = 'readonly';
        }
    }

    /**
     * @param string $name
     *
     * @return Api\Colocation|Api\Domain|Api\Forward|Api\Webhosting
     * @throws Exception\InvalidArgumentException
     */
    public function api($name)
    {
        switch ($name) {
            case 'domain':
                $api = new Api\Domain($this);
                break;
            case 'webhosting':
                $api = new Api\Webhosting($this);
                break;
            case 'forward':
                $api = new Api\Forward($this);
                break;
            case 'colocation':
                $api = new Api\Colocation($this);
                break;
            case 'vps':
                $api = new Api\Vps($this);
                break;

            default:
                throw new InvalidArgumentException(sprintf('Undefined api instance called: "%s"', $name));
        }

        return $api;
    }

    /**
     * @return string
     */
    public function getEndpoint()
    {
        return $this->endpoint;
    }

    /**
     * @param string $endpoint
     */
    public function setEndpoint($endpoint)
    {
        $this->endpoint = $endpoint;
    }

    /**
     * @return string
     */
    public function getProtocol()
    {
        return $this->protocol;
    }

    /**
     * @param string $protocol
     * @return Client
     */
    public function setProtocol($protocol)
    {
        $this->protocol = $protocol;

        return $this;
    }

    /**
     * @return string
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * @return string
     */
    public function getPrivateKey()
    {
        return $this->privateKey;
    }

    /**
     * @return string
     */
    public function getMode()
    {
        return $this->mode;
    }

    /**
     * @param string $mode
     *
     * @throws \Exception
     */
    public function setMode($mode)
    {
        if (in_array($mode, self::$availableModes, true)) {
            $this->mode = $mode;
        }

        throw new ApiException("$mode is not an available mode for this API.");
    }
}
