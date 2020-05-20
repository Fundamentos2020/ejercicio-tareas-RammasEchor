<?php
header('Access-Control-Allow-Origin: *');

require_once('Response.php');

/* Clases */


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
    
        $response = new Response();
        $response->setHttpStatusCode( 200 );
        $response->setSuccess( true );
        $response->setData( $tareas );
        $response->send();
        exit();
    }
    
    catch( PDOException $e )    {
        $response = new Response();
        $response->setHttpStatusCode( 500 );
        $response->setSuccess( false );
        $response->addMessage('Algo falló');
        $response->send();
        exit();
    }
}

function dameCategorias()   {
    try     {
        $connection = dameConexion();
    
        $query = $connection->prepare('SELECT * FROM categorias');
        $query->execute();
    
        $categorias = array();
    
        while( $row = $query->fetch( PDO::FETCH_ASSOC )) {
            $categorias[] = new Categorias( $row['id'], $row['nombre'] );
    }
    
        return( $categorias );
    }
    
    catch( PDOException $e )    {
        echo 'Error'. $e ;
    }
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