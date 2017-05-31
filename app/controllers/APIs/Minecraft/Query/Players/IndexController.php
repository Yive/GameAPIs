<?php

namespace GameAPIs\Controllers\APIs\Minecraft\Query\Players;

use GameAPIs\Libraries\Minecraft\Query\MCPing;
use Redis;

class IndexController extends ControllerBase {

    public function initialize() {
        $this->tag->setTitle("GameAPIs");
    }

    public function indexAction() {
        $params = $this->dispatcher->getParams();
        if(empty($params['ip'])) {
            $output['error'] = "Please provide an address";
            echo json_encode($output, JSON_PRETTY_PRINT);
        } else {
            if(strpos($params['ip'],',')) {
                if(count(explode(',', $params['ip'])) > 5) {
                    $output['error'] = "Maximum address count surpassed. Please lower to 5 addresses.";
                    echo json_encode($output, JSON_PRETTY_PRINT);
                } else {
                    $this->dispatcher->forward(
                        [
                            "namespace"     => "GameAPIs\Controllers\APIs\Minecraft\Query\Players",
                            "controller"    => "index",
                            "action"        => "multi"
                        ]
                    );
                }
            } else {
                $this->dispatcher->forward(
                    [
                        "namespace"     => "GameAPIs\Controllers\APIs\Minecraft\Query\Players",
                        "controller"    => "index",
                        "action"        => "single"
                    ]
                );
            }
        }
    }

    public function singleAction() {
        $params = $this->dispatcher->getParams();
        if(strpos($params['ip'], ':')) {
            $explodeParams = explode(':', $params['ip']);
            $params['ip'] = $explodeParams[0];
            $params['port'] = $explodeParams[1];
        } else {
            $params['port'] = 25565;
        }
        $redis = new Redis();
        $redis->pconnect('/var/run/redis/redis.sock');
        if($redis->exists('ping:'.$params['ip'].':'.$params['port'])) {
            $response = json_decode(base64_decode($redis->get('ping:'.$params['ip'].':'.$params['port'])),true);
            if(!$response['online']) {
                $output['status']            = $response['online'];
                $output['hostname']          = $response['hostname'];
                $output['port']              = $params['port'];
                $output['error']             = $response['error'];
            } else {
            	$output['status']            = $response['online'];
            	$output['hostname']          = $response['hostname'];
            	$output['port']              = $response['port'];
            	$output['ping']              = $response['ping'];
            	$output['players']['online'] = $response['players'];
            	$output['players']['max']    = $response['max_players'];
            }
            $output['cached'] = true;
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

            if(!$response['online']) {
                $output['status']            = $response['online'];
                $output['hostname']          = $response['hostname'];
                $output['port']              = $params['port'];
                $output['error']             = $response['error'];
            } else {
                $output['status']            = $response['online'];
                $output['hostname']          = $response['hostname'];
                $output['port']              = $response['port'];
                $output['ping']              = $response['ping'];
                $output['players']['online'] = $response['players'];
                $output['players']['max']    = $response['max_players'];
            }
            $output['cached'] = false;
            $redis->set('ping:'.$params['ip'].':'.$params['port'], base64_encode(json_encode($response, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE)), 15);
        }
        echo json_encode($output, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
    }

    public function multiAction() {
        $params = $this->dispatcher->getParams();
        $explodeComma = explode(',', $params['ip']);
        unset($params['ip']);
        $i=0;
        $redis = new Redis();
        $redis->pconnect('/var/run/redis/redis.sock');
        foreach ($explodeComma as $key => $value) {
            if(strpos($value, ':')) {
                $explodeParams = explode(':', $value);
                $params['addresses'][$i]['ip'] = $explodeParams[0];
                $params['addresses'][$i]['port'] = $explodeParams[1];
            } else {
                $params['addresses'][$i]['ip'] = $value;
                $params['addresses'][$i]['port'] = 25565;
            }
            $i++;
        }
        foreach ($params['addresses'] as $key => $value) {
            $combined = $value['ip'].':'.$value['port'];
            if($redis->exists('ping:'.$combined)) {
                $response = json_decode(base64_decode($redis->get('ping:'.$combined)),true);
                if(!$response['online']) {
                    $output[$combined]['status']            = $response['online'];
                    $output[$combined]['hostname']          = $response['hostname'];
                    $output[$combined]['port']              = $params['port'];
                    $output[$combined]['error']             = $response['error'];
                } else {
                	$output[$combined]['status']            = $response['online'];
                	$output[$combined]['hostname']          = $response['hostname'];
                	$output[$combined]['port']              = $response['port'];
                	$output[$combined]['ping']              = $response['ping'];
                	$output[$combined]['players']['online'] = $response['players'];
                	$output[$combined]['players']['max']    = $response['max_players'];
                }
                $output[$combined]['cached'] = true;
            } else {
                $status    = new MCPing();
                $getStatus = $status->GetStatus($value['ip'], $value['port']);
                $response  = $getStatus->Response();
                if($response['error'] == "Server returned too little data.") {
                    $status    = new MCPing();
                    $getStatus = $status->GetStatus($value['ip'], $value['port'], true);
                    $response  = $getStatus->Response();
                }
                $response['htmlmotd']  = $getStatus->MotdToHtml($response['motd']);
                $response['cleanmotd'] = $getStatus->ClearMotd($response['motd']);

                if(!$response['online']) {
                    $output[$combined]['status']            = $response['online'];
                    $output[$combined]['hostname']          = $response['hostname'];
                    $output[$combined]['port']              = $params['port'];
                    $output[$combined]['error']             = $response['error'];
                } else {
                    $output[$combined]['status']            = $response['online'];
                    $output[$combined]['hostname']          = $response['hostname'];
                    $output[$combined]['port']              = $response['port'];
                    $output[$combined]['ping']              = $response['ping'];
                    $output[$combined]['players']['online'] = $response['players'];
                    $output[$combined]['players']['max']    = $response['max_players'];
                }
                $output[$combined]['cached'] = false;
                $redis->set('ping:'.$combined, base64_encode(json_encode($response, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE)), 15);
            }
        }
        echo json_encode($output, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
    }
}
