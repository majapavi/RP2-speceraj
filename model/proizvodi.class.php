<?php
class Proizvod
{
    protected $ID, $Naziv, $Link;

    function __construct( $ID, $Naziv, $Link )
    {
        $this->ID = $ID;
        $this->Naziv = $Naziv;
        $this->Link = $Link;
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
