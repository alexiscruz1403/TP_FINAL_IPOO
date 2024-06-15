<?php
include_once 'BaseDatos.php';
include_once 'Responsable.php';
include_once 'Pasajero.php';
include_once 'Empresa.php';
include_once 'Viaje.php';

//Main

$unPasajero=new Empresa();
$unPasajero->cargar(1,"Flecha Bus","Buenos Aires 321");
$unPasajero->insertar();
$unPasajero->cargar(1,"La Veloz del Norte","Buenos Aires 123");
$unPasajero->insertar();
$unPasajero->cargar(1,"Flecha Bus","Buenos Aires 132");
$unPasajero->insertar();

$unResponsable=new Responsable();
$unResponsable->cargar(1,1,"Alexis","Cruz");
$unResponsable->insertar();
$unResponsable->cargar(1,2,"Juan","Perez");
$unResponsable->insertar();
$unResponsable->cargar(1,3,"Pedro","Juarez");
$unResponsable->insertar();

$unViaje=new Viaje();
$unViaje->cargar(1,"Cipoletti",20,100000,1,1);
$unViaje->insertar();
$unViaje->cargar(1,"General Roca",15,150000,2,2);
$unViaje->insertar();
$unViaje->cargar(1,"Cinco Saltos",25,200000,3,3);
$unViaje->insertar();

$unPasajero=new Pasajero();
$unPasajero->cargar(1,12345678,"Martin","Martinez",123456,1);
$unPasajero->insertar();
$unPasajero->cargar(1,87654321,"Matias","Gonzalez",123456,1);
$unPasajero->insertar();
$unPasajero->cargar(1,11223344,"Mariano","Sanchez",123456,2);
$unPasajero->insertar();
$unPasajero->cargar(1,44332211,"Maria","Estevanez",123456,2);
$unPasajero->insertar();
$unPasajero->cargar(1,18273645,"Martina","Marconi",123456,3);
$unPasajero->insertar();
$unPasajero->cargar(1,81726354,"Juana","Maroni",123456,3);
$unPasajero->insertar();

