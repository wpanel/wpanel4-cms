<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Facebookheader extends Widget {

    public function run()
	{
		$html = "";
        $html .= "<div id=\"fb-root\"></div>\n";
        $html .= "<script>\n";
        $html .= "(function(d, s, id) {\n";
        $html .= "\tvar js, fjs = d.getElementsByTagName(s)[0];\n";
        $html .= "\tif (d.getElementById(id))\n";
        $html .= "\t    return;\n";
        $html .= "\tjs = d.createElement(s);\n";
        $html .= "\tjs.id = id;\n";
        $html .= "\tjs.src = \"//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.0\";\n";
        $html .= "\tfjs.parentNode.insertBefore(js, fjs);\n";
        $html .= "\t    }(document, 'script', 'facebook-jssdk'));\n";
        $html .= "</script>\n";
        return $html;
	}

}