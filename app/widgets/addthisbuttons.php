<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Addthisbuttons extends Widget {

	function __construct($config = array())
	{
		if (count($config) > 0) {
            $this->initialize($config);
        }
	}

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

    public function run()
	{
		$html = "";
		$html .= "<div class=\"addthis_toolbox addthis_default_style\">
                     <a class=\"addthis_button_facebook_like\" fb:like:layout=\"button_count\"></a>            
                     <a class=\"addthis_button_tweet\"></a>            
                     <a class=\"addthis_button_pinterest_pinit\"></a>            
                     <a class=\"addthis_counter addthis_pill_style\"></a>            
                 </div>";
		return $html;
	}

}