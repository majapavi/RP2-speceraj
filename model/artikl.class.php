<?php

class Artikl
{
    public $ArtiklID, $ArtiklSlika, $ArtiklaNaziv, $DucanSlika, $Kolicina, $Cijena, $Akcija;

    function __construct( $ArtiklID, $ArtiklSlika, $ArtiklaNaziv, $DucanSlika, $Kolicina, $Cijena, $Akcija )
    {
        $this->ArtiklID = $ArtiklID;
        $this->ArtiklSlika = $ArtiklSlika;
        $this->ArtiklaNaziv = $ArtiklaNaziv;
        $this->DucanSlika = $DucanSlika;
        $this->Kolicina = $Kolicina;
        $this->Cijena = $Cijena;
        $this->Akcija = $Akcija;
    }

    function __get( $property )
    {
        if( property_exists( $this, $property ) )
            return $this->$property;
    }

    function __set( $property )
    {
        if( property_exists( $this, $property ) )
            $this->$property = $value;

        return $this;
    }
}

?>