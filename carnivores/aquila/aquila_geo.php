<?php
	if ( isset($_GET['q']) ){
		$ADDRESSES = explode(",", $_GET['q']);

		// CREATING PROXY LIST
		$PROXY = explode("\n", shell_exec('/var/www/carnivores/aquila/getproxy.sh -'));
		//$TPROXY = shell_exec('/var/www/dev/misar/getproxy.sh -');

		$result =[];
		//$result["ADDRESSES"] = $ADDRESSES;
		//$result["PROXY"] = $PROXY;
		foreach ( $ADDRESSES as $key => $value){
			$ARR = explode( ":", $value);
			//$result["ARR"] .= $ARR[0] . $ARR[1];
			// GETTING GEO DATA
			$OUT = "-|-|-|-|-|-";

			for ( $i = 0; $i < count($PROXY); $i++ ){
				$OUT = shell_exec('/var/www/carnivores/aquila/get_geo.sh ' . $ARR[1] . ' ' . $PROXY[$i] );
				//$result["command"] .= '/var/www/dev/misar/get_geo.sh ' . $ARR[1] . ' ' . $PROXY[$i];
				//$result["OUT"] .= $OUT;
				//$result["proxy_in"] .= $PROXY[$i] . "\n";
				if ($OUT == "-|-|-|-|-|-"){
					continue;
				}
				else {
					$DATA = explode("|", $OUT);
					$result[] = [ "lat" => $DATA[0], "lng" => $DATA[1], "hostname" => $DATA[2], "country"=> $DATA[3], "city"=> $DATA[4], "ip" => $DATA[5] ];
					break;
				}
			}
		}
		echo json_encode($result);
	}
	else {
		$ADDRESSES = explode(",", "3:186.228.78.135,4:64.71.3.2");

		$PROXY = explode("\n", shell_exec('/var/www/carnivores/aquila/getproxy.sh -'));
		//$TPROXY = shell_exec('/var/www/dev/misar/getproxy.sh -');

		$result =[];
		//$result["ADDRESSES"] = $ADDRESSES;
		//$result["PROXY"] = $TPROXY;
		foreach ( $ADDRESSES as $key => $value){
			$ARR = explode( ":", $value);
			//$result["ARR"] .= $ARR[0] . $ARR[1];
			// GETTING GEO DATA
			$OUT = "-|-|-|-|-|-";

			for ( $i = 0; $i < count($PROXY); $i++ ){
				$OUT = shell_exec('/var/www/carnivores/aquila/get_geo.sh ' . $ARR[1] . ' ' . $PROXY[$i] );
				//$result["command"] .= '/var/www/dev/misar/get_geo.sh ' . $ARR[1] . ' ' . $PROXY[$i];
				$result["OUT"] .= $OUT;
				//$result["proxy_in"] .= $PROXY[$i] . "\n";
				if ($OUT == "-|-|-|-|-|-"){
					continue;
				}
				else {
					$DATA = explode("|", $OUT);
					$result[] = [ "lat" => $DATA[0], "lng" => $DATA[1], "hostname" => $DATA[2], "country"=> $DATA[3], "city"=> $DATA[4], "ip" => $DATA[5] ];
					break;
				}
			}
		}
		echo json_encode($result);
	}
?>
