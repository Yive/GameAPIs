<?php

namespace GameAPIs\Controllers\APIs\Minecraft\Query\Banner;

use GameAPIs\Libraries\Minecraft\Query\MCPing;
use Redis;
use Phalcon\Filter;
use GDText\Box;
use GDtext\Color;
use GDText\TextWrapping;

class IndexController extends ControllerBase {

    public function indexAction() {
        require_once $this->config->application->appDir."library/Minecraft/Query/Banner/GDText/vendor/autoload.php";
        $params = $this->dispatcher->getParams();
        if(empty($params['ip'])) {
            $dir = $this->config->application->appDir."library/Minecraft/Query/Banner/";
            $image = imagecreatetruecolor(560, 95);
            imagecopy($image, imagecreatefrompng($dir."backgrounds/default/offline.png"), 0, 0, 0, 0, 560, 95);
            $title = new Box($image);
            $title->setFontFace($dir."fonts/NotoSans/NotoSans-BoldItalic.ttf");
            $title->setFontColor(new Color(255, 255, 255));
            $title->setTextShadow(new Color(0, 0, 0, 50), 2, 2);
            $title->setFontSize(25);
            $title->setBox(95, 16, 449, 40);
            $title->setTextAlign('left', 'top');
            $title->draw("Error...");

            $errMsg = new Box($image);
            $errMsg->setFontFace($dir."fonts/NotoSans/NotoSans-BoldItalic.ttf");
            $errMsg->setFontColor(new Color(160, 0, 0));
            $errMsg->setTextShadow(new Color(0, 0, 0, 50), 2, 2);
            $errMsg->setFontSize(15);
            $errMsg->setBox(95, 44, 449, 15);
            $errMsg->setTextAlign('left', 'top');
            $errMsg->draw("Please provide an address.");
            imagepng($image);
            imagedestroy($image);
        } else {
            if(strpos($params['ip'],',')) {
                $dir = $this->config->application->appDir."library/Minecraft/Query/Banner/";
                $image = imagecreatetruecolor(560, 95);
                foreach (explode(",", $params['options']) as $key) {
                    switch (strtolower($key)) {
                        case 'capitalised': {
                            $capitalised = true;
                            break;
                        }

                        case 'capitalized': {
                            $capitalised = true;
                            break;
                        }

                        case 'caps': {
                            $capitalised = true;
                            break;
                        }

                        case 'nether': {
                            $folder = "nether";
                            break;
                        }

                        case 'night': {
                            $folder = "night";
                            break;
                        }

                        case 'sunset': {
                            $folder = "sunset";
                            break;
                        }

                        case 'default': {
                            $folder = "default";
                            break;
                        }
                    }
                }
                if(!isset($folder)) {
                    $folder = "default";
                }
                if(!isset($capitalised)) {
                    $capitalised = false;
                }
                imagecopy($image, imagecreatefrompng($dir."backgrounds/".$folder."/offline.png"), 0, 0, 0, 0, 560, 95);
                $title = new Box($image);
                $title->setFontFace($dir."fonts/NotoSans/NotoSans-BoldItalic.ttf");
                $title->setFontColor(new Color(255, 255, 255));
                $title->setTextShadow(new Color(0, 0, 0, 50), 2, 2);
                $title->setFontSize(25);
                $title->setBox(95, 16, 449, 40);
                $title->setTextAlign('left', 'top');
                if($capitalised) {
                    $title->draw(strtoupper("Error..."));
                } else {
                    $title->draw("Error...");
                }

                $errMsg = new Box($image);
                $errMsg->setFontFace($dir."fonts/NotoSans/NotoSans-Regular.ttf");
                $errMsg->setFontColor(new Color(160, 0, 0));
                $errMsg->setTextShadow(new Color(0, 0, 0, 50), 2, 2);
                $errMsg->setFontSize(15);
                $errMsg->setBox(95, 44, 449, 15);
                $errMsg->setTextAlign('left', 'top');
                if($capitalised) {
                    $errMsg->draw(strtoupper("Comma detected. Banners only support single server queries."));
                } else {
                    $errMsg->draw("Comma detected. Banners only support single server queries.");
                }
                imagepng($image);
                imagedestroy($image);
            } else {
                $this->dispatcher->forward(
                    [
                        "namespace"     => "GameAPIs\Controllers\APIs\Minecraft\Query\Banner",
                        "controller"    => "index",
                        "action"        => "single",
                        "options"       => $params['options']
                    ]
                );
            }
        }
    }

