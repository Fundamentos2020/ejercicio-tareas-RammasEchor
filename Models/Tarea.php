<?php

class TareaException extends Exception {}

class Tarea {
    /* Constantes de la clase en la base de datos */
    private const TITLE_LEN = 50 ;
    private const INT_SIZE = 2147483647 ;
    private const ID_MIN_VAL = 0 ;
    private const DESC_LEN = 150 ;
    private const ENUM_YES = 'SI' ;
    private const ENUM_NO = 'NO' ;
    

    /*Atributos */
    private $_id ;
    private $_titulo ;
    private $_descripcion ;
    private $_fecha_limite ;
    private $_completada ;
    private $_categoria_id ;

    /* Constructor */
    public function __construct( $id, $titulo, $descripcion, $fecha_limite, $completada, $categoria_id )  {
        $this->_id = $id ;
        $this->_titulo = $titulo ;
        $this->_descripcion = $descripcion ;
        $this->_fecha_limite = $fecha_limite ;
        $this->_completada = $completada ;
        $this->_categoria_id = $categoria_id ;
    }

    /* Getters */
    public function getID() {
        return $this->_id ;
    }

    public function getTitulo() {
        return $this->_titulo ;
    }

    public function getDescripcion()    {
        return $this->_descripcion ;
    }

    public function getFechaLimite()    {
        return $this->_fecha_limite ;
    }

    public function getCompletada() {
        return $this->_completada ;
    }

    public function getCategoriaId()    {
        return $this->_categoria_id ;
    }

    /* Setters */
    public function setID( $id ) {
        if( $id !== null && ( !is_numeric( $id ) || $id <= ID_MIN_VAL || $id >= INT_SIZE || $this->_id !== null ) ) {
            throw TareaException('Error en id de tarea.');
        }

        $this->_id = $id ;
    }

    public function setTitulo( $titulo )    {
        if( titulo === null || strlen( $titulo ) > TITLE_LEN || strlen( $titulo ) <= 0 )  {
            throw TareaException('Error en titulo de tarea');
        }

        $this->_titulo = $titulo ;
    }

    public function setDescripcion( $descripcion )  {
        if( $descripcion !== null || strlen( $descripcion ) > DESC_LEN )    {
            throw TareaException('Error en descripcion de tarea.');
        }

        $this->_descripcion = $descripcion ;
    }

    public function setFechaLimite( $fecha_limite ) {
        $this->_fecha_limite = $fecha_limite ;
    }

    public function setCompletada( $completada )    {
        if( strtoupper( $completada ) != ENUM_YES && strtoupper( $completada ) != ENM_NO )  {
            throw TareaException('Error en campo completada de tarea.');
        }

        $this->_completada = strtoupper( $completada );
    }

    public function setCategoriaId( $categoria_id ) {
        if( !is_numeric( $categoria_id ) || $categoria_id <= ID_MIN_VAL || $categoria_id >= INT_SIZE ) {
            throw TareaException('Error en categoria id de tarea.');
        }

        $this->_categoria_id = $categoria_id ;
    }

    public function getArray()  {
        $tarea = array();

        $tarea['id'] = $this->getID();
        $tarea['titulo'] = $this->getTitulo();
        $tarea['descripcion'] = $this->getDescripcion();
        $tarea['fecha_limite'] = $this->getFechaLimite();
        $tarea['completada'] = $this->getCompletada();
        $tarea['categoria_id'] = $this->getCategoriaId();

        return $tarea ;
    }

}

?>