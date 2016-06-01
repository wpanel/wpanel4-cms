<?php

/**
 * WPanel CMS
 *
 * An open source Content Manager System for blogs and websites using CodeIgniter and PHP.
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2014 - 2016, British Columbia Institute of Technology
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package     WpanelCms
 * @author      Eliel de Paula <dev@elieldepaula.com.br>
 * @copyright   Copyright (c) 2008 - 2016, Eliel de Paula. (https://elieldepaula.com.br/)
 * @license     http://opensource.org/licenses/MIT  MIT License
 * @link        https://wpanelcms.com.br
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Install Library Class
 *
 * This class maintain the methods to install WpanelCms.
 *
 * @package     WpanelCms
 * @subpackage  Libraries
 * @category    Libraries
 * @author      Eliel de Paula <dev@elieldepaula.com.br>
 * @link        https://wpanelcms.com.br
 * @version     0.0.1
 */
class Install {

	protected $siteurl = '';
	protected $urlamigavel = '';
	protected $usaextensao = '';
	protected $tipo_database = '';
	protected $servername = '';
	protected $databasename = '';
	protected $username = '';
	protected $password = '';

	/**
     * Class constructor.
     * 
     * @return void
     */
    public function __construct($config = array()) 
    {
        if (count($config) > 0)
            $this->initialize($config);
        log_message('debug', "Install Class Initialized");
    }

    /**
     * Get the instance of CI.
     * 
     * @return mixed
     */
    public function __get($var) 
    {
        return get_instance()->$var;
    }

    private function _attributes($attributes) 
    {
        if (is_array($attributes)) {
            $atr = '';
            foreach ($attributes as $key => $value) {
                $atr .= $key . "=\"" . $value . "\" ";
            }
            return $atr;
        } elseif (is_string($attributes) and strlen($attributes) > 0)
            $atr = ' ' . $attributes;
        
    }

    public function initialize($config = array()) 
    {
        foreach ($config as $key => $val) {
            if (isset($this->$key)) {
                $method = 'set_' . $key;
                if (method_exists($this, $method))
                    $this->$method($val);
                else
                    $this->$key = $val;
            }
        }
        return $this;
    }

