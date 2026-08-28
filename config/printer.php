<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Impresora de tickets (ESC/POS)
    |--------------------------------------------------------------------------
    |
    | Nombre de la impresora compartida de Windows que se usa para imprimir los
    | tickets de consumo. Se define por instalacion en el archivo .env.
    |
    | Este valor debe leerse siempre con config("printer.name") y nunca con
    | env("PRINTER_NAME") desde un controlador: cuando la configuracion esta
    | cacheada (php artisan config:cache), env() devuelve null fuera de config/
    | y la impresion falla.
    |
    */

    "name" => env("PRINTER_NAME"),

];
