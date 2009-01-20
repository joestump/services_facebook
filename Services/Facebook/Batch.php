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
 * @copyright 2009 Jeff Hodsdon <jeffhodsdon@gmail.com>  
 * @license   http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @version   Release: @package_version@
 * @link      http://pear.php.net/package/Services_Facebook
 */

require_once 'Services/Facebook/Common.php';

/**
 * Facebook Batch Interface
 *
 * <code>
 * $api = new Services_Facebook();
 * Services_Facebook::beginBatch();
 * $friends    = & $api->friends->get();
 * $areFriends = & $api->friends->areFriends(617370918, 683226814);
 * Services_Facebook::endBatch();
 * ?>
 * </code>
 *
 * @category Services
 * @package  Services_Facebook
 * @author   Jeff Hodsdon <jeffhodsdon@gmail.com>
 * @license  http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @version  Release: @package_version@
 * @link     http://wiki.developers.facebook.com
 */
class Services_Facebook_Batch extends Services_Facebook_Common
{

    /**
     * Run batch
     *
     * Take batch data and run it.
     * 
     * <code>
     * $data = array(
     *     array(
     *         'method' => 'users.getInfo',
     *         'args'   => array(),
     *         'result' => null
     *     ),
     *     array(
     *         'method' => 'friends.get',
     *         'args'   => array(),
     *         'result' => null
     *     )
     * );
     * $data = $facebook->batch->run($data);
     * $userInfo = $data[0]['result'];
     * </code>
     *
     * @param array $data   Formated data, including args and method
     * @param bool  $serial True executes api calls in order
     *
     * @return array All data. Args, method, and result
     */
    public function run(array $data, $serial = false)
    {
        $batch      = array();
        $sessionKey = '';
        foreach ($data as $item) {
            $args    = $item['args'];
            $batch[] = http_build_query($args);
            if (!empty($args['session_key'])) {
                $sessionKey = $args['session_key'];
            }
        }

        $args = array(
            'method_feed' => json_encode($batch),
            'serial_only' => ($serial) ? 'true' : 'false',
            'session_key' => $sessionKey
        );

        $result    = $this->callMethod('batch.run', $args);
        $exception = false;
        for ($i = 0; $i < count($data); $i++) {
            try {
                $response           = urldecode($result->batch_run_response_elt[$i]);
                $data[$i]['result'] = $this->parseResponse($response,
                    $data[$i]['format']);
            } catch (Services_Facebook_Exception $e) {
                $exception = $e;
            }
        }

        if ($exception instanceof Services_Facebook_Exception) {
            throw $exception;
        }

        return $data;
    }

}

?>
