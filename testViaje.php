<?php

include_once 'BaseDatos.php';
include_once 'Persona.php';
include_once 'Responsable.php';
include_once 'Pasajero.php';
include_once 'Empresa.php';
include_once 'Viaje.php';


class TestViaje
{

    // public function mostrarMenuPrincipal()
    // {
    //     do {
    //         echo "----------<< MENU PRINCIPAL >>------------\n";
    //         echo "1. Menu Empresa\n";
    //         echo "2. Menu Viaje\n";
    //         echo "3. Salir\n";
    //         echo "------------------------------------------\n";
    //         echo "Seleccione una opción: ";
    //         $opcion = trim(fgets(STDIN));

    //         switch ($opcion) {
    //             case 1:
    //                 $this->mostrarMenuEmpresa();
    //                 break;
    //             case 2:
    //                 $this->mostrarMenuViaje();
    //                 break;
    //             case 3:
    //                 echo "Saliendo...\n";
    //                 break;
    //             default:
    //                 echo "Opción no válida, intente nuevamente.\n";
    //                 break;
    //         }
    //     } while ($opcion != 3);
    // }


    public function mostrarMenuPrincipal()
    {
        do {
            echo "----------<< MENU PRINCIPAL >>------------\n";
            echo "1. Menu Empresa\n";
            echo "2. Menu Viaje\n";
            echo "3. Menu Pasajero\n";
            echo "4. Salir\n";
            echo "------------------------------------------\n";
            echo "Seleccione una opción: ";
            $opcion = trim(fgets(STDIN));

            switch ($opcion) {
                case 1:
                    $this->mostrarMenuEmpresa();
                    break;
                case 2:
                    $this->mostrarMenuViaje();
                    break;
                case 3:
                    $this->mostrarMenuPasajero();
                    break;
                case 4:
                    echo "Saliendo...\n";
                    break;
                default:
                    echo "Opción no válida, intente nuevamente.\n";
                    break;
            }
        } while ($opcion != 4);
    }

    public function mostrarMenuPasajero()
    {
        do {
            echo "----------<< MENU PASAJEROS >>------------\n";
            echo "1. Insertar Pasajero\n";
            echo "2. Buscar Pasajero\n";
            echo "3. Modificar Pasajero\n";
            echo "4. Eliminar Pasajero\n";
            echo "5. Listar Pasajeros\n";
            echo "6. Salir\n";
            echo "----------------------\n";
            echo "Seleccione una opción: ";
            $opcion = trim(fgets(STDIN));

            switch ($opcion) {
                case 1:
                    $this->insertarPasajero();
                    break;
                case 2:
                    $this->buscarPasajero();
                    break;
                case 3:
                    $this->modificarPasajero();
                    break;
                case 4:
                    $this->eliminarPasajero();
                    break;
                case 5:
                    $this->listarPasajeros();
                    break;
                case 6:
                    echo "Saliendo...\n";
                    break;
                default:
                    echo "Opción no válida, intente nuevamente.\n";
                    break;
            }
        } while ($opcion != 6);
    }

