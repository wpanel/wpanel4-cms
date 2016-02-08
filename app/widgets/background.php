<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Background extends Widget {

    public function run()
	{

        $html = "";
        $html .= "<style type=\"text/css\">\n";
        $html .= "\tbody {\n";
        if(wpn_config('background'))$html .= "\t\tbackground-image: url('" . base_url('media/'.wpn_config('background')) ."');\n";
        if(wpn_config('bgcolor'))$html .= "\t\tbackground-color: " . wpn_config('bgcolor') . ";\n";
        $html .= "\t}\n";
        $html .= "\t</style>\n";
        return $html;
	}

}