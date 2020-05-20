<?php

class DatabaseException extends Exception {}

class DB    {
    private static $connection ;

    public static function getConnection()  {
        
        if( self::$connection !== null )    {
            throw new DatabaseException('Error: ya hay una conexión.', 503 );
        }

        $dns = 'mysql:host=localhost;dbname=lista_tareas;charset=utf8';
        $username = 'root';
        $password = '';

        self::$connection = new PDO( $dns, $username, $password );
        self::$connection->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
        self::$connection->setAttribute( PDO::ATTR_EMULATE_PREPARES, false );

        return self::$connection ;
    }
}

?>