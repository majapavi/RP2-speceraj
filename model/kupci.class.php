<?php
class Kupac
{
    protected $ID, $Username, $Password_Hash;

    function __construct( $ID, $Username, $Password_Hash )
    {
        $this->ID = $ID;
        $this->Username = $Username;
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
