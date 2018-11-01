<?php

namespace App\Services;

use App\Services\Data\ActionType;

class ReaderService
{
    protected $service;


    public function __construct(ActionType $service)
    {
        $this->service = $service;
    }

    // Get file and manage index array to save values
    public function storeContent()
    {
        $file = file("https://gist.githubusercontent.com/labmorales/7ebd77411ad51c32179bd4c912096031/raw/045192ef9ff87ed87b36eda3170056485cfbdb5a/games.log") or die("Unable to open file!");

        try {
            foreach($file as $row) {
                $obj = explode(' ', $row);
                $this->getType($obj,$row);
            }
        } catch (\Exception $e) {
            throw $e;
        }

       return $this->service->getResult();
    }

    // Get type action
    public function getType($obj, $row)
    {
        $obj = $this->removeEmpty($obj);
        $hour       = $obj[0];
        $typeAction = $obj[1];

        return $this->service->performAction($typeAction, $obj, $row);
    }


    public function removeEmpty($array)
    {
        $newData = [];
        foreach($array as $item){
            if(!empty($item))
                array_push($newData,  preg_replace('/[^A-Za-z0-9\-]/', '', $item));
        }
        return $newData;
    }
}
