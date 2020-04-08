<?php
    
    function estados() {
        $estados = array(
            "AC"=>"Acre",
            "AL"=>"Alagoas",
            "AM"=>"Amazonas",
            "AP"=>"Amapá",
            "BA"=>"Bahia",
            "CE"=>"Ceará",
            "DF"=>"Distrito Federal",
            "ES"=>"Espírito Santo",
            "GO"=>"Goiás",
            "MA"=>"Maranhão",
            "MT"=>"Mato Grosso",
            "MS"=>"Mato Grosso do Sul",
            "MG"=>"Minas Gerais",
            "PA"=>"Pará",
            "PB"=>"Paraíba",
            "PR"=>"Paraná",
            "PE"=>"Pernambuco",
            "PI"=>"Piauí",
            "RJ"=>"Rio de Janeiro",
            "RN"=>"Rio Grande do Norte",
            "RO"=>"Rondônia",
            "RS"=>"Rio Grande do Sul",
            "RR"=>"Roraima",
            "SC"=>"Santa Catarina",
            "SE"=>"Sergipe",
            "SP"=>"São Paulo",
            "TO"=>"Tocantins"
        ); 
        
        //var_dump($estados);
        
        return $estados;
    }
    
    function objToArray($obj, &$arr){
    
        if(!is_object($obj) && !is_array($obj)){
            $arr = $obj;
            return $arr;
        }
    
        foreach ($obj as $key => $value)
        {
            if (!empty($value))
            {
                $arr[$key] = array();
                objToArray($value, $arr[$key]);
            }
            else
            {
                $arr[$key] = $value;
            }
        }
        return $arr;
    }
    
	function getVimeoThumb($id)
	{
		$vimeo = unserialize(file_get_contents("http://vimeo.com/api/v2/video/$id.php"));
		
		return array('small' => $vimeo[0]['thumbnail_small'],
					 'medium' => $vimeo[0]['thumbnail_medium'],
					 'large' =>$vimeo[0]['thumbnail_large']);
	}
	
	function is_valid_date($date) {
		$test_arr  = explode('/', $date);
		if (checkdate($day=$test_arr[0], $month=$test_arr[1], $year=$test_arr[2])) {
		    return true;
		}
		return false;
	}
	
	function randomPassword($size) {
	    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
	    $pass = array(); //remember to declare $pass as an array
	    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
	    for ($i = 0; $i < $size; $i++) {
	        $n = rand(0, $alphaLength);
	        $pass[] = $alphabet[$n];
	    }
	    return implode($pass); //turn the array into a string
	}
	
	function arrayToObject($d) {
		if (is_array($d)) {
			return (object) array_map(__FUNCTION__, $d);
		} else {
			return $d;
		}
	}
	
	function objectToArray($d) {
		 if (is_object($d)) {
			 // Gets the properties of the given object
			 // with get_object_vars function
			 $d = get_object_vars($d);
		 }
		 
		 if (is_array($d)) {
			 /*
			 * Return array converted to object
			 * Using __FUNCTION__ (Magic constant)
			 * for recursive call
			 */
			 return array_map(__FUNCTION__, $d);
		 } else {
			 // Return array
			 return $d;
		 }
	}
	
	function search_array ( $array, $key, $value ){
	    $results = array();
	    if ( is_array($array) ) {
	        if ( $array[$key] == $value ) {
	            $results[] = $array;
	        } else {
	            foreach ($array as $subarray) 
	                $results = array_merge( $results, search_array($subarray, $key, $value) );
	        }
	    }
	    return $results;
	}
	
	function tirarAcentos($string, $semespaco=false){
	    $texto = preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/", "/(ç)/", "/(Ç)/"),explode(" ","a A e E i I o O u U n N c C"),$string);
	    if ($semespaco) {
		    $texto = str_replace(" ", "_", $texto);
	    }
	    return $texto;
	}
	
	function cortaTexto($texto, $limit){
		if (strlen($texto) > $limit)
			return substr($texto, 0, $limit)."...";
		else
			return $texto;
	}
	
	function semHtml($string) {
		$string = str_replace("<br>", " ", $string);
		$string = str_replace("<BR>", " ", $string);
		$string = str_replace("<br />", " ", $string);
		$string = str_replace("<BR />", " ", $string);
		$string = str_replace("\n", " ", $string);
		$string = str_replace("\r", " ", $string);
		return strip_tags($string);
	}
	
	function verificaXFrameOption($url, $count = 0) {
	    if ($count > 5) { return false;}
	
	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, $url);
	    curl_setopt($ch, CURLOPT_HEADER, true);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	
	
	    $data = curl_exec($ch);
	    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	
	    curl_close($ch);
	
	    if (!$data) {
	        return false;
	    }
	
	    $dataArray = explode("\r\n\r\n", $data, 2);
	
	    if (count($dataArray) != 2) {
	        return false;
	    }
	
	    list($header, $body) = $dataArray;
	    
	    if ($httpCode == 301 || $httpCode == 302) {
	        $matches = array();
	        preg_match('/Location:(.*)\n?/', $header, $matches);
	
	        if (isset($matches[1])) {
	            return verificaXFrameOption(trim($matches[1]), $count + 1);
	        }
	    }
	    else {
	        
	        preg_match('/window.location.href=[\"|\'](.*?)[\"|\']/',$body, $matches);
	         if (isset($matches[1])) {
	            return verificaXFrameOption(trim($matches[1]), $count + 1);
	        }        
	        
	        return !preg_match('/X-Frame-Options: SAMEORIGIN|DENY/i', $header);
	    }
	}
	
	
	function chamadaCurl ($url, $method = "GET", $campos = "") {
		$handle = curl_init();
		curl_setopt($handle, CURLOPT_URL, $url);
		curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false);								
		curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($handle, CURLOPT_FAILONERROR, true);
		curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 10);
		curl_setopt($handle, CURLOPT_TIMEOUT, 40);
		curl_setopt($handle, CURLOPT_SSLVERSION, 4);
		switch($method) {
		    case 'GET':
		        break;
		    case 'POST':
		        curl_setopt($handle, CURLOPT_POST, true);
		        curl_setopt($handle, CURLOPT_POSTFIELDS, $campos);
		        break;
		    case 'PUT': 
		        curl_setopt($handle, CURLOPT_CUSTOMREQUEST, 'PUT');
		        curl_setopt($handle, CURLOPT_POSTFIELDS, $campos);
		        break;
		    case 'DELETE':
		        curl_setopt($handle, CURLOPT_CUSTOMREQUEST, 'DELETE');
		        break;
		}
		
		$response = curl_exec($handle);
		return $response;
	}
	
	
	function dateDiff($time1, $time2, $precision = 6) {
		date_default_timezone_set("America/Sao_Paulo");
		setlocale(LC_ALL, "pt_BR", "ptb");
		// If not numeric then convert texts to unix timestamps
		if (!is_int($time1)) {
		$time1 = strtotime($time1);
		}
		if (!is_int($time2)) {
		$time2 = strtotime($time2);
		}
		
		// If time1 is bigger than time2
		// Then swap time1 and time2
		if ($time1 > $time2) {
			$ttime = $time1;
			$time1 = $time2;
			$time2 = $ttime;
		}
		
		// Set up intervals and diffs arrays
		$intervals = array('year','month','day','hour','minute','second');
		$diffs = array();
		
		// Loop thru all intervals
		foreach ($intervals as $interval) {
			// Create temp time from time1 and interval
			$ttime = strtotime('+1 ' . $interval, $time1);
			// Set initial values
			$add = 1;
			$looped = 0;
			// Loop until temp time is smaller than time2
			while ($time2 >= $ttime) {
				// Create new temp time from time1 and interval
				$add++;
				$ttime = strtotime("+" . $add . " " . $interval, $time1);
				$looped++;
			}
		
			$time1 = strtotime("+" . $looped . " " . $interval, $time1);
			$diffs[$interval] = $looped;
		}
		
		$count = 0;
		$times = array();
		// Loop thru all diffs
		foreach ($diffs as $interval => $value) {
			// Break if we have needed precission
			if ($count >= $precision) {
				break;
			}
			// Add value and interval 
			// if value is bigger than 0
			if ($value > 0) {
				// Add s if value is not 1
				if ($value != 1) {
					$interval .= "s";
				}
				// Add value and interval to times array
				$times[] = $value . " " . $interval;
				$count++;
			}
		}
		$times = str_replace("day", "dia", $times);
		$times = str_replace("days", "dias", $times);
		$times = str_replace("hour", "hora", $times);
		$times = str_replace("hours", "horas", $times);
		$times = str_replace("month", "mes", $times);
		$times = str_replace("months", "meses", $times);
		$times = str_replace("year", "ano", $times);
		$times = str_replace("years", "anos", $times);
		
		// Return string with times
		return implode(", ", $times);
	}

	function mask($val, $mask) {
		$maskared = '';
		$k = 0;
		for($i = 0; $i<=strlen($mask)-1; $i++){
			if($mask[$i] == '#'){
				if(isset($val[$k]))
					$maskared .= $val[$k++];
			} else {
				if(isset($mask[$i]))
					$maskared .= $mask[$i];
			}
		}
		return $maskared;
	}	
	
	function sucess($msg, $extras = array()){
		$retorno["mensagem"] = $msg;
		$retorno["tipo"] = "success";
		
		foreach ($extras as $nome => $valor) {
			$retorno[$nome] = $valor;
		}

		return json_encode($retorno);
	}
	
	function error($msg){
		$retorno["mensagem"] = $msg;
		$retorno["tipo"] = "error";
		
		return json_encode($retorno);
	}	
	
	function add($e, $name, $array){
		
		$obj = json_decode($array);
		
		$obj->$name = $e;
		
		return json_encode($obj);
		
	}
	
	function data($data){
		$retorno["options"] = array();
		$retorno["files"] = array();
		$retorno["data"] = $data;
		
		return json_encode($retorno);		
	}
	
	/*function getAmount($money) {
	    $cleanString = preg_replace('/([^0-9\.,])/i', '', $money);
	    $onlyNumbersString = preg_replace('/([^0-9])/i', '', $money);
	
	    $separatorsCountToBeErased = strlen($cleanString) - strlen($onlyNumbersString) - 1;
	
	    $stringWithCommaOrDot = preg_replace('/([,\.])/', '', $cleanString, $separatorsCountToBeErased);
	    $removedThousendSeparator = preg_replace('/(\.|,)(?=[0-9]{3,}$)/', '',  $stringWithCommaOrDot);
	
	    return (float) str_replace(',', '.', $removedThousendSeparator);
	}*/
	
	function currencyToFloat($string){
		//return (float) preg_replace("/([^0-9\\,])/i", "", $string);
		$f = str_replace('.', '', $string);
		$f = str_replace(',', '.', $f);
		return $f; 
	}
	
	function floatToCurrency($float){
		return number_format($float,"2",",",".");
	}
	
	function multiArrayToUTF_8($multiArray){
		foreach($multiArray as $i => $array){
			foreach($array as $j => $v){
				$multiArray[$i][$j] = utf8_encode($v);	
			}
		}
		
		return $multiArray;
	}
	
	function arrayToUTF_8($array){
		foreach($array as $i => $v){
			$array[$i] = utf8_encode($v);	
		}		
		
		return $array;
	}
	
	function validaCPF($cpf) {
		$cpf = ereg_replace("[^0-9]", "", $cpf); 
		
		for( $i = 0; $i < 10; $i++ ){
			if ( $cpf ==  str_repeat( $i , 11) or !preg_match("@^[0-9]{11}$@", $cpf ) or $cpf == "12345678909" )return false;        
			if ( $i < 9 ) $soma[]  = $cpf{$i} * ( 10 - $i );
			$soma2[] = $cpf{$i} * ( 11 - $i );            
		}
		if(((array_sum($soma)% 11) < 2 ? 0 : 11 - ( array_sum($soma)  % 11 )) != $cpf{9})return false;
		return ((( array_sum($soma2)% 11 ) < 2 ? 0 : 11 - ( array_sum($soma2) % 11 )) != $cpf{10}) ? false : true;
	}
	
	/*
	* arrayToFunction('htmlspecialchars', $array) retorna todos os campos da array passados pelo htmlspecialchars
	* arrayToFunction('utf8_decode', $array) retorna todos os campos da array passados pelo utf8_decode
	* E assim em diante, sempre o mesmo padrão.
	*/
	
	function arrayToFunction($function, $array) {
		foreach ($array as $campo => $valor) {
			if (is_array($valor)) {
				$ret[$campo] = arrayToFunction($function, $valor);
			} else {
				$ret[$campo] = $function($valor);
			}
		}
		return $ret;
	}
	
	// Deixa todos o campos de uma array em maiúsculo
	function arrayToUpper ($array) {
		foreach ($array as $campo => $valor) {
			if (is_array($valor)) {
				$ret[$campo] = arrayToUpper($valor);
			} else {
				$ret[$campo] = toUpperAcento(strtoupper($valor));
			}
		}
		return $ret;
	}

	// Deixa todos o campos de uma array em minúsculo	
	function arrayToLower ($array) {
		foreach ($array as $campo => $valor) {
			if (is_array($valor)) {
				$ret[$campo] = arrayToLower($valor);
			} else {
				$ret[$campo] = toLowerAcento(strtolower($valor));
			}
		}
		return $ret;
	}

	function toLowerAcento($string) {
		$a = array(
			"/(Á)/" => "á",
			"/(À)/" => "à",
			"/(Â)/" => "â",
			"/(Ã)/" => "ã",
			"/(É)/" => "é",
			"/(È)/" => "è",
			"/(Ê)/" => "ê",
			"/(Ë)/" => "ë",
			"/(Í)/" => "í",
			"/(Ì)/" => "ì",
			"/(Î)/" => "î",
			"/(Ï)/" => "ï",
			"/(Ò)/" => "ò",
			"/(Ó)/" => "ó",
			"/(Õ)/" => "õ",
			"/(Ô)/" => "ô",
			"/(Ö)/" => "ö",
			"/(Ú)/" => "ú",
			"/(Ù)/" => "ù",
			"/(Û)/" => "û",
			"/(Ü)/" => "ü"
		);
		return preg_replace( array_keys($a), array_values($a), $string);
	}
	
	function toUpperAcento($string) {
		$a = array(
			"/(Á)/" => "á",
			"/(À)/" => "à",
			"/(Â)/" => "â",
			"/(Ã)/" => "ã",
			"/(É)/" => "é",
			"/(È)/" => "è",
			"/(Ê)/" => "ê",
			"/(Ë)/" => "ë",
			"/(Í)/" => "í",
			"/(Ì)/" => "ì",
			"/(Î)/" => "î",
			"/(Ï)/" => "ï",
			"/(Ò)/" => "ò",
			"/(Ó)/" => "ó",
			"/(Õ)/" => "õ",
			"/(Ô)/" => "ô",
			"/(Ö)/" => "ö",
			"/(Ú)/" => "ú",
			"/(Ù)/" => "ù",
			"/(Û)/" => "û",
			"/(Ü)/" => "ü"
		);
		return preg_replace( array_values($a), array_keys($a), $string);
	}
	
	/*
	*	Se você tem algum formulário que pode ser acessado por qualquer pessoa
	*	do sistema e esse formulário possui campos de descrição que precisam de
	*	um HTML (geralmente um textarea) então use a função abaixo para impedir
	*	que o usuário coloque códigos maliciosos nesse campo.
	*	Use para teste: 
		
	</div></DIV></Div>'"<script>Console.log("oi")</script></textarea></TEXTAREA><input type="text"><INPUT type="text"> <b onclIck="alert()">divulgação</b> Divulgação DIVULGAÇÃO
	
	*	As palavras do final não podem receber alteração, mas as tags antes não podem funcionar. O primeiro "divulgação" tem que estar
	*	em negrito e se clicar nele nada deve acontecer. Se tudo está assim, então o formulário está seguro.
	*	No normal o texto deve ficar como '"Console.log("oi") <b ="alert()">divulgação</b> Divulgação DIVULGAÇÃO
	*/
	function trataEntrada($string) {
		
		// Expressões proibidas
		$proibido = array("onclick", "onblur", "onfocus", "ajax", ".location", "$", "onmouse", "onload", "onhashchagen", "onbefo", "onpage", "onpop", "onunload", "onstor", "onresize", "ononline", "onoffline", "onmessage", "onerror", "onkey", "ondbclick", "ondrag", "onscroll", "onwheel", "oncopy", "oncut", "onpaste");
		
		return strip_tags(str_ireplace($proibido, "", $string), '<p><a><br><i><u><b><font><span><strong>');
	}
	
	function includeClasses(){
		$pathControllers = PATH_ABSOLUTO.'classes/';

		$classes = func_get_args();
		if (empty($classes)) return false;
		foreach ($classes as $classe) {
			if (file_exists("$pathControllers$classe.php"))
				require_once "$pathControllers$classe.php";
		}
		
		return true;
	}
	
	function formatDate($date, $outputFormat, $inputFormat = 'Y-m-d H:i:s') {
		if (empty($date)) return '';
		$date = DateTime::createFromFormat($inputFormat, $date);
		if (is_bool($date)) return '';
		return $date->format($outputFormat);
	}
	
	function debug_to_console( $data ) {
	    $output = $data;
	    if ( is_array( $output ) )
	        $output = implode( ',', $output);
	
	    echo "<script>console.log( 'Debug Objects: " . $output . "' );</script>";
	}
	
	function tituloEmURL($texto) {
		return str_replace(' ', '-', str_replace(array(',','.','-','"',"'"), '', strtolower(tirarAcentos($texto))));
	}
	
	function estaLogado($section = 'admin'){
		return !empty($_SESSION[$section]['id']);
	}
	
	function necessitaLogin($section = 'admin'){
		if (!estaLogado($section)) {
			http_response_code(401);
			die('<p><script>history.go(0)</script></p>');
		}
	}
	
	function soNumero($str) {
	    return preg_replace("/[^0-9]/", "", $str);
	}
	
	function avg($arr) {
	    if (!count($arr)) return 0;
	
	    foreach ($arr as $v)
	        $sum += $v;
	
	    return number_format(((float) $sum / count($arr)), 2, '.', ' ');
	}
	
	function floatToHour ($float, $precision = 'HOURS') {
		if ($precision == 'HOURS')
			return str_pad(floor($float), 2, '0', STR_PAD_LEFT).':'.str_pad(($float - floor($float)) * 60, 2, '0', STR_PAD_LEFT);
		
		if ($precision == 'MINUTES')
			return str_pad(floor($float / 60), 2, '0', STR_PAD_LEFT).':'.str_pad(($float % 60), 2, '0', STR_PAD_LEFT);
	}
	
	function floatToMoney($float) {
		return number_format($float, 2, ',', '.');
	}
	
	function debug_log() {
		error_log(date('Y-m-d H:i:s ').var_export(func_get_args(), true)."\n\n", 3, $_SERVER['DOCUMENT_ROOT'].'/debug.log');
	}
	
