<?php

namespace GameAPIs\Controllers\APIs\Minecraft\Player\Profile;

use Redis;
use Phalcon\Filter;

class IndexController extends ControllerBase {

    public function firstAction() {
        $params = $this->dispatcher->getParams();
        $filter = new Filter();
        $target = strtolower($filter->sanitize($params['target'], 'string'));
        if(empty($target)) {
            $output = array("error" => "Please enter a username or UUID.");
            return json_encode($output, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
        }
        $cConfig = array();
        
        $cConfig['redis']['host'] = $this->config->application->redis->host;
        $cConfig['redis']['key']['avoid'] = $this->config->application->redis->keyStructure->mcpc->player->avoid;
        $cConfig['redis']['key']['profile'] = $this->config->application->redis->keyStructure->mcpc->player->profile;
        $cConfig['redis']['key']['overloaded'] = $this->config->application->redis->keyStructure->mcpc->player->overloaded;
        $redis = new Redis();
        $redis->pconnect($cConfig['redis']['host']);

        if (strlen($target) > 16) {
            if (ctype_alnum(str_replace('-', '', $target))) {
                $uuid = str_replace('-', '', $target);
                if($redis->exists($cConfig['redis']['key']['avoid'].$uuid)) {
                    $output = array("error" => "Requested UUID is on the avoid list. Check back later.");
                    return json_encode($output, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
                } else {
                    if($redis->exists($cConfig['redis']['key']['profile'].$uuid)) {
                        $checkRedis = json_decode($redis->get($cConfig['redis']['key']['profile'].$uuid),true);
                        if($checkRedis['expiresAt'] > time()) {
                            return json_encode($checkRedis, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
                        } else {
                            if($redis->exists($cConfig['redis']['key']['overloaded'])) {
                                $output = array("error" => "API is overloaded. Please wait a few minutes.");
                                return json_encode($output, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
                            } else {
                                return $this->dispatcher->forward(
                                    [
                                        'namespace'     => 'GameAPIs\Controllers\APIs\Minecraft\Player\Profile',
                                        'controller'    => 'index',
                                        'action'        => 'second',
                                        'params'        => array(
                                            'uuid'          => $uuid
                                        )
                                    ]
                                );
                            }
                        }
                    } else {
                        return $this->dispatcher->forward(
                            [
                                'namespace'     => 'GameAPIs\Controllers\APIs\Minecraft\Player\Profile',
                                'controller'    => 'index',
                                'action'        => 'second',
                                'params'        => array(
                                    'uuid'          => $uuid
                                )
                            ]
                        );
                    }
                }
            } else {
                $redis->set($cConfig['redis']['key']['avoid'].$target, true, 300);
                $output = array("error" => "Invalid UUID characters.");
                return json_encode($output, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
            }
        } else {
            if (ctype_alnum(strtr($target, array(' ' => '', '%20' => '', '-' => '', '_' => '', '$' => 'S', '.' => 'dot')))) {
                if($redis->exists($cConfig['redis']['key']['avoid'].$target)) {
                    $output = array("error" => "Requested username is on the avoid list. Check back later.");
                    return json_encode($output, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
                } else {
                    if($redis->exists($cConfig['redis']['key']['profile'].$target)) {
                        $checkRedis = json_decode($redis->get($cConfig['redis']['key']['profile'].$target),true);
                        if($checkRedis['expiresAt'] > time()) {
                            return json_encode($checkRedis, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
                        } else {
                            if($redis->exists($cConfig['redis']['key']['overloaded'])) {
                                $output = array("error" => "API is overloaded. Please wait a few minutes.");
                                return json_encode($output, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
                            } else {
                                return $this->dispatcher->forward(
                                    [
                                        'namespace'     => 'GameAPIs\Controllers\APIs\Minecraft\Player\Profile',
                                        'controller'    => 'index',
                                        'action'        => 'second',
                                        'params'        => array(
                                            'username'      => $target
                                        )
                                    ]
                                );
                            }
                        }
                    } else {
                        return $this->dispatcher->forward(
                            [
                                'namespace'     => 'GameAPIs\Controllers\APIs\Minecraft\Player\Profile',
                                'controller'    => 'index',
                                'action'        => 'second',
                                'params'        => array(
                                    'username'      => $target
                                )
                            ]
                        );
                    }
                }
            } elseif ($target == NULL) {
                $output = array("error" => "Missing username or UUID.");
                return json_encode($output, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
            } else {
                $redis->set($cConfig['redis']['key']['avoid'].$target, true, 300);
                $output = array("error" => "Invalid username characters.");
                return json_encode($output, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
            }
        }
    }

    public function secondAction() {
        $params = $this->dispatcher->getParams();
        $cConfig = array();
        
        $cConfig['redis']['host'] = $this->config->application->redis->host;
        $cConfig['redis']['key']['avoid'] = $this->config->application->redis->keyStructure->mcpc->player->avoid;
        $cConfig['redis']['key']['profile'] = $this->config->application->redis->keyStructure->mcpc->player->profile;
        $cConfig['redis']['key']['overloaded'] = $this->config->application->redis->keyStructure->mcpc->player->overloaded;
        $redis = new Redis();
        $redis->pconnect($cConfig['redis']['host']);
        function getUser($uuid) {
            session_write_close();
            $curl = curl_init();
            $curlConfig = array(
                CURLOPT_HTTPHEADER => array('Content-Type: application/json') ,
                CURLOPT_URL => 'https://sessionserver.mojang.com/session/minecraft/profile/' . $uuid . '?unsigned=false',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CONNECTTIMEOUT => 1,
                CURLOPT_TIMEOUT => 1,
                CURLOPT_SSL_VERIFYPEER => false
            );
            curl_setopt_array($curl, $curlConfig);
            $req = json_decode(curl_exec($curl), true);
            if (!curl_errno($curl)) {
                switch ($http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE)) {
                    case 200: {
                        break;
                    }
                    default: {
                        $req['error'] = true;
                    }
                }
            }
            curl_close($curl);
            return $req;
        }
        function getUUID($username) {
            session_write_close();
            $curl = curl_init();
            $curlConfig = array(
                CURLOPT_HTTPHEADER => array('Content-Type: application/json') ,
                CURLOPT_URL => 'https://api.mojang.com/users/profiles/minecraft/' . $username,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CONNECTTIMEOUT => 1,
                CURLOPT_TIMEOUT => 1,
                CURLOPT_SSL_VERIFYPEER => false
            );
            curl_setopt_array($curl, $curlConfig);
            $req = json_decode(curl_exec($curl), true);
            if (!curl_errno($curl)) {
                switch ($http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE)) {
                    case 200: {
                        break;
                    }
                    default: {
                        $req['error'] = true;
                    }
                }
            }
            curl_close($curl);
            return $req;
        }
        if(isset($params['uuid'])){
            $uuid = $params['uuid'];
            if($redis->exists($cConfig['redis']['key']['profile'].$uuid)) {
                $getUser = getUser($uuid);
                if(empty($getUser['id'])) {
                    $output = json_decode($redis->get($cConfig['redis']['key']['profile'].$uuid),true);
                    $output['expiresAt'] = time() + 172800;
                    $output['expiresAtHR'] = date("F j, Y, g:i a", time() + 172800);
                    $redis->mSet(array(
                        $cConfig['redis']['key']['profile'] . strtolower($output['name']) => json_encode($output,JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE),
                        $cConfig['redis']['key']['profile'] . $output['id'] => json_encode($output,JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE)
                    ));
                    return json_encode($output, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
                } else {
                    $uid = '';
                    $uid.= substr($getUser['id'], 0, 8) . '-';
                    $uid.= substr($getUser['id'], 8, 4) . '-';
                    $uid.= substr($getUser['id'], 12, 4) . '-';
                    $uid.= substr($getUser['id'], 16, 4) . '-';
                    $uid.= substr($getUser['id'], 20);
                    $output['id'] = $getUser['id'];
                    $output['uuid_formatted'] = $uid;
                    $output['name'] = $getUser['name'];
                    $output['properties'][0]['name'] = $getUser['properties'][0]['name'];
                    $output['properties'][0]['value'] = $getUser['properties'][0]['value'];
                    $output['properties'][0]['signature'] = $getUser['properties'][0]['signature'];
                    $output['properties_decoded'] = json_decode(base64_decode($getUser['properties'][0]['value']) , true);
                    $output['expiresAt'] = time() + 172800;
                    $output['expiresAtHR'] = date("F j, Y, g:i a", time() + 172800);
                    $redis->mSet(array(
                        $cConfig['redis']['key']['profile'] . strtolower($getUser['name']) => json_encode($output,JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE),
                        $cConfig['redis']['key']['profile'] . $getUser['id'] => json_encode($output,JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE)
                    ));
                    return json_encode($output, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
                }
            } else {
                $getUser = getUser($uuid);
                if(!empty($getUser['error'])) {
                    $output = array("error" => "Invalid UUID.");
                    $redis->set($cConfig['redis']['key']['avoid'].$uuid, true, 300);
                    return json_encode($output, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
                } elseif(empty($getUser['id'])) {
                    $output = array("error" => "API is overloaded. Please wait a few minutes.");
                    $redis->set($cConfig['redis']['key']['overloaded'], true, 300);
                    return json_encode($output, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
                } else {
                    $uid = '';
                    $uid.= substr($getUser['id'], 0, 8) . '-';
                    $uid.= substr($getUser['id'], 8, 4) . '-';
                    $uid.= substr($getUser['id'], 12, 4) . '-';
                    $uid.= substr($getUser['id'], 16, 4) . '-';
                    $uid.= substr($getUser['id'], 20);
                    $output['id'] = $getUser['id'];
                    $output['uuid_formatted'] = $uid;
                    $output['name'] = $getUser['name'];
                    $output['properties'][0]['name'] = $getUser['properties'][0]['name'];
                    $output['properties'][0]['value'] = $getUser['properties'][0]['value'];
                    $output['properties'][0]['signature'] = $getUser['properties'][0]['signature'];
                    $output['properties_decoded'] = json_decode(base64_decode($getUser['properties'][0]['value']) , true);
                    $output['expiresAt'] = time() + 172800;
                    $output['expiresAtHR'] = date("F j, Y, g:i a", time() + 172800);
                    $redis->mSet(array(
                        $cConfig['redis']['key']['profile'] . strtolower($getUser['name']) => json_encode($output,JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE),
                        $cConfig['redis']['key']['profile'] . $getUser['id'] => json_encode($output,JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE)
                    ));
                    return json_encode($output, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
                }
            }
        } elseif (isset($params['username'])) {
            $username = $params['username'];
            if($redis->exists($cConfig['redis']['key']['profile'].$username)) {
                $getUUID = getUUID($username);
                if(empty($getUUID['id'])) {
                    $output = json_decode($redis->get($cConfig['redis']['key']['profile'].$username),true);
                    $output['expiresAt'] = time() + 172800;
                    $output['expiresAtHR'] = date("F j, Y, g:i a", time() + 172800);
                    $redis->mSet(array(
                        $cConfig['redis']['key']['profile'] . strtolower($output['name']) => json_encode($output,JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE),
                        $cConfig['redis']['key']['profile'] . $output['id'] => json_encode($output,JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE)
                    ));
                    return json_encode($output, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
                } else {
                    $getUser = getUser($getUUID['id']);
                    $uid = '';
                    $uid.= substr($getUser['id'], 0, 8) . '-';
                    $uid.= substr($getUser['id'], 8, 4) . '-';
                    $uid.= substr($getUser['id'], 12, 4) . '-';
                    $uid.= substr($getUser['id'], 16, 4) . '-';
                    $uid.= substr($getUser['id'], 20);
                    $output['id'] = $getUser['id'];
                    $output['uuid_formatted'] = $uid;
                    $output['name'] = $getUser['name'];
                    $output['properties'][0]['name'] = $getUser['properties'][0]['name'];
                    $output['properties'][0]['value'] = $getUser['properties'][0]['value'];
                    $output['properties'][0]['signature'] = $getUser['properties'][0]['signature'];
                    $output['properties_decoded'] = json_decode(base64_decode($getUser['properties'][0]['value']) , true);
                    $output['expiresAt'] = time() + 172800;
                    $output['expiresAtHR'] = date("F j, Y, g:i a", time() + 172800);
                    $redis->mSet(array(
                        $cConfig['redis']['key']['profile'] . strtolower($getUser['name']) => json_encode($output,JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE),
                        $cConfig['redis']['key']['profile'] . $getUser['id'] => json_encode($output,JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE)
                    ));
                    return json_encode($output, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
                }
            } else {
                $getUUID = getUUID($username);
                if(!empty($getUUID['error'])) {
                    $output = array("error" => "Invalid Username.");
                    $redis->set($cConfig['redis']['key']['avoid'].$username, true, 300);
                    return json_encode($output, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
                } elseif(empty($getUUID['id'])) {
                    $output = array("error" => "API is overloaded. Please wait a few minutes.");
                    $redis->set($cConfig['redis']['key']['overloaded'], true, 300);
                    return json_encode($output, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
                } else {
                    $getUser = getUser($getUUID['id']);
                    $uid = '';
                    $uid.= substr($getUser['id'], 0, 8) . '-';
                    $uid.= substr($getUser['id'], 8, 4) . '-';
                    $uid.= substr($getUser['id'], 12, 4) . '-';
                    $uid.= substr($getUser['id'], 16, 4) . '-';
                    $uid.= substr($getUser['id'], 20);
                    $output['id'] = $getUser['id'];
                    $output['uuid_formatted'] = $uid;
                    $output['name'] = $getUser['name'];
                    $output['properties'][0]['name'] = $getUser['properties'][0]['name'];
                    $output['properties'][0]['value'] = $getUser['properties'][0]['value'];
                    $output['properties'][0]['signature'] = $getUser['properties'][0]['signature'];
                    $output['properties_decoded'] = json_decode(base64_decode($getUser['properties'][0]['value']) , true);
                    $output['expiresAt'] = time() + 172800;
                    $output['expiresAtHR'] = date("F j, Y, g:i a", time() + 172800);
                    $redis->mSet(array(
                        $cConfig['redis']['key']['profile'] . strtolower($getUser['name']) => json_encode($output,JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE),
                        $cConfig['redis']['key']['profile'] . $getUser['id'] => json_encode($output,JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE)
                    ));
                    return json_encode($output, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
                }
            }
        } else {
            $output = array("error" => "Something went wrong between phase 1 and phase 2.");
            return json_encode($output, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
        }
    }
}
