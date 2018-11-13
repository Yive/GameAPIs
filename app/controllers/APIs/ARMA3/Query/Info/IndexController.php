<?php

namespace GameAPIs\Controllers\APIs\ARMA3\Query\Info;

use Redis;
use Phalcon\Filter;

class IndexController extends ControllerBase {

    public function indexAction() {
        $params = $this->dispatcher->getParams();
        if(empty($params['ip'])) {
            $output['error'] = "Please provide an address";
            $output['code'] = 001;
            echo json_encode($output, JSON_PRETTY_PRINT);
        } else {
            if(strpos($params['ip'], ',')) {
                if(count(explode(',', $params['ip'])) > 5) {
                    $output['error'] = "Address count > 5.";
                    $output['code'] = 002;
                    echo json_encode($output, JSON_PRETTY_PRINT);
                } else {
                    $this->dispatcher->forward(
                        [
                            "namespace"     => "GameAPIs\Controllers\APIs\ARMA3\Query\Info",
                            "controller"    => "index",
                            "action"        => "multi"
                        ]
                    );
                }
            } else {
                $this->dispatcher->forward(
                    [
                        "namespace"     => "GameAPIs\Controllers\APIs\ARMA3\Query\Info",
                        "controller"    => "index",
                        "action"        => "single"
                    ]
                );
            }
        }
    }