/*
	spl_autoload_register(function ($classe) {
		require_once $_SERVER['DOCUMENT_ROOT'].'/application/controller/'.$classe.'.php';
	});
*/
	
	function pass($string) {
		return md5($string);
	}
	
	function filterArray($arrayModel, &$arrayFiltered) {
		$tempArray = array();
		foreach ($arrayModel as $model) {
			if (!is_null($arrayFiltered[$model])) {
				$tempArray[$model] = trim($arrayFiltered[$model]);
			}
		}
		
		$arrayFiltered = $tempArray;
	}
	
	function getUrlTo($filePath) {
		return URL_SITE . str_replace(PATH_ABSOLUTO, '', realpath(dirname($filePath))) . '/';
	}
	
	function forbidden_ajax() {
		http_response_code(403);
		$Resposta->insert('Você não possui permissão', Resposta::ERROR);
		die();
	}
	
	/** @param string $money Valor em dinheiro com centavos */
	function form2sqlMoney($money) {
		return number_format(soNumero($money) / 100, 2, '.', '');
	}
	
	/** @param string $flag O valor que o checkbox enviou */
	function form2sqlFlag($flag) {
		return (bool) $flag;
	}
	
	function isCaptchaValid(){
		$captchaResponse = $_REQUEST['g-recaptcha-response'];
		$postData = array(
			'secret'		=> CAPTCHA_SECRET,
			'response'		=> $captchaResponse,
			'remoteip'		=> $_SERVER['REMOTE_ADDR']
		);
		
		$ch = curl_init();
		
		curl_setopt($ch, CURLOPT_URL,				'https://www.google.com/recaptcha/api/siteverify');
		curl_setopt($ch, CURLOPT_POST, 				1);
		curl_setopt($ch, CURLOPT_POSTFIELDS,		$postData);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,	1);
		
		$return = curl_exec($ch);
		curl_close($ch);
		
		$successResponse = json_decode($return, true);
		
		return $successResponse['success'];
	}
?>