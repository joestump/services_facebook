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

require_once 'Validate.php';

/**
 * Facebook Notifications Interface
 *
 * @category    Services
 * @package     Services_Facebook
 * @author      Joe Stump <joe@joestump.net>
 * @link        http://wiki.developers.facebook.com
 */
class Services_Facebook_Notifications extends Services_Facebook_Common
{
    /**
     * Get notifications for current user
     *
     * Returns all of the outstanding notifications for the given user, which
     * include messages, pokes, shares, friend requests, group invites, and  
     * event invites.
     *
     * @return      object      Instance of SimpleXmlElement 
     * @link        http://wiki.developers.facebook.com/index.php/Notifications.get
     */
    public function get()
    {
        $args = array(
            'session_key' => $this->sessionKey
        );

        return $this->sendRequest('notifications.get', $args);
    }

    /**
     * Send a notification
     *
     * When you send a notification you can send it to an array of Facebook
     * uids. The notification should be valid FBML. Optionally, you can pass
     * FBML for an email that will go out to each user. 
     *
     * The result value can either be true or a string. The string is a valid
     * URI that you should redirect the user to for confirmation.
     *
     * @param       array       $to             Facebook uids to send note to
     * @param       string      $notification   FBML of notification
     * @param       string      $email          FBML for email sent to user
     * @return      mixed       Confirmation URI or true 
     * @link        http://wiki.developers.facebook.com/index.php/Notifications.send
     */
    public function send(array $to, $notification, $email = '')
    {
        $args = array(
            'to_ids' => implode(',', $to),
            'notification' => $notification
        ); 

        if (strlen($email)) {
            $args['email'] = $email;
        }

        $result = $this->sendRequest('notifications.send', $args);
        $check = (string)$result;
        if (strlen($check) && Validate::uri($check)) {
            return $check;
        }

        return true;
    }

    /**
     * Send a notification request
     *
     * @param       array       $to             An array of Facebok uids
     * @param       string      $type           Type of even (e.g. 'event')
     * @param       string      $content        FBML of request / notification
     * @param       string      $image          URI of image to include
     * @param       boolean     $invite         True = invite, False = request
     * @link        http://wiki.developers.facebook.com/index.php/Notifications.sendRequest
     */
    public function sendRequest(array $to, $type, $content, $image, $invite)
    {
        $args = array(
            'to_ids' => implode(',', $to),
            'type' => $type,
            'content' => $content,
            'image' => $image,
            'invite' => (($invite == true) ? 'true' : 'false')
        );

        $result = $this->sendRequest('notifications.sendRequest', $args);
        $check = (string)$result;
        if (strlen($check) && Validate::uri($check)) {
            return $check;
        }

        return true;
    }
}

?>
