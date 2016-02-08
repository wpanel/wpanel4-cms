<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Addthisheader extends Widget {

    public function run()
	{
		$html = "";
        $html .= "<script type=\"text/javascript\" src=\"//s7.addthis.com/js/300/addthis_widget.js
        #pubid=" . wpn_config('addthis_uid') . "\"></script>";
        return $html;
	}

}