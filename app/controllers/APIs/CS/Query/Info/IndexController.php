<?php

namespace GameAPIs\Controllers\APIs\CS\Query\Info;

use Redis;

class IndexController extends ControllerBase {

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
                            "namespace"     => "GameAPIs\Controllers\APIs\CS\Query\Info",
                            "controller"    => "index",
                            "action"        => "multi"
                        ]
                    );
                }
            } else {
                $this->dispatcher->forward(
                    [
                        "namespace"     => "GameAPIs\Controllers\APIs\CS\Query\Info",
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
        $redis->pconnect($this->config->application->redis->host);
        if(!strpos($params['ip'], ':')) {
            $params['ip'] = $params['ip'].':27015';
        }
        if($redis->exists($this->config->application->redis->keyStructure->cs16->ping.$params['ip'])) {
            $response = json_decode(base64_decode($redis->get($this->config->application->redis->keyStructure->cs16->ping.$params['ip'])),true);
            if(!$response['gq_online']) {
                $output['status']   = $response['gq_online'];
                $output['hostname'] = $response['gq_address'];
                $output['port']     = $response['gq_port_client'];
                $output['error']    = "Couldn't connect to address.";
            } else {
                if(in_array($response['game_dir'], array('cstrike')) && $response['game_descr'] !== "Counter-Strike: Source") {
                    $output['status']               = $response['gq_online'];
                    $output['hostname']             = $response['gq_address'];
                    $output['port']                 = $response['gq_port_client'];
                    $output['name']                 = $response['gq_hostname'];
                    $output['map']                  = $response['gq_mapname'];
                    if($response['secure'] == 1) {
                        $response['secure'] = true;
                    } else {
                        $response['secure'] = false;
                    }
                    if($response['gq_password'] == 1) {
                        $response['gq_password'] = true;
                    } else {
                        $response['gq_password'] = false;
                    }
                    $output['secured']              = $response['secure'];
                    $output['password_protected']   = $response['gq_password'];
                    $output['join']                 = $response['gq_joinlink'];
                    $output['version']              = $response['version'];
                    $output['protocol']             = $response['protocol'];
                    $output['players']['online']    = $response['gq_numplayers'];
                    $output['players']['max']       = $response['gq_maxplayers'];
                    $output['players']['list']      = $response['players'];
                    foreach ($response['players'] as $key => $value) {
                        unset($output['players']['list'][$key]['id'], $output['players']['list'][$key]['gq_name'], $output['players']['list'][$key]['gq_score'], $output['players']['list'][$key]['gq_time'], $output['players']['list'][$key]['time']);
                        $output['players']['list'][$key]['time']['seconds'] = $response['players'][$key]['time'];
                        $output['players']['list'][$key]['time']['minutes'] = $response['players'][$key]['time'] / 60;
                        $output['players']['list'][$key]['time']['hours'] = $response['players'][$key]['time'] / 3600;
                    }
                } else {
                    $output['status']   = $response['gq_online'];
                    $output['hostname'] = $response['gq_address'];
                    $output['port']     = $response['gq_port_client'];
                    $output['error']    = "Server is not running Counter-Strike 1.6. It's running ".$response['game_descr']." (".$response['game_id'].")";
                }
            }
            $output['cached'] = true;
        } else {
            $GameQ = new \GameQ\GameQ();
            $GameQ->addServer(['type' => 'cs16','host'=> $params['ip']]);
            $GameQ->setOption('timeout', 3); // seconds

            $response = $GameQ->process();
            $response = $response[$params['ip']];

            if(!$response['gq_online']) {
                $output['status']   = $response['gq_online'];
                $output['hostname'] = $response['gq_address'];
                $output['port']     = $response['gq_port_client'];
                $output['error']    = "Couldn't connect to address.";
            } else {
                if(in_array($response['game_dir'], array('cstrike')) && $response['game_descr'] !== "Counter-Strike: Source") {
                    $output['status']               = $response['gq_online'];
                    $output['hostname']             = $response['gq_address'];
                    $output['port']                 = $response['gq_port_client'];
                    $output['name']                 = $response['gq_hostname'];
                    $output['map']                  = $response['gq_mapname'];
                    if($response['secure'] == 1) {
                        $response['secure'] = true;
                    } else {
                        $response['secure'] = false;
                    }
                    if($response['gq_password'] == 1) {
                        $response['gq_password'] = true;
                    } else {
                        $response['gq_password'] = false;
                    }
                    $output['secured']              = $response['secure'];
                    $output['password_protected']   = $response['gq_password'];
                    $output['join']                 = $response['gq_joinlink'];
                    $output['version']              = $response['version'];
                    $output['protocol']             = $response['protocol'];
                    $output['players']['online']    = $response['gq_numplayers'];
                    $output['players']['max']       = $response['gq_maxplayers'];
                    $output['players']['list']      = $response['players'];
                    foreach ($response['players'] as $key => $value) {
                        unset($output['players']['list'][$key]['id'], $output['players']['list'][$key]['gq_name'], $output['players']['list'][$key]['gq_score'], $output['players']['list'][$key]['gq_time'], $output['players']['list'][$key]['time']);
                        $output['players']['list'][$key]['time']['seconds'] = $response['players'][$key]['time'];
                        $output['players']['list'][$key]['time']['minutes'] = $response['players'][$key]['time'] / 60;
                        $output['players']['list'][$key]['time']['hours'] = $response['players'][$key]['time'] / 3600;
                    }
                } else {
                    $output['status']   = $response['gq_online'];
                    $output['hostname'] = $response['gq_address'];
                    $output['port']     = $response['gq_port_client'];
                    $output['error']    = "Server is not running Counter-Strike 1.6. It's running ".$response['game_descr']." (".$response['game_id'].")";
                }
            }
            $output['cached'] = false;
            $redis->set($this->config->application->redis->keyStructure->cs16->ping.$params['ip'], base64_encode(json_encode($response, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE)), 15);
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
        $redis->pconnect($this->config->application->redis->host);
        foreach ($explodeComma as $key => $value) {
            if(strpos($value, ':')) {
                $explodeParams = explode(':', $value);
                $params['addresses'][$i]['ip'] = $explodeParams[0];
                $params['addresses'][$i]['port'] = (int) $explodeParams[1];
            } else {
                $params['addresses'][$i]['ip'] = $value;
                $params['addresses'][$i]['port'] = 27015;
            }
            $i++;
        }
        foreach ($params['addresses'] as $key => $value) {
            $combined = $value['ip'].':'.$value['port'];
            if($redis->exists($this->config->application->redis->keyStructure->cs16->ping.$combined)) {
                $response = json_decode(base64_decode($redis->get($this->config->application->redis->keyStructure->cs16->ping.$combined)),true);
                if(!$response['online']) {
                    $output[$combined]['status']   = $response['gq_online'];
                    $output[$combined]['hostname'] = $response['gq_address'];
                    $output[$combined]['port']     = $response['gq_port_client'];
                    $output[$combined]['error']    = "Couldn't connect to address.";
                } else {
                    if(in_array($response['game_dir'], array('cstrike')) && $response['game_descr'] !== "Counter-Strike: Source") {
                        $output[$combined]['status']   = $response['gq_online'];
                        $output[$combined]['hostname'] = $response['gq_address'];
                        $output[$combined]['port']     = $response['gq_port_client'];
                        $output[$combined]['name']     = $response['gq_hostname'];
                        $output[$combined]['map']      = $response['gq_mapname'];
                        if($response['secure'] == 1) {
                            $response['secure'] = true;
                        } else {
                            $response['secure'] = false;
                        }
                        if($response['gq_password'] == 1) {
                            $response['gq_password'] = true;
                        } else {
                            $response['gq_password'] = false;
                        }
                        $output[$combined]['secured']              = $response['secure'];
                        $output[$combined]['password_protected']   = $response['gq_password'];
                        $output[$combined]['join']                 = $response['gq_joinlink'];
                        $output[$combined]['version']              = $response['version'];
                        $output[$combined]['protocol']             = $response['protocol'];
                        $output[$combined]['players']['online']    = $response['gq_numplayers'];
                        $output[$combined]['players']['max']       = $response['gq_maxplayers'];
                        $output[$combined]['players']['list']      = $response['players'];
                        foreach ($response['players'] as $key => $value) {
                            unset($output[$combined]['players']['list'][$key]['id'], $output[$combined]['players']['list'][$key]['gq_name'], $output[$combined]['players']['list'][$key]['gq_score'], $output[$combined]['players']['list'][$key]['gq_time']);
                            $output[$combined]['players']['list'][$key]['time']['seconds'] = $response['players'][$key]['time'];
                            $output[$combined]['players']['list'][$key]['time']['minutes'] = $response['players'][$key]['time'] / 60;
                            $output[$combined]['players']['list'][$key]['time']['hours'] = $response['players'][$key]['time'] / 3600;
                        }
                    } else {
                        $output[$combined]['status']   = $response['gq_online'];
                        $output[$combined]['hostname'] = $response['gq_address'];
                        $output[$combined]['port']     = $response['gq_port_client'];
                        $output[$combined]['error']    = "Server is not running Counter-Strike 1.6. It's running ".$response['game_descr']." (".$response['game_id'].")";
                    }
                }
                $output[$combined]['cached'] = true;
            } else {
                $GameQ = new \GameQ\GameQ();
                $GameQ->addServer(['type' => 'cs16','host'=> $combined]);
                $GameQ->setOption('timeout', 2); // seconds

                $response = $GameQ->process();
                $response = $response[$combined];

                if(!$response['online']) {
                    $output[$combined]['status']   = $response['gq_online'];
                    $output[$combined]['hostname'] = $response['gq_address'];
                    $output[$combined]['port']     = $response['gq_port_client'];
                    $output[$combined]['error']    = "Couldn't connect to address.";
                } else {
                	if(in_array($response['game_dir'], array('cstrike')) && $response['game_descr'] !== "Counter-Strike: Source") {
                        $output[$combined]['status']   = $response['gq_online'];
                        $output[$combined]['hostname'] = $response['gq_address'];
                        $output[$combined]['port']     = $response['gq_port_client'];
                        $output[$combined]['name']     = $response['gq_hostname'];
                        $output[$combined]['map']      = $response['gq_mapname'];
                        if($response['secure'] == 1) {
                            $response['secure'] = true;
                        } else {
                            $response['secure'] = false;
                        }
                        if($response['gq_password'] == 1) {
                            $response['gq_password'] = true;
                        } else {
                            $response['gq_password'] = false;
                        }
                        $output[$combined]['secured']              = $response['secure'];
                        $output[$combined]['password_protected']   = $response['gq_password'];
                        $output[$combined]['join']                 = $response['gq_joinlink'];
                        $output[$combined]['version']              = $response['version'];
                        $output[$combined]['protocol']             = $response['protocol'];
                        $output[$combined]['players']['online']    = $response['gq_numplayers'];
                        $output[$combined]['players']['max']       = $response['gq_maxplayers'];
                        $output[$combined]['players']['list']      = $response['players'];
                        foreach ($response['players'] as $key => $value) {
                            unset($output[$combined]['players']['list'][$key]['id'], $output[$combined]['players']['list'][$key]['gq_name'], $output[$combined]['players']['list'][$key]['gq_score'], $output[$combined]['players']['list'][$key]['gq_time']);
                            $output[$combined]['players']['list'][$key]['time']['seconds'] = $response['players'][$key]['time'];
                            $output[$combined]['players']['list'][$key]['time']['minutes'] = $response['players'][$key]['time'] / 60;
                            $output[$combined]['players']['list'][$key]['time']['hours'] = $response['players'][$key]['time'] / 3600;
                        }
                    } else {
                        $output[$combined]['status']   = $response['gq_online'];
                        $output[$combined]['hostname'] = $response['gq_address'];
                        $output[$combined]['port']     = $response['gq_port_client'];
                        $output[$combined]['error']    = "Server is not running Counter-Strike 1.6. It's running ".$response['game_descr']." (".$response['game_id'].")";
                    }
                }
                $output[$combined]['cached'] = false;
                $redis->set($this->config->application->redis->keyStructure->cs16->ping.$combined, base64_encode(json_encode($response, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE)), 15);
            }
        }
        echo json_encode($output, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
    }
}