    private function create_config()
	{

		$temp_urlamigavel = "";
		$temp_usaextensao = "";

		if(!$this->urlamigavel == 1)
			$temp_urlamigavel = "index.php";

		if($this->usaextensao == 1)
			$temp_usaextensao = ".html";

		// Unlink previous config.php file.
		unlink(APPPATH . '/config/config.php');
		
		$this->load->helper('file');

		$data = "";
		$data .= "<?php defined('BASEPATH') OR exit('No direct script access allowed');\n\n";

		$data .= "\$config['base_url'] = '".$this->siteurl."';\n";
		$data .= "\$config['index_page'] = '$temp_urlamigavel';\n";
		$data .= "\$config['url_suffix'] = '$temp_usaextensao';\n";
		$data .= "\$config['uri_protocol']	= 'REQUEST_URI';\n";
		$data .= "\$config['language']	= 'portuguese';\n";
		$data .= "\$config['charset'] = 'UTF-8';\n";
		$data .= "\$config['enable_hooks'] = FALSE;\n";
		$data .= "\$config['subclass_prefix'] = 'MY_';\n";
		$data .= "\$config['composer_autoload'] = APPPATH.'libraries\/autoload.php';\n";
		$data .= "\$config['permitted_uri_chars'] = 'a-z 0-9~%.:_\\-';\n";
		$data .= "\$config['allow_get_array'] = TRUE;\n";
		$data .= "\$config['enable_query_strings'] = FALSE;\n";
		$data .= "\$config['controller_trigger'] = 'c';\n";
		$data .= "\$config['function_trigger'] = 'm';\n";
		$data .= "\$config['directory_trigger'] = 'd';\n";
		$data .= "\$config['log_threshold'] = 0;\n";
		$data .= "\$config['log_path'] = '';\n";
		$data .= "\$config['log_file_extension'] = '';\n";
		$data .= "\$config['log_file_permissions'] = 0644;\n";
		$data .= "\$config['log_date_format'] = 'Y-m-d H:i:s';\n";
		$data .= "\$config['error_views_path'] = '';\n";
		$data .= "\$config['cache_path'] = '';\n";
		$data .= "\$config['cache_query_string'] = FALSE;\n";
		$data .= "\$config['encryption_key'] = '';\n";
		$data .= "\$config['sess_driver'] = 'files';\n";
		$data .= "\$config['sess_cookie_name'] = 'ci_session';\n";
		$data .= "\$config['sess_expiration'] = 7200;\n";
		$data .= "\$config['sess_save_path'] = APPPATH . 'sessions';\n";
		$data .= "\$config['sess_match_ip'] = FALSE;\n";
		$data .= "\$config['sess_time_to_update'] = 300;\n";
		$data .= "\$config['sess_regenerate_destroy'] = FALSE;\n";
		$data .= "\$config['cookie_prefix']	= '';\n";
		$data .= "\$config['cookie_domain']	= '';\n";
		$data .= "\$config['cookie_path']		= '\/';\n";
		$data .= "\$config['cookie_secure']	= FALSE;\n";
		$data .= "\$config['cookie_httponly'] 	= FALSE;\n";
		$data .= "\$config['standardize_newlines'] = FALSE;\n";
		$data .= "\$config['global_xss_filtering'] = TRUE;\n";
		$data .= "\$config['csrf_protection'] = TRUE;\n";
		$data .= "\$config['csrf_token_name'] = 'csrf_test_name';\n";
		$data .= "\$config['csrf_cookie_name'] = 'csrf_cookie_name';\n";
		$data .= "\$config['csrf_expire'] = 7200;\n";
		$data .= "\$config['csrf_regenerate'] = TRUE;\n";
		$data .= "\$config['csrf_exclude_uris'] = array();\n";
		$data .= "\$config['compress_output'] = FALSE;\n";
		$data .= "\$config['time_reference'] = 'local';\n";
		$data .= "\$config['rewrite_short_tags'] = FALSE;\n";
		$data .= "\$config['proxy_ips'] = '';\n\n";

		if (!write_file(APPPATH . '/config/config.php', $data))
		{
			return FALSE;
		} else {
			return TRUE;
		}

	}

	private function create_json()
	{

		// Unlink previous config.json file.
		unlink(APPPATH . '/config/config.json');
		
		$this->load->helper('file');

		$data = "";
		$data .= "{\n";
		$data .= "    \"site_titulo\": \"Site de exemplo\",\n";
		$data .= "    \"site_desc\": \"Descri\\u00e7\\u00e3o do site aqui\",\n";
		$data .= "    \"site_tags\": \"exemplo, site, wpanelcms\",\n";
		$data .= "    \"site_contato\": \"\",\n";
		$data .= "    \"site_telefone\": \"\",\n";
		$data .= "    \"link_instagram\": \"\",\n";
		$data .= "    \"link_twitter\": \"\",\n";
		$data .= "    \"link_facebook\": \"\",\n";
		$data .= "    \"link_likebox\": \"http:\\/\\/facebook.com\\/wpanelcms\",\n";
		$data .= "    \"copyright\": \"\\u00ae Wpanel CMS - 2016 - Site de exemplo.\",\n";
		$data .= "    \"addthis_uid\": \"\",\n";
		$data .= "    \"texto_contato\": \"Esta mensagem pode ser alterada no painel de controle.\",\n";
		$data .= "    \"google_analytics\": \"UA-XXXXX-Y\",\n";
		$data .= "    \"bgcolor\": \"\",\n";
		$data .= "    \"language\": \"portuguese\",\n";
		$data .= "    \"text_editor\": \"ckeditor\",\n";
		$data .= "    \"author\": \"Eliel de Paula - dev@elieldepaula.com.br\",\n";
		$data .= "    \"home_tipo\": \"page\",\n";
		$data .= "    \"home_id\": \"1\",\n";
		$data .= "    \"usa_smtp\": null,\n";
		$data .= "    \"smtp_servidor\": \"\",\n";
		$data .= "    \"smtp_porta\": \"\",\n";
		$data .= "    \"smtp_usuario\": \"\",\n";
		$data .= "    \"smtp_senha\": \"\",\n";
		$data .= "    \"logomarca\": \"logomarca.png\",\n";
		$data .= "    \"background\": false\n";
		$data .= "}\n";

		if (!write_file(APPPATH . '/config/config.json', $data))
		{
			return FALSE;
		} else {
			return TRUE;
		}

	}

