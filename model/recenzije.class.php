<?php
class Recenzija
{
    protected $ID, $ID_Ducan, $ID_User, $Ocjena, $Tekst;

    function __construct( $ID, $ID_Ducan, $ID_User, $Ocjena, $Tekst )
    {
        $this->ID = $ID;
        $this->ID_Ducan = $ID_Ducan;
        $this->ID_User = $ID_User;
        $this->Ocjena = $Ocjena;
        $this->Tekst = $Tekst;
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
