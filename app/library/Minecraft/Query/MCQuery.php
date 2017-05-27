<?php

namespace GameAPIs\Libraries\Minecraft\Query;

class MCQuery {
	const STATISTIC = 0x00;
	const HANDSHAKE = 0x09;
	
	private $Socket;
	private $error;
	private $host;
	private $Info;
	private $Players;

	//public methods

	public function __construct() {
	}

	public function GetStatus($Host='127.0.0.1', $Port=25565, $Timeout=1) {
		$this->Clear();

		$this->host=$Host;

		if( !is_int( $Timeout ) || $Timeout < 0 ) {
			$this->error="Invalid timeout";
			return $this;
		}

		$this->Socket = @fsockopen( 'udp://' . $Host, (int)$Port, $ErrNo, $ErrStr, $Timeout );

		if( $ErrNo || $this->Socket === false ) {
			$this->error="Socket error";
			return $this;
		}

		@stream_set_timeout( $this->Socket, $Timeout );
		@stream_set_blocking( $this->Socket, true );

		$this->Query();

		@fclose( $this->Socket );

		return $this;
	}

	public function Response() {
		return array(
			'online'=>$this->error==null?true:false,
			'error'=>$this->error,
			'hostname'=>$this->host,
			'address'=>isset($this->Info['HostIp'])?$this->Info['HostIp']:null,
			'port'=>isset($this->Info['HostPort'])?$this->Info['HostPort']:null,
			'version'=>isset($this->Info['Version'])?$this->Info['Version']:null,
			'software'=>isset($this->Info['Software'])?$this->Info['Software']:null,
			'game_type'=>isset($this->Info['GameType'])?$this->Info['GameType']:null,
			'game_name'=>isset($this->Info['GameName'])?$this->Info['GameName']:null,
			'players'=>isset($this->Info['Players'])?$this->Info['Players']:null,
			'max_players'=>isset($this->Info['MaxPlayers'])?$this->Info['MaxPlayers']:null,
			'player_list'=>isset($this->Players)?$this->Players:null,
			'motd'=>isset($this->Info['HostName'])?$this->Info['HostName']:null,
			'map'=>isset($this->Info['Map'])?$this->Info['Map']:null,
			'plugins'=>isset($this->Info['Plugins'])?$this->Info['Plugins']:null
		);
	}

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


	//private methods

	private function Clear() {
		$this->Socket=null;
		$this->error=null;
		$this->host=null;
		$this->Info=null;
		$this->Players=null;
	}

	private function Query() {
		//challenge
		$Data = $this->WriteData( self :: HANDSHAKE );
		if( $Data === false ) {
			$this->error="Failed to receive challenge";
		}
		$challenge=pack( 'N', $Data );


		$Data = $this->WriteData( self :: STATISTIC, $challenge . pack( 'c*', 0x00, 0x00, 0x00, 0x00 ) );

		if( !$Data ) {
			$this->error="Failed to receive status";
		}

		$Last = '';
		$Info = Array( );

		$Data    = substr( $Data, 11 ); // splitnum + 2 int
		$Data    = explode( "\x00\x00\x01player_\x00\x00", $Data );

		if( count( $Data ) !== 2 ) {
			$this->error="Failed to parse server's response";
		}

		$Players = @substr( $Data[ 1 ], 0, -2 );
		$Data    = explode( "\x00", $Data[ 0 ] );

		// Array with known keys in order to validate the result
		// It can happen that server sends custom strings containing bad things (who can know!)
		$Keys = Array(
			'hostname'   => 'HostName',
			'gametype'   => 'GameType',
			'version'    => 'Version',
			'plugins'    => 'Plugins',
			'map'        => 'Map',
			'numplayers' => 'Players',
			'maxplayers' => 'MaxPlayers',
			'hostport'   => 'HostPort',
			'hostip'     => 'HostIp',
			'game_id'    => 'GameName'
		);

		foreach( $Data as $Key => $Value ) {
			if( ~$Key & 1 ) {
				if( !array_key_exists( $Value, $Keys ) ) {
					$Last = false;
					continue;
				}

				$Last = $Keys[ $Value ];
				$Info[ $Last ] = '';
			}
			else if( $Last != false ) {
				$Info[ $Last ] = $Value;
			}
		}

		// Ints
		$Info[ 'Players' ]    = $this->error==null?@intval( $Info[ 'Players' ] ):null;
		$Info[ 'MaxPlayers' ] = $this->error==null?@intval( $Info[ 'MaxPlayers' ] ):null;
		$Info[ 'HostPort' ]   = $this->error==null?@intval( $Info[ 'HostPort' ] ):null;

		// Parse "plugins", if any
		if( @$Info[ 'Plugins' ] ) {
			$Data = explode( ": ", $Info[ 'Plugins' ], 2 );

			$Info[ 'RawPlugins' ] = $Info[ 'Plugins' ];
			$Info[ 'Software' ]   = $Data[ 0 ];

			if( count( $Data ) == 2 ) {
				$Info[ 'Plugins' ] = explode( "; ", $Data[ 1 ] );
			}
		} else {
			$Info[ 'Software' ] = $this->error==null?'Vanilla':null;
		}

		$this->Info = $Info;

		if( $Players ) {
			$this->Players = explode( "\x00", $Players );
		}
	}

	private function WriteData( $Command, $Append = "" ) {
		$Command = pack( 'c*', 0xFE, 0xFD, $Command, 0x01, 0x02, 0x03, 0x04 ) . $Append;
		$Length  = strlen( $Command );

		if( $Length !== @fwrite( $this->Socket, $Command, $Length ) ) {
			$this->error="Failed to write on socket";
		}

		$Data = @fread( $this->Socket, 4096 );

		if( $Data === false ) {
			$this->error="Failed to read from socket";
		}

		if( strlen( $Data ) < 5 || $Data[ 0 ] != $Command[ 2 ] ) {
			$this->error="Strlen error";
		}

		return substr( $Data, 5 );
	}
}

?>
