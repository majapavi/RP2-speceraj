<?php
class Ducan2
{
    public $Naziv, $Logo, $Cijena, $Akcija, $ID_Ponuda;

    function __construct( $Naziv, $Logo, $Cijena, $Akcija, $ID_Ponuda )
    {
        $this->Naziv = $Naziv;
        $this->Logo = $Logo;
        $this->Cijena = $Cijena;
        $this->Akcija = $Akcija;
        $this->ID_Ponuda = $ID_Ponuda;
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
