<?php

require_once('../Models/DB.php');
require_once('../Models/Tarea.php');
require_once('../Models/Response.php');

$response = new Response();

try {

    if( $_SERVER['REQUEST_METHOD'] !== 'GET' )
        throw new Exception('Método HTTP no permitido.', 405 );

    $connection = DB::getConnection();

    $stringSQL = 'SELECT id, titulo, descripcion, DATE_FORMAT( fecha_limite, "%Y-%m-%d %H:%i") fecha_limite ,completada, categoria_id FROM tareas';

    if( isset( $_GET['categoria_id'] ) )    {
        $query = $connection->prepare( $stringSQL . ' WHERE categoria_id = :categoria_id');

        if( $query->bindParam( ':categoria_id', $_GET['categoria_id'], PDO::PARAM_INT ) )  {
            throw new Exception('Argumento categoria_id no es númerico', 400 );
        }
    }

    else {
        $query = $connection->prepare( $stringSQL );
    }

    $query->execute();

    $tareas = array();

    while( $row = $query->fetch( PDO::FETCH_ASSOC )) {
        $tarea = new Tarea( $row['id'], $row['titulo'], $row['descripcion'], $row['fecha_limite'], $row['completada'], $row['categoria_id']);
        $tareas[] = $tarea->getArray();
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