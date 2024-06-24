<?php
class Ducan2
{
    public $Naziv, $Logo, $Cijena, $Akcija;

    function __construct( $Naziv, $Logo, $Cijena, $Akcija )
    {
        $this->Naziv = $Naziv;
        $this->Logo = $Logo;
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
