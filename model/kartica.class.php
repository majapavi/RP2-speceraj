<?php
class Kartica
{
    protected $Proizvod_ID, $Proizvod_Naziv, $Proizvod_Link, $Ducani;

    function __construct( $Proizvod_ID, $Proizvod_Naziv, $Proizvod_Link, $Ducani )
    {
        $this->Proizvod_ID = $Proizvod_ID;
        $this->Proizvod_Naziv = $Proizvod_Naziv;
        $this->Proizvod_Link = $Proizvod_Link;
        $this->Ducani = $Ducani;
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
