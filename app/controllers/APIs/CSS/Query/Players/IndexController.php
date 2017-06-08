<?php

namespace GameAPIs\Controllers\APIs\CSS\Query\Players;

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
                            "namespace"     => "GameAPIs\Controllers\APIs\CSS\Query\Players",
                            "controller"    => "index",
                            "action"        => "multi"
                        ]
                    );
                }
            } else {
                $this->dispatcher->forward(
                    [
                        "namespace"     => "GameAPIs\Controllers\APIs\CSS\Query\Players",
                        "controller"    => "index",
                        "action"        => "single"
                    ]
                );
            }
        }
    }

    public function singleAction() {
        require_once(APP_PATH . '/library/Multiple/Query/V3/vendor/autoload.php');
        $params = $this->dispatcher->getParams();
        $redis = new Redis();
        $redis->pconnect('/var/run/redis/redis.sock');
        if(!strpos($params['ip'], ':')) {
            $params['ip'] = $params['ip'].':27015';
        }
        if($redis->exists('ping:css:'.$params['ip'])) {
            $response = json_decode(base64_decode($redis->get('ping:css:'.$params['ip'])),true);
            if(!$response['gq_online']) {
                $output['status']   = $response['gq_online'];
                $output['hostname'] = $response['gq_address'];
                $output['port']     = $response['gq_port_client'];
                $output['error']    = "Couldn't connect to address.";
            } else {
                $output['status']               = $response['gq_online'];
                $output['hostname']             = $response['gq_address'];
                $output['port']                 = $response['gq_port_client'];
                $output['players']['online']    = $response['gq_numplayers'];
                $output['players']['max']       = $response['gq_maxplayers'];
                $output['players']['list']      = $response['players'];
                foreach ($response['players'] as $key => $value) {
                    unset($output['players']['list'][$key]['id'], $output['players']['list'][$key]['gq_name'], $output['players']['list'][$key]['gq_score'], $output['players']['list'][$key]['gq_time']);
                    $output['players']['list'][$key]['time']['seconds'] = $response['players'][$key]['time'];
                    $output['players']['list'][$key]['time']['minutes'] = $response['players'][$key]['time'] / 60;
                    $output['players']['list'][$key]['time']['hours'] = $response['players'][$key]['time'] / 3600;
                }
            }
            $output['cached'] = true;
        } else {
            $GameQ = new \GameQ\GameQ();
            $GameQ->addServer(['type' => 'css','host'=> $params['ip']]);
            $GameQ->setOption('timeout', 2); // seconds

            $response = $GameQ->process();
            $response = $response[$params['ip']];

            if(!$response['gq_online']) {
                $output['status']   = $response['gq_online'];
                $output['hostname'] = $response['gq_address'];
                $output['port']     = $response['gq_port_client'];
                $output['error']    = "Couldn't connect to address.";
            } else {
                $output['status']               = $response['gq_online'];
                $output['hostname']             = $response['gq_address'];
                $output['port']                 = $response['gq_port_client'];
                $output['players']['online']    = $response['gq_numplayers'];
                $output['players']['max']       = $response['gq_maxplayers'];
                $output['players']['list']      = $response['players'];
                foreach ($response['players'] as $key => $value) {
                    unset($output['players']['list'][$key]['id'], $output['players']['list'][$key]['gq_name'], $output['players']['list'][$key]['gq_score'], $output['players']['list'][$key]['gq_time']);
                    $output['players']['list'][$key]['time']['seconds'] = $response['players'][$key]['time'];
                    $output['players']['list'][$key]['time']['minutes'] = $response['players'][$key]['time'] / 60;
                    $output['players']['list'][$key]['time']['hours'] = $response['players'][$key]['time'] / 3600;
                }
            }
            $output['cached'] = false;
            $redis->set('ping:css:'.$params['ip'], base64_encode(json_encode($response, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE)), 15);
        }
        echo json_encode($output, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
    }

    public function multiAction() {
        require_once(APP_PATH . '/library/Multiple/Query/V3/vendor/autoload.php');
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
                $params['addresses'][$i]['port'] = 27015;
            }
            $i++;
        }
        foreach ($params['addresses'] as $key => $value) {
            $combined = $value['ip'].':'.$value['port'];
            if($redis->exists('ping:css:'.$combined)) {
                $response = json_decode(base64_decode($redis->get('ping:css:'.$combined)),true);
                if(!$response['online']) {
                    $output[$combined]['status']   = $response['gq_online'];
                    $output[$combined]['hostname'] = $response['gq_address'];
                    $output[$combined]['port']     = $response['gq_port_client'];
                    $output[$combined]['error']    = "Couldn't connect to address.";
                } else {
                	$output[$combined]['status']   = $response['gq_online'];
                	$output[$combined]['hostname'] = $response['gq_address'];
                	$output[$combined]['port']     = $response['gq_port_client'];
                    $output[$combined]['players']['online']    = $response['gq_numplayers'];
                    $output[$combined]['players']['max']       = $response['gq_maxplayers'];
                    $output[$combined]['players']['list']      = $response['players'];
                    foreach ($response['players'] as $key => $value) {
                        unset($output[$combined]['players']['list'][$key]['id'], $output[$combined]['players']['list'][$key]['gq_name'], $output[$combined]['players']['list'][$key]['gq_score'], $output[$combined]['players']['list'][$key]['gq_time']);
                        $output[$combined]['players']['list'][$key]['time']['seconds'] = $response['players'][$key]['time'];
                        $output[$combined]['players']['list'][$key]['time']['minutes'] = $response['players'][$key]['time'] / 60;
                        $output[$combined]['players']['list'][$key]['time']['hours'] = $response['players'][$key]['time'] / 3600;
                    }
                }
                $output[$combined]['cached'] = true;
            } else {
                $GameQ = new \GameQ\GameQ();
                $GameQ->addServer(['type' => 'css','host'=> $combined]);
                $GameQ->setOption('timeout', 2); // seconds

                $response = $GameQ->process();
                $response = $response[$combined];

                if(!$response['online']) {
                    $output[$combined]['status']   = $response['gq_online'];
                    $output[$combined]['hostname'] = $response['gq_address'];
                    $output[$combined]['port']     = $params['gq_port_client'];
                    $output[$combined]['error']    = "Couldn't connect to address.";
                } else {
                	$output[$combined]['status']   = $response['gq_online'];
                	$output[$combined]['hostname'] = $response['gq_address'];
                	$output[$combined]['port']     = $response['gq_port_client'];
                    $output[$combined]['players']['online']    = $response['gq_numplayers'];
                    $output[$combined]['players']['max']       = $response['gq_maxplayers'];
                    $output[$combined]['players']['list']      = $response['players'];
                    foreach ($response['players'] as $key => $value) {
                        unset($output[$combined]['players']['list'][$key]['id'], $output[$combined]['players']['list'][$key]['gq_name'], $output[$combined]['players']['list'][$key]['gq_score'], $output[$combined]['players']['list'][$key]['gq_time']);
                        $output[$combined]['players']['list'][$key]['time']['seconds'] = $response['players'][$key]['time'];
                        $output[$combined]['players']['list'][$key]['time']['minutes'] = $response['players'][$key]['time'] / 60;
                        $output[$combined]['players']['list'][$key]['time']['hours'] = $response['players'][$key]['time'] / 3600;
                    }
                }
                $output[$combined]['cached'] = false;
                $redis->set('ping:css:'.$combined, base64_encode(json_encode($response, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE)), 15);
            }
        }
        echo json_encode($output, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
    }
}
