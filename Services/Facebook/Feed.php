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
 * @version   Release: @package_version@
 * @link      http://pear.php.net/package/Services_Facebook
 */

/**
 * Facebook Feed Interface
 *
 * @category Services
 * @package  Services_Facebook
 * @author   Joe Stump <joe@joestump.net>
 * @license  http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @version  Release: @package_version@
 * @link     http://wiki.developers.facebook.com
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
     * @param string $title  FBML to post as story title
     * @param string $body   FBML to post as story body
     * @param array  $images Images to post to story entry
     *
     * @return boolean
     *
     * @link http://wiki.developers.facebook.com/index.php/Feed.publishStoryToUser
     * @link http://wiki.developers.facebook.com/index.php/PublishActionOfUser_vs._PublishStoryToUser
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
            // Facebook only allows four images so don't send more than that.
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
        $check  = intval((string)$result->feed_publishStoryToUser_response_elt);
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
     * @param string $title  FBML to post as story title
     * @param string $body   FBML to post as story body
     * @param array  $images Images to post to story entry
     * 
     * @return boolean
     *
     * @link http://wiki.developers.facebook.com/index.php/Feed.publishActionOfUser
     * @link http://wiki.developers.facebook.com/index.php/PublishActionOfUser_vs._PublishStoryToUser
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
            // Facebook only allows four images so don't send more than that.
            $cnt = count($images)
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
        $check  = intval((string)$result->feed_publishActionOfUser_response_elt);
        return ($check == 1);
    }
    
    /**
     * Publish a templatized action to a user's feed
     *
     * An action differs from a story in that a user's action is sent to all
     * of that user's friends as well.
     * 
     * An templatized story publishes News Feed stories to the friends of that user.
     * These stories or more likely to appear to the friends of that user depending
     * upon a variety of factors, such as the closeness of the relationship between
     * the users, the interaction data facebook has about that particular story type,
     * and the quality of the content in the story/on the linked page.
     * http://wiki.developers.facebook.com/index.php/FeedRankingFAQ
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
     * @param string $titleTemplate FBML to post as the title, must contain {actor}
     * @param array  $feedData      Array containing optional Feed template, data, and/or actor id
     * @param array  $images        Images to post to story entry
     *
     * @return boolean
     *
     * @author Jeff Hodsdon <jeffhodsdon@gmail.com>
     * @link   http://wiki.developers.facebook.com/index.php/Feed.publishTemplatizedAction
     */
    public function publishTemplatizedAction($titleTemplate,
                                             array $feedData = array(),
                                             array $images = array())
    {
        $args = array(
            'title_template' => $titleTemplate,
            'session_key' => $this->sessionKey
        );

        static $options = array('title_data', 'body_template', 'body_data',
                                'body_general', 'page_actor_id');
    
        foreach ($options as $opt) {
            if (isset($feedData[$opt]) && strlen($feedData[$opt])) {
                $args[$opt] = $feedData[$opt];
            }
        }

        if (count($images)) {
            // Facebook only allows four images so don't send more than that.
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

        $result = $this->sendRequest('feed.publishTemplatizedAction', $args);
        $check  = intval((string)$result->feed_publishTemplatizedAction_response);
        return ($check == 1);
    }
}

?>
