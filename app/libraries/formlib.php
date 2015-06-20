<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class formlib 
{

	private $form_title 		= ''; // Título do form exibido no 'panel'.
	private $form_submitaction 	= ''; // Endereço completo do action (http://endereco/completo).
	private $form_cancelaction 	= ''; // Endereço completo do cancelamento (http://endereco/completo).
	private $form_submit_label 	= 'Submit'; // Texto do botão de submit.
	private $form_cancel_label 	= 'Cancel'; // Texto do botão de cancelamento.
	private $form_type 			= 'post'; // Tipo de envio: post, get, multipart.
	private $form_role 			= 'form'; // Tag 'role' usada pelo bootstrap.
	private $form_itens 		= array(); // array com os itens do formulário.

	public function __construct($config = array())
    {
        if (count($config) > 0) {
            $this->initialize($config);
        }
        log_message('debug', "FormLib Class Initialized");
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
        if (is_array($attributes)) {
            $atr = '';
            foreach ($attributes as $key => $value)
            {
                $atr .= $key . "=\"" . $value . "\" ";
            }
            return $atr;
        } elseif (is_string($attributes) and strlen($attributes) > 0) {
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
                if (method_exists($this, $method)) {
                    $this->$method($val);
                } else {
                    $this->$key = $val;
                }
            }
        }
        return $this;
    }
    
	private function is_required($var)
	{
		if($var == True){
			return 'required="required"';
		}
	}

	private function is_checked($var)
	{
		if($var == True){
			return 'checked="checked"';
		}
	}

	private function is_selected($field, $value)
	{
		if($field == $value){
			return 'selected="selected"';
		}
	}

	private function show_error($var)
	{
		if($var){
			return "<p class=\"bg-danger\">".$var."</p>\n";
		}
	}

	private function form_header()
	{
		$html = "";
		$html .= "<div class=\"panel panel-default\">\n";
		$html .= "<div class=\"panel-heading\">".$this->form_title."</div>\n";
		$html .= "<div class=\"panel-body\">\n";
		if($this->form_type == 'multipart'){
			$html .= "<form action=\"".$this->form_submitaction."\" type=\"".$this->form_type."\" enctype=\"multipart/form-data\" role=\"".$this->form_role."\" >\n";
		} else {
			$html .= "<form action=\"".$this->form_submitaction."\" type=\"".$this->form_type."\" role=\"".$this->form_role."\" >\n";
		}
		return $html;
	}

	private function form_footer()
	{
		$html = "";
		$html .= "<button type=\"submit\" class=\"btn btn-success\">".$this->form_submit_label."</button>\n";
		$html .= "<a href=\"".$this->form_cancelaction."\" class=\"btn btn-danger\">".$this->form_cancel_label."</a>\n";
		$html .= "\n</form>\n</div>\n</div>\n</div>";
		return $html;
	}

	public function set_itens($var)
	{
		$this->form_items = $var;
	}

	private function make_input($item = array())
	{
		$html = "";
		switch ($item['type']) {
			case 'textarea':
				$html .= "<div class=\"form-group\">\n";
				$html .= "<label for=\"".$item['id']."\">".$item['label']."</label>\n";
				$html .= "<textarea class=\"form-control\" id=\"".$item['id']."\" name=\"".$item['name']."\" placeholder=\"".$item['placeholder']."\" rows=\"".$item['rows']."\">".$item['value']."</textarea>\n";
				$html .= $this->show_error($item['error']);
				$html .= "</div>\n";			
				break;
			case 'checkbox':
				$html .= "<div class=\"checkbox\">\n<label>\n";
				$html .= "<input type=\"".$item['type']."\" name=\"".$item['name']."\" value=\"".$item['value']."\" ".$this->is_checked($item['checked'])." > ".$item['label']."\n";
				$html .= "</label>\n";
				$html .= $this->show_error($item['error']);
				$html .= "</div>\n";
				break;
			case 'radio':
				$html .= "<div class=\"radio\">\n<label>\n";
				$html .= "<input type=\"".$item['type']."\" name=\"".$item['name']."\" value=\"".$item['value']."\" ".$this->is_checked($item['checked'])." > ".$item['label']."\n";
				$html .= "</label>\n";
				$html .= $this->show_error($item['error']);
				$html .= "</div>\n";
				break;
			case 'select':
				$html .= "<div class=\"form-group\">\n";
				$html .= "<label for=\"".$item['id']."\">".$item['label']."</label>\n";
				$html .= "<select class=\"form-control\" id=\"".$item['id']."\" name=\"".$item['name']."\">\n";
				$html .= "<option>[ Selecione ]</option>\n";
				foreach($item['itens'] as $x => $value)
				{
					$html .= "<option value=\"".$x."\" ".$this->is_selected($x, $item['value'])." >".$value."</option>\n";
				}
				$html .= "</select>\n";
				$html .= $this->show_error($item['error']);
				$html .= "</div>\n";
				break;
			default:
				$html .= "<div class=\"form-group\">\n";
				$html .= "<label for=\"".$item['id']."\">".$item['label']."</label>\n";
				$html .= "<input type=\"".$item['type']."\" ".$this->is_required($item['required'])." class=\"form-control\" id=\"".$item['id']."\" name=\"".$item['name']."\" value=\"".$item['value']."\" placeholder=\"".$item['placeholder']."\">\n";
				$html .= $this->show_error($item['error']);
				$html .= "</div>\n";
				break;
		}		
		return $html;
	}

	private function get_items()
	{
		$html = "";
		foreach($this->form_items as $x => $item)
		{
			$html .= $this->make_input($item);
		}
		return $html;
	}

	public function get_form()
    {
    	$html = "";
    	$html .= $this->form_header();
    	$html .= $this->get_items();
    	$html .= $this->form_footer();
    	return $html;
    }

}