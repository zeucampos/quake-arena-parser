<?php

namespace App\Services;

class ReaderService
{
    public function getFile()
    {
        $file = file("https://gist.githubusercontent.com/labmorales/7ebd77411ad51c32179bd4c912096031/raw/045192ef9ff87ed87b36eda3170056485cfbdb5a/games.log") or die("Unable to open file!");

        try {
            foreach($file as $row) {
                $obj = explode(' ', $row);
                dd($obj);
            }
        } catch (\Exception $e) {
            throw $e;
        }

       return true;
    }
}
