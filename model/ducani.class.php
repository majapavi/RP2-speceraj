<?php
class Ducan
{
    protected $ID, $Naziv, $Prosjek, $Link;

    function __construct( $ID, $Naziv, $Prosjek, $Link )
    {
        $this->ID = $ID;
        $this->Naziv = $Naziv;
        $this->Prosjek = $Prosjek;
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
