<?php
class Kupac
{
    protected $ID, $Ime, $Prezime, $Password_Hash;

    function __construct( $ID, $Ime, $Prezime, $Password_Hash )
    {
        $this->ID = $ID;
        $this->Ime = $Ime;
        $this->Prezime = $Prezime;
        $this->Password_Hash = $Password_Hash;
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
