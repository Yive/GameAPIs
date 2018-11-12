<?php

namespace GameAPIs\Controllers\APIs\Minecraft\Query\Icon;

use GameAPIs\Libraries\Minecraft\Query\MCPing;
use Redis;
use Phalcon\Filter;

class IndexController extends ControllerBase {

    public function indexAction() {
        $params = $this->dispatcher->getParams();
        if(empty($params['ip'])) {
            $output['error'] = "Please provide an address";
            echo json_encode($output, JSON_PRETTY_PRINT);
        } else {
            if(strpos($params['ip'],',')) {
                $default = "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";
                $favicon = imagecreatefromstring(base64_decode($default));
                imagepng($favicon);
                imagedestroy($favicon);
            } else {
                $this->dispatcher->forward(
                    [
                        "namespace"     => "GameAPIs\Controllers\APIs\Minecraft\Query\Icon",
                        "controller"    => "index",
                        "action"        => "single"
                    ]
                );
            }
        }
    }

    public function singleAction() {
        $default = "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";
        $params = $this->dispatcher->getParams();
        $filter = new Filter();
        if(strpos($params['ip'], ':')) {
            $explodeParams = explode(':', $params['ip']);
            $params['ip'] = $explodeParams[0];
            $params['port'] = (int) $explodeParams[1];
        } else {
            $params['port'] = 25565;
        }
        $cConfig = array();
        $cConfig['ip']   = $filter->sanitize($params['ip'], 'string');
        $cConfig['port'] = $params['port'] ?? 25565;

        $cConfig['redis']['host'] = $this->config->application->redis->host;
        $cConfig['redis']['key']  = $this->config->application->redis->keyStructure->mcpc->ping.$cConfig['ip'].':'.$cConfig['port'];

        $redis = new Redis();
        $redis->pconnect($cConfig['redis']['host']);
        if($redis->exists($cConfig['redis']['key'])) {
            $response = json_decode(base64_decode($redis->get($cConfig['redis']['key'])),true);
            $favicon = @imagecreatefromstring(base64_decode(str_replace('data:image/png;base64,', '', $response['favicon'])));
            if ($favicon !== false) {
                imagesavealpha($favicon, true);
                imagepng($favicon);
                imagedestroy($favicon);
            } else {
                $favicon = imagecreatefromstring(base64_decode($default));
                imagepng($favicon);
                imagedestroy($favicon);
            }
        } else {
            $status    = new MCPing();
            $getStatus = $status->GetStatus($params['ip'], $params['port']);
            $response  = $getStatus->Response();
            if($response['error'] == "Server returned too little data.") {
                $status    = new MCPing();
                $getStatus = $status->GetStatus($params['ip'], $params['port'], true);
                $response  = $getStatus->Response();
            }
            $response['htmlmotd']  = $getStatus->MotdToHtml($response['motd']);
            $response['cleanmotd'] = $getStatus->ClearMotd($response['motd']);

            $favicon = @imagecreatefromstring(base64_decode(str_replace('data:image/png;base64,', '', $response['favicon'])));
            if ($favicon !== false) {
                imagesavealpha($favicon, true);
                imagepng($favicon);
                imagedestroy($favicon);
            } else {
                $favicon = imagecreatefromstring(base64_decode($default));
                imagepng($favicon);
                imagedestroy($favicon);
            }
            $redis->set($cConfig['redis']['key'], base64_encode(json_encode($response, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE)), 15);
        }
        header("Cache-Control: max-age=15");
    }
}
