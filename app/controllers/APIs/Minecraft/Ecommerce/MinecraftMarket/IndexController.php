<?php

namespace GameAPIs\Controllers\APIs\Minecraft\Ecommerce\MinecraftMarket;

class IndexController extends ControllerBase {

    public function initialize() {
        $this->tag->setTitle("GameAPIs");
    }

    public function indexAction() {
        $params = $this->dispatcher->getParams();
        if(empty($params['action'])) {
            echo json_encode(array('error' => 'Action is missing.'), JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
        } elseif(empty($params['secret'])) {
            echo json_encode(array('error' => 'Key is missing.'), JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
        } else {
            $redis = new Redis();
            $redis->pconnect($this->config->application->redis->host);
            $hash = hash('sha512', $params['secret']);
            if($params['action'] == "ingame") {
                $params['action'] = 'gui';
            } elseif($params['action'] == "payments") {
                $params['action'] = 'recentdonor';
            }
            if($redis->exists($this->config->application->redis->keyStructure->mcpc->minecraftmarket.$params['action'].':'.$hash)) {
                $response = $redis->get($this->config->application->redis->keyStructure->mcpc->minecraftmarket.$params['action'].':'.$hash);
                echo json_encode($response, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
            } else {
                function file_get_contents_curl($url) {
                    $ch = curl_init();
              	    $randIP = "".mt_rand(0,255).".".mt_rand(0,255).".".mt_rand(0,255).".".mt_rand(0,255);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                        "REMOTE_ADDR: $randIP",
                        "HTTP_X_FORWARDED_FOR: $randIP",
                        "User-Agent: Mozilla/5.0 (Windows NT 10.0; WOW64; rv:45.0) Gecko/20100101 Firefox/45.0",
                        "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8",
                        "Accept-Language: en-US,en;q=0.5",
                        "Accept-Encoding: gzip, deflate"
                    ));
                    curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
                    curl_setopt($ch, CURLOPT_HEADER, 0);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
             		curl_setopt($ch, CURLOPT_ENCODING, "gzip");

                    $data = curl_exec($ch);
                    curl_close($ch);

                    return $data;
           		}
                $response = json_decode(file_get_contents_curl('http://www.minecraftmarket.com/api/1.5/'.$params['secret'].'/'.$params['action']), true);
                $redis->set($this->config->application->redis->keyStructure->mcpc->minecraftmarket.$params['action'].':'.$hash, json_encode($response, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE), 120);
           		echo json_encode($response, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
            }
        }
    }
}
