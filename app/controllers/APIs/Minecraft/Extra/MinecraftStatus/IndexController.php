<?php

namespace GameAPIs\Controllers\APIs\Minecraft\Extra\MinecraftStatus;

use Redis;

class IndexController extends ControllerBase {

    public function indexAction() {
        $cConfig = array();
        $cConfig['redis']['host'] = $this->config->application->redis->host;
        $cConfig['redis']['key'] = $this->config->application->redis->keyStructure->mcpc->mcstatus;
        $redis = new Redis();
        $redis->pconnect($cConfig['redis']['host']);
        if(!$redis->exists($cConfig['redis']['key'])) {
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
            $redis->set($cConfig['redis']['key'], json_encode($output, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE), 60);
        } else {
            $output = json_decode($redis->get($cConfig['redis']['key']),true);
        }
        header("Cache-Control: max-age=60");
        echo json_encode($output, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
    }

}
