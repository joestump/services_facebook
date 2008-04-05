<?php

/**
 * PHP5 interface for Facebook's REST API
 *
 * PHP version 5.1.0+
 *
 * LICENSE: This source file is subject to the New BSD license that is 
 * available through the world-wide-web at the following URI:
 * http://www.opensource.org/licenses/bsd-license.php. If you did not receive  
 * a copy of the New BSD License and are unable to obtain it through the web, 
 * please send a note to license@php.net so we can mail you a copy immediately.
 *
 * @category  Services
 * @package   Services_Facebook
 * @author    Joe Stump <joe@joestump.net> 
 * @copyright 2007-2008 Joe Stump <joe@joestump.net>  
 * @license   http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @version   CVS: $Id$
 * @link      http://pear.php.net/package/Services_Facebook
 */

/**
 * Common class for all Facebook interfaces
 *
 * @category Services
 * @package  Services_Facebook
 * @author   Joe Stump <joe@joestump.net>
 * @license  http://www.opensource.org/licenses/bsd-license.php  New BSD License
 * @link     http://wiki.developers.facebook.com
 */
abstract class Services_Facebook_Common
{
    /**
     * URI of Facebook's REST API
     *
     * @var         string      $api
     */
    protected $api = 'http://api.facebook.com/restserver.php';

    /**
     * Version of the API to use
     *
     * @var         string      $version
     */
    protected $version = '1.0';

    /**
     * Currently logged in user
     * 
     * @var         string      $sessionKey
     */
    public $sessionKey = '';

    /**
     * Send a request to the API
     *
     * Used by all of the interface classes to send a request to the Facebook
     * API. It builds the standard argument list, munges that with the 
     * arguments passed to it, signs the request and sends it along to the
     * API. 
     *
     * Once the request has taken place the cURL response is checked to make
     * sure no low level HTTP errors occurred, the XML is parsed using 
     * SimpleXml and then checked for Facebook errors. 
     * 
     * Any formal error encountered is thrown as an exception.
     *
     * @param string $method The API method to call
     * @param array  $args   API arguments passed as GET args
     *
     * @return object Response as an instance of SimleXmlElement
     * @throws Services_Facebook_Exception
     */
    protected function sendRequest($method, array $args = array()) 
    {
        $args['api_key'] = Services_Facebook::$apiKey;
        $args['v']       = $this->version;
        $args['format']  = 'XML';
        $args['method']  = $method;
        $args['call_id'] = microtime(true);
        $args            = $this->signRequest($args);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->api);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $args);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);

        if (curl_errno($ch)) {
            throw new Services_Facebook_Exception(
                curl_error($ch), curl_errno($ch), $url, $this->api
            );
        }

        curl_close($ch);

        $xml = @simplexml_load_string($result);
        if (!$xml instanceof SimpleXmlElement) {
            throw new Services_Facebook_Exception(
                'Could not parse XML response', 0, $this->api
            );
        }

        $error = $this->checkRequest($xml);
        if (is_array($error) && count($error)) {
            throw new Services_Facebook_Exception($error['message'],
                                                  $error['code'], $this->api);
        } 

        return $xml;
    }

    /**
     * Sign the request
     *
     * @param array $args Arguments for the request to be signed
     * 
     * @return array Arguments with the appropriate sig added
     * @see Services_Facebook::$secret
     */
    protected function signRequest(array $args) 
    {
        if (isset($args['sig'])) {
            unset($args['sig']);
        }

        ksort($args);

        $sig = '';
        foreach ($args as $k => $v) {
            $sig .= $k .'=' . $v;
        }

        $sig        .= Services_Facebook::$secret;
        $args['sig'] = md5($sig);
        return $args;
    }

    /**
     * Check if request resulted in an error
     *
     * @param object $xml Instance of SimpleXmlElement
     * 
     * @return Array with code/message or false if no error is present
     */
    protected function checkRequest($xml)
    {
        $message = null;
        $code    = 0;
        switch ($this->version) {
        case '1.0':
            if (isset($xml->error_code)) {
                $code = (int)$xml->error_code;
            }

            if (isset($xml->error_msg)) {
                $message = $xml->error_msg;
            }
            break;
        default:
            if (isset($xml->fb_error->code)) {
                $code = (int)$xml->fb_error->code;
            }

            if (isset($xml->fb_error->msg)) {
                $message = $xml->fb_error->msg;
            }
            break;
        }

        if ($code > 0 || !is_null($message)) {
            return array('code' => $code, 'message' => $message);
        }

        return false;
    }
}

?>
