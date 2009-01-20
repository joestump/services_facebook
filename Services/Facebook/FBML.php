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

require_once 'Services/Facebook/Common.php';

/**
 * Facebook FBML Interface
 *
 * @category Services
 * @package  Services_Facebook
 * @author   Joe Stump <joe@joestump.net>
 * @author   Jeff Hodsdon <jeffhodsdon@gmail.com>
 * @license  http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @version  Release: @package_version@
 * @link     http://wiki.developers.facebook.com
 */
class Services_Facebook_FBML extends Services_Facebook_Common
{
    /**
     * Refresh an image cache
     *
     * Facebook caches images from your application. If you want Facebook to
     * refresh your image's cache use this URL to tell Facebook to re-request
     * and re-cache your image.
     *
     * @param string $url URL of image to refresh
     * 
     * @return boolean
     */
    public function & refreshImgSrc($url)
    {
        $args = array(
            'session_key' => $this->sessionKey,
            'url'         => $url
        );

        return $this->callMethod('fbml.refreshImgSrc', $args, 'Bool');
    }

    /**
     * Fetches and re-caches the content stored at the given URL
     * 
     * @param string $url The absolute URL from which to fetch content.
     * 
     * @return      boolean
     */
    public function & refreshRefUrl($url)
    {
        $args = array(
            'session_key' => $this->sessionKey,
            'url'         => $url
        );

        return $this->callMethod('fbml.refreshRefUrl', $args, 'Bool');
    }

    /**
     * Associates a given "handle" with FBML markup
     * 
     * @param string $handle The handle to associate with the given FBML
     * @param string $fbml   The FBML to associate with the given handle
     * 
     * @return boolean
     * @link http://wiki.developers.facebook.com/index.php/Fbml.setRefHandle
     */
    public function & setRefHandle($handle, $fbml)
    {
        $args = array(
            'session_key' => $this->sessionKey,
            'handle'      => $handle,
            'fbml'        => $fbml
        );

        return $this->callMethod('fbml.setRefHandle', $args, 'Bool');
    }
}

?>
