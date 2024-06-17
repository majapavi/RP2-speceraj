<?php
class Ducan
{
    protected $ID, $Naziv, $Prosjek;

    function __construct( $ID, $Naziv, $Prosjek )
    {
        $this->ID = $ID;
        $this->Naziv = $Naziv;
        $this->Prosjek = $Prosjek;
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