    public function insertarPasajero() {
        echo "\n***********************************" . "\n";
        echo "Ingrese el DNI del pasajero: ";
        $nroDoc = trim(fgets(STDIN));
        echo "Ingrese el ID del viaje al que desea agregar al pasajero: ";
        $idViaje = trim(fgets(STDIN));
    
        $pasajeroExistente = new Pasajero();
        $encontrado = $pasajeroExistente->buscar($nroDoc);
    
        if ($encontrado) {
            // Verificar si el pasajero está asociado al mismo viaje
            if ($pasajeroExistente->getViaje()->getIdViaje() == $idViaje) {
                echo "El pasajero con DNI $nroDoc ya está registrado en el viaje a ".$pasajeroExistente->getViaje()->getDestino().".\n";
            } else {
                echo "El pasajero con DNI $nroDoc ya está asociado a otro vuelo.\n";
            }
        } else {
            // Pasajero no existe, proceder con la inserción como nuevo pasajero
            echo "Ingrese el nombre del pasajero: ";
            $nombre = trim(fgets(STDIN));
            echo "Ingrese el apellido del pasajero: ";
            $apellido = trim(fgets(STDIN));
            echo "Ingrese el número de asiento: ";
            $nroAsiento = trim(fgets(STDIN));
            echo "Ingrese el número de ticket: ";
            $nroTicket = trim(fgets(STDIN));
            echo "Ingrese el número de telefono: ";
            $telefono = trim(fgets(STDIN));
    
            $pasajero = new Pasajero();
            $unViaje = new Viaje();
    
            if ($unViaje->buscar($idViaje)) {
                $pasajero->cargar($nroDoc, $nombre, $apellido, $telefono, $unViaje, $nroAsiento, $nroTicket);
                if ($pasajero->insertar()) {
                    echo "Pasajero insertado correctamente.\n";
                } else {
                    echo "Error al insertar el pasajero: " . $pasajero->getMensaje() . "\n";
                }
            } else {
                echo "El viaje con el ID proporcionado no existe.\n";
            }
        }
    
        echo "\n***********************************" . "\n";
    }
    
    
    


    public function buscarPasajero()
    {
        echo "Ingrese el número de documento del pasajero a buscar: ";
        $id = trim(fgets(STDIN));

        $pasajero = new Pasajero();
        echo "\n***********************************" . "\n";
        if ($pasajero->buscar($id)) {
            echo $pasajero;
        } else {
            echo "Pasajero no encontrado." . "\n";
        }
        echo "\n***********************************" . "\n";
    }

    public function modificarPasajero()
{
    echo "Ingrese el número de documento del pasajero a modificar: ";
    $nroDoc = trim(fgets(STDIN));

    $pasajero = new Pasajero();
    echo "\n***********************************" . "\n";
    if ($pasajero->buscar($nroDoc)) {
        echo "Pasajero encontrado:\n" . $pasajero;
        echo "\n***********************************" . "\n";
        
        // Solicitar y actualizar los datos modificables
        echo "Ingrese el nuevo número de asiento (deje vacío para mantener el actual): ";
        $nroAsiento = trim(fgets(STDIN));
        if (!empty($nroAsiento)) {
            $pasajero->setNroAsiento($nroAsiento);
        }

        echo "Ingrese el nuevo número de ticket (deje vacío para mantener el actual): ";
        $nroTicket = trim(fgets(STDIN));
        if (!empty($nroTicket)) {
            $pasajero->setNroTicket($nroTicket);
        }

        if ($pasajero->modificar()) {
            echo "Pasajero modificado correctamente.\n";
        } else {
            echo "Error al modificar el pasajero: " . $pasajero->getMensaje() . "\n";
        }

    } else {
        echo "Pasajero no encontrado." . "\n";
    }
    echo "\n***********************************" . "\n";
}



public function eliminarPasajero()
{
    echo "Ingrese el número de viaje del pasajero a eliminar: ";
    $idViaje = trim(fgets(STDIN));
    echo "Ingrese el número de documento del pasajero a eliminar: ";
    $nroDoc = trim(fgets(STDIN));

    $pasajero = new Pasajero();
    $encontrado = $pasajero->buscar($nroDoc);

    if ($encontrado && $pasajero->getViaje()->getIdViaje() == $idViaje) {
        echo "\n*********** <<PASAJERO A ELIMINAR>> ***********" . "\n";
        echo "Pasajero encontrado:\n" . $pasajero . "\n";
        echo "***********************************************" . "\n";
        echo "¿Está seguro que desea eliminar este pasajero? (s/n): ";
        $confirmacion = trim(fgets(STDIN));

        if (strtolower($confirmacion) == 's') {
            if ($pasajero->eliminar()) {
                echo "Pasajero eliminado correctamente.\n";
            } else {
                echo "Error al eliminar el pasajero: " . $pasajero->getMensaje() . "\n";
            }
        } else {
            echo "Eliminación cancelada.\n";
        }
    } else {
        if (!$encontrado) {
            echo "El pasajero con número de documento $nroDoc no está registrado en ningún vuelo.\n";
        } else {
            echo "El pasajero con número de documento $nroDoc no está registrado en el vuelo N° $idViaje" . " con destino a " . $pasajero->getViaje()->getDestino() . "\n" ;
        }
    }

    echo "\n***********************************" . "\n";
}



public function listarPasajeros() {
    echo "Ingrese el ID del viaje para listar los pasajeros (o deje vacío para listar todos): ";
    $idViaje = trim(fgets(STDIN));

    $pasajero = new Pasajero();
    $pasajeros = [];

    if (!empty($idViaje)) {
        // Listar pasajeros para un viaje específico
        $pasajeros = $pasajero->listar("idViaje = $idViaje");
    } else {
        // Listar todos los pasajeros
        $pasajeros = $pasajero->listar();
    }

    if (count($pasajeros) > 0) {
        if (!empty($idViaje)) {
            echo "\n<<<<<<<<<<<< LISTADO DE PASAJEROS PARA EL VIAJE $idViaje >>>>>>>>>>>>" . "\n";
        } else {
            echo "\n<<<<<<<<<<<< LISTADO DE TODOS LOS PASAJEROS >>>>>>>>>>>>" . "\n";
        }
        
        foreach ($pasajeros as $pas) {
            echo $pas . "\n";
        }
    } else {
        if (!empty($idViaje)) {
            echo "No hay pasajeros registrados para el viaje $idViaje.\n";
        } else {
            echo "No hay pasajeros registrados.\n";
        }
    }
    echo "<<<<<<<<<<<< FIN DE LISTADO >>>>>>>>>>>>" . "\n";
    echo "\n";
}



