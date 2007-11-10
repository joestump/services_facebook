<?php

class Services_Facebook_Share
{
    public function parse($body)
    {
        $metas = $links = array();
        preg_match_all('/<meta ([^>]+)>/i', $body, $metas);
        preg_match_all('/<link ([^>]+)>/i', $body, $links);

        $ret = array();
        foreach ($links[0] as $l) {
            $m = array();
            if (preg_match('/rel="(image_src|audio_src|video_src)"/i', $l, $m)) {
                $type = preg_replace('/_src$/i', '', $m[1]);
                if (!isset($ret[$type])) {
                    $ret[$type] = array();
                }

                if (preg_match('/href="([^"]+)"/i', $l, $m)) {
                    $ret[$type]['src'] = $m[1];
                }
            }
        }

        foreach ($metas[0] as $meta) {
            $m = array();
            if (preg_match('/name="(title|description)"/i', $meta, $m)) {
                $type = $m[1];
                if (preg_match('/content="([^"]+)"/i', $meta, $m)) {
                    $ret[$type] = $m[1];
                }
            } elseif (preg_match('/name="medium"/i', $meta, $m)) {
                if (preg_match('/content="(audio|image|video|news|blog|mult)"/i', $meta, $m)) {
                    $ret['medium'] = $m[1];
                } 
            } elseif (preg_match('/name="(video|image)_(height|width)"/i', $meta, $m)) {
                $type = $m[1];
                $val = $m[2];
                if (preg_match('/content="([0-9]+)"/i', $meta, $m)) {
                    $ret[$type][$val] = $m[1];
                }
            } elseif (preg_match('/name="(video|audio|image)_type"/i', $meta, $m)) {
                $type = $m[1];
                if (preg_match('/content="([^"]+)"/i', $meta, $m)) {
                    $ret[$type]['type'] = $m[1];
                }
            } elseif (preg_match('/name="audio_(title|artist|album)"/i', $meta, $m)) {
                $val = $m[1];
                if (preg_match('/content="([^"]+)"/i', $meta, $m)) {
                    $ret['audio'][$val] = $m[1];
                }
            }
        }

        return $ret;
    }
}

?>
