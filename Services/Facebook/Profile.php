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
 * Facebook Profile Interface
 *
 * @category    Services
 * @package     Services_Facebook
 * @author      Joe Stump <joe@joestump.net>
 * @link        http://wiki.developers.facebook.com
 */
class Services_Facebook_Profile extends Services_Facebook_Common
{
    /**
     * Set FBML in a user's profile
     *
     * You are not required to use a session key that belongs
     * to the user whose profile you are changing.
     *
     * @param       string      $profileMarkup      FBML for the profile box
     * @param       string      $profileAction      FBML for the profile actions
     * @param       string      $mobileProfile      FBML for Facebook mobile view
     * @param       int         $uid                Facebook uid to set FBML for
     * @param       string      $sessionKey         The sessionKey that may be 
     *                                               specified
     * @return      boolean     True on success, false on unknown error
     * @link        http://wiki.developers.facebook.com/index.php/Profile.setFBML
     */
    public function setFBML($profileMarkup = '', 
                            $profileAction = '', 
                            $mobileProfile = '', 
                            $uid = 0,
                            $sessionKey = '')
    {
        $args = array();

        if (strlen($profileMarkup)) {
            $args['profile'] = $profileMarkup;
        }
        if (strlen($profileAction)) {
            $args['profile_action'] = $profileAction;
        }
        if (strlen($mobileProfile)) {
            $args['mobile_profile'] = $mobileProfile;
        }
        if ($uid > 0) {
            $args['uid'] = $uid;
        }
        if (strlen($sessionKey)) {
            $args['session_key'] = $sessionKey;
        }
        else {
            $args['session_key'] = $this->sessionKey;
        }

        $result = $this->sendRequest('profile.setFBML', $args);
        $check = intval((string)$result);
        return ($check == 1);
    }

    /**
     * Get the current profile FBML
     *
     * @param       int         $uid        Facebook uid to fetch FBML for
     * @return      object      Instance of SimpleXmlElement
     * @link        http://wiki.developers.facebook.com/index.php/Profile.getFBML
     */
    public function getFBML($uid = 0)
    {
        $args = array('session_key' => $this->sessionKey);
        if ($uid > 0) {
            $args['uid'] = $uid;
        }

        return $this->sendRequest('profile.getFBML', $args);
    }
}

?>
