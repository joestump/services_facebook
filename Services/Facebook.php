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
 * @category    Services
 * @package     Services_Facebook
 * @author      Joe Stump <joe@joestump.net> 
 * @copyright   Joe Stump <joe@joestump.net>  
 * @license     http://www.opensource.org/licenses/bsd-license.php 
 * @version     CVS: $Id:$
 * @link        http://pear.php.net/package/Services_Facebook
 */

require_once 'Services/Facebook/Common.php';
require_once 'Services/Facebook/Exception.php';

/**
 * Services_Facebook
 *
 * @category    Services
 * @package     Services_Facebook
 * @author      Joe Stump <joe@joestump.net>
 * @link        http://wiki.developers.facebook.com
 */
abstract class Services_Facebook
{
    /**
     * Facebok application API key 
     *
     * @access      public
     * @var         string      $apiKey     32 character api_key from Facebook
     * @static
     */
    static public $apiKey = '';

    /**
     * Facebok application secret 
     *
     * The Facebook secret token is used to both sign requests sent to 
     * Facebook and to verify requests sent from Facebook to your application.
     *
     * @access      public
     * @var         string      $secret     32 character secret from Facebook
     * @static
     */
    static public $secret = '';

    /**
     * Create a facebook service 
     *
     * @param       string      $endPoint       Services to create
     * @return      object      Instance of Facebook endpoint
     * @throws      Services_Facebook_Exception
     * @static
     */
    static public function factory($endPoint)
    {
        $file = 'Services/Facebook/' . $endPoint . '.php';
        require_once $file;
        $class = 'Services_Facebook_' . $endPoint;
        if (!class_exists($class)) {
            throw new Services_Facebook_Exception('Class not found ' . $class);
        } 

        $instance = new $class();
        return $instance;
    }

    /**
     * Validates requests from Facebook
     *
     * Facebook sends a series of $_POST variables when it requests a canvas
     * page or sends a user to the post removal URL. This function validates
     * that request came from Facebook. This function returns true if the 
     * request came from Facebook.
     * 
     * Both the signature of the request and the api_key is verified. If the
     * api_key given doesn't match up to the current Services_Facebook::$apiKey
     * then it will return false. 
     *
     * @access      public
     * @param       array       $args       Normally the $_POST array
     * @return      boolean     True if the request signature is valid
     */
    static public function isValidRequest($args)
    {
        if ($args['fb_sig_api_key'] != Services_Facebook::$apiKey) {
            return false;
        }

        ksort($args);

        $sig = '';
        foreach ($args as $k => $v) {
            if ($k == 'fb_sig') {
                continue;
            }
        
            // The signature is based on fb_sig_* fields only. Extra POST
            // args are passed along, but don't alter the signature.
            if (preg_match('/^fb_sig_/', $k)) {
                $sig .= substr($k, 7) . '=' . $v;
            }
        }        

        return (md5($sig . Services_Facebook::$secret) == $args['fb_sig']); 
    }
}

?>
