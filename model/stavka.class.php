<?php

class Stavka
{
    public $ArtiklaNaziv, $DucanNaziv, $Kolicina, $CijenaSAkcijom;

    function __construct($ArtiklaNaziv, $DucanNaziv, $Kolicina, $CijenaBezAkcije, $Akcija)
    {
        $this->ArtiklaNaziv = $ArtiklaNaziv;
        $this->DucanNaziv = $DucanNaziv;
        $this->Kolicina = $Kolicina;
        if ($Akcija == 0)
            $this->CijenaSAkcijom = $CijenaBezAkcije;
        else
            $this->CijenaSAkcijom = $Akcija;
    }

    function __get($property)
    {
        if (property_exists($this, $property))
            return $this->$property;
    }

    function __set($property, $value)
    {
        if (property_exists($this, $property))
            $this->$property = $value;

        return $this;
    }
}

?>