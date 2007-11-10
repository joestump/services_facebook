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

/**
 * Facebook Authentication Interface
 *
 * <code>
 * <?php
 * require_once 'Services/Facebook.php';
 * $api = Services_Facebook::factory('Auth');
 * // An instance of SimpleXmlElement with the response loaded into it
 * // is returned.
 * $session = $api->getSession($_GET['auth_token']);
 * echo 'uid: ' . (string)$session->uid . '<br />';
 * echo 'session_key: ' . (string)$session->session_key . '<br />';
 * ?>
 * </code>
 *
 * @category    Services
 * @package     Services_Facebook
 * @author      Joe Stump <joe@joestump.net>
 * @link        http://wiki.developers.facebook.com
 */
class Services_Facebook_Auth extends Services_Facebook_Common
{
    /**
     * Create a token for login
     *
     * @access      public
     * @return      string
     */
    public function createToken()
    {
        $result = $this->sendRequest('auth.createToken');
        return (string)$result;
    }

    /**
     * Convert auth_token into a session_key
     *
     * @access      public
     * @param       string      $authToken      auth_token from callback
     * @return      object      SimpleXmlElement of response 
     */
    public function getSession($authToken)
    {
        return $this->sendRequest('auth.getSession', array(
            'auth_token' => $authToken
        ));
    }
}

?>