    public function mostrarMenuEmpresa()
    {
        do {
            echo "----------<< MENU EMPRESAS >>------------\n";
            echo "1. Insertar Empresa\n";
            echo "2. Buscar Empresa\n";
            echo "3. Modificar Empresa\n";
            echo "4. Eliminar Empresa\n";
            echo "5. Listar Empresas\n";
            echo "6. Salir\n";
            echo "----------------------\n";
            echo "Seleccione una opción: ";
            $opcion = trim(fgets(STDIN));

            switch ($opcion) {
                case 1:
                    $this->insertarEmpresa();
                    break;
                case 2:
                    $this->buscarEmpresa();
                    break;
                case 3:
                    $this->modificarEmpresa();
                    break;
                case 4:
                    $this->eliminarEmpresa();
                    break;
                case 5:
                    $this->listarEmpresas();
                    break;
                case 6:
                    echo "Saliendo...\n";
                    break;
                default:
                    echo "Opción no válida, intente nuevamente.\n";
                    break;
            }
        } while ($opcion != 6);
    }

    public function insertarEmpresa()
    {
        echo "\n***********************************" . "\n";
        echo "Ingrese el nombre de la empresa: ";
        $nombre = trim(fgets(STDIN));
        echo "Ingrese la dirección de la empresa: ";
        $direccion = trim(fgets(STDIN));

        $empresa = new Empresa();
        $empresa->cargar($nombre, $direccion);
        if ($empresa->insertar()) {
            echo "Empresa insertada correctamente.\n";
        } else {
            echo "Error al insertar la empresa: " . $empresa->getMensaje() . "\n";
        }
        echo "\n***********************************" . "\n";
    }

    public function buscarEmpresa()
    {
        echo "Ingrese el ID de la empresa a buscar: ";
        $id = trim(fgets(STDIN));

        $empresa = new Empresa();
        echo "\n***********************************" . "\n";
        if ($empresa->buscar($id)) {
            echo $empresa;
        } else {
            echo "Empresa no encontrada." . "\n";
        }
        echo "\n***********************************" . "\n";
    }

