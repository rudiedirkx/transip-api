<?php

namespace Transip\Api;

/**
 * This is the API endpoint for the HaipService
 *
 * @package Transip
 * @class   WebhostingService
 * @author  TransIP (support@transip.nl)
 * @author  Sander Krul (sander@dope-e.nl)
 * @version 20170413 15:20
 */
class Haip extends SoapClientAbstract
{
    /**
     * Gets the singleton SoapClient which is used to connect to the TransIP Api.
     *
     * @param  array $parameters Parameters.
     * @return \SoapClient The SoapClient object to which we can connect to the TransIP API
     */
    public function getSoapClient(array $parameters = array())
    {
        $classMap = array(
            'Haip' => 'Transip\\Model\\Haip',
        );

        $this->service = 'HaipService';

        return $this->soapClient($classMap, $parameters);
    }

    /**
     * Get a HA-IP by name
     *
     * @param string $haipName The HA-IP name
     * @return \Transip\Model\Haip The vps objects
     */
    public function getHaip($haipName)
    {
        return $this->getSoapClient(array_merge(array($haipName), array('__method' => 'getHaip')))->getHaip($haipName);
    }

    /**
     * Get all HA-IPs
     *
     * @return \Transip\Model\Haip[] Array of HA-IP objects
     */
    public function getHaips()
    {
        return $this->getSoapClient(array_merge(array(), array('__method' => 'getHaips')))->getHaips();
    }

    /**
     * Changes the VPS connected to the HA-IP.
     *
     * @param string $haipName The HA-IP name
     * @param string $vpsName The Vps name
     */
    public function changeHaipVps($haipName, $vpsName)
    {
        return $this->getSoapClient(array_merge(array($haipName, $vpsName), array('__method' => 'changeHaipVps')))->changeHaipVps($haipName, $vpsName);
    }
}
