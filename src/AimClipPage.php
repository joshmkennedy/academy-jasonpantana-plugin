<?php

namespace JP;


class AimClipPage {
    public $clipQueryVars = [
        // 'aim-clip',
        // 'aim-100-days',
        'aim-learning-path',
        'week-index'
    ];
    private VimeoApi $vimeoApi;
    public function __construct() {
        $this->vimeoApi = new VimeoApi();
    }
    public function addVars(array $vars) {
        return array_merge($vars, $this->clipQueryVars);
    }

    public function getWeekIntro(){
        global $getAimClipListWeekData;
        if (!$getAimClipListWeekData) return "";

        $id = get_query_var('aim-learning-path');
        $week = get_query_var('week-index');
        $weekData = $getAimClipListWeekData((int)$id, (int)$week);
        $data = $weekData->getVimeoPluginData();
        return $data['intro'] ?: "";
    }

    public function getSelectedVideo() {
        global $getAimClipListWeekData;
        if (!$getAimClipListWeekData) return [];
        $id = get_query_var('aim-learning-path');
        $week = get_query_var('week-index');
        $weekData = $getAimClipListWeekData((int)$id, (int)$week);
        $data = $weekData->getVimeoPluginData();
        $video = $data['selectedVideo'];
        $videos = collect($data['videos']);
        $video = $videos->first(function ($v) use ($video) {
            return $v['vimeoId'] === $video;
        }) ?: $videos->first();
        return $video;
    }

    public function getVimeoInfo() {
        $vimeoId = $this->getVimeoId();
        if ($vimeoId) {
            if ($cached = get_transient("vts_vimeo_info_$vimeoId")) {
                return $cached;
            }
            $info = $this->vimeoApi->getVideoInfo($vimeoId, ['name', 'uri', 'pictures' => [0 => 'base_link'], 'player_embed_url']);
            set_transient("vts_vimeo_info_$vimeoId", $info, \YEAR_IN_SECONDS);
            return $info;
        }
    }

    public function getVimeoId() {
        foreach ($this->clipQueryVars as $var) {
            if (get_query_var($var)) {
                return get_query_var($var);
            }
            if (isset($_GET[$var])) {
                return $_GET[$var];
            }
        }
        // if we get here, we didn't find a vimeo id
        return null;
    }
}
