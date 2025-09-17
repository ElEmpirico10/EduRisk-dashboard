<?php
require __DIR__ . '/../../public/correo/correo.php';

$resultado = recuperarPassword(
    'brayandejesusecheberriacastro@gmail.com',
    'brallan',
    'brallan384958'
);

if ($resultado === true) {
    echo 'Correo enviado correctamente 🎉';
} else {
    echo $resultado;
}
