<?php
class Akcija
{
    public $ID, $Naziv, $Slika, $Korak, $Ducan, $DucanSlika, $Cijena, $Akcija;

    function __construct( $ID, $Naziv, $Slika, $Korak, $Ducan, $DucanSlika, $Cijena, $Akcija )
    {
        $this->ID = $ID;
        $this->Naziv = $Naziv;
        $this->Slika = $Slika;
        $this->Korak = $Korak;
        $this->Ducan = $Ducan;
        $this->DucanSlika = $DucanSlika;
        $this->Cijena = $Cijena;
        $this->Akcija = $Akcija;
    }

    function __get( $property )
    {
        if( property_exists( $this, $property ) )
            return $this->$property;
    }

    function __set( $property, $value )
    {
        if( property_exists( $this, $property ) )
            $this->$property = $value;

        return $this;
    }
}
?>
