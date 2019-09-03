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
 
 
}