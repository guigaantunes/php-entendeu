<?php 
	class PagseguroException extends Exception {
		static $extra = '';
		function __construct($msg, $code = 0, $third = null) {
			mail(EMAIL_DEBUG, 'PAGSEGURO ' . NOME_EMPRESA, var_export(func_get_args(), true) . "\n" . self::$extra);
			parent::__construct($msg, $code, $third);
		}
	}
	
	abstract class PagSeguro {
		const SANDBOX_SENDER_EMAIL = 'c79560227681283404562@sandbox.pagseguro.com.br';
		
		const DISCOUNT_PERCENT = 'DISCOUNT_PERCENT';
		const DISCOUNT_AMOUNT = 'DISCOUNT_AMOUNT';
		
		public $_URL_NOTIF = 'https://www.entendeudireito.com.br/pagseguro/notificacao_hook.php';
		
		public $_SANDBOX = FALSE;
		
		private $_EMAIL = array(
			'sandbox'	=> 'guiga.equeirozan@gmail.com',
			'producao'	=> 'entendeudireito@gmail.com'
		);
		
		private $_TOKEN = array(
			'sandbox'	=> 'F2F85578937647DBAC82A8F4E40BC430',
			//'producao'	=> 'D19356534A0A4D2BA37AE9C9E009FCFD'
			'producao'	=> '2aae09fa-3cbb-4e9e-ad49-ef674b7a7a9a38cf314c423d960db25c39c25e6e75680717-e521-4edd-af09-c33a854e1421'
		);
		
		private $_URL = array(
			'sandbox'	=> 'https://ws.sandbox.pagseguro.uol.com.br',
			'producao'	=> 'https://ws.pagseguro.uol.com.br'
		);
		
		private $_JS_URL = array(
			'sandbox'	=> 'https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js',
			'producao'	=> 'https://stc.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js'
		);
		
		public function __construct($email = false, $token = false) {
			if ($email)
				$this->_EMAIL['producao'] = $email;
				
			if ($token)
				$this->_TOKEN['producao'] = $token;
			
			//$this->_SANDBOX = (bool)$sandbox;
			$this->_URL_NOTIF = URL_SITE.'pagseguro/notificacao.php';
		}
		
		/* !GETTERS */
		public function getToken() {
			if ($this->_SANDBOX) 
				return $this->_TOKEN['sandbox'];
			
			return $this->_TOKEN['producao'];
		}
		
		public function getUrl() {
			if ($this->_SANDBOX) 
				return $this->_URL['sandbox'];
			
			return $this->_URL['producao'];
		}
		
		public function getEmail() {
			if ($this->_SANDBOX) 
				return $this->_EMAIL['sandbox'];
			
			return $this->_EMAIL['producao'];
		}
		
		public function getAutData($extra = array()) {
			return '?'.http_build_query(array_merge(array('email' => $this->getEmail(),'token' => $this->getToken()), $extra));
		}
		
		public function getJsURL() {
			if ($this->_SANDBOX) 
				return $this->_JS_URL['sandbox'];
			
			return $this->_JS_URL['producao'];
		}
		
		/* !SESSAO/AUTENTICACAO */
		public function getSession() {
			$session = $this->request('/v2/sessions');
			$session = (array)($session);

			return $session['id'];	
		}
		
		
		/* !REQUISIÇÃO */
		protected function requestJSON() {
			list($target, $method, $postFields) = func_get_args()[0];
			//var_dump(func_get_args());
			$url = $this->getUrl().$target.$this->getAutData();
			
			$method = strtoupper($method);
			$headers = array(
				'Content-type: application/json;charset=ISO-8859-1',
				'Accept: application/vnd.pagseguro.com.br.v3+json;charset=ISO-8859-1'
			);
			
			$sendString = '';
			
			if (!empty($postFields)) {
				$sendString = json_encode($postFields);
			}
			
			$ch = curl_init($url);
			
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); 
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
			curl_setopt($ch, CURLOPT_TIMEOUT, 25);

			switch ($method) {
				case 'POST':
					curl_setopt($ch, CURLOPT_POST, 1);
					curl_setopt($ch, CURLOPT_POSTFIELDS, $sendString);
					break;
				case 'PUT':
					curl_setopt($ch, CURLOPT_PUT, 1);
					curl_setopt($ch, CURLOPT_POSTFIELDS, $sendString);
					break;
				case 'GET':
					$url = $this->getUrl().$target.$this->getAutData($postFields);
					curl_setopt($ch, CURLOPT_URL, $url);
					break;
				default: 
					throw new PagseguroException('"'.$method.'" method not configured', 405);
			}
			
			$curlReturn = curl_exec($ch);
			//echo $curlReturn;
			//die();
			
			$error = curl_error($ch);
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close($ch);
			
			if ($error) {
				PagseguroException::$extra = $error . ' ' . $sendString;
				throw new PagseguroException('Erro ao conectar-se com pagseguro, resposta vazia', 0);
			}
			
			if ($curlReturn === 'Internal Server Error') {
				throw new PagseguroException('Erro na formatação dos dados', 500);
			}
			
			if ($curlReturn === 'Unauthorized') {
				throw new PagseguroException('Dados de autenticação inválidos', 401);
			}
			
			$content = json_decode($curlReturn);
			if ($content->error) {
				if ($this->_SANDBOX)
					var_dump($content);
				
				debug_log($content);
				if (is_array($content->error)) {
					throw new PagseguroException($content->error[0]->message, 402);
				}
			}
			
			return $content;
		}
		
		protected function requestXML() {
			// Essas duas virgulas não são um erro
			list($target, $method, $postFields, $rootTag) = func_get_args()[0];
			
			if (!$method) {
				$method = 'POST';
			} else {
				$method = strtoupper($method);
			}
			
			$sendString = '';
			
			if ($postFields) {
				if (!$rootTag) 
					throw new PagseguroException('Not defined rootTag to XML request');
					
				$xml = new SimpleXMLElement("<$rootTag/>");
				$this->arrayIntoXML($postFields, $xml);
				$sendString = $xml->asXML();
			} else {
				$postFields = array();
			}
			
			$url = $this->getUrl().$target.$this->getAutData();
			
			
			$headers = array(
				'Content-type: application/xml;charset=ISO-8859-1',
				'Accept: application/xml;charset=ISO-8859-1'
			);
			
			$ch = curl_init($url);
			
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); 
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			
			switch ($method) {
				case 'POST':
					curl_setopt($ch, CURLOPT_POST, 1);
					curl_setopt($ch, CURLOPT_POSTFIELDS, $sendString);
					break;
				case 'PUT':
					curl_setopt($ch, CURLOPT_PUT, 1);
					curl_setopt($ch, CURLOPT_POSTFIELDS, $sendString);
					break;
				case 'GET':
					$url = $this->getUrl().$target.$this->getAutData($postFields);
					curl_setopt($ch, CURLOPT_URL, $url);
					break;
				default: 
					throw new PagseguroException($method.' not configured', 405);
			}
			
			$curlReturn = curl_exec($ch);
			$error = curl_error($ch);
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			
			curl_close($ch);
			
			if ($error) {
				PagseguroException::$extra = $error . ' ' . $sendString;
				throw new PagseguroException('Erro ao conectar-se com pagseguro, resposta vazia', 500);
			}
			
			if ($curlReturn === 'Internal Server Error') {
				throw new PagseguroException('Erro na formatação dos dados', 500);
			}
			
			if ($curlReturn === 'Unauthorized') {
				throw new PagseguroException('Dados de autenticação inválidos', 401);
			}
			
			$content = simplexml_load_string(utf8_encode($curlReturn));
			
			if (libxml_get_last_error()) {
				if ($this->_SANDBOX)
					var_dump(libxml_get_last_error(), $httpcode);
				
				throw new PagseguroException('Erro '.$httpcode.' retornado do pagseguro', 501);
			}
			
			if ($content->error) {
				if ($this->_SANDBOX)
					var_dump($content, $curlReturn);
				
				throw new PagseguroException($content->error[0]->message, 402);
			}
			
			return $content;
		}
		
		protected function request($target, $method = 'POST', $postFields = array(), $type = '', $rootTag = '') {
			switch($type) {
				case 'JSON' :
					return call_user_func(array($this, 'requestJSON'), func_get_args());
				default:
					return call_user_func(array($this, 'requestXML'), func_get_args());
			}
		}
		
		/* !HELPERS */
		static function arrayIntoXML($array, SimpleXMLElement &$xml) {
			foreach ($array as $key => $field) {
				if ($field instanceof PagSeguroItemList) {
					$node = $xml->addChild('items', '');
					self::xml_adopt($node, simplexml_load_string($field->asXML()));
				} elseif ($key === 'documents') {
					$subnode = $xml->addChild("$key");
					$subsubnode = $subnode->addChild("document");
					self::arrayIntoXML($field[0], $subsubnode);
				} elseif (is_array($field) OR is_object($field)) {
					if(!is_numeric($key)) {
		                $subnode = $xml->addChild("$key");
		                self::arrayIntoXML($field, $subnode);
		            } else {
		                self::arrayIntoXML($field, $xml);
		            }
				} else {
					$xml->addChild("$key", "$field");
				}
			}
		}
		
		static function xml_adopt($root, $new) {
		    $node = $root->addChild($new->getName(), (string) $new);
		    foreach($new->children() as $ch) {
		        self::xml_adopt($node, $ch);
		    }
		}
		
		static function soNumero($string) {
			return preg_replace("/[^0-9]/", "", $string);
		}
		
		static function isErro($string) {
			return (strpos($string, 'ERRO: ') === 0);
		}
		
		static function latin2utf($dat) {
			if (is_string($dat)) {
				return utf8_encode($dat);
			} elseif (is_array($dat) OR is_object($dat)) {
				foreach ($dat as &$d) 
					$d = self::latin2utf($d);
			}
			
			return $dat;
		}
		
		public function log($text) {
			error_log(date('Y-m-d H:i:s ').$text."\nfrom ".get_called_class().($this->_SANDBOX ? ' (sandbox)' : ' (produção)')."\n\n", 3, $_SERVER['DOCUMENT_ROOT'].'/pagseguro.log');
		}
	}
	
	require_once 'Recorrencia.php';
	require_once 'Transparente.php';
	require_once 'Notificacao.php';
?>