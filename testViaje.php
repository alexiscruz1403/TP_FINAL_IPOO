<?php
include_once 'BaseDatos.php';
include_once 'Responsable.php';
include_once 'Pasajero.php';
include_once 'Empresa.php';
include_once 'Viaje.php';

//Main

$unViaje=new Viaje;
$unViaje->buscar(1);
echo $unViaje->getResponsable();