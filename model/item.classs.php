<?php
class Item
{
    protected $ID, $ID_Proizvod, $ID_Ducan, $Kolicina, $ZaPlatiti;

    function __construct( $ID, $ID_Proizvod, $ID_Ducan, $Kolicina, $ZaPlatiti )
    {
        $this->ID = $ID;
        $this->ID_Proizvod = $ID_Proizvod;
        $this->ID_Ducan = $ID_Ducan;
        $this->Kolicina = $Kolicina;
        $this->ZaPlatiti = $ZaPlatiti;
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
