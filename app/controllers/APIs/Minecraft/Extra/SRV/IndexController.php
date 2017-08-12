<?php

namespace GameAPIs\Controllers\APIs\Minecraft\Extra\SRV;

use Redis;

class IndexController extends ControllerBase {

    public function initialize() {
        $this->tag->setTitle("GameAPIs");
    }

    public function indexAction() {
        function strposa($haystack, $needle, $offset=0) {
            if(!is_array($needle)) $needle = array($needle);
            foreach($needle as $query) {
                if(strpos($haystack, $query, $offset) !== false) return true; // stop on first true result
            }
            return false;
        }
        function extract_domain($domain) {
            $tlds = array('abogado','abudhabi','academy','accenture','accountant','accountants','afamilycompany','agakhan','airforce','alfaromeo','alibaba','allfinanz','allstate','americanexpress','americanfamily','amsterdam','analytics','android','apartments','aquarelle','associates','athleta','attorney','auction','audible','auspost','avianca','banamex','bananarepublic','barcelona','barclaycard','barclays','barefoot','bargains','baseball','basketball','bauhaus','bentley','bestbuy','blackfriday','blockbuster','bloomberg','bnpparibas','boehringer','booking','boutique','bradesco','bridgestone','broadway','brother','brussels','budapest','bugatti','builders','business','calvinklein','cancerresearch','capetown','capital','capitalone','caravan','careers','cartier','catering','catholic','channel','chintai','christmas','chrysler','cipriani','citadel','cityeats','cleaning','clinique','clothing','clubmed','college','cologne','comcast','commbank','community','company','compare','computer','construction','consulting','contact','contractors','cooking','cookingchannel','corsica','country','coupons','courses','creditcard','creditunion','cricket','cruises','cuisinella','delivery','deloitte','democrat','dentist','diamonds','digital','directory','discount','discover','domains','download','education','engineer','engineering','enterprises','equipment','ericsson','esurance','eurovision','everbank','exchange','exposed','express','extraspace','fairwinds','farmers','fashion','feedback','ferrari','ferrero','fidelity','finance','financial','firestone','firmdale','fishing','fitness','flights','florist','flowers','foodnetwork','football','forsale','foundation','fresenius','frogans','frontdoor','frontier','fujitsu','fujixerox','furniture','gallery','genting','godaddy','goldpoint','goodhands','goodyear','grainger','graphics','guardian','guitars','hamburg','hangout','hdfcbank','healthcare','helsinki','hisamitsu','hitachi','holdings','holiday','homedepot','homegoods','homesense','honeywell','hospital','hosting','hoteles','hotmail','hyundai','immobilien','industries','infiniti','institute','insurance','international','investments','ipiranga','iselect','ismaili','istanbul','jewelry','jpmorgan','juniper','kerryhotels','kerrylogistics','kerryproperties','kitchen','komatsu','kuokgroup','lacaixa','ladbrokes','lamborghini','lancaster','lancome','landrover','lanxess','lasalle','latrobe','leclerc','liaison','lifeinsurance','lifestyle','lighting','limited','lincoln','lplfinancial','lundbeck','management','marketing','markets','marriott','marshalls','maserati','mcdonalds','mckinsey','melbourne','memorial','metlife','microsoft','mitsubishi','monster','montblanc','mortgage','motorcycles','movistar','nationwide','netbank','netflix','network','neustar','newholland','nextdirect','northwesternmutual','observer','okinawa','olayangroup','oldnavy','onyourside','organic','orientexpress','origins','pamperedchef','panasonic','panerai','partners','passagens','pharmacy','philips','photography','pictures','pioneer','playstation','plumbing','politie','pramerica','productions','progressive','properties','property','protection','prudential','realestate','realtor','recipes','redstone','redumbrella','reliance','rentals','republican','restaurant','reviews','rexroth','richardli','rightathome','saarland','samsclub','samsung','sandvik','sandvikcoromant','schaeffler','schmidt','scholarships','schwarz','science','scjohnson','security','services','shangrila','shiksha','shopping','showtime','shriram','singles','softbank','software','solutions','spiegel','spreadbetting','staples','starhub','statebank','statefarm','statoil','stcgroup','stockholm','storage','supplies','support','surgery','swiftcover','symantec','systems','tatamotors','technology','telecity','telefonica','temasek','theater','theatre','tickets','tiffany','toshiba','trading','training','travelchannel','travelers','travelersinsurance','uconnect','university','vacations','vanguard','ventures','verisign','versicherung','vistaprint','vlaanderen','volkswagen','walmart','wanggou','watches','weather','weatherchannel','website','wedding','whoswho','williamhill','windows','winners','wolterskluwer','woodside','xfinity','xn--11b4c3d','xn--1ck2e1b','xn--1qqw23a','xn--30rr7y','xn--3bst00m','xn--3ds443g','xn--3e0b707e','xn--3oq18vl8pn36a','xn--3pxu8k','xn--42c2d9a','xn--45brj9c','xn--45q11c','xn--4gbrim','xn--54b7fta0cc','xn--55qw42g','xn--55qx5d','xn--5su34j936bgsg','xn--5tzm5g','xn--6frz82g','xn--6qq986b3xl','xn--80adxhks','xn--80ao21a','xn--80aqecdr1a','xn--80asehdb','xn--80aswg','xn--8y0a063a','xn--90a3ac','xn--90ae','xn--90ais','xn--9dbq2a','xn--9et52u','xn--9krt00a','xn--b4w605ferd','xn--bck1b9a5dre4c','xn--c1avg','xn--c2br7g','xn--cck2b3b','xn--cg4bki','xn--clchc0ea0b2g2a9gcd','xn--czr694b','xn--czrs0t','xn--czru2d','xn--d1acj3b','xn--d1alf','xn--e1a4c','xn--eckvdtc9d','xn--efvy88h','xn--estv75g','xn--fct429k','xn--fhbei','xn--fiq228c5hs','xn--fiq64b','xn--fiqs8s','xn--fiqz9s','xn--fjq720a','xn--flw351e','xn--fpcrj9c3d','xn--fzc2c9e2c','xn--fzys8d69uvgm','xn--g2xx48c','xn--gckr3f0f','xn--gecrj9c','xn--gk3at1e','xn--h2brj9c','xn--hxt814e','xn--i1b6b1a6a2e','xn--imr513n','xn--io0a7i','xn--j1aef','xn--j1amh','xn--j6w193g','xn--jlq61u9w7b','xn--jvr189m','xn--kcrx77d1x4a','xn--kprw13d','xn--kpry57d','xn--kpu716f','xn--kput3i','xn--l1acc','xn--lgbbat1ad8j','xn--mgb9awbf','xn--mgba3a3ejt','xn--mgba3a4f16a','xn--mgba7c0bbn0a','xn--mgbaam7a8h','xn--mgbab2bd','xn--mgbayh7gpa','xn--mgbb9fbpob','xn--mgbbh1a71e','xn--mgbc0a9azcg','xn--mgbca7dzdo','xn--mgberp4a5d4ar','xn--mgbi4ecexp','xn--mgbpl2fh','xn--mgbt3dhd','xn--mgbtx2b','xn--mgbx4cd0ab','xn--mix891f','xn--mk1bu44c','xn--mxtq1m','xn--ngbc5azd','xn--ngbe9e0a','xn--node','xn--nqv7f','xn--nqv7fs00ema','xn--nyqy26a','xn--o3cw4h','xn--ogbpf8fl','xn--p1acf','xn--p1ai','xn--pbt977c','xn--pgbs0dh','xn--pssy2u','xn--q9jyb4c','xn--qcka1pmc','xn--qxam','xn--rhqv96g','xn--rovu88b','xn--s9brj9c','xn--ses554g','xn--t60b56a','xn--tckwe','xn--tiq49xqyj','xn--unup4y','xn--vermgensberater-ctb','xn--vermgensberatung-pwb','xn--vhquv','xn--vuq861b','xn--w4r85el8fhu5dnra','xn--w4rs40l','xn--wgbh1c','xn--wgbl6a','xn--xhq521b','xn--xkc2al3hye2a','xn--xkc2dl3a5ee0h','xn--y9a3aq','xn--yfro4i67o','xn--ygbi2ammx','xn--zfr164b','yamaxun','yodobashi','yokohama','youtube','zuerich');
            if(strposa($domain,$tlds)) {
                if(preg_match("/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,16})$/i", $domain, $matches)) {
                    return $matches['domain'];
                } else {
                    return $domain;
                }
            } else {
                if(preg_match("/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i", $domain, $matches)) {
                    return $matches['domain'];
                } else {
                    return $domain;
                }
            }
        }

        function extract_subdomains($domain) {
            $subdomains = $domain;
            $domain = extract_domain($subdomains);

            $subdomains = rtrim(strstr($subdomains, $domain, true), '.');

            return $subdomains;
        }
        function check($redisIP, $redisCheckKey, $ips, $blockedservers) {
            $redis = new Redis();
            $redis->pconnect($redisIP);
            if(!is_array($ips)) {
                $ips = array($ips);
            }
            $noipDomains = array("ddns.net","ddnsking.com","3utilities.com","bounceme.net","freedynamicdns.net","freedynamicdns.org","gotdns.ch","hopto.org","myftp.biz","myftp.org","myvnc.com","onthewifi.com","redirectme.net","servebeer.com","serveblog.net","servecounterstrike.com","serveftp.com","servegame.com","servehalflife.com","servehttp.com","serveirc.com","serveminecraft.net","servemp3.com","servepics.com","servequake.com","sytes.net","viewdns.net","webhop.me","zapto.org","access.ly","blogsyte.com","brasilia.me","cable-modem.org","ciscofreak.com","collegefan.org","couchpotatofries.org","damnserver.com","ddns.me","ditchyourip.com","dnsfor.me","dnsiskinky.com","dvrcam.info","dynns.com","eating-organic.net","fantasyleague.cc","geekgalaxy.com","golffan.us","health-carereform.com","homesecuritymac.com","homesecuritypc.com","hosthampster.com","hopto.me","ilovecollege.info","loginto.me","mlbfan.org","mmafan.biz","myactivedirectory.com","mydissent.net","myeffect.net","mymediapc.net","mypsx.net","mysecuritycamera.com","mysecuritycamera.net","mysecuritycamera.org","net-freaks.com","nflfan.org","nhlfan.net","pgafan.net","point2this.com","pointto.us","privatizehealthinsurance.net","quicksytes.com","read-books.org","securitytactics.com","serveexchange.com","servehumour.com","servep2p.com","servesarcasm.com","stufftoread.com","ufcfan.org","unusualperson.com","workisboring.com");
            foreach ($ips as $ip) {
                $i=0;
                if(in_array(extract_domain($ip), $noipDomains)) {
                    $domain = $ip;
                    $sha1 = sha1($domain);
                    $output[$ip][$i]['domain'] = $domain;
                    $output[$ip][$i]['sha1'] = $sha1;
                    $redisSet['sha1'] = $sha1;
                    $redisSet['domain'] = $domain;
                    if (!$redis->exists($redisCheckKey.$sha1)) {
                        $redis->set($redisCheckKey.$sha1, json_encode($redisSet, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE));
                    }
                    if(in_array($sha1, $blockedservers)) {
                        $output[$ip][$i]['blocked'] = true;
                    } else {
                        $output[$ip][$i]['blocked'] = false;
                    }
                    if($output[$ip][$i]['blocked'] == false) {
                        $i++;
                        $domain = "*.".$ip;
                        $sha1 = sha1($domain);
                        $output[$ip][$i]['domain'] = $domain;
                        $output[$ip][$i]['sha1'] = $sha1;
                        $redisSet['sha1'] = $sha1;
                        $redisSet['domain'] = $domain;
                        if (!$redis->exists($redisCheckKey.$sha1)) {
                            $redis->set($redisCheckKey.$sha1, json_encode($redisSet, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE));
                        }
                        if(in_array($sha1, $blockedservers)) {
                            $output[$ip][$i]['blocked'] = true;
                        } else {
                            $output[$ip][$i]['blocked'] = false;
                        }
                    }
                } else {
                    if(empty(dns_get_record('_minecraft._tcp.'.$ip, DNS_SRV))) {
                        if(filter_var($ip,FILTER_VALIDATE_IP)) {
                            $domain = $ip;
                        } else {
                            $domain = '*.'.extract_domain($ip);
                        }
                        $sha1 = sha1($domain);
                        $output[$ip][$i]['domain'] = $domain;
                        $output[$ip][$i]['sha1'] = $sha1;
                        $redisSet['sha1'] = $sha1;
                        $redisSet['domain'] = $domain;
                        if (!$redis->exists($redisCheckKey.$sha1)) {
                            $redis->set($redisCheckKey.$sha1, json_encode($redisSet, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE));
                        }
                        if(in_array($sha1, $blockedservers)) {
                            $output[$ip][$i]['blocked'] = true;
                        } else {
                            $output[$ip][$i]['blocked'] = false;
                        }
                        if($output[$ip][$i]['blocked'] == false) {
                            $i++;
                            $domain = "*.".$ip;
                            $sha1 = sha1($domain);
                            $output[$ip][$i]['domain'] = $domain;
                            $output[$ip][$i]['sha1'] = $sha1;
                            $redisSet['sha1'] = $sha1;
                            $redisSet['domain'] = $domain;
                            if (!$redis->exists($redisCheckKey.$sha1)) {
                                $redis->set($redisCheckKey.$sha1, json_encode($redisSet, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE));
                            }
                            if(in_array($sha1, $blockedservers)) {
                                $output[$ip][$i]['blocked'] = true;
                            } else {
                                $output[$ip][$i]['blocked'] = false;
                            }
                        }
                    } else {
                       $dns = dns_get_record('_minecraft._tcp.'.$ip, DNS_SRV);
                       foreach ($dns as $key => $value) {
                            if(in_array(extract_domain($value['target']), $noipDomains)) {
                                if(filter_var($ip,FILTER_VALIDATE_IP)) {
                                    $domain = $value['target'];
                                } else {
                                    $domain = $value['target'];
                                }
                                $sha1 = sha1($domain);
                                $output[$ip][$i]['domain'] = $domain;
                                $output[$ip][$i]['sha1'] = $sha1;
                                $redisSet['sha1'] = $sha1;
                                $redisSet['domain'] = $domain;
                                if (!$redis->exists($redisCheckKey.$sha1)) {
                                    $redis->set($redisCheckKey.$sha1, json_encode($redisSet, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE));
                                }
                                if(in_array($sha1, $blockedservers)) {
                                    $output[$ip][$i]['blocked'] = true;
                                } else {
                                    $output[$ip][$i]['blocked'] = false;
                                }
                                if($output[$ip][$i]['blocked'] == false) {
                                    $i++;
                                    $domain = "*.".$domain;
                                    $sha1 = sha1($domain);
                                    $output[$ip][$i]['domain'] = $domain;
                                    $output[$ip][$i]['sha1'] = $sha1;
                                    $redisSet['sha1'] = $sha1;
                                    $redisSet['domain'] = $domain;
                                    if (!$redis->exists($redisCheckKey.$sha1)) {
                                        $redis->set($redisCheckKey.$sha1, json_encode($redisSet, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE));
                                    }
                                    if(in_array($sha1, $blockedservers)) {
                                        $output[$ip][$i]['blocked'] = true;
                                    } else {
                                        $output[$ip][$i]['blocked'] = false;
                                    }
                                }
                            } else {
                                if(filter_var($ip,FILTER_VALIDATE_IP)) {
                                    $domain = $value['target'];
                                } else {
                                    $domain = '*.'.extract_domain($value['target']);
                                }
                                $sha1 = sha1($domain);
                                $output[$ip][$i]['domain'] = $domain;
                                $output[$ip][$i]['sha1'] = $sha1;
                                $redisSet['sha1'] = $sha1;
                                $redisSet['domain'] = $domain;
                                if (!$redis->exists($redisCheckKey.$sha1)) {
                                    $redis->set($redisCheckKey.$sha1, json_encode($redisSet, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE));
                                }
                                if(in_array($sha1, $blockedservers)) {
                                    $output[$ip][$i]['blocked'] = true;
                                } else {
                                    $output[$ip][$i]['blocked'] = false;
                                }
                                if($output[$ip][$i]['blocked'] == false) {
                                    $i++;
                                    $domain = "*.".$value['target'];
                                    $sha1 = sha1($domain);
                                    $output[$ip][$i]['domain'] = $domain;
                                    $output[$ip][$i]['sha1'] = $sha1;
                                    $redisSet['sha1'] = $sha1;
                                    $redisSet['domain'] = $domain;
                                    if (!$redis->exists($redisCheckKey.$sha1)) {
                                        $redis->set($redisCheckKey.$sha1, json_encode($redisSet, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE));
                                    }
                                    if(in_array($sha1, $blockedservers)) {
                                        $output[$ip][$i]['blocked'] = true;
                                    } else {
                                        $output[$ip][$i]['blocked'] = false;
                                    }
                                }
                            }
                        $i++;
                       }
                        if(in_array(extract_domain($ip), $noipDomains)) {
                            if(filter_var($ip,FILTER_VALIDATE_IP)) {
                                $domain = $ip;
                            } else {
                                $domain = $ip;
                            }
                            $sha1 = sha1($domain);
                            $output[$ip][$i]['domain'] = $domain;
                            $output[$ip][$i]['sha1'] = $sha1;
                            $redisSet['sha1'] = $sha1;
                            $redisSet['domain'] = $domain;
                            if (!$redis->exists($redisCheckKey.$sha1)) {
                                $redis->set($redisCheckKey.$sha1, json_encode($redisSet, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE));
                            }
                            if(in_array($sha1, $blockedservers)) {
                                $output[$ip][$i]['blocked'] = true;
                            } else {
                                $output[$ip][$i]['blocked'] = false;
                            }
                            if($output[$ip][$i]['blocked'] == false) {
                                $i++;
                                $domain = "*.".$ip;
                                $sha1 = sha1($domain);
                                $output[$ip][$i]['domain'] = $domain;
                                $output[$ip][$i]['sha1'] = $sha1;
                                $redisSet['sha1'] = $sha1;
                                $redisSet['domain'] = $domain;
                                if (!$redis->exists($redisCheckKey.$sha1)) {
                                    $redis->set($redisCheckKey.$sha1, json_encode($redisSet, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE));
                                }
                                if(in_array($sha1, $blockedservers)) {
                                    $output[$ip][$i]['blocked'] = true;
                                } else {
                                    $output[$ip][$i]['blocked'] = false;
                                }
                            }
                        } else {
                            if(filter_var($ip,FILTER_VALIDATE_IP)) {
                                $domain = $ip;
                            } else {
                                $domain = '*.'.extract_domain($ip);
                            }
                            $sha1 = sha1($domain);
                            $output[$ip][$i]['domain'] = $domain;
                            $output[$ip][$i]['sha1'] = $sha1;
                            $redisSet['sha1'] = $sha1;
                            $redisSet['domain'] = $domain;
                            if (!$redis->exists($redisCheckKey.$sha1)) {
                                $redis->set($redisCheckKey.$sha1, json_encode($redisSet, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE));
                            }
                            if(in_array($sha1, $blockedservers)) {
                                $output[$ip][$i]['blocked'] = true;
                            } else {
                                $output[$ip][$i]['blocked'] = false;
                            }
                            if($output[$ip][$i]['blocked'] == false) {
                                $i++;
                                $domain = "*.".$ip;
                                $sha1 = sha1($domain);
                                $output[$ip][$i]['domain'] = $domain;
                                $output[$ip][$i]['sha1'] = $sha1;
                                $redisSet['sha1'] = $sha1;
                                $redisSet['domain'] = $domain;
                                if (!$redis->exists($redisCheckKey.$sha1)) {
                                    $redis->set($redisCheckKey.$sha1, json_encode($redisSet, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE));
                                }
                                if(in_array($sha1, $blockedservers)) {
                                    $output[$ip][$i]['blocked'] = true;
                                } else {
                                    $output[$ip][$i]['blocked'] = false;
                                }
                            }
                        }
                    }
                    if($output[$ip][$i]['blocked'] == false) {
                        $i++;
                        $domain = $ip;
                        $sha1 = sha1($domain);
                        $output[$ip][$i]['domain'] = $domain;
                        $output[$ip][$i]['sha1'] = $sha1;
                        $redisSet['sha1'] = $sha1;
                        $redisSet['domain'] = $domain;
                        if (!$redis->exists($redisCheckKey.$sha1)) {
                            $redis->set($redisCheckKey.$sha1, json_encode($redisSet, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE));
                        }
                        if(in_array($sha1, $blockedservers)) {
                            $output[$ip][$i]['blocked'] = true;
                        } else {
                            $output[$ip][$i]['blocked'] = false;
                        }
                    }
                    if($output[$ip][$i]['blocked'] == false) {
                        $i++;
                        $domain = "*.".$ip;
                        $sha1 = sha1($domain);
                        $output[$ip][$i]['domain'] = $domain;
                        $output[$ip][$i]['sha1'] = $sha1;
                        $redisSet['sha1'] = $sha1;
                        $redisSet['domain'] = $domain;
                        if (!$redis->exists($redisCheckKey.$sha1)) {
                            $redis->set($redisCheckKey.$sha1, json_encode($redisSet, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE));
                        }
                        if(in_array($sha1, $blockedservers)) {
                            $output[$ip][$i]['blocked'] = true;
                        } else {
                            $output[$ip][$i]['blocked'] = false;
                        }
                    }
                }
                foreach ($output as $value) {
                    $unique = array_values(array_unique($value, SORT_REGULAR));
                    $output[$ip] = $unique;
                }
                return json_encode($output, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
            }
        }
        $key = $this->request->get('key') ?: false;
        if (!$key) {
            $output['error'] = "Key required. Contact Yive to purchase a key.";
        } else {
            $redis = new Redis();
            $redis->pconnect($this->config->application->redis->host);
            if (!$redis->exists($this->config->application->redis->keyStructure->mcpc->srv.$key)) {
                $output['error'] = "Invalid auth.";
            } else {
                $account = json_decode($redis->get($this->config->application->redis->keyStructure->mcpc->srv.$key) , true);
                if (!in_array($_SERVER['HTTP_CF_CONNECTING_IP'] || $_SERVER['REMOTE_ADDR'], $account['ips'])) {
                    $output['error'] = "Invalid source IP. This key will be deleted after contacting it's owner.";
                } else {
                    $domainPost = json_decode(file_get_contents('php://input'), true);
                    $domain = $domainPost ?: false;
                    if(count($domain['available'] >= 5)) {
                        $domain['available'] = array_slice($domain['available'], 0, 5);
                    }
                    if (!$domain) {
                        $output['error'] = "Invalid post.";
                    } else {
                        if (!$redis->exists($this->config->application->redis->keyStructure->mcpc->blockedservers->list)) {
                            $checkDatabase = array_filter(explode(PHP_EOL, file_get_contents('https://sessionserver.mojang.com/blockedservers')));
                            $redis->set($this->config->application->redis->keyStructure->mcpc->blockedservers->list, json_encode($checkDatabase), 15);
                        } else {
                            $checkDatabase = json_decode($redis->get($this->config->application->redis->keyStructure->mcpc->blockedservers->list),true);
                        }
                        if (in_array(sha1($domain['wildcard-domain']), $checkDatabase)) {
                            $checkCurrent = json_decode(check($this->config->application->redis->host, $this->config->application->redis->keyStructure->mcpc->blockedservers->check, $domain['current'], $checkDatabase), true);
                            if ($checkCurrent[$domain['current']][0]['blocked']) {
                                $statuses['statuses']['current'] = true;
                                $checkAvaliable = json_decode(check($this->config->application->redis->host, $this->config->application->redis->keyStructure->mcpc->blockedservers->check, $domain['available'], $checkDatabase),true);
                                foreach($domain['available'] as $key) {
                                    foreach ($checkAvaliable[$key] as $key2) {
                                        if(@$statuses['statuses']['available'][$key] == true) {
                                            continue;
                                        }
                                        if ($key2['blocked'] == true) {
                                            $statuses['statuses']['available'][$key] = true;
                                        } else {
                                            $statuses['statuses']['available'][$key] = false;
                                        }
                                    }
                                }
                            } else {
                                $statuses['statuses']['current'] = false;
                                if($statuses['statuses']['current'] == false) {
                                    $reCheck = json_decode(check($this->config->application->redis->host, $this->config->application->redis->keyStructure->mcpc->blockedservers->check, $domain['current'], $checkDatabase), true);
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
                                $checkAvaliable = json_decode(check($this->config->application->redis->host, $this->config->application->redis->keyStructure->mcpc->blockedservers->check, $domain['available'], $checkDatabase),true);
                                foreach($domain['available'] as $key) {
                                    foreach ($checkAvaliable[$key] as $key2) {
                                        if(@$statuses['statuses']['available'][$key] == true) {
                                            continue;
                                        }
                                        if ($key2['blocked'] == true) {
                                            $statuses['statuses']['available'][$key] = true;
                                        } else {
                                            $statuses['statuses']['available'][$key] = false;
                                        }
                                    }
                                }
                            }
                        } else {
                            $checkCurrent = json_decode(check($this->config->application->redis->host, $this->config->application->redis->keyStructure->mcpc->blockedservers->check, $domain['current'], $checkDatabase), true);
                            if ($checkCurrent[$domain['current']][0]['blocked']) {
                                $statuses['statuses']['current'] = true;
                                $checkAvaliable = json_decode(check($this->config->application->redis->host, $this->config->application->redis->keyStructure->mcpc->blockedservers->check, $domain['available'], $checkDatabase),true);
                                foreach($domain['available'] as $key) {
                                    foreach ($checkAvaliable[$key] as $key2) {
                                        if(@$statuses['statuses']['available'][$key] == true) {
                                            continue;
                                        }
                                        if ($key2['blocked'] == true) {
                                            $statuses['statuses']['available'][$key] = true;
                                        } else {
                                            $statuses['statuses']['available'][$key] = false;
                                        }
                                    }
                                }
                            } else {
                                $statuses['statuses']['current'] = false;
                                if($statuses['statuses']['current'] == false) {
                                    $reCheck = json_decode(check($this->config->application->redis->host, $this->config->application->redis->keyStructure->mcpc->blockedservers->check, $domain['current'], $checkDatabase), true);
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
                                $checkAvaliable = json_decode(check($this->config->application->redis->host, $this->config->application->redis->keyStructure->mcpc->blockedservers->check, $domain['available'], $checkDatabase),true);
                                foreach($domain['available'] as $key) {
                                    foreach ($checkAvaliable[$key] as $key2) {
                                        if(@$statuses['statuses']['available'][$key] == true) {
                                            continue;
                                        }
                                        if ($key2['blocked'] == true) {
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
