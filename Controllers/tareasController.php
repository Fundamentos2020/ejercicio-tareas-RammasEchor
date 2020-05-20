<?php

require_once('../Models/DB.php');
require_once('../Models/Categoria.php');
require_once('../Models/Response.php');

$response = new Response();

try {

    $connection = DB::getConnection();
    
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
    
    $response->setHttpStatusCode( 200 );
    $response->setSuccess( true );
    $response->setData( $tareas );

}
catch( Exception $e )   {
    $response->setHttpStatusCode( $e->getCode() );
    $response->addMessage( $e->getMessage() );
}
finally {
    $response->send();
}
?>