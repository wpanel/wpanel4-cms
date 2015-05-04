<?php if (!defined('BASEPATH'))exit('No direct script access allowed');

/**
 * Biblioteca reunindo as opções de integração com a PayPal.
 *
 * @package wPanel
 * @author Eliel de Paula <dev@elieldepaula.com.br>
 * @since 04/05/2015
 **/
class paypal
{

	private $sandbox = false;
	private $user = '';
	private $pswd = '';
	private $signature = '';
	private $paypalURL = '';
	private $requestNvp = '';
	private $version = '108.0';
	private $subject = '';

	public function __construct($config = array()) 
	{
		if (count($config) > 0) 
		{
			$this->initialize($config);
		}
		log_message('debug', "PayPal Class Initialized");
	}

	public function __get($var) 
	{
		return get_instance()->$var;
	}

	/**
	 * Este método preenche uma lista de atributos passados
	 * em forma de array em um elemento HTML
	 *
	 * @return mixed
	 * @author Eliel de Paula <dev@elieldepaula.com.br>
	 */
	private function _attributes($attributes)
	{
		if(is_array($attributes))
		{
			$atr = '';
			foreach($attributes as $key => $value)
			{
				$atr .= $key . "=\"".$value."\" ";
			}
			return $atr;
		} 
		elseif (is_string($attributes) and strlen($attributes) > 0) 
		{
			$atr = ' ' . $attributes;
		}
	}

	/**
	 * Initialize the library loading the configuration files or
	 * an array() passed on load of the class.
	 *
	 * @author Eliel de Paula <dev@elieldepaula.com.br>
	 * @param $config array()
	 * @return void
	 */
	public function initialize($config = array()) 
	{
		foreach ($config as $key => $val) 
		{
			if (isset($this->$key)) {
				$method = 'set_' . $key;
				if (method_exists($this, $method)) 
				{
					$this->$method($val);
				}
				else 
				{
					$this->$key = $val;
				}
			}
		}
		return $this;
	}

	public function sendNvpRequest()
	{
	    //Endpoint da API
	    $apiEndpoint  = 'https://api-3t.' . ($this->sandbox? 'sandbox.': null);
	    $apiEndpoint .= 'paypal.com/nvp';
	 
	    //Executando a operação
	    $curl = curl_init();
	 
	    curl_setopt($curl, CURLOPT_URL, $apiEndpoint);
	    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($curl, CURLOPT_POST, true);
	    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($this->requestNvp));
	 
	    $response = urldecode(curl_exec($curl));
	 
	    curl_close($curl);
	 
	    //Tratando a resposta
	    $responseNvp = array();
	 
	    if (preg_match_all('/(?<name>[^\=]+)\=(?<value>[^&]+)&?/', $response, $matches)) {
	        foreach ($matches['name'] as $offset => $name) {
	            $responseNvp[$name] = $matches['value'][$offset];
	        }
	    }
	 
	    //Verificando se deu tudo certo e, caso algum erro tenha ocorrido,
	    //gravamos um log para depuração.
	    if (isset($responseNvp['ACK']) && $responseNvp['ACK'] != 'Success') {
	        for ($i = 0; isset($responseNvp['L_ERRORCODE' . $i]); ++$i) {
	            $message = sprintf("PayPal NVP %s[%d]: %s\n",
	                               $responseNvp['L_SEVERITYCODE' . $i],
	                               $responseNvp['L_ERRORCODE' . $i],
	                               $responseNvp['L_LONGMESSAGE' . $i]);
	 
	            error_log($message);
	        }
	    }
	 
	    return $responseNvp;
	}

	// continua...

}