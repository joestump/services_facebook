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
 * @author    Jeff Hodsdon <jeffhodsdon@gmail.com> 
 * @copyright 2007-2008 Joe Stump <joe@joestump.net>  
 * @license   http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @version   Release: @package_version@
 * @link      http://pear.php.net/package/Services_Facebook
 */

/**
 * Facebook Authentication Interface
 *
 * <code>
 * <?php
 * require_once 'Services/Facebook.php';
 * $api = Services_Facebook();
 * // An instance of SimpleXmlElement with the response loaded into it
 * // is returned.
 * $session = $api->auth->getSession($_GET['auth_token']);
 * echo 'uid: ' . (string)$session->uid . '<br />';
 * echo 'session_key: ' . (string)$session->session_key . '<br />';
 * ?>
 * </code>
 *
 * @category Services
 * @package  Services_Facebook
 * @author   Joe Stump <joe@joestump.net>
 * @author   Jeff Hodsdon <jeff@digg.com>
 * @license  http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @version  Release: @package_version@
 * @link     http://wiki.developers.facebook.com
 */
class Services_Facebook_Auth extends Services_Facebook_Common
{
    /**
     * Create a token for login
     *
     * @return string
     */
    public function createToken()
    {
        return $this->callMethod('auth.createToken', array(), 'String');
    }

    /**
     * Convert auth_token into a session_key
     *
     * @param string $authToken auth_token from callback
     *
     * @return object SimpleXmlElement of response 
     */
    public function getSession($authToken)
    {
        $args = array(
            'auth_token' => $authToken
        );

        return $this->callMethod('auth.getSession', $args);
    }

    /**
     * Promote session 
     * 
     * Creates a temporary session secret for the current (non-infinite)
     * session of a Web application. This session secret will not be used in
     * the signature for the server-side component of an application, it is
     * only meant for use by the application which additionally want to use
     * a client side component. (e.g. Javascript Client Library)
     *
     * @return void
     */
    public function promoteSession()
    {
        return $this->callMethod('auth.promoteSession', array(), 'String');
    }

    /**
     * Expire session 
     * 
     * Invalidates the current session being used, regardless of whether it
     * is temporary or infinite. After successfully calling this function, no
     * further API calls requiring a session will succeed using this session.
     * If the invalidation is successful, this will return true.
     *
     * @return void
     */
    public function expireSession()
    {
        return $this->callMethod('auth.expireSession', array(), 'Bool');
    }

    /**
     * Revoke authorization 
     * 
     * If this method is called for the logged in user, then no further API
     * calls can be made on that user's behalf until the user decides to
     * authorize the application again.
     *
     * @param float $uid User id
     *
     * @return void
     */
    public function revokeAuthorization($uid = null)
    {
        $args = array();
        if (isset($this->sessionKey)) {
            $args['session_key'] = $this->sessionKey;
        }

        if ($uid !== null) {
            $args['uid'] = $uid;
        }

        return $this->callMethod('auth.revokeAuthorization', $args, 'Bool');
    }
}

?>
