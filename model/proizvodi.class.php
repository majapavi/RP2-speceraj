<?php
class Proizvod
{
    protected $ID, $Naziv, $Link, $Korak;

    function __construct( $ID, $Naziv, $Link, $Korak )
    {
        $this->ID = $ID;
        $this->Naziv = $Naziv;
        $this->Link = $Link;
        $this->Korak = $Korak;
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