    public function modificarEmpresa()
    {
        echo "Ingrese el ID de la empresa a modificar: ";
        $id = trim(fgets(STDIN));

        $empresa = new Empresa();
        echo "\n***********************************" . "\n";
        if ($empresa->buscar($id)) {
            echo "Empresa encontrada:\n" . $empresa;
            echo "\n***********************************" . "\n";
            echo "Ingrese el nuevo nombre de la empresa: ";
            $nombre = trim(fgets(STDIN));
            echo "Ingrese la nueva dirección de la empresa: ";
            $direccion = trim(fgets(STDIN));

            $empresa->setNombre($nombre);
            $empresa->setDireccion($direccion);
            if ($empresa->modificar()) {
                echo "Empresa modificada correctamente.\n";
            } else {
                echo "Error al modificar la empresa: " . $empresa->getMensaje() . "\n";
            }
        } else {
            echo "Empresa no encontrada." . "\n";
        }
        echo "\n***********************************" . "\n";
    }


    public function eliminarEmpresa()
    {
        echo "Ingrese el ID de la empresa a eliminar: ";
        $id = trim(fgets(STDIN));

        $empresa = new Empresa();
        echo "\n*********** <<EMPPRESA A ELIMINAR>> ***********" . "\n";
        if ($empresa->buscar($id)) {
            echo "Empresa encontrada:\n" . $empresa . "\n";
            echo "***********************************************" . "\n";
            echo "¿Está seguro que desea eliminar esta empresa? (s/n): ";
            $confirmacion = trim(fgets(STDIN));

            if (strtolower($confirmacion) == 's') {
                if ($empresa->eliminar()) {
                    echo "Empresa eliminada correctamente.\n";
                } else {
                    echo "Error al eliminar la empresa: " . $empresa->getMensaje() . "\n";
                }
            } else {
                echo "Eliminación cancelada.\n";
            }
        } else {
            echo "Empresa no encontrada: " . $empresa->getMensaje() . "\n";
        }
        echo "\n***********************************" . "\n";
    }


    public function listarEmpresas()
    {
        $empresa = new Empresa();
        $empresas = $empresa->listar();

        if (count($empresas) > 0) {
            echo "\n<<<<<<<<<<<< LISTADO DE EMPRESAS >>>>>>>>>>>>" . "\n";
            foreach ($empresas as $emp) {
                echo $emp . "\n";
            }
        } else {
            echo "No hay empresas registradas.\n";
        }
        echo "<<<<<<<<<<<< FIN DE LISTADO >>>>>>>>>>>>" . "\n";
        echo "\n";
    }

    public function mostrarMenuViaje()
    {
        do {
            echo "----------<< MENU VIAJES >>------------\n";
            echo "1. Ingresar un Viaje\n";
            echo "2. Buscar un Viaje\n";
            echo "3. Modificar un Viaje\n";
            echo "4. Eliminar un Viaje\n";
            echo "5. Listar Viajes\n";
            echo "6. Salir\n";
            echo "----------------------\n";
            echo "Opcion: ";
            $opcion = trim(fgets(STDIN));
            switch ($opcion) {
                case 1:
                    $this->insertarViaje();
                    break;
                case 2:
                    $this->buscarViaje();
                    break;
                case 3:
                    $this->modificarViaje();
                    break;
                case 4:
                    $this->eliminarViaje();
                    break;
                case 5:
                    $this->listarViajes();
                    break;
                case 6:
                    echo "Saliendo...\n";
                    break;
                default:
                    echo "Opción no válida, intente nuevamente.\n";
                    break;
            }
        } while ($opcion != 6);
    }

