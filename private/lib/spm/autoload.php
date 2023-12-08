<?php



spl_autoload_register
(
    function ($name)
    {
        // (Getting the values)
        $parts                      = explode( "\\",  $name );

        $vendor                     = $parts[0];
        $package                    = $parts[1];

        $local_namespace_components = array_slice( $parts, 2 );



        // (Including the file)
        include_once( __DIR__ . "/$vendor/$package/src/" . implode( '/', $local_namespace_components ) . '.php' );
    }
)
;


?>