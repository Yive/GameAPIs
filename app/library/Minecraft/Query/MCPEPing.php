<?php
/**
 * MIT licensed.
 */

namespace GameAPIs\Libraries\Minecraft\Query;


class McpePing {
    const RAKNET_MAGIC = "\x00\xff\xff\x00\xfe\xfe\xfe\xfe\xfd\xfd\xfd\xfd\x12\x34\x56\x78";

    public static function ClearMotd($string) {
		$chars = array('§0', '§1', '§2', '§3', '§4', '§5', '§6', '§7', '§8', '§9', '§a', '§b', '§c', '§d', '§e', '§f', '§k', '§l', '§m', '§n', '§o', '§r');
		$output = str_replace($chars, '', $string);
		$output = str_replace('\n', '<br>', $output);
		return $output;
	}

	public static function MotdToHtml($minetext) {
		preg_match_all("/[^§&]*[^§&]|[§&][0-9a-z][^§&]*/", $minetext, $brokenupstrings);
		$returnstring = "";
		foreach ($brokenupstrings as $results) {
			$ending = '';
			foreach ($results as $individual) {
				$code = preg_split("/[&§][0-9a-z]/", $individual);
				preg_match("/[&§][0-9a-z]/", $individual, $prefix);
				if (isset($prefix[0])) {
					$actualcode = substr($prefix[0], 1);
					switch ($actualcode) {
						case "1":
							$returnstring = $returnstring . '<span style="color:#0000aa">';
							$ending = $ending . "</span>";
							break;
						case "2":
							$returnstring = $returnstring . '<span style="color:#00aa00">';
							$ending = $ending . "</span>";
							break;
						case "3":
							$returnstring = $returnstring . '<span style="color:#00aaaa">';
							$ending = $ending . "</span>";
							break;
						case "4":
							$returnstring = $returnstring . '<span style="color:#aa0000">';
							$ending = $ending . "</span>";
							break;
						case "5":
							$returnstring = $returnstring . '<span style="color:#aa00aa">';
							$ending = $ending . "</span>";
							break;
						case "6":
							$returnstring = $returnstring . '<span style="color:#ffaa00">';
							$ending = $ending . "</span>";
							break;
						case "7":
							$returnstring = $returnstring . '<span style="color:#aaaaaa">';
							$ending = $ending . "</span>";
							break;
						case "8":
							$returnstring = $returnstring . '<span style="color:#555555">';
							$ending = $ending . "</span>";
							break;
						case "9":
							$returnstring = $returnstring . '<span style="color:#5555ff">';
							$ending = $ending . "</span>";
							break;
						case "a":
							$returnstring = $returnstring . '<span style="color:#55ff55">';
							$ending = $ending . "</span>";
							break;
						case "b":
							$returnstring = $returnstring . '<span style="color:#55ffff">';
							$ending = $ending . "</span>";
							break;
						case "c":
							$returnstring = $returnstring . '<span style="color:#ff5555">';
							$ending = $ending . "</span>";
							break;
						case "d":
							$returnstring = $returnstring . '<span style="color:#ff55ff">';
							$ending = $ending . "</span>";
							break;
						case "e":
							$returnstring = $returnstring . '<span style="color:#ddc300">';
							$ending = $ending . "</span>";
							break;
						case "f":
							$returnstring = $returnstring . '<span style="color:#ffffff">';
							$ending = $ending . "</span>";
							break;
						case "l":
							if (strlen($individual) > 2) {
								$returnstring = $returnstring . '<span style="font-weight:bold;">';
								$ending = "</span>" . $ending;
								break;
							}
						case "m":
							if (strlen($individual) > 2) {
								$returnstring = $returnstring . '<strike>';
								$ending = "</strike>" . $ending;
								break;
							}
						case "n":
							if (strlen($individual) > 2) {
								$returnstring = $returnstring . '<span style="text-decoration: underline;">';
								$ending = "</span>" . $ending;
								break;
							}
						case "o":
							if (strlen($individual) > 2) {
								$returnstring = $returnstring . '<i>';
								$ending = "</i>" . $ending;
								break;
							}
						case "r":
							$returnstring = $returnstring . $ending;
							$ending = '';
							break;
					}
					if (isset($code[1])) {
						$returnstring = $returnstring . $code[1];
						if (isset($ending) && strlen($individual) > 2) {
							$returnstring = $returnstring . $ending;
							$ending = '';
						}
					}
				} else {
					$returnstring = $returnstring . $individual;
				}
			}
		}
		return $returnstring;
	}

    public static function ping($host, $port, $debug = false)
    {
        $stream = fsockopen("udp://" . $host, $port, $errno, $errstr, 1);
        if (!$stream) {
			fclose($stream);
			if($debug) {
				return array("online" => false, "error" => "Unable to connect to " . $host . ":" . $port . ": " . $errstr, "hostname" => $host, "port" => $port, "errno" => $errno, "errstr" => $errstr);
			}
            return array("online" => false, "error" => "Unable to connect to " . $host . ":" . $port . ": " . $errstr, "hostname" => $host, "port" => $port);
        }
        stream_set_timeout($stream, 1);
        stream_set_blocking($stream, TRUE);
        
        $r1 = random_int(PHP_INT_MIN, PHP_INT_MAX);
        $r2 = random_int(PHP_INT_MIN, PHP_INT_MAX);
        $send = "\x01" . pack('J', $r1) . self::RAKNET_MAGIC . pack('J', $r2);
        fwrite($stream, $send);
        
        $buf = fread($stream, 2048);
        
        if (count($buf) < 1 || $buf[0] != "\x1c") {
			fclose($stream);
			if($debug) {
				return array("online" => false, "error" => "Unable to get a response / valid response", "hostname" => $host, "port" => $port, "errno" => $errno, "errstr" => $errstr, "buf" => $buf);
			}
            return array("online" => false, "error" => "Unable to get a response / valid response", "hostname" => $host, "port" => $port);
        }
        $ping_raw = substr($buf, strlen(self::RAKNET_MAGIC) + 19);
        $ping_parts = explode(';', $ping_raw);
        fclose($stream);
        
        return array("online" => true, "motd" => $ping_parts[1], "protocol" => (int) $ping_parts[2], "version" => $ping_parts[3], "players" => (int) $ping_parts[4], "max_players" => (int) $ping_parts[5], "hostname" => $host, "port" => $port);
    }
}
?>