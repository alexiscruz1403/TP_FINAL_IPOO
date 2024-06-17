<?php

include_once 'BaseDatos.php';
include_once 'Persona.php';
include_once 'Persona.php';
include_once 'Responsable.php';
include_once 'Pasajero.php';
include_once 'Empresa.php';
include_once 'Viaje.php';


class TestViaje
{


    public function mostrarMenu()
    {
        do {
            echo "----------<< MENU >>------------\n";
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
        $empresa->cargar(0, $nombre, $direccion);
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
}

// Menú
$test = new TestViaje();
$test->mostrarMenu();


