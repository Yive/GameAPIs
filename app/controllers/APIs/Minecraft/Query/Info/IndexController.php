<?php

namespace GameAPIs\Controllers\APIs\Minecraft\Query\Info;

use GameAPIs\Libraries\Minecraft\Query\MCPing;
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
                            "namespace"     => "GameAPIs\Controllers\APIs\Minecraft\Query\Info",
                            "controller"    => "index",
                            "action"        => "multi"
                        ]
                    );
                }
            } else {
                $this->dispatcher->forward(
                    [
                        "namespace"     => "GameAPIs\Controllers\APIs\Minecraft\Query\Info",
                        "controller"    => "index",
                        "action"        => "single"
                    ]
                );
            }
        }
    }

    public function singleAction() {
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
            if(!$response['online']) {
                $output['status']            = $response['online'];
                $output['hostname']          = $response['hostname'];
                $output['port']              = $params['port'];
                $output['protocol']          = "tcp";
                $output['error']             = $response['error'];
            } else {
                $output['status']            = $response['online'];
                $output['hostname']          = $response['hostname'];
                $output['port']              = $response['port'];
                $output['ping']              = $response['ping'];
                $output['version']           = $response['version'];
                $output['protocol']          = "tcp";
                $output['players']['online'] = $response['players'];
                $output['players']['max']    = $response['max_players'];
                $output['motds']['ingame']   = $response['motd'];
                $output['motds']['html']     = $response['htmlmotd'];
                $output['motds']['clean']    = $response['cleanmotd'];
                $output['favicon']           = $response['favicon'];
                $output['hover']             = $response['sample_player_list'];
                if(!empty($response['mods']['list'])) {
                    $output['mods'] = $response['mods'];
                }
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
                $output['protocol']          = "tcp";
                $output['error']             = $response['error'];
            } else {
                $response['version']         = str_replace('kcauldron,cauldron,craftbukkit,mcpc,fml,forge ', '', $response['version']);
                $output['status']            = $response['online'];
                $output['hostname']          = $response['hostname'];
                $output['port']              = $response['port'];
                $output['ping']              = $response['ping'];
                $output['version']           = $response['version'];
                $output['protocol']          = "tcp";
                $output['players']['online'] = $response['players'];
                $output['players']['max']    = $response['max_players'];
                $output['motds']['ingame']   = $response['motd'];
                $output['motds']['html']     = $response['htmlmotd'];
                $output['motds']['clean']    = $response['cleanmotd'];
                $output['favicon']           = $response['favicon'];
                $output['hover']             = $response['sample_player_list'];
                if(!empty($response['mods']['list'])) {
                    $output['mods'] = $response['mods'];
                }
            }
            $output['cached'] = false;
            $redis->set($cConfig['redis']['key'], base64_encode(json_encode($response, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE)), 15);
        }
        header("Cache-Control: max-age=15");
        echo json_encode($output, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
    }

    public function multiAction() {
        $params = $this->dispatcher->getParams();
        $filter = new Filter();
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
                $cConfig['addresses'][$i]['port'] = (int) $explodeParams[1];
            } else {
                $cConfig['addresses'][$i]['ip'] = $value;
                $cConfig['addresses'][$i]['port'] = 25565;
            }
            $i++;
        }
        foreach ($cConfig['addresses'] as $key => $value) {
            $combined = $value['ip'].':'.$value['port'];
            $combinedRedis = $this->config->application->redis->keyStructure->mcpc->ping.$combined;
            if($redis->exists($combinedRedis)) {
                $response = json_decode(base64_decode($redis->get($combinedRedis)),true);
                if(!$response['online']) {
                    $output[$combined]['status']            = $response['online'];
                    $output[$combined]['hostname']          = $response['hostname'];
                    $output[$combined]['port']              = $params['port'];
                    $output[$combined]['protocol']          = "tcp";
                    $output[$combined]['error']             = $response['error'];
                } else {
                    $output[$combined]['status']            = $response['online'];
                    $output[$combined]['hostname']          = $response['hostname'];
                    $output[$combined]['port']              = $response['port'];
                    $output[$combined]['ping']              = $response['ping'];
                    $output[$combined]['version']           = $response['version'];
                    $output[$combined]['protocol']          = "tcp";
                    $output[$combined]['players']['online'] = $response['players'];
                    $output[$combined]['players']['max']    = $response['max_players'];
                    $output[$combined]['motds']['ingame']   = $response['motd'];
                    $output[$combined]['motds']['html']     = $response['htmlmotd'];
                    $output[$combined]['motds']['clean']    = $response['cleanmotd'];
                    $output[$combined]['favicon']           = $response['favicon'];
                    if(!empty($response['mods']['list'])) {
                        $output[$combined]['mods'] = $response['mods'];
                    }
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
                    $output[$combined]['protocol']          = "tcp";
                    $output[$combined]['error']             = $response['error'];
                } else {
                    $response['version']                    = str_replace('kcauldron,cauldron,craftbukkit,mcpc,fml,forge ', '', $response['version']);
                    $output[$combined]['status']            = $response['online'];
                    $output[$combined]['hostname']          = $response['hostname'];
                    $output[$combined]['port']              = $response['port'];
                    $output[$combined]['ping']              = $response['ping'];
                    $output[$combined]['version']           = $response['version'];
                    $output[$combined]['protocol']          = "tcp";
                    $output[$combined]['players']['online'] = $response['players'];
                    $output[$combined]['players']['max']    = $response['max_players'];
                    $output[$combined]['motds']['ingame']   = $response['motd'];
                    $output[$combined]['motds']['html']     = $response['htmlmotd'];
                    $output[$combined]['motds']['clean']    = $response['cleanmotd'];
                    $output[$combined]['favicon']           = $response['favicon'];
                    if(!empty($response['mods']['list'])) {
                        $output[$combined]['mods'] = $response['mods'];
                    }
                }
                $output[$combined]['cached'] = false;
                $redis->set($combinedRedis, base64_encode(json_encode($response, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE)), 15);
            }
        }
        header("Cache-Control: max-age=15");
        echo json_encode($output, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
    }
}
