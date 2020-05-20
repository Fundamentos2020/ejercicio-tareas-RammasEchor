<?php

class Categoria {
    /* Atributos */
    private $_id ;
    private $_nombre ;

    /* Constructor */
    public function __construct( $id, $nombre ) {
        $this->setID( $id );
        $this->setNombre( $nombre );
    }

    /* Getters */
    public function getID() {
        return $this->_id ;
    }

    public function getNombre() {
        return $this->_nombre ;
    }

    /* Setters */
    public function setID( $id ) {
        $this->_id = $id ;
    }

    public function setNombre( $nombre )    {
        $this->_nombre = $nombre ;
    }

    /* Data to echo */
    public function getArray()  {
        $categoria = array();

        $categoria['id'] = $this->_id ;
        $categoria['nombre'] = $this->_nombre ;

        return $categoria ;
    }
}

?>