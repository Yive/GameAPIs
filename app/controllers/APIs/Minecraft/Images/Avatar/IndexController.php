<?php

namespace GameAPIs\Controllers\APIs\Minecraft\Images\Avatar;

use Redis;
use Phalcon\Filter;

class IndexController extends ControllerBase {

    public function avatarAction() {
        $filter = new Filter();
        $params = $this->dispatcher->getParams();

        $cConfig = array();
        $cConfig['name']  = $filter->sanitize($params['name'], 'string');
        $cConfig['size']  = $params['size'] ?? 100;
        $cConfig['helm']  = $params['helm'] ?? 'true';

        // Finalise variable values
        if ($cConfig['helm'] !== 'false') {
            $cConfig['helm'] = 'true';
        } else {
            $cConfig['helm'] = 'false';
        }

        if (!is_numeric($cConfig['size'])) {
            $cConfig['size'] = 100;
        } elseif($cConfig['size'] > 500) {
            $cConfig['size'] = 500;
        }

        $cConfig['redis']['host'] = $this->config->application->redis->host;
        $cConfig['redis']['key'] = $this->config->application->redis->keyStructure->mcpc->avatar.$cConfig['name'].':'.$cConfig['size'].':'.$cConfig['helm'];

        $redis = new Redis();
        $redis->pconnect($cConfig['redis']['host']);
        if($redis->exists($cConfig['redis']['key'])) {
            $data = base64_decode($redis->get($cConfig['redis']['key']));
            echo $data;
        } else {
            function get_skin($name) {
                $output = 'iVBORw0KGgoAAAANSUhEUgAAAEAAAABACAYAAACqaXHeAAAFDUlEQVR42u2a20sUURzH97G0LKMotPuWbVpslj1olJ';
                $output.= 'XdjCgyisowsSjzgrB0gSKyC5UF1ZNQWEEQSBQ9dHsIe+zJ/+nXfM/sb/rN4ZwZ96LOrnPgyxzP/M7Z+X7OZc96JpE';
                $output.= 'ISfWrFhK0YcU8knlozeJKunE4HahEqSc2nF6zSEkCgGCyb+82enyqybtCZQWAzdfVVFgBJJNJn1BWFgC49/VpwGVl';
                $output.= 'D0CaxQiA5HSYEwBM5sMAdKTqygcAG9+8coHKY/XXAZhUNgDYuBSPjJL/GkzVVhAEU5tqK5XZ7cnFtHWtq/TahdSw2';
                $output.= 'l0HUisr1UKIWJQBAMehDuqiDdzndsP2EZECAG1ZXaWMwOCODdXqysLf++uXUGv9MhUHIByDOijjdiSAoH3ErANQD7';
                $output.= '3C7TXXuGOsFj1d4YH4OTJAEy8y9Hd0mCaeZ5z8dfp88zw1bVyiYhCLOg1ZeAqC0ybaDttHRGME1DhDeVWV26u17lR';
                $output.= 'APr2+mj7dvULfHw2q65fhQRrLXKDfIxkau3ZMCTGIRR3URR5toU38HbaPiMwUcKfBAkoun09PzrbQ2KWD1JJaqswj';
                $output.= 'deweoR93rirzyCMBCmIQizqoizZkm2H7iOgAcHrMHbbV9KijkUYv7qOn55sdc4fo250e+vUg4329/Xk6QB/6DtOws';
                $output.= '+dHDGJRB3XRBve+XARt+4hIrAF4UAzbnrY0ve07QW8uHfB+0LzqanMM7qVb+3f69LJrD90/1axiEIs6qIs21BTITo';
                $output.= 'ewfcSsA+Bfb2x67OoR1aPPzu2i60fSNHRwCw221Suz0O3jO+jh6V1KyCMGse9721XdN5ePutdsewxS30cwuMjtC86';
                $output.= '0T5JUKpXyKbSByUn7psi5l+juDlZYGh9324GcPKbkycaN3jUSAGxb46IAYPNZzW0AzgiQ5tVnzLUpUDCAbakMQXXr';
                $output.= 'OtX1UMtHn+Q9/X5L4wgl7t37r85OSrx+TYl379SCia9KXjxRpiTjIZTBFOvrV1f8ty2eY/T7XJ81FQAwmA8ASH1ob';
                $output.= '68r5PnBsxA88/xAMh6SpqW4HRnLBrkOA9Xv5wPAZjAUgOkB+SHxgBgR0qSMh0zmZRsmwDJm1gFg2PMDIC8/nAHIMl';
                $output.= 's8x8GgzOsG5WiaqREgYzDvpTwjLDy8NM15LpexDEA3LepjU8Z64my+8PtDCmUyRr+fFwA2J0eAFYA0AxgSgMmYBMZ';
                $output.= 'TwFQnO9RNAEaHOj2DXF5UADmvAToA2ftyxZYA5BqgmZZApDkdAK4mAKo8GzPlr8G8AehzMAyA/i1girUA0HtYB2Ca';
                $output.= 'IkUBEHQ/cBHSvwF0AKZFS5M0ZwMQtEaEAmhtbSUoDADH9ff3++QZ4o0I957e+zYAMt6wHkhzpjkuAcgpwNcpA7AZD';
                $output.= 'LsvpwiuOkBvxygA6Bsvb0HlaeKIF2EbADZpGiGzBsA0gnwQHGOhW2snRpbpPexbAB2Z1oicAMQpTnGKU5ziFKc4xS';
                $output.= 'lOcYpTnOIUpzgVmgo+XC324WfJAdDO/+ceADkCpuMFiFKbApEHkOv7BfzfXt+5gpT8V7rpfYJcDz+jAsB233r6yyB';
                $output.= 'sJ0mlBCDofuBJkel4vOwBFPv8fyYAFPJ+wbSf/88UANNRVy4Awo6+Ig2gkCmgA5DHWjoA+X7AlM//owLANkX0w035';
                $output.= '9od++pvX8fdMAcj3/QJ9iJsAFPQCxHSnQt8vMJ3v2wCYpkhkAOR7vG7q4aCXoMoSgG8hFAuc/grMdAD4B/kHl9da7';
                $output.= 'Ne9AAAAAElFTkSuQmCC';
                $output = base64_decode($output);
                if ($name != '') {
                    $ch = curl_init('http://skins.minecraft.net/MinecraftSkins/' . $name . '.png');
                    curl_setopt($ch, CURLOPT_HEADER, 1);
                    curl_setopt($ch, CURLOPT_NOBODY, 1);
                    curl_setopt($ch, CURLOPT_TIMEOUT, 1);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    $result = curl_exec($ch);
                    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                    if ($status == 301) {
                        preg_match('/location:(.*)/i', $result, $matches);
                        curl_setopt($ch, CURLOPT_URL, trim($matches[1]));
                        curl_setopt($ch, CURLOPT_HEADER, 0);
                        curl_setopt($ch, CURLOPT_NOBODY, 0);
                        $result = curl_exec($ch);
                        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                        if ($status == 200) {
                            $output = $result;
                        }
                    }

                    curl_close($ch);
                }

                return $output;
            }

            $im = imagecreatefromstring(get_skin($cConfig['name']));
            $av = imagecreatetruecolor($cConfig['size'], $cConfig['size']);
            imagecopyresized($av, $im, 0, 0, 8, 8, $cConfig['size'], $cConfig['size'], 8, 8); // Face
            imagecolortransparent($im, imagecolorat($im, 63, 0)); // Black Hat Issue
            if (@$cConfig['helm'] == 'true') {
                imagecopyresized($av, $im, 0, 0, 40, 8, $cConfig['size'], $cConfig['size'], 8, 8); // Accessories
            }
            ob_start();
            imagepng($av);
            $imagedata = ob_get_contents();
            ob_end_clean();
            imagedestroy($im);
            imagedestroy($av);
            $redis->set($cConfig['redis']['key'], base64_encode($imagedata), 120);
            header("Cache-Control: max-age=120");
            echo $imagedata;
        }
    }

}
