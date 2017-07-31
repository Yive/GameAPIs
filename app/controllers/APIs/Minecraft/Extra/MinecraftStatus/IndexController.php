<?php

namespace GameAPIs\Controllers\APIs\Minecraft\Extra\MinecraftStatus;

use Redis;

class IndexController extends ControllerBase {

    public function initialize() {
        $this->tag->setTitle("GameAPIs");
    }

    public function indexAction() {
        $redis = new Redis();
        $redis->pconnect($this->config->application->redis->host);
        $mojang = $redis->exists($this->config->application->redis->keyStructure->mcpc->mcstatus);
        if(!$mojang) {
            $status = json_decode(file_get_contents('https://status.mojang.com/check'),true);
            foreach ($status as $key => $value) {
                $key = current(array_keys($value));
                if($value[$key] == 'green') {
                    $output[$key]['status'] = "Online";
                } elseif($value[$key] == 'yellow') {
                    $output[$key]['status'] = "Slow";
                } elseif($value[$key] == 'red') {
                    $output[$key]['status'] = "Offline";
                }
            }
            $redis->set($this->config->application->redis->keyStructure->mcpc->mcstatus, json_encode($output, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE), 60);
        } else {
            $output = json_decode($redis->get($this->config->application->redis->keyStructure->mcpc->mcstatus),true);
        }
        echo json_encode($output, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
    }

}
