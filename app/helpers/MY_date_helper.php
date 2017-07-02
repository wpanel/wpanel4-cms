<?php

/**
 * WPanel CMS
 *
 * An open source Content Manager System for websites and systems using CodeIgniter.
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2008 - 2017, Eliel de Paula.
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
 * @copyright   Copyright (c) 2008 - 2017, Eliel de Paula. (https://elieldepaula.com.br/)
 * @license     http://opensource.org/licenses/MIT  MIT License
 * @link        https://wpanel.org
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Wpanel aditional date helper.
 *
 * This helper contains some aditional functions to 
 * Date Helper of Codeigniter to Wpanel CMS.
 *
 * @todo        Alterar para usar a função mdate() do CodeIgniter.
 * @package     WpanelCms
 * @subpackage  Helpers
 * @category    Helpers
 * @author      Eliel de Paula <dev@elieldepaula.com.br>
 * @link        http://elieldepaula.com.br
 * @since       v1.0.0
 */
if (!function_exists('date_for_mysql'))
{

    /**
     * This helper return an human date to mysql date.
     *
     * @param $date string Ex: 10/12/2015
     * @return string Ex: 2015-12-10
     */
    function date_for_mysql($date)
    {
        $desmonta = explode("/", $date);
        $dia = $desmonta[0];
        $mes = $desmonta[1];
        $ano = $desmonta[2];
        $saida = $ano . "-" . $mes . "-" . $dia;
        return $saida;
    }

}

if (!function_exists('date_for_user'))
{

    /**
     * This helper return an mysql date to human date.
     *
     * @param $date string Ex: 2015-12-10
     * @return string Ex: 10/12/2015
     */
    function date_for_user($date)
    {
        $desmonta = explode("-", $date);
        $ano = $desmonta[0];
        $mes = $desmonta[1];
        $dia = $desmonta[2];
        $saida = $dia . "/" . $mes . "/" . $ano;
        return $saida;
    }

}

if (!function_exists('datetime_for_mysql'))
{

    /**
     * This helper return an human date with time to mysql date.
     *
     * @param $date string Ex: 10/12/2015 12:00:00
     * @return string Ex: 2015-12-10 12:00:00
     */
    function datetime_for_mysql($date, $show_time = True)
    {
        $desmonta = explode(" ", $date);
        $data = $desmonta[0];
        $hora = $desmonta[1];
        if ($show_time)
            $saida = date_for_mysql($data) . ' ' . $hora;
        else
            $saida = date_for_mysql($data);
        return $saida;
    }

}

if (!function_exists('datetime_for_user'))
{

    /**
     * This helper return an mysql date with time to human date.
     *
     * @param $date string Ex: 2015-12-10 12:00:00
     * @return string Ex: 10/12/2015 12:00:00
     */
    function datetime_for_user($date, $show_time = True)
    {
        $desmonta = explode(" ", $date);
        $data = $desmonta[0];
        $hora = $desmonta[1];
        if ($show_time)
            $saida = date_for_user($data) . ' ' . $hora;
        else
            $saida = date_for_user($data);
        return $saida;
    }

}