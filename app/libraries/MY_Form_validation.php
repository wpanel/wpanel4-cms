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
 * Esta classe é uma extensão para a classe de validação do  CodeIgniter
 * validar campos de confirmação 'Captcha'.
 *
 * ATENÇÃO!!!
 * ----------
 * Certifique-se de ter a biblioteca GD instlada no seu ambiente de desenvolvimento
 * caso contrário ocorrerá um erro na geração do captcha.
 *
 */
class MY_Form_validation extends CI_Form_validation {

	/**
	 * Construtor da classe.
	 **/
	function __construct() {
		parent::__construct();
	}

	public function captcha() {
		// First, delete old captchas
		$expiration = time() - 7200;// Two hour limit
		$this->CI->db->query("DELETE FROM captcha WHERE captcha_time < " . $expiration);

		// Then see if a captcha exists:
		$sql = "SELECT COUNT(*) AS count FROM captcha WHERE word = ? AND ip_address = ? AND captcha_time > ?";
		$binds = array($_POST['captcha'], $this->CI->input->ip_address(), $expiration);
		$query = $this->CI->db->query($sql, $binds);
		$row = $query->row();

		if ($row->count == 0) {
			$this->set_message('captcha', lang('captcha_err'));
			return FALSE;
		} else {
			return TRUE;
		}
	}

	/**
	 * Este método executa a bilbioteca 'Captcha' do CodeIgniter.
	 **/
	function get_captcha() {
		$vals = array(
			'word' => $this->gen_rand_shortcode(6),
			'img_path' => './captcha/',
			'img_url' => base_url('captcha').'/',
			'font_path'  => './lib/fonts/essai.ttf',
			'img_width' => '150',
			'img_height' => '50',
			'expiration' => 7200,
			'colors'        => array(
                'background' => array(255, 100, 80),
                'border' => array(0, 0, 80),
                'text' => array(40, 40, 40),
                'grid' => array(255, 40, 40)
        	)
		);

		$cap = create_captcha($vals);

		$data = array(
			'captcha_time' => $cap['time'],
			'ip_address' => $this->CI->input->ip_address(),
			'word' => $cap['word']
		);

		$query = $this->CI->db->insert_string('captcha', $data);
		$this->CI->db->query($query);

		return $cap['image'];
	}

	/**
	 * Este método gera o código aleatório
	 * para ser impresso na imagem.
	 **/
	private function gen_rand_shortcode($length) {
		$randstr = "";
		for ($i = 0; $i < $length; $i++) {
			$randnum = mt_rand(0, 61);
			if ($randnum < 10) {
				$randstr .= chr($randnum + 48);
			} else if ($randnum < 36) {
				$randstr .= chr($randnum + 55);
			} else {
				$randstr .= chr($randnum + 61);
			}
		}
		return $randstr;
	}
}