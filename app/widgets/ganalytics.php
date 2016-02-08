<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Ganalytics extends Widget {

    public function run()
	{

        $html = "";
        $html .= "\t<!-- Google Analytics -->\n";
        $html .= "\t<script>\n";
        $html .= "\t(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){\n";
        $html .= "\t(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),\n";
        $html .= "\tm=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)\n";
        $html .= "\t})(window,document,'script','//www.google-analytics.com/analytics.js','ga');\n";

        $html .= "\tga('create', '".wpn_config('google_analytics')."', 'auto');\n";
        $html .= "\tga('send', 'pageview');\n";
        $html .= "\t</script>\n";
        $html .= "\t<!-- End Google Analytics -->\n";

        return $html;
	}

}