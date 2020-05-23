 <?php

require_once('../Models/DB.php');
require_once('../Models/Categoria.php');
require_once('../Models/Response.php');

$response = new Response();

try {

    if( $_SERVER['REQUEST_METHOD'] !== 'GET' )
        throw new Exception('Método HTTP no permitido.', 405 );

    $connection = DB::getConnection();

    $query = $connection->prepare('SELECT * FROM categorias');
    $query->execute();

    $categorias = array();

    while( $row = $query->fetch( PDO::FETCH_ASSOC )) {
        $categoria = new Categoria( $row['id'], $row['nombre'] );

        $categorias[] = $categoria->getArray();
    }

    $response->setHttpStatusCode( 200 );
    $response->setSuccess( true );
    $response->setData( $categorias );

}
catch( Exception $e )   {
    $response->setHttpStatusCode( $e->getCode() );
    $response->addMessage( $e->getMessage() );
}
finally {
    $response->send();
}
?>