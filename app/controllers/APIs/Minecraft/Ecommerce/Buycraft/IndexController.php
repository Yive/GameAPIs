<?php

namespace GameAPIs\Controllers\APIs\Minecraft\Ecommerce\Buycraft;

class IndexController extends ControllerBase {

    public function indexAction() {
        $params = $this->dispatcher->getParams();
        if(empty($params['action'])) {
            echo json_encode(array('error' => 'Action is missing.'), JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
        } elseif(empty($params['secret'])) {
            echo json_encode(array('error' => 'Key is missing.'), JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
        } else {
            $cConfig = array();
            
            $cConfig['redis']['host'] = $this->config->application->redis->host;
            $cConfig['redis']['key'] = $this->config->application->redis->keyStructure->mcpc->buycraft;
            $redis = new Redis();
            $redis->pconnect($cConfig['redis']['host']);
            $hash = hash('sha512', $params['secret']);
            if($redis->exists($cConfig['redis']['key'].$params['action'].':'.$hash)) {
                $response = $redis->get($cConfig['redis']['key'].$params['action'].':'.$hash);
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
                $response = json_decode(file_get_contents_curl('http://api.buycraft.net/v4?action='.$params['action'].'&secret='.$params['secret']), true);
                $redis->set($cConfig['redis']['key'].$params['action'].':'.$hash, json_encode($response, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE), 120);
                header("Cache-Control: max-age=120");
           		echo json_encode($response, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
            }
        }
    }

}
