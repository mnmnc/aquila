<?php

	if ( isset($_GET['q']) ){

		$ip = $_GET['q'];
		$output=shell_exec('/var/www/carnivores/aquila/aquila_traceroute.sh ' . $ip );
		$tmp = explode("\n", $output);

		// ARRAYS
		$missing = [];
		$result =[];
		$trace_results = [];

		// PARSING TRACE RESULTS
		foreach ($tmp as $key => $value){
			$line = explode("|", $value);
			$record = [];
			// MARKING HOPS WITHOUT DATA
			if ($line[1] == "UNREACHABLE"){
				$missing[] = $line[0];
			}
			elseif ( $line[1] == "*" ){
				$none = 1;
			}
			elseif ( $line[0] == "log"){
				$result["log"] = $line[1]; 
			}
			// ADDING RECORD TO OUTPUT
			else{
				$id = $line[0];
				$hop_ip = $line[1];
				$as = $line[2];
				$delay = $line[3];
				$record = [ "id" => $id, "ip" => $hop_ip, "as" => $as, "delay" => $delay ];
				$trace_results[] = $record;
			}
		}
		$result["trace_results"] = $trace_results;
		$result["missing"] = $missing;
		echo json_encode($result);
	}
	if ( isset($_POST['r']) ){
		$path = "/var/www/carnivores/aquila/archive/";
		$now =  time();
		$file = $path . "failed" . ".txt";
		$name = "";
		$log = "";
		$array = explode("^", $_POST['r']);
		$result = "";
		foreach ( $array as $key => $value){
			$record = explode("|", $value);
			foreach ( $record as $record_key => $record_value){
				$data = explode("=", $record_value);
				if ( $data[0] == "destination" ){
					$name = explode( " ", $data[1] );
					$file = $path . $now . "_" . $name[0] . ".txt";
					$result .= $data[1] . "\n";
				}
				elseif ( $data[0] == "log"){
					$log = $data[1];
				}
				else {
					$result .= " " . $data[1];
				}
			}
			$result .= "\n";
		}

		$code = file_put_contents($file, date( "Y/m/d H:i:s ", $now). $name[0] . "\n\n" . $result . "\n\n" . $log, FILE_APPEND | LOCK_EX);
		
		echo json_encode($code);
	}
	if (isset($_GET['archive']) ){
		
		date_default_timezone_set('Europe/Warsaw');
		$path = 'archive/';
		$results = [];
		$list = explode("\n",shell_exec('ls -1 archive/*'));
		$results['list'] = $list;
		$for_table = [];

		if ( isset($_GET['archive']) && strlen($_GET['archive']) > 3 ){
			$domain = $_GET['archive'];
			
			foreach ($list as $key => $value){				
				$object = [];
				$object['filename'] = $value;
				$first_line = explode(" ", shell_exec('head -1 ' . $value . '| tr -d "\n"'));
				$last_line = shell_exec('tail -1 ' .$value . '|tr -d "\n"');
				$ip_line = explode(" ", shell_exec('head -3 '. $value .'| tail -1 | tr -d "(" | tr -d ")"| tr -d "\n"'));
				$dest_check = shell_exec(' echo '. $last_line . '| grep '. $ip_line[1] . '| wc -l | tr -d "\n"');
				$object['date'] = $first_line[0];
				$object['time'] = $first_line[1];
				$object['name'] = $first_line[2];
				$object['ip'] = $ip_line[1];
				$object['reached'] = $dest_check;
				if ( $object['name'] == $domain){
					$for_table[] = $object;
				}
			}
		}
		else {
			foreach ($list as $key => $value){
				if ( $value != ""){
					$object = [];
					$object['filename'] = $value;
					$first_line = explode(" ", shell_exec('head -1 ' . $value . '| tr -d "\n"'));
					$last_line = shell_exec('tail -1 ' .$value . '|tr -d "\n"');
					$ip_line = explode(" ", shell_exec('head -3 '. $value .'| tail -1 | tr -d "(" | tr -d ")"| tr -d "\n"'));
					$dest_check = shell_exec(' echo '. $last_line . '| grep '. $ip_line[1] . '| wc -l | tr -d "\n"');
					$object['date'] = $first_line[0];
					$object['time'] = $first_line[1];
					$object['name'] = $first_line[2];
					$object['ip'] = $ip_line[1];
					$object['reached'] = $dest_check;
					$for_table[] = $object; 
				}
			}
		}

		$results['table'] = $for_table;
		echo json_encode($results);
	}
?>
