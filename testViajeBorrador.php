<?php

include_once 'BaseDatos.php';
include_once 'Persona.php';
include_once 'Responsable.php';
include_once 'Pasajero.php';
include_once 'Empresa.php';
include_once 'Viaje.php';

class TestViaje
{
    public function mostrarMenuPrincipal()
    {
        do {
            echo "----------<< MENU PRINCIPAL >>------------\n";
            echo "1. Menu Empresa\n";
            echo "2. Menu Viaje\n";
            echo "3. Menu Pasajero\n";
            echo "4. Menu Responsable\n";
            echo "5. Salir\n";
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
                    $this->mostrarMenuResponsable();
                    break;
                case 5:
                    echo "Saliendo...\n";
                    break;
                default:
                    echo "Opción no válida, intente nuevamente.\n";
                    break;
            }
        } while ($opcion != 5);
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

    private function insertarEmpresa()
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

    private function buscarEmpresa()
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

    private function modificarEmpresa()
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

    private function eliminarEmpresa()
    {
        echo "Ingrese el ID de la empresa a eliminar: ";
        $id = trim(fgets(STDIN));

        $empresa = new Empresa();
        echo "\n*********** <<EMPRESA A ELIMINAR>> ***********" . "\n";
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

    private function listarEmpresas()
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
            echo "Opción: ";
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

    private function insertarViaje()
    {
        echo "\n***********************************" . "\n";
        echo "Ingrese el destino: ";
        $destino = trim(fgets(STDIN));
        echo "Ingrese la cantidad máxima de pasajeros: ";
        $cantMaxPasajeros = trim(fgets(STDIN));
        echo "Ingrese el ID de la empresa: ";
        $idEmpresa = trim(fgets(STDIN));
        echo "Ingrese el número de empleado del Responsable a cargo: ";
        $numEmpleado = trim(fgets(STDIN));
        echo "Ingrese el costo del viaje: ";
        $importe = trim(fgets(STDIN));

        $unViaje = new Viaje();
        $unViaje->cargar($destino, $cantMaxPasajeros, $importe, $idEmpresa, $numEmpleado);
        if ($unViaje->insertar()) {
            echo "Viaje insertado correctamente.\n";
        } else {
            echo "Error al insertar el Viaje: " . $unViaje->getMensaje() . "\n";
        }
        echo "\n***********************************" . "\n";
    }

    private function buscarViaje()
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

    private function modificarViaje()
    {
        echo "Ingrese el ID del Viaje a modificar: ";
        $idViaje = trim(fgets(STDIN));
        $unViaje = new Viaje();
        echo "\n***********************************" . "\n";
        if ($unViaje->buscar($idViaje)) {
            echo "Viaje encontrado:\n" . $unViaje;
            echo "\n***********************************" . "\n";
            echo "Ingrese el nuevo destino: ";
            $destino = trim(fgets(STDIN));
            echo "Ingrese la nueva cantidad máxima de pasajeros: ";
            $cantMaxPasajeros = trim(fgets(STDIN));
            echo "Ingrese el nuevo número de empleado del Responsable: ";
            $numEmpleado = trim(fgets(STDIN));
            echo "Ingrese el nuevo ID de la empresa: ";
            $idEmpresa = trim(fgets(STDIN));
            echo "Ingrese el nuevo costo: ";
            $importe = trim(fgets(STDIN));

            $unViaje->setDestino($destino);
            $unViaje->setCantMaxPasajeros($cantMaxPasajeros);
            $unViaje->setNumeroEmpleado($numEmpleado);
            $unViaje->setIdEmpresa($idEmpresa);
            $unViaje->setImporte($importe);

            if ($unViaje->modificar()) {
                echo "Viaje modificado correctamente.\n";
            } else {
                echo "Error al modificar el Viaje: " . $unViaje->getMensaje() . "\n";
            }
        } else {
            echo "Viaje no encontrado.\n";
        }
        echo "\n***********************************" . "\n";
    }

    private function eliminarViaje()
    {
        echo "Ingrese el ID del Viaje a eliminar: ";
        $idViaje = trim(fgets(STDIN));
        $unViaje = new Viaje();
        echo "\n*********** <<VIAJE A ELIMINAR>> ***********" . "\n";
        if ($unViaje->buscar($idViaje)) {
            echo "Viaje encontrado:\n" . $unViaje . "\n";
            echo "***********************************************" . "\n";
            echo "¿Está seguro que desea eliminar este Viaje? (s/n): ";
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

    private function listarViajes()
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

    private function insertarPasajero()
    {
        echo "\n***********************************" . "\n";
        echo "Ingrese el número de documento del pasajero: ";
        $nroDocumento = trim(fgets(STDIN));
        echo "Ingrese el nombre del pasajero: ";
        $nombre = trim(fgets(STDIN));
        echo "Ingrese el apellido del pasajero: ";
        $apellido = trim(fgets(STDIN));
        echo "Ingrese el teléfono del pasajero: ";
        $telefono = trim(fgets(STDIN));
        echo "Ingrese el ID del viaje: ";
        $idViaje = trim(fgets(STDIN));
        echo "Ingrese el número de asiento: ";
        $nroAsiento = trim(fgets(STDIN));
        echo "Ingrese el número de ticket: ";
        $nroTicket = trim(fgets(STDIN));

        $pasajero = new Pasajero();
        $pasajero->cargar($nroDocumento, $nombre, $apellido, $telefono, $idViaje, $nroAsiento, $nroTicket);
        if ($pasajero->insertar()) {
            echo "Pasajero insertado correctamente.\n";
        } else {
            echo "Error al insertar el pasajero: " . $pasajero->getMensaje() . "\n";
        }
        echo "\n***********************************" . "\n";
    }

    private function buscarPasajero()
    {
        echo "Ingrese el número de documento del pasajero a buscar: ";
        $nroDocumento = trim(fgets(STDIN));
        $pasajero = new Pasajero();
        echo "\n***********************************" . "\n";
        if ($pasajero->buscar($nroDocumento)) {
            echo $pasajero;
        } else {
            echo "Pasajero no encontrado." . "\n";
        }
        echo "\n***********************************" . "\n";
    }

    private function modificarPasajero()
    {
        echo "Ingrese el número de documento del pasajero a modificar: ";
        $nroDocumento = trim(fgets(STDIN));
        $pasajero = new Pasajero();
        echo "\n***********************************" . "\n";
        if ($pasajero->buscar($nroDocumento)) {
            echo "Pasajero encontrado:\n" . $pasajero;
            echo "\n***********************************" . "\n";
            echo "Ingrese el nuevo nombre del pasajero: ";
            $nombre = trim(fgets(STDIN));
            echo "Ingrese el nuevo apellido del pasajero: ";
            $apellido = trim(fgets(STDIN));
            echo "Ingrese el nuevo teléfono del pasajero: ";
            $telefono = trim(fgets(STDIN));
            echo "Ingrese el nuevo ID del viaje: ";
            $idViaje = trim(fgets(STDIN));
            echo "Ingrese el nuevo número de asiento: ";
            $nroAsiento = trim(fgets(STDIN));
            echo "Ingrese el nuevo número de ticket: ";
            $nroTicket = trim(fgets(STDIN));

            $pasajero->setNombre($nombre);
            $pasajero->setApellido($apellido);
            $pasajero->setTelefono($telefono);
            $pasajero->setIdViaje($idViaje);
            $pasajero->setNroAsiento($nroAsiento);
            $pasajero->setNroTicket($nroTicket);

            if ($pasajero->modificar()) {
                echo "Pasajero modificado correctamente.\n";
            } else {
                echo "Error al modificar el pasajero: " . $pasajero->getMensaje() . "\n";
            }
        } else {
            echo "Pasajero no encontrado.\n";
        }
        echo "\n***********************************" . "\n";
    }

    private function eliminarPasajero()
    {
        echo "Ingrese el número de documento del pasajero a eliminar: ";
        $nroDocumento = trim(fgets(STDIN));
        $pasajero = new Pasajero();
        echo "\n*********** <<PASAJERO A ELIMINAR>> ***********" . "\n";
        if ($pasajero->buscar($nroDocumento)) {
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
            echo "Pasajero no encontrado\n";
        }
        echo "\n***********************************" . "\n";
    }

    private function listarPasajeros()
    {
        $pasajero = new Pasajero();
        $colPasajeros = $pasajero->listar();
        if (count($colPasajeros) > 0) {
            echo "\n<<<<<<<<<<< LISTADO DE PASAJEROS >>>>>>>>>>>>" . "\n";
            foreach ($colPasajeros as $pas) {
                echo $pas . "\n";
            }
        } else {
            echo "No hay pasajeros registrados.\n";
        }
        echo "<<<<<<<<<<<< FIN DE LISTADO >>>>>>>>>>>>" . "\n";
        echo "\n";
    }

    public function mostrarMenuResponsable()
    {
        do {
            echo "----------<< MENU RESPONSABLES >>------------\n";
            echo "1. Insertar Responsable\n";
            echo "2. Buscar Responsable\n";
            echo "3. Modificar Responsable\n";
            echo "4. Eliminar Responsable\n";
            echo "5. Listar Responsables\n";
            echo "6. Salir\n";
            echo "----------------------\n";
            echo "Seleccione una opción: ";
            $opcion = trim(fgets(STDIN));

            switch ($opcion) {
                case 1:
                    $this->insertarResponsable();
                    break;
                case 2:
                    $this->buscarResponsable();
                    break;
                case 3:
                    $this->modificarResponsable();
                    break;
                case 4:
                    $this->eliminarResponsable();
                    break;
                case 5:
                    $this->listarResponsables();
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

    private function insertarResponsable()
    {
        echo "\n***********************************" . "\n";
        echo "Ingrese el número de empleado: ";
        $numEmpleado = trim(fgets(STDIN));
        echo "Ingrese el número de licencia: ";
        $numLicencia = trim(fgets(STDIN));
        echo "Ingrese el nombre: ";
        $nombre = trim(fgets(STDIN));
        echo "Ingrese el apellido: ";
        $apellido = trim(fgets(STDIN));

        $responsable = new Responsable();
        $responsable->cargar($numEmpleado, $numLicencia, $nombre, $apellido);
        if ($responsable->insertar()) {
            echo "Responsable insertado correctamente.\n";
        } else {
            echo "Error al insertar el responsable: " . $responsable->getMensaje() . "\n";
        }
        echo "\n***********************************" . "\n";
    }

    private function buscarResponsable()
    {
        echo "Ingrese el número de empleado del responsable a buscar: ";
        $numEmpleado = trim(fgets(STDIN));
        $responsable = new Responsable();
        echo "\n***********************************" . "\n";
        if ($responsable->buscar($numEmpleado)) {
            echo $responsable;
        } else {
            echo "Responsable no encontrado." . "\n";
        }
        echo "\n***********************************" . "\n";
    }

    private function modificarResponsable()
    {
        echo "Ingrese el número de empleado del responsable a modificar: ";
        $numEmpleado = trim(fgets(STDIN));
        $responsable = new Responsable();
        echo "\n***********************************" . "\n";
        if ($responsable->buscar($numEmpleado)) {
            echo "Responsable encontrado:\n" . $responsable;
            echo "\n***********************************" . "\n";
            echo "Ingrese el nuevo número de licencia: ";
            $numLicencia = trim(fgets(STDIN));
            echo "Ingrese el nuevo nombre: ";
            $nombre = trim(fgets(STDIN));
            echo "Ingrese el nuevo apellido: ";
            $apellido = trim(fgets(STDIN));

            $responsable->setNumeroLicencia($numLicencia);
            $responsable->setNombre($nombre);
            $responsable->setApellido($apellido);

            if ($responsable->modificar()) {
                echo "Responsable modificado correctamente.\n";
            } else {
                echo "Error al modificar el responsable: " . $responsable->getMensaje() . "\n";
            }
        } else {
            echo "Responsable no encontrado.\n";
        }
        echo "\n***********************************" . "\n";
    }

    private function eliminarResponsable()
    {
        echo "Ingrese el número de empleado del responsable a eliminar: ";
        $numEmpleado = trim(fgets(STDIN));
        $responsable = new Responsable();
        echo "\n*********** <<RESPONSABLE A ELIMINAR>> ***********" . "\n";
        if ($responsable->buscar($numEmpleado)) {
            echo "Responsable encontrado:\n" . $responsable . "\n";
            echo "***********************************************" . "\n";
            echo "¿Está seguro que desea eliminar este responsable? (s/n): ";
            $confirmacion = trim(fgets(STDIN));
            if (strtolower($confirmacion) == 's') {
                if ($responsable->eliminar()) {
                    echo "Responsable eliminado correctamente.\n";
                } else {
                    echo "Error al eliminar el responsable: " . $responsable->getMensaje() . "\n";
                }
            } else {
                echo "Eliminación cancelada.\n";
            }
        } else {
            echo "Responsable no encontrado\n";
        }
        echo "\n***********************************" . "\n";
    }

    private function listarResponsables()
    {
        $responsable = new Responsable();
        $colResponsables = $responsable->listar();
        if (count($colResponsables) > 0) {
            echo "\n<<<<<<<<<<< LISTADO DE RESPONSABLES >>>>>>>>>>>>" . "\n";
            foreach ($colResponsables as $resp) {
                echo $resp . "\n";
            }
        } else {
            echo "No hay responsables registrados.\n";
        }
        echo "<<<<<<<<<<<< FIN DE LISTADO >>>>>>>>>>>>" . "\n";
        echo "\n";
    }
}

// Menú
$test = new TestViaje();
$test->mostrarMenuPrincipal();