	private function create_database()
	{
		// Unlink previous database.php file.
		unlink(APPPATH . '/config/database.php');
		
		$this->load->helper('file');

		$data = "";
		$data .= "<?php if(!defined('BASEPATH')) exit('No direct script access allowed');\n\n";

		$data .= "\$active_group = ENVIRONMENT;\n";
		$data .= "\$query_builder = TRUE;\n\n";

		$data .= "/**\n";
		$data .= " * Configurações para o ambiente de desenvolvimento.\n";
		$data .= " */\n";
		
		if($this->tipo_database == 'mysql')
			$data .= "\$db['development']['hostname'] = '".$this->servername."';\n";
		else 
			$data .= "\$db['development']['hostname'] = 'sqlite:'.APPPATH.'db/".$this->databasename.".sqlite';\n";
		if($this->tipo_database == 'mysql')
			$data .= "\$db['development']['username'] = '".$this->username."';\n";
		if($this->tipo_database == 'mysql')
			$data .= "\$db['development']['password'] = '".$this->password."';\n";
		if($this->tipo_database == 'mysql')
			$data .= "\$db['development']['database'] = '".$this->databasename."';\n";
		if($this->tipo_database == 'mysql')
			$data .= "\$db['development']['dbdriver'] = 'mysqli';\n";
		else
			$data .= "\$db['development']['dbdriver'] = 'pdo';\n";
		
		$data .= "\$db['development']['dbprefix'] = '';\n";
		$data .= "\$db['development']['pconnect'] = TRUE;\n";
		$data .= "\$db['development']['db_debug'] = TRUE;\n";
		$data .= "\$db['development']['cache_on'] = FALSE;\n";
		$data .= "\$db['development']['cachedir'] = '';\n";
		$data .= "\$db['development']['char_set'] = 'utf8';\n";
		$data .= "\$db['development']['dbcollat'] = 'utf8_general_ci';\n";
		$data .= "\$db['development']['swap_pre'] = '';\n";
		$data .= "\$db['development']['autoinit'] = TRUE;\n";
		$data .= "\$db['development']['stricton'] = FALSE;\n\n";

		$data .= "/**\n";
		$data .= " * Configurações para o ambiente de produção.\n";
		$data .= " */\n";
		$data .= "\$db['production']['hostname'] = '';\n";
		$data .= "\$db['production']['username'] = '';\n";
		$data .= "\$db['production']['password'] = '';\n";
		$data .= "\$db['production']['database'] = '';\n";
		$data .= "\$db['production']['dbdriver'] = 'mysqli';\n";
		$data .= "\$db['production']['dbprefix'] = '';\n";
		$data .= "\$db['production']['pconnect'] = TRUE;\n";
		$data .= "\$db['production']['db_debug'] = TRUE;\n";
		$data .= "\$db['production']['cache_on'] = FALSE;\n";
		$data .= "\$db['production']['cachedir'] = '';\n";
		$data .= "\$db['production']['char_set'] = 'utf8';\n";
		$data .= "\$db['production']['dbcollat'] = 'utf8_general_ci';\n";
		$data .= "\$db['production']['swap_pre'] = '';\n";
		$data .= "\$db['production']['autoinit'] = TRUE;\n";
		$data .= "\$db['production']['stricton'] = FALSE;\n\n";

		if (!write_file(APPPATH . '/config/database.php', $data))
		{
			return FALSE;
		} else {
			return TRUE;
		}
	}

	private function do_migrate($version = null)
	{
		$this->load->library('migration');
		if($version == null) {
			if($this->migration->latest()) {
				return TRUE;
			} else {
				return FALSE;
			}
		} else {
			if($this->migration->version($version)) {
				return TRUE;
			} else {
				return FALSE;
			}
		}
	}

	public function get_config()
	{
		return $this->create_config();
	}

	public function get_json()
	{
		return $this->create_json();
	}

	public function get_database()
	{
		return $this->create_database();
	}

	public function get_migrate()
	{
		return $this->do_migrate();
	}

}
