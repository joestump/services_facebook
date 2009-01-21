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
 * @author    Jeff Hodsdon <jeffhodsdon@gmail.com>
 * @copyright 2007-2008 Jeff Hodsdon <jeffhodsdon@gmail.com>
 * @license   http://www.opensource.org/licenses/bsd-license.php New BSD License 
 * @version   Release: @package_version@
 * @link      http://pear.php.net/package/Services_Facebook
 */

require_once 'Services/Facebook/Common.php';

/**
 * Facebook Pages Interface
 *
 * @category Services
 * @package  Services_Facebook
 * @author   Jeff Hodsdon <jeffhodsdon@gmail.com>
 * @license  http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @version  Release: @package_version@
 * @link     http://wiki.developers.facebook.com
 */
class Services_Facebook_Pages extends Services_Facebook_Common
{
    /**
     * Checks whether the logged-in user is the admin for a given page. 
     *
     * @param int $pageId Page ID
     *
     * @return boolean
     *
     * @link        http://wiki.developers.facebook.com/index.php/Pages.isAdmin
     **/
    public function isAdmin($pageId = null)
    {
        $args = array(
            'session_key' => $this->sessionKey,
            'page_id'     => $pageId
        );

        return $this->callMethod('pages.isAdmin', $args, 'Bool');
    }
    
    /**
     * Checks whether the page has added the application. 
     *
     * @param int $pageId Page ID, optional
     *
     * @return boolean
     *
     * @link http://wiki.developers.facebook.com/index.php/Pages.isAppAdded
     **/
    public function isAppAdded($pageId = null)
    {
        $args = array(
            'session_key' => $this->sessionKey,
            'page_id'     => $pageId
        );

        return $this->callMethod('pages.isAppAdded', $args, 'Bool');
    }
    
    /**
     * Checks whether a user is a fan of a given Page. Doesn't work for
     * Application about Pages.
     *
     * @param int $pageId Page ID
     * @param int $uid    User ID of the person to test, defaults to 
     *                    logged-in user
     *
     * @return      boolean
     *
     * @link        http://wiki.developers.facebook.com/index.php/Pages.isFan
     **/
    public function isFan($pageId = null, $uid = null)
    {
        $args = array(
            'session_key' => $this->sessionKey,
            'page_id'     => $pageId,
            'uid'         => $uid
        );

        return $this->callMethod('pages.isFan', $args, 'Bool');
    }
}

?>
