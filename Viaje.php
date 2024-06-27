<?php

class Viaje {
    // Atributos
    private $idViaje;
    private $destino;
    private $cantMaxPasajeros;
    private $importe; // Costo del viaje
    private $costosAbonados; // Suma de los costos abonados por los pasajeros
    private $colPasajeros;
    private $objEmpresa;
    private $objResponsable;
    private $mensaje;

    // Constructor
    public function __construct() {
        $this->idViaje = "";
        $this->destino = "";
        $this->cantMaxPasajeros = "";
        $this->importe = "";
        $this->costosAbonados = "";
        $this->colPasajeros = array();
        $this->mensaje = "";
    }

    public function cargar($unDestino, $unaCantMaxPasajeros, $unImporte, $costosAbonados, $unaEmpresa, $unResponsable, $unaColPasajeros) {
        $this->destino = $unDestino;
        $this->cantMaxPasajeros = $unaCantMaxPasajeros;
        $this->importe = $unImporte;
        $this->costosAbonados = $costosAbonados;
        $this->objEmpresa = $unaEmpresa;
        $this->objResponsable = $unResponsable;
        $this->colPasajeros = $unaColPasajeros;
    }

    // Observadores
    public function getIdViaje() {
        return $this->idViaje;
    }

    public function getDestino() {
        return $this->destino;
    }

    public function getCantMaxPasajeros() {
        return $this->cantMaxPasajeros;
    }

    public function getImporte() {
        return $this->importe;
    }

    public function getCostosAbonados() {
        return $this->costosAbonados;
    }

    public function getEmpresa() {
        return $this->objEmpresa;
    }

    public function getResponsable() {
        return $this->objResponsable;
    }

    public function getColeccionPasajeros() {
        return $this->colPasajeros;
    }

    public function getMensaje() {
        return $this->mensaje;
    }

    public function __toString() {
        return "IdViaje: " . $this->getIdViaje() . "\n" .
               "Destino: " . $this->getDestino() . "\n" .
               "CantMaxPasajeros: " . $this->getCantMaxPasajeros() . "\n" .
               "Importe: " . $this->getImporte() . "\n" .
               "Empresa: \n" . $this->getEmpresa() .
               "Responsable: \n" . $this->getResponsable() .
               "Cantidad Pasajeros: " . count($this->getColeccionPasajeros()) . "\n" .
               "Costos abonados: " . $this->getCostosAbonados() . "\n";
    }

    // Modificadores
    public function setIdViaje($unIdViaje) {
        $this->idViaje = $unIdViaje;
    }

    public function setDestino($unDestino) {
        $this->destino = $unDestino;
    }

    public function setCantMaxPasajeros($unaCantMaxPasajeros) {
        $this->cantMaxPasajeros = $unaCantMaxPasajeros;
    }

    public function setImporte($unImporte) {
        $this->importe = $unImporte;
    }

    public function setCostosAbonados($costosAbonados) {
        $this->costosAbonados = $costosAbonados;
    }

    public function setColeccionPasajeros($unaColeccion) {
        $this->colPasajeros = $unaColeccion;
    }

    public function setEmpresa($unaEmpresa) {
        $this->objEmpresa = $unaEmpresa;
    }

    public function setResponsable($unResponsable) {
        $this->objResponsable = $unResponsable;
    }

    public function setMensaje($unMensaje) {
        $this->mensaje = $unMensaje;
    }

    // Propios

    /**
     * Busca el registro en la tabla viaje donde idViaje coincida con el valor enviado por parametro
     * Retorna true si la encuentra o false en caso contrario
     * @param int $idViaje
     * @return boolean
     */
    public function buscar($idViaje) {
        $base = new BaseDatos();
        $encontrado = false;
        if ($base->iniciar()) {
            $consulta = "SELECT * FROM viaje WHERE idViaje=" . $idViaje;
            if ($base->ejecutar($consulta)) {
                $unaEmpresa = new Empresa();
                $unResponsable = new Responsable();
                $unPasajero = new Pasajero();
                if($registro = $base->registro()) {
                    $unaEmpresa="";
                    $unResponsable="";
                    $destino = $registro['destino'];
                    $cantidadMaxima = $registro['cantMaxPasajeros'];
                    $importe = $registro['importe'];
                    $costosAbonados = $registro['costosAbonados'];
                    $colPasajeros = $unPasajero->listar("idViaje=".$idViaje);
                    $this->cargar($destino, $cantidadMaxima, $importe, $costosAbonados, $unaEmpresa, $unResponsable, $colPasajeros);
                    $this->setIdViaje($idViaje);
                    $encontrado = true;
                }
            } else {
                $this->setMensaje($base->getError());
            }
        } else {
            $this->setMensaje($base->getError());
        }
        return $encontrado;
    }

    /**
     * Agrega la instancia actual como un registro en la base de datos
     * Retorna true si se agregó correctamente o false en caso contrario
     * @return boolean
     */

