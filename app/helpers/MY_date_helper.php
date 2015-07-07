<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('date_for_mysql')) {

    function date_for_mysql($date) {
        $desmonta = explode("/", $date);
        $dia = $desmonta[0];
        $mes = $desmonta[1];
        $ano = $desmonta[2];
        $saida = $ano . "-" . $mes . "-" . $dia;
        return $saida;
    }

}

if (!function_exists('date_for_user')) {

    function date_for_user($date) {
        $desmonta = explode("-", $date);
        $ano = $desmonta[0];
        $mes = $desmonta[1];
        $dia = $desmonta[2];
        $saida = $dia . "/" . $mes . "/" . $ano;
        return $saida;
    }

}

if (!function_exists('datetime_for_mysql')) {

    function datetime_for_mysql($date, $show_time = True) {

        $desmonta = explode(" ", $date);
        $data = $desmonta[0];
        $hora = $desmonta[1];

        if($show_time){
            $saida = date_for_mysql($data) . ' ' . $hora;
        } else {
            $saida = date_for_mysql($data);
        }

        return $saida;
    }

}

if (!function_exists('datetime_for_user')) {

    function datetime_for_user($date, $show_time = True) {

        $desmonta = explode(" ", $date);
        $data = $desmonta[0];
        $hora = $desmonta[1];

        if($show_time){
            $saida = date_for_user($data) . ' ' . $hora;
        } else {
            $saida = date_for_user($data);
        }

        return $saida;
    }

}