    public function insertarViaje() {
        echo "\n***********************************" . "\n";
        echo "Ingrese el destino: ";
        $destino = trim(fgets(STDIN));
        echo "Ingrese la cantidad maxima de pasajeros: ";
        $cantMaxPasajeros = trim(fgets(STDIN));
        echo "Ingrese el ID de la empresa: ";
        $idEmpresa = trim(fgets(STDIN));
        echo "Ingrese el numero de empleado del Responsable a cargo: ";
        $numEmpleado = trim(fgets(STDIN));
        echo "Ingrese el costo del viaje: ";
        $importe = trim(fgets(STDIN));
    
        $unaEmpresa = new Empresa();
        $unResponsable = new Responsable();
    
        if ($unaEmpresa->buscar($idEmpresa)) {
            if ($unResponsable->buscar($numEmpleado)) {
                $unViaje = new Viaje();
                $unViaje->cargar($destino, $cantMaxPasajeros, $importe, 0, $unaEmpresa, $unResponsable, array());
                if ($unViaje->insertar()) {
                    echo "Viaje insertado correctamente.\n";
                } else {
                    echo "Error al insertar el Viaje: " . $unViaje->getMensaje() . "\n";
                }
            } else {
                echo "No se encontró al responsable. Se procederá a registrar uno nuevo.\n";
                echo "Ingrese el número de documento del responsable: ";
                $nroDocumento = trim(fgets(STDIN));
                echo "Ingrese el nombre del responsable: ";
                $nombre = trim(fgets(STDIN));
                echo "Ingrese el apellido del responsable: ";
                $apellido = trim(fgets(STDIN));
                echo "Ingrese el teléfono del responsable: ";
                $telefono = trim(fgets(STDIN));
                echo "Ingrese el número de licencia del responsable: ";
                $numeroLicencia = trim(fgets(STDIN));
    
                $unResponsable->cargar($nroDocumento, $nombre, $apellido, $telefono, $numeroLicencia);
    
                if ($unResponsable->insertar()) {
                    echo "Responsable registrado correctamente.\n";
                    
                    if ($unResponsable->buscarPorDocumento($nroDocumento)) {
                        $unViaje = new Viaje();
                        $unViaje->cargar($destino, $cantMaxPasajeros, $importe, 0, $unaEmpresa, $unResponsable, array());
                        if ($unViaje->insertar()) {
                            echo "Viaje insertado correctamente.\n";
                        } else {
                            echo "Error al insertar el Viaje: " . $unViaje->getMensaje() . "\n";
                        }
                    } else {
                        echo "Error al recuperar el numeroEmpleado del responsable.\n";
                    }
                } else {
                    echo "Error al registrar el Responsable: " . $unResponsable->getMensaje() . "\n";
                }
            }
        } else {
            echo "No se encontró a la empresa\n";
        }
        echo "\n***********************************" . "\n";
    }
    
    
    

    public function buscarViaje()
    {
        echo "Ingrese el ID del Viaje a buscar: ";
        $idViaje = trim(fgets(STDIN));
        $unViaje = new Viaje();
        echo "\n***********************************" . "\n";
        if ($unViaje->buscar($idViaje)) {
            echo $unViaje;
        } else {
            echo "Viaje no encontrado." . "\n";
        }
        echo "\n***********************************" . "\n";
    }