    public function singleAction() {
        require_once $this->config->application->appDir."library/Minecraft/Query/Banner/GDText/vendor/autoload.php";
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
        $cConfig['ip-port'] = ($cConfig['port'] == 25565) ? $cConfig['ip'] : $cConfig['ip'].':'.$cConfig['port'];

        $cConfig['redis']['host'] = $this->config->application->redis->host;
        $cConfig['redis']['key']  = $this->config->application->redis->keyStructure->mcpc->ping.$cConfig['ip'].':'.$cConfig['port'];

        $dir = $this->config->application->appDir."library/Minecraft/Query/Banner/";
        $image = imagecreatetruecolor(560, 95);
        foreach (explode(",", $params['options']) as $key) {
            switch (strtolower($key)) {
                case 'capitalised': {
                    $capitalised = true;
                    break;
                }

                case 'capitalized': {
                    $capitalised = true;
                    break;
                }

                case 'caps': {
                    $capitalised = true;
                    break;
                }

                case 'nether': {
                    $folder = "nether";
                    break;
                }

                case 'night': {
                    $folder = "night";
                    break;
                }

                case 'sunset': {
                    $folder = "sunset";
                    break;
                }

                case 'default': {
                    $folder = "default";
                    break;
                }
            }
        }
        if(!isset($folder)) {
            $folder = "default";
        }
        if(!isset($capitalised)) {
            $capitalised = false;
        }

        $redis = new Redis();
        $redis->pconnect($cConfig['redis']['host']);
        if($redis->exists($cConfig['redis']['key'])) {
            $response = json_decode(base64_decode($redis->get($cConfig['redis']['key'])),true);
            $favicon = @imagecreatefromstring(base64_decode(str_replace('data:image/png;base64,', '', $response['favicon'])));
            if ($favicon !== false) {
                imagesavealpha($favicon, true);
                imagecopy($image, imagecreatefrompng($dir."backgrounds/".$folder."/online.png"), 0, 0, 0, 0, 560, 95);
                imagecopy($image, $favicon, 16, 16, 0, 0, 64, 64);

                $title = new Box($image);
                $title->setFontFace($dir."fonts/NotoSans/NotoSans-BoldItalic.ttf");
                $title->setFontColor(new Color(255, 255, 255));
                $title->setTextShadow(new Color(0, 0, 0, 50), 2, 2);
                $title->setFontSize(25);
                $title->setBox(95, 16, 449, 40);
                $title->setTextAlign('left', 'top');
                if($capitalised) {
                    $title->draw(strtoupper($cConfig['ip-port']));
                } else {
                    $title->draw(strtolower($cConfig['ip-port']));
                }

                $motd = new Box($image);
                $motd->setFontFace($dir."fonts/NotoSans/NotoSans-Regular.ttf");
                $motd->setFontColor(new Color(255, 255, 255));
                $motd->setTextShadow(new Color(0, 0, 0, 50), 2, 2);
                $motd->setFontSize(15);
                $motd->setBox(95, 44, 449, 15);
                $motd->setTextAlign('left', 'top');
                $motd->setTextWrapping(TextWrapping::NoWrap);
                $motdText = explode("\n", $response['cleanmotd']);
                if($capitalised) {
                    $motd->draw(strtoupper(trim($motdText[0])));
                } else {
                    $motd->draw(trim($motdText[0]));
                }

                $players = new Box($image);
                $players->setFontFace($dir."fonts/NotoSans/NotoSans-Regular.ttf");
                $players->setFontColor(new Color(255, 255, 255));
                $players->setTextShadow(new Color(0, 0, 0, 50), 2, 2);
                $players->setFontSize(15);
                $players->setBox(95, 62, 449, 15);
                $players->setTextAlign('left', 'top');
                if($capitalised) {
                    $players->draw(strtoupper(number_format($response['players']).'/'.number_format($response['max_players']).' Players'));
                } else {
                    $players->draw(number_format($response['players']).'/'.number_format($response['max_players']).' Players');
                }

                imagepng($image);
                imagedestroy($image);
            } else {
                if($response['online']) {
                    imagecopy($image, imagecreatefrompng($dir."backgrounds/".$folder."/online-no-icon.png"), 0, 0, 0, 0, 560, 95);

                    $title = new Box($image);
                    $title->setFontFace($dir."fonts/NotoSans/NotoSans-BoldItalic.ttf");
                    $title->setFontColor(new Color(255, 255, 255));
                    $title->setTextShadow(new Color(0, 0, 0, 50), 2, 2);
                    $title->setFontSize(25);
                    $title->setBox(95, 16, 449, 40);
                    $title->setTextAlign('left', 'top');
                    if($capitalised) {
                        $title->draw(strtoupper($cConfig['ip-port']));
                    } else {
                        $title->draw(strtolower($cConfig['ip-port']));
                    }
    
                    $motd = new Box($image);
                    $motd->setFontFace($dir."fonts/NotoSans/NotoSans-Regular.ttf");
                    $motd->setFontColor(new Color(255, 255, 255));
                    $motd->setTextShadow(new Color(0, 0, 0, 50), 2, 2);
                    $motd->setFontSize(15);
                    $motd->setBox(95, 44, 449, 15);
                    $motd->setTextAlign('left', 'top');
                    $motd->setTextWrapping(TextWrapping::NoWrap);
                    $motdText = explode("\n", $response['cleanmotd']);
                    if($capitalised) {
                        $motd->draw(strtoupper(trim($motdText[0])));
                    } else {
                        $motd->draw(trim($motdText[0]));
                    }
    
                    $players = new Box($image);
                    $players->setFontFace($dir."fonts/NotoSans/NotoSans-Regular.ttf");
                    $players->setFontColor(new Color(255, 255, 255));
                    $players->setTextShadow(new Color(0, 0, 0, 50), 2, 2);
                    $players->setFontSize(15);
                    $players->setBox(95, 62, 449, 15);
                    $players->setTextAlign('left', 'top');
                    if($capitalised) {
                        $players->draw(strtoupper(number_format($response['players']).'/'.number_format($response['max_players']).' Players'));
                    } else {
                        $players->draw(number_format($response['players']).'/'.number_format($response['max_players']).' Players');
                    }

                    imagepng($image);
                    imagedestroy($image);
                } else {
                    imagecopy($image, imagecreatefrompng($dir."backgrounds/".$folder."/offline.png"), 0, 0, 0, 0, 560, 95);

                    $title = new Box($image);
                    $title->setFontFace($dir."fonts/NotoSans/NotoSans-BoldItalic.ttf");
                    $title->setFontColor(new Color(255, 255, 255));
                    $title->setTextShadow(new Color(0, 0, 0, 50), 2, 2);
                    $title->setFontSize(25);
                    $title->setBox(95, 16, 449, 40);
                    $title->setTextAlign('left', 'top');
                    if($capitalised) {
                        $title->draw(strtoupper($cConfig['ip-port']));
                    } else {
                        $title->draw(strtolower($cConfig['ip-port']));
                    }
    
                    $errMsg = new Box($image);
                    $errMsg->setFontFace($dir."fonts/NotoSans/NotoSans-Regular.ttf");
                    $errMsg->setFontColor(new Color(160, 0, 0));
                    $errMsg->setTextShadow(new Color(0, 0, 0, 50), 2, 2);
                    $errMsg->setFontSize(15);
                    $errMsg->setBox(95, 44, 449, 15);
                    $errMsg->setTextAlign('left', 'top');
                    if($capitalised) {
                        $errMsg->draw(strtoupper("Server is offline."));
                    } else {
                        $errMsg->draw("Server is offline.");
                    }

                    imagepng($image);
                    imagedestroy($image);
                }
            }
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

            $favicon = @imagecreatefromstring(base64_decode(str_replace('data:image/png;base64,', '', $response['favicon'])));
            if ($favicon !== false) {
                imagesavealpha($favicon, true);
                imagecopy($image, imagecreatefrompng($dir."backgrounds/".$folder."/online.png"), 0, 0, 0, 0, 560, 95);
                imagecopy($image, $favicon, 16, 16, 0, 0, 64, 64);

                $title = new Box($image);
                $title->setFontFace($dir."fonts/NotoSans/NotoSans-BoldItalic.ttf");
                $title->setFontColor(new Color(255, 255, 255));
                $title->setTextShadow(new Color(0, 0, 0, 50), 2, 2);
                $title->setFontSize(25);
                $title->setBox(95, 16, 449, 40);
                $title->setTextAlign('left', 'top');
                if($capitalised) {
                    $title->draw(strtoupper($cConfig['ip-port']));
                } else {
                    $title->draw(strtolower($cConfig['ip-port']));
                }

                $motd = new Box($image);
                $motd->setFontFace($dir."fonts/NotoSans/NotoSans-Regular.ttf");
                $motd->setFontColor(new Color(255, 255, 255));
                $motd->setTextShadow(new Color(0, 0, 0, 50), 2, 2);
                $motd->setFontSize(15);
                $motd->setBox(95, 44, 449, 15);
                $motd->setTextAlign('left', 'top');
                $motd->setTextWrapping(TextWrapping::NoWrap);
                $motdText = explode("\n", $response['cleanmotd']);
                if($capitalised) {
                    $motd->draw(strtoupper(trim($motdText[0])));
                } else {
                    $motd->draw(trim($motdText[0]));
                }

                $players = new Box($image);
                $players->setFontFace($dir."fonts/NotoSans/NotoSans-Regular.ttf");
                $players->setFontColor(new Color(255, 255, 255));
                $players->setTextShadow(new Color(0, 0, 0, 50), 2, 2);
                $players->setFontSize(15);
                $players->setBox(95, 62, 449, 15);
                $players->setTextAlign('left', 'top');
                if($capitalised) {
                    $players->draw(strtoupper(number_format($response['players']).'/'.number_format($response['max_players']).' Players'));
                } else {
                    $players->draw(number_format($response['players']).'/'.number_format($response['max_players']).' Players');
                }

                imagepng($image);
                imagedestroy($image);
            } else {
                if($response['online']) {
                    imagecopy($image, imagecreatefrompng($dir."backgrounds/".$folder."/online-no-icon.png"), 0, 0, 0, 0, 560, 95);

                    $title = new Box($image);
                    $title->setFontFace($dir."fonts/NotoSans/NotoSans-BoldItalic.ttf");
                    $title->setFontColor(new Color(255, 255, 255));
                    $title->setTextShadow(new Color(0, 0, 0, 50), 2, 2);
                    $title->setFontSize(25);
                    $title->setBox(95, 16, 449, 40);
                    $title->setTextAlign('left', 'top');
                    if($capitalised) {
                        $title->draw(strtoupper($cConfig['ip-port']));
                    } else {
                        $title->draw(strtolower($cConfig['ip-port']));
                    }
    
                    $motd = new Box($image);
                    $motd->setFontFace($dir."fonts/NotoSans/NotoSans-Regular.ttf");
                    $motd->setFontColor(new Color(255, 255, 255));
                    $motd->setTextShadow(new Color(0, 0, 0, 50), 2, 2);
                    $motd->setFontSize(15);
                    $motd->setBox(95, 44, 449, 15);
                    $motd->setTextAlign('left', 'top');
                    $motd->setTextWrapping(TextWrapping::NoWrap);
                    $motdText = explode("\n", $response['cleanmotd']);
                    if($capitalised) {
                        $motd->draw(strtoupper(trim($motdText[0])));
                    } else {
                        $motd->draw(trim($motdText[0]));
                    }
    
                    $players = new Box($image);
                    $players->setFontFace($dir."fonts/NotoSans/NotoSans-Regular.ttf");
                    $players->setFontColor(new Color(255, 255, 255));
                    $players->setTextShadow(new Color(0, 0, 0, 50), 2, 2);
                    $players->setFontSize(15);
                    $players->setBox(95, 62, 449, 15);
                    $players->setTextAlign('left', 'top');
                    if($capitalised) {
                        $players->draw(strtoupper(number_format($response['players']).'/'.number_format($response['max_players']).' Players'));
                    } else {
                        $players->draw(number_format($response['players']).'/'.number_format($response['max_players']).' Players');
                    }

                    imagepng($image);
                    imagedestroy($image);
                } else {
                    imagecopy($image, imagecreatefrompng($dir."backgrounds/".$folder."/offline.png"), 0, 0, 0, 0, 560, 95);

                    $title = new Box($image);
                    $title->setFontFace($dir."fonts/NotoSans/NotoSans-BoldItalic.ttf");
                    $title->setFontColor(new Color(255, 255, 255));
                    $title->setTextShadow(new Color(0, 0, 0, 50), 2, 2);
                    $title->setFontSize(25);
                    $title->setBox(95, 16, 449, 40);
                    $title->setTextAlign('left', 'top');
                    if($capitalised) {
                        $title->draw(strtoupper($cConfig['ip-port']));
                    } else {
                        $title->draw(strtolower($cConfig['ip-port']));
                    }
    
                    $errMsg = new Box($image);
                    $errMsg->setFontFace($dir."fonts/NotoSans/NotoSans-Regular.ttf");
                    $errMsg->setFontColor(new Color(160, 0, 0));
                    $errMsg->setTextShadow(new Color(0, 0, 0, 50), 2, 2);
                    $errMsg->setFontSize(15);
                    $errMsg->setBox(95, 44, 449, 15);
                    $errMsg->setTextAlign('left', 'top');
                    if($capitalised) {
                        $errMsg->draw(strtoupper("Server is offline."));
                    } else {
                        $errMsg->draw("Server is offline.");
                    }
                    imagepng($image);
                    imagedestroy($image);
                }
            }
            $redis->set($cConfig['redis']['key'], base64_encode(json_encode($response, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE)), 15);
            header("Cache-Control: max-age=15");
        }
    }
}
