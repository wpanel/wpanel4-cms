<?php
/*
  RoxyFileman - web based file manager. Ready to use with CKEditor, TinyMCE. 
  Can be easily integrated with any other WYSIWYG editor or CMS.

  Copyright (C) 2013, RoxyFileman.com - Lyubomir Arsov. All rights reserved.
  For licensing, see LICENSE.txt or http://RoxyFileman.com/license

  This program is free software: you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation, either version 3 of the License.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program.  If not, see <http://www.gnu.org/licenses/>.

  Contact: Lyubomir Arsov, liubo (at) web-lobby.com
*/
  
function checkAccess($action){
    if(!is_logged())
        exit('No direct script access allowed');
}

function is_logged(){
    $output = false;
    $filename = sys_get_temp_dir() . '/wpanel_' . $_COOKIE['wpanel_'];
    if(file_exists($filename)){
        $handle = fopen($filename, "r");
        $contents = fread($handle, filesize($filename));
        fclose($handle);
        $x = explode(';', $contents);
        foreach($x as $key => $value){
            $y = explode('|', $value);
            if ($y[0] == 'logged_in') {
                $output = true;
                break;
            } else {
                $output = false;
            }
        }
    }
    return $output;
}

?>