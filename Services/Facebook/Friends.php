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
 * Facebook Friends Interface
 *
 * @category    Services
 * @package     Services_Facebook
 * @author      Joe Stump <joe@joestump.net>
 * @link        http://wiki.developers.facebook.com
 */
class Services_Facebook_Friends extends Services_Facebook_Common
{
    /**
     * Are groupings of friends friends?
     *
     * If an array matrix of friend pairings is passed then a SimpleXmlElement
     * is passed back. If it's a single pairing of friends then a boolean is
     * passed back.
     *
     * @param       array       $uid1
     * @param       array       $uid2
     * @return      mixed       Instance of SimpleXML response or boolean
     * @link        http://wiki.developers.facebook.com/index.php/Friends.areFriends
     */
    public function areFriends($uid1, $uid2)
    {
        if (is_array($uid1)) {
            $uids1 = implode(',', $uid1);
        } else {
            $uids1 = $uid1;
        }

        if (is_array($uid2)) {
            $uids2 = implode(',', $uid2);
        } else {
            $uids2 = $uid2;
        }

        $res = $this->sendRequest('friends.areFriends', array(
            'session_key' => $this->sessionKey,
            'uids1' => $uids1,
            'uids2' => $uids2
        )); 

        if (!is_array($uid1) && !is_array($uid2)) {
            return (intval((string)$res->friend_info->are_friends) == 1);
        }

        return $res;
    }

    /**
     * Get the current user's friends
     *
     * @access      public
     * @return      array       A list of uid's of current user's friends
     * @link        http://wiki.developers.facebook.com/index.php/Friends.get
     */
    public function get()
    {
        $result = $this->sendRequest('friends.get', array(
            'session_key' => $this->sessionKey
        ));

        $ret = array();
        foreach ($result->uid as $uid) {
            $ret[] = intval((string)$uid);
        }

        return $ret;
    }

    /**
     * Get the current user's friends by list
     * 
     * @access      public
     * @return      array       A list of uid's of a particular list from the current user
     * @author      Jeff Hodsdon <jeffhodsdon@gmail.com>
     * @link        http://wiki.developers.facebook.com/index.php/Friends.get
     */
    public function getByList($flid)
    {
        $result = $this->sendRequest('friends.get', array(
            'session_key' => $this->sessionKey,
            'flid' => $flid
        ));
        
        $ret = array();
        foreach($result->uid as $uid) {
            $ret[] = intval((string)$uid);
        }
        
        return $ret;
    }

    /**
     * Get a user's friends who are using your application
     *
     * @access      public
     * @return      array       A list of Facebook uid's
     * @link        http://wiki.developers.facebook.com/index.php/Friends.getAppUsers
     */
    public function getAppUsers()
    {
        $result = $this->sendRequest('friends.getAppUsers', array(
            'session_key' => $this->sessionKey
        ));

        $ret = array();
        foreach ($result->uid as $uid) {
            $ret[] = intval((string)$uid);
        }

        return $ret;
    }

    /**
     * Get the current user's friend lists
     *
     * @access      public
     * @return      object      SimpleXMLObject with a name and id for each list
     * @author      Jeff Hodsdon <jeffhodsdon@gmail.com>
     * @link        http://wiki.developers.facebook.com/index.php/Friends.getLists
     *
     */
    public function getLists()
    {
        $result = $this->sendRequest('friends.getLists', array(
            'session_key' => $this->sessionKey
        ));
        
        return $result;
    }
}

?>
