<?php

class Artikl
{
    public $ArtiklSlika, $ArtiklaNaziv, $DucanSlika, $Kolicina, $Cijena, $Akcija, $ponudaID;

    function __construct($ArtiklSlika, $ArtiklaNaziv, $DucanSlika, $Kolicina, $Cijena, $Akcija, $ponudaID)
    {
        $this->ArtiklSlika = $ArtiklSlika;
        $this->ArtiklaNaziv = $ArtiklaNaziv;
        $this->DucanSlika = $DucanSlika;
        $this->Kolicina = $Kolicina;
        $this->Cijena = $Cijena;
        $this->Akcija = $Akcija;
        $this->ponudaID = $ponudaID;
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