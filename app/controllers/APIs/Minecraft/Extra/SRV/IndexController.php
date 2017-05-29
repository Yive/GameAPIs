<?php

namespace GameAPIs\Controllers\APIs\Minecraft\Extra\SRV;

use Redis;

class IndexController extends ControllerBase {

    public function initialize() {
        $this->tag->setTitle("GameAPIs");
    }

    public function indexAction() {
        function file_get_contents_curl($url) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
            $data = curl_exec($ch);
            curl_close($ch);
            return $data;
        }

        header("Content-type: application/json");
        $key = $this->request->get('key') ?: false;
        if (!$key) {
            $output['error'] = "Key required. Contact Yive to purchase a key.";
        } else {
            if (!is_file(__DIR__ . '/../keys/' . $key . '.json')) {
                $output['error'] = "Invalid auth.";
            } else {
                $account = json_decode(file_get_contents(__DIR__ . '/../keys/' . $key . '.json') , true);
                if (!in_array($_SERVER['HTTP_CF_CONNECTING_IP'], $account['ips'])) {
                    $output['error'] = "Invalid source IP. This key will be deleted after contacting it's owner.";
                } else {
                    $domainPost = json_decode(file_get_contents('php://input'), true);
                    $domain = $domainPost ?: false;
                    if (!$domain) {
                        $output['error'] = "Invalid post.";
                    } else {
                        $checkDatabase = file_get_contents("http://mcapi.ca/blockedservers");
                        $checkDatabase = json_decode($checkDatabase, true);
                        if (in_array(sha1($domain['wildcard-domain']) , $checkDatabase['blocked'])) {
                            $checkCurrent = json_decode(file_get_contents("http://mcapi.ca/blockedservers/check/" . $domain['current']) , true);
                            if ($checkCurrent[$domain['current']][0]['blocked']) {
                                $statuses['statuses']['current'] = true;
                                foreach($domain['available'] as $key) {
                                    if (in_array(sha1($key) , $checkDatabase['blocked'])) {
                                        $statuses['statuses']['available'][$key] = true;
                                    } else {
                                        $checkKey = json_decode(file_get_contents("http://mcapi.ca/blockedservers/check/" . $key) , true);
                                        if ($checkKey[$key][0]['blocked'] == true) {
                                            $statuses['statuses']['available'][$key] = true;
                                        } else {
                                            $statuses['statuses']['available'][$key] = false;
                                        }
                                    }
                                }
                            } else {
                                $statuses['statuses']['current'] = false;
                                if($statuses['statuses']['current'] == false) {
                                    $reCheck = json_decode(file_get_contents("http://mcapi.ca/blockedservers/check/" . $domain['current']) , true);
                                    foreach ($reCheck[$domain['current']] as $reCheckkey) {
                                        if($reCheckkey['domain'] == "*.".$domain['current']) {
                                            if($reCheckkey['blocked'] == true) {
                                                $statuses['statuses']['current'] = true;
                                            }
                                        } else {
                                            continue;
                                        }
                                    }
                                }
                                foreach($domain['available'] as $key) {
                                    if (in_array(sha1($key) , $checkDatabase['blocked'])) {
                                        $statuses['statuses']['available'][$key] = true;
                                    } else {
                                        $checkKey = json_decode(file_get_contents("http://mcapi.ca/blockedservers/check/" . $key) , true);
                                        if ($checkKey[$key][0]['blocked'] == true) {
                                            $statuses['statuses']['available'][$key] = true;
                                        } else {
                                            $statuses['statuses']['available'][$key] = false;
                                        }
                                    }
                                }
                            }
                        } else {
                            $checkCurrent = json_decode(file_get_contents("http://mcapi.ca/blockedservers/check/" . $domain['current']) , true);
                            if ($checkCurrent[$domain['current']][0]['blocked']) {
                                $statuses['statuses']['current'] = true;
                                foreach($domain['available'] as $key) {
                                    if (in_array(sha1($key) , $checkDatabase['blocked'])) {
                                        $statuses['statuses']['available'][$key] = true;
                                    } else {
                                        $checkKey = json_decode(file_get_contents("http://mcapi.ca/blockedservers/check/" . $key) , true);
                                        if ($checkKey[$key][0]['blocked'] == true) {
                                            $statuses['statuses']['available'][$key] = true;
                                        } else {
                                            $statuses['statuses']['available'][$key] = false;
                                        }
                                    }
                                }
                            } else {
                                $statuses['statuses']['current'] = false;
                                if($statuses['statuses']['current'] == false) {
                                    $reCheck = json_decode(file_get_contents("http://mcapi.ca/blockedservers/check/" . $domain['current']) , true);
                                    foreach ($reCheck[$domain['current']] as $reCheckkey) {
                                        if($reCheckkey['domain'] == "*.".$domain['current']) {
                                            if($reCheckkey['blocked'] == true) {
                                                $statuses['statuses']['current'] = true;
                                            }
                                        } else {
                                            continue;
                                        }
                                    }
                                }
                                foreach($domain['available'] as $key) {
                                    if (in_array(sha1($key) , $checkDatabase['blocked'])) {
                                        $statuses['statuses']['available'][$key] = true;
                                    } else {
                                        $checkKey = json_decode(file_get_contents("http://mcapi.ca/blockedservers/check/" . $key) , true);
                                        if ($checkKey[$key][0]['blocked'] == true) {
                                            $statuses['statuses']['available'][$key] = true;
                                        } else {
                                            $statuses['statuses']['available'][$key] = false;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        if (!empty($output)) {
            echo json_encode($output, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        } elseif (!empty($statuses)) {
            echo json_encode($statuses, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        }
    }

}
