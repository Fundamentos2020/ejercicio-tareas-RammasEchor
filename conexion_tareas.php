<?php
header('Access-Control-Allow-Origin: *');

/* Clases */
class Tarea {
    public $_id ;
    public $_titulo ;
    public $_descripcion ;
    public $_fecha_limite ;
    public $_completada ;
    public $_categoria_id ;

    public function __construct( $id, $titulo, $descripcion, $fecha_limite, $completada, $categoria_id )  {
        $this->_id = $id ;
        $this->_titulo = $titulo ;
        $this->_descripcion = $descripcion ;
        $this->_fecha_limite = $fecha_limite ;
        $this->_completada = $completada ;
        $this->_categoria_id = $categoria_id ;
    }
}

/* Funciones */
function dameArregloTareas( $categoria )    {
    try     {
        $connection = dameConexion();
    
        if( $categoria != '*' ) {
            $query = $connection->prepare('SELECT * FROM tareas WHERE categoria_id = :categoria_id');
            $query->bindParam( ':categoria_id', $categoria, PDO::PARAM_INT );
        }

        else {
            $query = $connection->prepare('SELECT * FROM tareas');
        }
        
        $query->execute();
    
        $tareas = array();
    
        while( $row = $query->fetch( PDO::FETCH_ASSOC )) {
            $tarea = new Tarea( $row['id'], $row['titulo'], $row['descripcion'], $row['fecha_limite'], $row['completada'], $row['categoria_id']);
            $tareas[] = $tarea ;
    }
    
        return( $tareas );
    }
    
    catch( PDOException $e )    {
        echo 'Error'. $e ;
    }
}

function dameCategorias()   {
    try     {
        $connection = dameConexion();
    
        $query = $connection->prepare('SELECT * FROM categorias');
        $query->execute();
    
        $categorias = array();
    
        while( $row = $query->fetch( PDO::FETCH_ASSOC )) {
            $categorias[] = [ $row['id'], $row['nombre'] ];
    }
    
        return( $categorias );
    }
    
    catch( PDOException $e )    {
        echo 'Error'. $e ;
    }
}

function dameConexion() {
    try     {
        $dns = 'mysql:host=localhost;dbname=lista_tareas';
        $username = 'root';
        $password = '';

        $connection = new PDO( $dns, $username, $password );
        $connection->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
        $connection->setAttribute( PDO::ATTR_EMULATE_PREPARES, false );

        return( $connection );
    }
    
    catch( PDOException $e )    {
        echo 'Error'. $e ;
    }   
}

/* Main */
    if( isset( $_GET['categoria'] ) )   {
        $tareas = dameArregloTareas( $_GET['categoria'] );
        $json = json_encode( $tareas );
        echo $json ;
    }

    else if( isset( $_GET['categorias'] ) ) {
        $categorias = dameCategorias();
        $json = json_encode( $categorias );
        echo $json ;
    }
?>