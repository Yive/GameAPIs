<?php

namespace GameAPIs\Controllers\APIs\GameSpy2\Query\Status;

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
                            "namespace"     => "GameAPIs\Controllers\APIs\GameSpy2\Query\Status",
                            "controller"    => "index",
                            "action"        => "multi"
                        ]
                    );
                }
            } else {
                $this->dispatcher->forward(
                    [
                        "namespace"     => "GameAPIs\Controllers\APIs\GameSpy2\Query\Status",
                        "controller"    => "index",
                        "action"        => "single"
                    ]
                );
            }
        }
    }

    public function singleAction() {
        require_once(APP_PATH . '/library/Multiple/Query/V2/vendor/autoload.php');
        $params = $this->dispatcher->getParams();
        $filter = new Filter();
        $cConfig = array();

        if(strpos($params['ip'], ';debug')) {
            $params['ip'] = str_replace(';debug', '', $params['ip']);
            $cConfig['debug'] = true;
        } else {
            $cConfig['debug'] = false;
        }

        if(strpos($params['ip'], ':')) {
            $explodeParams = explode(':', $params['ip']);
            $params['ip']   = $explodeParams[0];
            $params['port'] = $explodeParams[1] ?? 27015;
        } else {
            $params['port'] = 27015;
        }
        $cConfig['ip']   = $filter->sanitize($params['ip'], 'string');
        $cConfig['port'] = $params['port'];

        $cConfig['redis']['host'] = $this->config->application->redis->host;
        $cConfig['redis']['key']  = $this->config->application->redis->keyStructure->gamespy2->ping.$cConfig['ip'].':'.$cConfig['port'];

        $redis = new Redis();
        $redis->pconnect($cConfig['redis']['host']);
        if($redis->exists($cConfig['redis']['key'])) {
            $response = json_decode(base64_decode($redis->get($cConfig['redis']['key'])),true);
            if(!$response['gq_online']) {
                $output['status']    = $response['gq_online']       ?? false;
                $output['hostname']  = $response['gq_address']      ?? $cConfig['ip'];
                $output['port']      = $response['gq_port_client']  ?? $cConfig['port'];
                $output['queryPort'] = $response['gq_port_query']   ?? $cConfig['port'];
                $output['protocol']  = $response['gq_transport']    ?? "udp";
                $output['error']     = "Couldn't connect to address.";
                $output['code']      = 003;
            } else {
                $output['status']    = $response['gq_online'];
                $output['hostname']  = $response['gq_address'];
                $output['port']      = $response['gq_port_client'];
                $output['queryPort'] = $response['gq_port_query'];
                $output['protocol']  = $response['gq_transport'];
            }
            $output['cached'] = true;
        } else {
            $GameQ = new \GameQ();
            // Switch to multiple servers, sometimes people will either provide the correct query port or the join port.
            $GameQ->addServers(
                [
                    [
                        'type'  => 'gamespy2',
                        'host'  => $cConfig['ip'].':'.$cConfig['port']
                    ]
                ]
            );
            $GameQ->setOption('timeout', 3); // Russian servers have shitty filters causing their query time to sometimes be above 2 seconds.

            $response = $GameQ->requestData();

            if(!$response['gq_online']) {
                $output['status']    = $response['gq_online']       ?? false;
                $output['hostname']  = $response['gq_address']      ?? $cConfig['ip'];
                $output['port']      = $response['gq_port_client']  ?? $cConfig['port'];
                $output['queryPort'] = $response['gq_port_query']   ?? $cConfig['port'];
                $output['protocol']  = $response['gq_transport']    ?? "udp";
                $output['error']     = "Couldn't connect to address.";
                $output['code']      = 003;
            } else {
                $output['status']    = $response['gq_online'];
                $output['hostname']  = $response['gq_address'];
                $output['port']      = $response['gq_port_client'];
                $output['queryPort'] = $response['gq_port_query'];
                $output['protocol']  = $response['gq_transport'];
            }
            $output['cached'] = false;
            $redis->set($cConfig['redis']['key'], base64_encode(json_encode($response, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE)), 15);
        }
        if($cConfig['debug']) {
            $output['debug'] = $response;
        }
        header("Cache-Control: s-maxage=15, max-age=15");
        echo json_encode($output, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
        if(!empty(json_last_error())) {
            var_dump($response);
        }
    }

    public function multiAction() {
        require_once(APP_PATH . '/library/Multiple/Query/V2/vendor/autoload.php');
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
                $cConfig['addresses'][$i]['port'] = (int) $explodeParams[1];
            } else {
                $cConfig['addresses'][$i]['ip'] = $value;
                $cConfig['addresses'][$i]['port'] = 27015;
            }
            $i++;
        }
        foreach ($cConfig['addresses'] as $key => $value) {
            $combined = $value['ip'].':'.$value['port'];
            $combinedRedis = $this->config->application->redis->keyStructure->gamespy2->ping.$combined;
            if($redis->exists($combinedRedis)) {
                $response = json_decode(base64_decode($redis->get($combinedRedis)),true);
                if(!$response['online']) {
                    $output[$combined]['status']    = $response['gq_online']        ?? false;
                    $output[$combined]['hostname']  = $response['gq_address']       ?? $value['ip'];
                    $output[$combined]['port']      = $response['gq_port_client']   ?? $value['port'];
                    $output[$combined]['queryPort'] = $response['gq_port_query']    ?? $value['port'];
                    $output[$combined]['protocol']  = $response['gq_transport']     ?? "udp";
                    $output[$combined]['error']     = "Couldn't connect to address.";
                    $output[$combined]['code']      = 003;
                } else {
                    $output[$combined]['status']    = $response['gq_online'];
                    $output[$combined]['hostname']  = $response['gq_address'];
                    $output[$combined]['port']      = $response['gq_port_client'];
                    $output[$combined]['queryPort'] = $response['gq_port_query'];
                    $output[$combined]['protocol']  = $response['gq_transport'];
                }
                $output[$combined]['cached'] = true;
            } else {
                $GameQ = new \GameQ();
                // Switch to multiple servers, sometimes people will either provide the correct query port or the join port.
                $GameQ->addServers(
                    [
                        [
                            'type'  => 'gamespy2',
                            'host'  => $combined
                        ]
                    ]
                );
                $GameQ->setOption('timeout', 3); // Russian servers have shitty filters causing their query time to sometimes be above 2 seconds.

                $response = $GameQ->requestData();

                if(!$response['online']) {
                    $output[$combined]['status']    = $response['gq_online']        ?? false;
                    $output[$combined]['hostname']  = $response['gq_address']       ?? $value['ip'];
                    $output[$combined]['port']      = $response['gq_port_client']   ?? $value['port'];
                    $output[$combined]['queryPort'] = $response['gq_port_query']    ?? $value['port'];
                    $output[$combined]['protocol']  = $response['gq_transport']     ?? "udp";
                    $output[$combined]['error']     = "Couldn't connect to address.";
                    $output[$combined]['code']      = 003;
                } else {
                    $output[$combined]['status']    = $response['gq_online'];
                    $output[$combined]['hostname']  = $response['gq_address'];
                    $output[$combined]['port']      = $response['gq_port_client'];
                    $output[$combined]['queryPort'] = $response['gq_port_query'];
                    $output[$combined]['protocol']  = $response['gq_transport'];
                }
                $output[$combined]['cached'] = false;
                $redis->set($combinedRedis, base64_encode(json_encode($response, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE)), 15);
            }
        }
        header("Cache-Control: s-maxage=15, max-age=15");
        echo json_encode($output, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
    }
}
