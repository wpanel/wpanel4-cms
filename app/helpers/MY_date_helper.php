<?php

/**
 * @copyright Eliel de Paula <dev@elieldepaula.com.br>
 * @license http://wpanel.org/license
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Wpanel aditional date helper.
 *
 * This helper contains some aditional functions to 
 * Date Helper of Codeigniter to Wpanel CMS.
 *
 * @author      Eliel de Paula <dev@elieldepaula.com.br>
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