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
 * Facebook Feed Interface
 *
 * @category    Services
 * @package     Services_Facebook
 * @author      Joe Stump <joe@joestump.net>
 * @link        http://wiki.developers.facebook.com
 */
class Services_Facebook_Feed extends Services_Facebook_Common
{
    /**
     * Publish a story to a user's feed
     *
     * The $images array should be a numerically indexed array of arrays, where
     * each image has two keys: src and href. The src is the full URI of the
     * image and the href is the link of that image.
     *
     * <code>
     * <?php
     * $images = array(
     *     array('src'  => 'http://example.com/images1.jpg',
     *           'href' => 'http://example.com/images.php?image=1'),
     *     array('src'  => 'http://example.com/images2.jpg',
     *           'href' => 'http://example.com/images.php?image=2'),
     *     array('src'  => 'http://example.com/images3.jpg',
     *           'href' => 'http://example.com/images.php?image=3')
     * );
     * ?>
     * </code>
     *
     * @param       string      $title      FBML to post as story title
     * @param       string      $body       FBML to post as story body
     * @param       array       $images     Images to post to story entry
     * @link        http://wiki.developers.facebook.com/index.php/PublishActionOfUser_vs._PublishStoryToUser
     */
    public function publishStoryToUser($title, 
                                       $body = '', 
                                       array $images = array())
    {
        $args = array(
            'title' => $title,
            'session_key' => $this->sessionKey
        );

        if (strlen($body)) {
            $args['body'] = $body;
        }

        if (count($images)) {
            // Facebook only allows for images so don't send more than that.
            $cnt = count($images);
            if ($cnt > 4) {
                $cnt = 4;
            }

            for ($i = 0 ; $i < $cnt ; $i++) {
                $n = ($i + 1);
                $args['image_' . $n] = $images[$i]['src'];
                if (isset($images[$i]['href'])) {
                    $args['image_' . $n . '_link'] = $images[$i]['href'];
                } else {
                    $args['image_' . $n . '_link'] = $images[$i]['src'];
                }
            }
        } 

        $result = $this->sendRequest('feed.publishStoryToUser', $args);
        $check = intval((string)$result->feed_publishStoryToUser_response);
        return ($check == 1);
    }

    /**
     * Publish an action to a user's feed
     *
     * An action differs from a story in that a user's action is sent to all
     * of that user's friends as well.
     *
     * The $images array should be a numerically indexed array of arrays, where
     * each image has two keys: src and href. The src is the full URI of the
     * image and the href is the link of that image.
     *
     * <code>
     * <?php
     * $images = array(
     *     array('src'  => 'http://example.com/images1.jpg',
     *           'href' => 'http://example.com/images.php?image=1'),
     *     array('src'  => 'http://example.com/images2.jpg',
     *           'href' => 'http://example.com/images.php?image=2'),
     *     array('src'  => 'http://example.com/images3.jpg',
     *           'href' => 'http://example.com/images.php?image=3')
     * );
     * ?>
     * </code>
     *
     * @param       string      $title      FBML to post as story title
     * @param       string      $body       FBML to post as story body
     * @param       array       $images     Images to post to story entry
     * @link        http://wiki.developers.facebook.com/index.php/PublishActionOfUser_vs._PublishStoryToUser
     */
    public function publishActionOfUser($title, 
                                        $body = '', 
                                        array $images = array())
    {
        $args = array(
            'title' => $title,
            'session_key' => $this->sessionKey
        );

        if (strlen($body)) {
            $args['body'] = $body;
        }

        if (count($images)) {
            // Facebook only allows for images so don't send more than that.
            $cnt = count($images);
            if ($cnt > 4) {
                $cnt = 4;
            }

            for ($i = 0 ; $i < $cnt ; $i++) {
                $n = ($i + 1);
                $args['image_' . $n] = $images[$i]['src'];
                if (isset($images[$i]['href'])) {
                    $args['image_' . $n . '_link'] = $images[$i]['href'];
                } else {
                    $args['image_' . $n . '_link'] = $images[$i]['src'];
                }
            }
        } 

        $result = $this->sendRequest('feed.publishActionOfUser', $args);
        $check = intval((string)$result->feed_publishActionOfUser_response_elt);
        return ($check == 1);
    }
}

?>
