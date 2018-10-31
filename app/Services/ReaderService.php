<?php

namespace App\Services;

class ReaderService
{

    // Get file and manage index array to save values
    public function storeContent()
    {
        $file = file("https://gist.githubusercontent.com/labmorales/7ebd77411ad51c32179bd4c912096031/raw/045192ef9ff87ed87b36eda3170056485cfbdb5a/games.log") or die("Unable to open file!");

        try {
            foreach($file as $row) {
                $obj = explode(' ', $row);
                $index = 0;

                (!empty($obj[1])) ? $index=1 : $index=2;

                $this->getType($obj, $index);
            }
        } catch (\Exception $e) {
            throw $e;
        }

       return true;
    }

    // Get type action
    public function getType($obj, $index)
    {
        $hour       = $obj[$index];
        $typeAction = $obj[$index + 1];

        dd($typeAction);
    }
}
