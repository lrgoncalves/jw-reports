<?php

namespace App\Traits;

use Carbon\Carbon;

trait DateTrait
{

    /**
     * Converte a data no padrao dd/mm/yyyy para Carbon Date
     *
     * @param string $strDate
     * @param string $separator (default = "/") forward slash
     * @return \Carbon\Carbon
     */
    protected function convertString2Carbon($strDate, $separator = "/")
    {
        if (is_null($strDate)) {
            return null;
        }
        $parties = explode($separator, $strDate);
        return Carbon::createFromDate($parties[2], $parties[1], $parties[0]);
    }

    protected function convertStringMY2Carbon($strDate, $separator = "/")
    {
        if (is_null($strDate)) {
            return null;
        }
        $parties = explode($separator, $strDate);
        return Carbon::createFromDate($parties[1], $parties[0], 1);
    }
 
    protected function getMonth($id = null) {
        $array = [
            1 => 'Janeiro',
            2 => 'Fevereiro',
            3 => 'Março',
            4 => 'Abril',
            5 => 'Maio',
            6 => 'Junho',
            7 => 'Julho',
            8 => 'Agosto',
            9 => 'Setembro',
            10 => 'Outubro',
            11 => 'Novembro',
            12 => 'Dezembro',
        ];

        if (!$id) {
            return $array;
        }

        return $array[$id];
    }
 
}