    public function singleAction() {
        require_once(APP_PATH . '/library/Multiple/Query/Dev/Autoloader.php');
        $params = $this->dispatcher->getParams();
        $filter = new Filter();
        $cConfig = array();
        if(strpos($params['ip'], ':')) {
            $explodeParams = explode(':', $params['ip']);
            $params['ip']   = $explodeParams[0];
            $params['port'] = $explodeParams[1] ?? 2302;
        } else {
            $params['port'] = 2302;
        }
        $cConfig['ip']   = $filter->sanitize($params['ip'], 'string');
        $cConfig['port'] = $params['port'];

        $cConfig['redis']['host'] = $this->config->application->redis->host;
        $cConfig['redis']['key']  = $this->config->application->redis->keyStructure->arma3->ping.$cConfig['ip'].':'.$cConfig['port'];

        $redis = new Redis();
        $redis->pconnect($cConfig['redis']['host']);
        if($redis->exists($cConfig['redis']['key'])) {
            $response = json_decode(base64_decode($redis->get($cConfig['redis']['key'])),true);
            if(!$response['gq_online']) {
                $output['status']    = $response['gq_online']       ?? false;
                $output['hostname']  = $response['gq_address']      ?? $cConfig['ip'];
                $output['port']      = $response['gq_port_client']  ?? $cConfig['port'];
                $output['queryPort'] = $response['gq_port_query']   ?? $cConfig['port'] + 1;
                $output['protocol']  = $response['gq_transport']    ?? "udp";
                $output['error']     = "Couldn't connect to address.";
                $output['code']      = 003;
            } else {
                if(in_array($response['game_dir'], array('Arma3'))) {
                    $output['status']               = $response['gq_online'];
                    $output['hostname']             = $response['gq_address'];
                    $output['port']                 = $response['gq_port_client'];
                    $output['queryPort']            = $response['gq_port_query'];
                    $output['name']                 = $response['gq_hostname'];
                    $output['map']                  = $response['gq_mapname'];
                    $output['secured']              = ($response['secure'] == 1) ? true : false;
                    $output['password_protected']   = ($response['gq_password'] == 1) ? true : false;
                    $output['join']                 = $response['gq_joinlink'];
                    $output['version']              = $response['version'];
                    $output['protocol']             = $response['gq_transport'];
                    $output['players']['online']    = $response['gq_numplayers'];
                    $output['players']['max']       = $response['gq_maxplayers'];
                    $output['players']['list']      = $response['players'];
                    foreach ($response['players'] as $key => $value) {
                        if(empty($output['players']['list'][$key]['name'])) {
                            unset($output['players']['list'][$key]);
                            continue;
                        }
                        unset($output['players']['list'][$key]['id'], $output['players']['list'][$key]['gq_name'], $output['players']['list'][$key]['gq_score'], $output['players']['list'][$key]['gq_time'], $output['players']['list'][$key]['time']);
                        $output['players']['list'][$key]['time']['seconds'] = $response['players'][$key]['time'];
                        $output['players']['list'][$key]['time']['minutes'] = $response['players'][$key]['time'] / 60;
                        $output['players']['list'][$key]['time']['hours'] = $response['players'][$key]['time'] / 3600;
                    }
                    $output['players']['list'] = array_values($output['players']['list']);
                } else {
                    $output['status']    = $response['gq_online'];
                    $output['hostname']  = $response['gq_address'];
                    $output['port']      = $response['gq_port_client'];
                    $output['queryPort'] = $response['gq_port_query'];
                    $output['protocol']  = $response['gq_transport'];
                    $output['error']    = "Server is not running ARMA 3. (".$response['game_descr']." - ".$response['game_id'].")";
                    $output['code']      = 004;
                }
            }
            $output['cached'] = true;
        } else {
            $GameQ = new \GameQ\GameQ();
            // Switch to multiple servers, sometimes people will either provide the correct query port or the join port.
            $GameQ->addServers(
                [
                    [
                        'type'  => 'arma3',
                        'host'  => $cConfig['ip'].':'.$cConfig['port'],
                        'id'    => 0
                    ],
                    [
                        'type' => 'arma3',
                        'host'=> $cConfig['ip'].':'.$cConfig['port'],
                        'id'    => 1,
                        'options' => [
                            'query_port' => $cConfig['port'] + 1
                        ]
                    ]
                ]
            );
            $GameQ->setOption('timeout', 3); // Russian servers have shitty filters causing their query time to sometimes be above 2 seconds.

            $responses = $GameQ->process();
            foreach ($responses as $resp) {
                if($resp['gq_online']) {
                    $response = $resp;
                }
            }
            if(empty($response)) {
                $response = $responses[0];
            }

            if(!$response['gq_online']) {
                $output['status']    = $response['gq_online']       ?? false;
                $output['hostname']  = $response['gq_address']      ?? $cConfig['ip'];
                $output['port']      = $response['gq_port_client']  ?? $cConfig['port'];
                $output['queryPort'] = $response['gq_port_query']   ?? $cConfig['port'] + 1;
                $output['protocol']  = $response['gq_transport']    ?? "udp";
                $output['error']     = "Couldn't connect to address.";
                $output['code']      = 003;
            } else {
                if(in_array($response['game_dir'], array('Arma3'))) {
                    $output['status']               = $response['gq_online'];
                    $output['hostname']             = $response['gq_address'];
                    $output['port']                 = $response['gq_port_client'];
                    $output['queryPort']            = $response['gq_port_query'];
                    $output['name']                 = $response['gq_hostname'];
                    $output['map']                  = $response['gq_mapname'];
                    $output['secured']              = ($response['secure'] == 1) ? true : false;
                    $output['password_protected']   = ($response['gq_password'] == 1) ? true : false;
                    $output['join']                 = $response['gq_joinlink'];
                    $output['version']              = $response['version'];
                    $output['protocol']             = $response['gq_transport'];
                    $output['players']['online']    = $response['gq_numplayers'];
                    $output['players']['max']       = $response['gq_maxplayers'];
                    $output['players']['list']      = $response['players'];
                    foreach ($response['players'] as $key => $value) {
                        if(empty($output['players']['list'][$key]['name'])) {
                            unset($output['players']['list'][$key]);
                            continue;
                        }
                        unset($output['players']['list'][$key]['id'], $output['players']['list'][$key]['gq_name'], $output['players']['list'][$key]['gq_score'], $output['players']['list'][$key]['gq_time'], $output['players']['list'][$key]['time']);
                        $output['players']['list'][$key]['time']['seconds'] = $response['players'][$key]['time'];
                        $output['players']['list'][$key]['time']['minutes'] = $response['players'][$key]['time'] / 60;
                        $output['players']['list'][$key]['time']['hours'] = $response['players'][$key]['time'] / 3600;
                    }
                    $output['players']['list'] = array_values($output['players']['list']);
                } else {
                    $output['status']    = $response['gq_online'];
                    $output['hostname']  = $response['gq_address'];
                    $output['port']      = $response['gq_port_client'];
                    $output['queryPort'] = $response['gq_port_query'];
                    $output['protocol']  = $response['gq_transport'];
                    $output['error']    = "Server is not running ARMA 3. (".$response['game_descr']." - ".$response['game_id'].")";
                    $output['code']      = 004;
                }
            }
            $output['cached'] = false;
            $redis->set($cConfig['redis']['key'], base64_encode(json_encode($response, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE)), 15);
        }
        header("Cache-Control: s-maxage=15, max-age=15");
        echo json_encode($output, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
    }

    public function multiAction() {
        require_once(APP_PATH . '/library/Multiple/Query/Dev/Autoloader.php');
        $params = $this->dispatcher->getParams();
        $explodeComma = explode(',', $params['ip']);
        unset($params['ip']);
        $i=0;
        $cConfig = array();

        $cConfig['redis']['host'] = $this->config->application->redis->host;
        $redis = new Redis();
        $redis->pconnect($cConfig['redis']['host']);
        foreach ($explodeComma as $key => $value) {
            if(strpos($value, ':')) {
                $explodeParams = explode(':', $value);
                $cConfig['addresses'][$i]['ip'] = $explodeParams[0];
                $cConfig['addresses'][$i]['port'] = (int) $explodeParams[1] ?? 2302;
            } else {
                $cConfig['addresses'][$i]['ip'] = $value;
                $cConfig['addresses'][$i]['port'] = 2302;
            }
            $i++;
        }
        foreach ($cConfig['addresses'] as $key => $value) {
            $combined = $value['ip'].':'.$value['port'];
            $combinedRedis = $this->config->application->redis->keyStructure->arma3->ping.$combined;
            if($redis->exists($combinedRedis)) {
                $response = json_decode(base64_decode($redis->get($combinedRedis)),true);
                if(!$response['gq_online']) {
                    $output[$combined]['status']    = $response['gq_online']        ?? false;
                    $output[$combined]['hostname']  = $response['gq_address']       ?? $value['ip'];
                    $output[$combined]['port']      = $response['gq_port_client']   ?? $value['port'];
                    $output[$combined]['queryPort'] = $response['gq_port_query']    ?? $value['port'] + 1;
                    $output[$combined]['protocol']  = $response['gq_transport']     ?? "udp";
                    $output[$combined]['error']     = "Couldn't connect to address.";
                    $output[$combined]['code']      = 003;
                } else {
                	if(in_array($response['game_dir'], array('Arma3'))) {
                        $output[$combined]['status']                = $response['gq_online'];
                        $output[$combined]['hostname']              = $response['gq_address'];
                        $output[$combined]['port']                  = $response['gq_port_client'];
                        $output[$combined]['name']                  = $response['gq_hostname'];
                        $output[$combined]['map']                   = $response['gq_mapname'];
                        $output[$combined]['secured']               = ($response['secure'] == 1) ? true : false;
                        $output[$combined]['password_protected']    = ($response['gq_password'] == 1) ? true : false;
                        $output[$combined]['join']                  = $response['gq_joinlink'];
                        $output[$combined]['version']               = $response['version'];
                        $output[$combined]['protocol']              = $response['gq_transport'];
                        $output[$combined]['players']['online']     = $response['gq_numplayers'];
                        $output[$combined]['players']['max']        = $response['gq_maxplayers'];
                        $output[$combined]['players']['list']       = $response['players'];
                        foreach ($response['players'] as $key => $value) {
                            if(empty($output[$combined]['players']['list'][$key]['name'])) {
                                unset($output[$combined]['players']['list'][$key]);
                                continue;
                            }
                            unset($output[$combined]['players']['list'][$key]['id'], $output[$combined]['players']['list'][$key]['gq_name'], $output[$combined]['players']['list'][$key]['gq_score'], $output[$combined]['players']['list'][$key]['gq_time']);
                            $output[$combined]['players']['list'][$key]['time']['seconds'] = $response['players'][$key]['time'];
                            $output[$combined]['players']['list'][$key]['time']['minutes'] = $response['players'][$key]['time'] / 60;
                            $output[$combined]['players']['list'][$key]['time']['hours'] = $response['players'][$key]['time'] / 3600;
                        }
                        $output[$combined]['players']['list'] = array_values($output[$combined]['players']['list']);
                    } else {
                        $output[$combined]['status']    = $response['gq_online'];
                        $output[$combined]['hostname']  = $response['gq_address'];
                        $output[$combined]['port']      = $response['gq_port_client'];
                        $output[$combined]['queryPort'] = $response['gq_port_query'];
                        $output[$combined]['protocol']  = $response['gq_transport'];
                        $output[$combined]['error']     = "Server is not running ARMA 3. (".$response['game_descr']." - ".$response['game_id'].")";
                        $output[$combined]['code']      = 004;
                    }
                }
                $output[$combined]['cached'] = true;
            } else {
                $GameQ = new \GameQ\GameQ();
                // Switch to multiple servers, sometimes people will either provide the correct query port or the join port.
                $GameQ->addServers(
                    [
                        [
                            'type'  => 'arma3',
                            'host'  => $combined,
                            'id'    => 0
                        ],
                        [
                            'type'  => 'arma3',
                            'host'  => $combined,
                            'id'    => 1,
                            'options' => [
                                'query_port' => $value['port'] + 1
                            ]
                        ]
                    ]
                );
                $GameQ->setOption('timeout', 3); // Russian servers have shitty filters causing their query time to sometimes be above 2 seconds.

                $responses = $GameQ->process();
                foreach ($responses as $resp) {
                    if($resp['gq_online']) {
                        $response = $resp;
                    }
                }
                if(empty($response)) {
                    $response = $responses[0];
                }

                if(!$response['gq_online']) {
                    $output[$combined]['status']    = $response['gq_online']        ?? false;
                    $output[$combined]['hostname']  = $response['gq_address']       ?? $value['ip'];
                    $output[$combined]['port']      = $response['gq_port_client']   ?? $value['port'];
                    $output[$combined]['queryPort'] = $response['gq_port_query']    ?? $value['port'] + 1;
                    $output[$combined]['protocol']  = $response['gq_transport']     ?? "udp";
                    $output[$combined]['error']     = "Couldn't connect to address.";
                    $output[$combined]['code']      = 003;
                } else {
                	if(in_array($response['game_dir'], array('Arma3'))) {
                        $output[$combined]['status']                = $response['gq_online'];
                        $output[$combined]['hostname']              = $response['gq_address'];
                        $output[$combined]['port']                  = $response['gq_port_client'];
                        $output[$combined]['name']                  = $response['gq_hostname'];
                        $output[$combined]['map']                   = $response['gq_mapname'];
                        $output[$combined]['secured']               = ($response['secure'] == 1) ? true : false;
                        $output[$combined]['password_protected']    = ($response['gq_password'] == 1) ? true : false;
                        $output[$combined]['join']                  = $response['gq_joinlink'];
                        $output[$combined]['version']               = $response['version'];
                        $output[$combined]['protocol']              = $response['gq_transport'];
                        $output[$combined]['players']['online']     = $response['gq_numplayers'];
                        $output[$combined]['players']['max']        = $response['gq_maxplayers'];
                        $output[$combined]['players']['list']       = $response['players'];
                        foreach ($response['players'] as $key => $value) {
                            if(empty($output[$combined]['players']['list'][$key]['name'])) {
                                unset($output[$combined]['players']['list'][$key]);
                                continue;
                            }
                            unset($output[$combined]['players']['list'][$key]['id'], $output[$combined]['players']['list'][$key]['gq_name'], $output[$combined]['players']['list'][$key]['gq_score'], $output[$combined]['players']['list'][$key]['gq_time']);
                            $output[$combined]['players']['list'][$key]['time']['seconds'] = $response['players'][$key]['time'];
                            $output[$combined]['players']['list'][$key]['time']['minutes'] = $response['players'][$key]['time'] / 60;
                            $output[$combined]['players']['list'][$key]['time']['hours'] = $response['players'][$key]['time'] / 3600;
                        }
                        $output[$combined]['players']['list'] = array_values($output[$combined]['players']['list']);
                    } else {
                        $output[$combined]['status']    = $response['gq_online'];
                        $output[$combined]['hostname']  = $response['gq_address'];
                        $output[$combined]['port']      = $response['gq_port_client'];
                        $output[$combined]['queryPort'] = $response['gq_port_query'];
                        $output[$combined]['protocol']  = $response['gq_transport'];
                        $output[$combined]['error']     = "Server is not running ARMA 3. (".$response['game_descr']." - ".$response['game_id'].")";
                        $output[$combined]['code']      = 004;
                    }
                }
                $output[$combined]['cached'] = false;
                $redis->set($combinedRedis, base64_encode(json_encode($response, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE)), 15);
            }
        }
        header("Cache-Control: s-maxage=15, max-age=15");
        echo json_encode($output, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
    }
}
