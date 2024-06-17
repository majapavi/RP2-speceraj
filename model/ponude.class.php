<?php
class Ponuda
{
    protected $ID, $ID_Proizvod, $ID_Ducan, $Cijena, $Akcija;

    function __construct( $ID, $ID_Proizvod, $ID_Ducan, $Cijena, $Akcija )
    {
        $this->ID = $ID;
        $this->ID_Proizvod = $ID_Proizvod;
        $this->ID_Ducan = $ID_Ducan;
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
