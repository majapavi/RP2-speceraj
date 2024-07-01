<?php
class Recenzija2
{
    protected $User, $ID_Ducan, $Ducan, $Ducan_Logo, $Ocjena, $Tekst;

    function __construct( $User, $ID_Ducan, $Ducan, $Ducan_Logo, $Ocjena, $Tekst )
    {
        $this->User = $User;
        $this->ID_Ducan = $ID_Ducan;
        $this->Ducan = $Ducan;
        $this->Ducan_Logo = $Ducan_Logo;
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
