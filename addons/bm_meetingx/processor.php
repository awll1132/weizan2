<?php


defined('IN_IA') or exit('Access Denied');
class Bm_meetingxModuleProcessor extends WeModuleProcessor
{
    public function respond()
    {
        $content = $this->message['content'];
    }
}