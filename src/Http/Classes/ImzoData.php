<?php

namespace Asadbek\Eimzo\Http\Classes;

class ImzoData  implements \JsonSerializable
{
    private $name;
    private $date;
    private $serialNumber;
    private $stir;
    public function __construct($name, $date, $serialNumber, $stir)
    {
        $this->name = $name;
        $this->date = $date;
        $this->serialNumber = $serialNumber;
        $this->stir = $stir;

    }


    public function jsonSerialize()
    {
        return [
            'name' => $this->name,
            'date' => $this->date,
            'serialNumber' => $this->serialNumber,
            'stir' => $this->serialNumber
        ];
    }
}