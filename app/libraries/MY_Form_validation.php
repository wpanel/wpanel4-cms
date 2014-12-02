<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Esta classe é uma extensão para a classe de validação do  CodeIgniter
 * validar campos de confirmação 'Captcha'.
 *
 * @author Desconhecido (pesquisar e informar aqui.)
 **/
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
			'img_url' => base_url() . '/captcha/',
			'font_path'  => './lib/fonts/essai.ttf',
			'img_width' => '150',
			'img_height' => 50,
			'expiration' => 7200
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