    public function modificarViaje()
{
    echo "Ingrese el ID del Viaje a modificar: ";
    $idViaje = trim(fgets(STDIN));
    $unViaje = new Viaje();
    echo "\n***********************************" . "\n";
    if ($unViaje->buscar($idViaje)) {
        echo "Viaje encontrado:\n" . $unViaje;
        echo "\n***********************************" . "\n";
        echo "Ingrese el nuevo destino (deje vacío para mantener el actual): ";
        $destino = trim(fgets(STDIN));
        if ($destino == "") {
            $destino = $unViaje->getDestino();
        }
        echo "Ingrese la nueva cantidad máxima de pasajeros (deje vacío para mantener el actual): ";
        $cantMaxPasajeros = trim(fgets(STDIN));
        if ($cantMaxPasajeros == "") {
            $cantMaxPasajeros = $unViaje->getCantMaxPasajeros();
        }
        echo "Ingrese el nuevo número de empleado del Responsable (deje vacío para mantener el actual): ";
        $numEmpleado = trim(fgets(STDIN));
        if ($numEmpleado == "") {
            $numEmpleado = $unViaje->getResponsable()->getNumeroEmpleado();
        }
        echo "Ingrese el nuevo ID de la empresa (deje vacío para mantener el actual): ";
        $idEmpresa = trim(fgets(STDIN));
        if ($idEmpresa == "") {
            $idEmpresa = $unViaje->getEmpresa()->getIdEmpresa();
        }
        echo "Ingrese el nuevo costo (deje vacío para mantener el actual): ";
        $importe = trim(fgets(STDIN));
        if ($importe == "") {
            $importe = $unViaje->getImporte();
        }
        echo "Ingrese el nuevo costo abonado (deje vacío para mantener el actual): ";
        $costoAbonado = trim(fgets(STDIN));
        if ($costoAbonado == "") {
            $costoAbonado = $unViaje->getCostosAbonados();
        }

        $unaEmpresa = new Empresa();
        if ($unaEmpresa->buscar($idEmpresa)) {
            $unResponsable = new Responsable();
            if ($unResponsable->buscar($numEmpleado)) {
                $unViaje->cargar($destino, $cantMaxPasajeros, $importe, $costoAbonado, $unaEmpresa, $unResponsable, $unViaje->getColeccionPasajeros());
                if ($unViaje->modificar()) {
                    echo "Viaje modificado correctamente.\n";
                } else {
                    echo "Error al modificar el Viaje: " . $unViaje->getMensaje() . "\n";
                }
            } else {
                echo "Empleado no encontrado\n";
            }
        } else {
            echo "Empresa no encontrada\n";
        }
    } else {
        echo "Viaje no encontrado.\n";
    }
    echo "\n***********************************" . "\n";
}

    public function eliminarViaje()
    {
        echo "Ingrese el ID del Viaje a eliminar: ";
        $idViaje = trim(fgets(STDIN));
        $unViaje = new Viaje();
        echo "\n*********** <<VIAJE A ELIMINAR>> ***********" . "\n";
        if ($unViaje->buscar($idViaje)) {
            echo "Viaje encontrado:\n" . $unViaje . "\n";
            echo "***********************************************" . "\n";
            echo "¿Está seguro que desea eliminar este Viaje? Recuerde que los pasajeros asociados a este viaje no se eliminaran y deberá reasignarles un nuevo vuelo. El ID viaje asignado sera NULO (s/n): ";
            $confirmacion = trim(fgets(STDIN));
            if (strtolower($confirmacion) == 's') {
                if ($unViaje->eliminar()) {
                    echo "Viaje eliminado correctamente.\n";
                } else {
                    echo "Error al eliminar el viaje: " . $unViaje->getMensaje() . "\n";
                }
            } else {
                echo "Eliminación cancelada.\n";
            }
        } else {
            echo "Viaje no encontrado\n";
        }
        echo "\n***********************************" . "\n";
    }

    public function listarViajes()
    {
        $unViaje = new Viaje();
        $colViajes = $unViaje->listar();
        if (count($colViajes) > 0) {
            echo "\n<<<<<<<<<<< LISTADO DE VIAJES >>>>>>>>>>>>" . "\n";
            foreach ($colViajes as $viaje) {
                echo $viaje . "\n";
            }
        } else {
            echo "No hay Viajes registrados.\n";
        }
        echo "<<<<<<<<<<<< FIN DE LISTADO >>>>>>>>>>>>" . "\n";
        echo "\n";
    }
}

// Menú
$test = new TestViaje();
$test->mostrarMenuPrincipal();


