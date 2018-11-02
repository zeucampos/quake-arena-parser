<?php
/*
 * Helpers customizados
*/


if (! function_exists('Transaction')) {
    function Transaction() {
        return new \App\Http\Helpers\TransactionHelper();
    }
}
