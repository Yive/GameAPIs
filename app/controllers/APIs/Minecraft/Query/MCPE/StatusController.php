<?php

namespace GameAPIs\Controllers\APIs\Minecraft\Query\MCPE;

use Redis;
use GameAPIs\Libraries\Minecraft\Query\MCPEPing;

class StatusController extends ControllerBase {

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
                            "namespace"     => "GameAPIs\Controllers\APIs\Minecraft\Query\MCPE",
                            "controller"    => "status",
                            "action"        => "multi"
                        ]
                    );
                }
            } else {
                $this->dispatcher->forward(
                    [
                        "namespace"     => "GameAPIs\Controllers\APIs\Minecraft\Query\MCPE",
                        "controller"    => "status",
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
            $params['port'] = (int) $explodeParams[1];
        } else {
            $params['port'] = 19132;
        }
        $redis = new Redis();
        $redis->pconnect($this->config->application->redis->host);
        if($redis->exists($this->config->application->redis->keyStructure->mcpe->ping.$params['ip'].':'.$params['port'])) {
            $response = json_decode(base64_decode($redis->get($this->config->application->redis->keyStructure->mcpe->ping.$params['ip'].':'.$params['port'])),true);
            if(!$response['online']) {
                $output['status']            = $response['online'];
                $output['hostname']          = $response['hostname'];
                $output['port']              = $params['port'];
                $output['error']             = $response['error'];
            } else {
                $output['status']            = $response['online'];
                $output['hostname']          = $response['hostname'];
                $output['port']              = $response['port'];
            }
            $output['cached'] = true;
        } else {
            $status                = new McpePing();
            $response             = $status->ping($params['ip'], $params['port']);
            $response['htmlmotd']  = $status->MotdToHtml($response['motd']);
            $response['cleanmotd'] = $status->ClearMotd($response['motd']);

            if(!$response['online']) {
                $output['status']               = $response['online'];
                $output['hostname']             = $response['hostname'];
                $output['port']                 = $params['port'];
                $output['error']                = $response['error'];
            } else {
                $output['status']               = $response['online'];
                $output['hostname']             = $response['hostname'];
                $output['port']                 = $response['port'];
            }
            $output['cached'] = false;
            $redis->set($this->config->application->redis->keyStructure->mcpe->ping.$params['ip'].':'.$params['port'], base64_encode(json_encode($response, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE)), 15);
        }
        echo json_encode($output, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
    }

    public function multiAction() {
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
                $params['addresses'][$i]['port'] = 19132;
            }
            $i++;
        }
        foreach ($params['addresses'] as $key => $value) {
            $combined = $value['ip'].':'.$value['port'];
            if($redis->exists($this->config->application->redis->keyStructure->mcpe->ping.$combined)) {
                $response = json_decode(base64_decode($redis->get($this->config->application->redis->keyStructure->mcpe->ping.$combined)),true);
                if(!$response['online']) {
                    $output[$combined]['status']               = $response['online'];
                    $output[$combined]['hostname']             = $response['hostname'];
                    $output[$combined]['port']                 = $params['port'];
                    $output[$combined]['error']                = $response['error'];
                } else {
                    $output[$combined]['status']               = $response['online'];
                    $output[$combined]['hostname']             = $response['hostname'];
                    $output[$combined]['port']                 = $response['port'];
                }
                $output[$combined]['cached'] = true;
            } else {
                $status                = new McpePing();
                $response              = $status->ping($value['ip'], $value['port']);
                $response['htmlmotd']  = $status->MotdToHtml($response['motd']);
                $response['cleanmotd'] = $status->ClearMotd($response['motd']);

                if(!$response['online']) {
                    $output[$combined]['status']               = $response['online'];
                    $output[$combined]['hostname']             = $response['hostname'];
                    $output[$combined]['port']                 = $params['port'];
                    $output[$combined]['error']                = $response['error'];
                } else {
                    $output[$combined]['status']               = $response['online'];
                    $output[$combined]['hostname']             = $response['hostname'];
                    $output[$combined]['port']                 = $response['port'];
                }
                $output[$combined]['cached'] = false;
                $redis->set($this->config->application->redis->keyStructure->mcpe->ping.$combined, base64_encode(json_encode($response, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE)), 15);
            }
        }
        echo json_encode($output, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
    }
}