     public function insertar() {
        $base = new BaseDatos();
        $agregado = false;
        $idEmpresa = $this->getEmpresa()->getIdEmpresa();
        $numeroEmpleado = $this->getResponsable()->getNumeroEmpleado();
        if ($base->iniciar()) {
            // Construir la consulta SQL
            $consulta = "INSERT INTO viaje(destino, cantMaxPasajeros, importe, idEmpresa, numeroEmpleado, costosAbonados) VALUES ('" .
                $this->getDestino() . "', " .
                $this->getCantMaxPasajeros() . ", " .
                $this->getImporte() . ", " .
                $idEmpresa . ", " .   // Asegurar que idEmpresa sea tratado como cadena
                $numeroEmpleado . ", " . // Asegurar que numeroEmpleado sea tratado como cadena
                $this->getCostosAbonados() . ")";
            
            // Ejecutar la consulta SQL
            if ($base->ejecutar($consulta)) {
                $agregado = true;
            } else {
                $this->setMensaje($base->getError());
            }
        } else {
            $this->setMensaje($base->getError());
        }
        return $agregado;
    }
    
    

    /**
     * Elimina el registro donde idViaje coincida con el valor actual de la instancia
     * Retorna true si se eliminó correctamente o false en caso contrario
     * @return boolean
     */
    public function eliminar() {
        $base = new BaseDatos();
        $eliminado = false;
        if ($base->iniciar()) {
            $consulta = "DELETE FROM viaje WHERE idViaje=" . $this->getIdViaje();
            if ($base->ejecutar($consulta)) {
                $eliminado = true;
            } else {
                $this->setMensaje($base->getError());
            }
        } else {
            $this->setMensaje($base->getError());
        }
        return $eliminado;
    }

    /**
     * Modifica el registro donde idViaje coincida con el valor actual de la instancia
     * Retorna true si se modificó correctamente o false en caso contrario
     * @return boolean
     */
    public function modificar() {
        $modificado = false;
        $base = new BaseDatos();
        if ($base->iniciar()) {
            $consulta = "UPDATE viaje SET destino='" . $this->getDestino() .
                        "', cantMaxPasajeros=" . $this->getCantMaxPasajeros() .
                        ", importe=" . $this->getImporte() .
                        ", idEmpresa=" . $this->getEmpresa()->getIdEmpresa() .
                        ", numeroEmpleado=" . $this->getResponsable()->getNumeroEmpleado() .
                        ", costosAbonados=" . $this->getCostosAbonados() .
                        " WHERE idViaje=" . $this->getIdViaje();
            if ($base->ejecutar($consulta)) {
                $modificado = true;
            } else {
                $this->setMensaje($base->getError());
            }
        } else {
            $this->setMensaje($base->getError());
        }
        return $modificado;
    }

    /**
     * Crea una colección con información de todos los viajes
     * Se puede mandar una condición de manera opcional
     * Si no hay registros, devuelve una colección vacía
     * @param string $condicion
     * @return array
     */
    public function listar($condicion = "") {
        $colViajes = array();
        $base = new BaseDatos();
        if ($base->iniciar()) {
            $consulta = "SELECT * FROM viaje";
            if ($condicion != "") {
                $consulta .= " WHERE " . $condicion;
            }
            if ($base->ejecutar($consulta)) {
                while ($registro = $base->registro()) {
                    $unViaje = new Viaje();
                    $unaEmpresa = new Empresa();
                    $unPasajero = new Pasajero();
                    $unResponsable = new Responsable();
                    $unaEmpresa->buscar($registro['idEmpresa']);
                    $unResponsable->buscar($registro['numeroEmpleado']);
                    $colPasajeros = $unPasajero->listar("idViaje=".$registro['idViaje']);
                    $unViaje->cargar(
                        $registro['destino'],
                        $registro['cantMaxPasajeros'],
                        $registro['importe'],
                        $registro['costosAbonados'],
                        $unaEmpresa,
                        $unResponsable,
                        $colPasajeros
                    );
                    $unViaje->setIdViaje($registro['idViaje']);
                    array_push($colViajes, $unViaje);
                }
            } else {
                $this->setMensaje($base->getError());
            }
        } else {
            $this->setMensaje($base->getError());
        }
        return $colViajes;
    }

    /**
     * Verifica si hay pasajes disponibles para la instancia actual
     * Retorna true si la cantidad de pasajeros en colPasajeros es menor al valor en cantMaxPasajeros o false en caso contrario
     * @return boolean
     */
    public function hayPasajesDisponibles() {
        $cantidadPasajeros = count($this->getColeccionPasajeros());
        $cantidadMaxima = $this->getCantMaxPasajeros();
        return $cantidadPasajeros < $cantidadMaxima;
    }

    /**
 * Vende un pasaje a un pasajero si hay disponibilidad.
 * @param Pasajero $unPasajero
 * @return boolean
 */
public function venderPasaje($unPasajero) {
    $vendido = false;
    if ($this->hayPasajesDisponibles()) {
        $costosAbonados = $this->getCostosAbonados();
        $importe = $this->getImporte();
        $costosAbonados += $importe;
        $this->setCostosAbonados($costosAbonados);

        // Agregar el pasajero a la colección de pasajeros del viaje
        $colPasajeros = $this->getColeccionPasajeros();
        array_push($colPasajeros, $unPasajero);
        $this->setColeccionPasajeros($colPasajeros);

        // Asignar este viaje al pasajero
        $unPasajero->setViaje($this);

        // Actualizar el viaje en la base de datos
        if ($this->modificar()) {
            // Guardar el pasajero en la base de datos
            if ($unPasajero->insertar()) {
                $vendido = true;
            } else {
                $this->setMensaje($unPasajero->getMensaje());
            }
        } else {
            $this->setMensaje($this->getMensaje());
        }
    }
    return $vendido;
}

}
