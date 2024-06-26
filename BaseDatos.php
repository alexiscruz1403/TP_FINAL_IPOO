<?php

class BaseDatos {
    private $HOSTNAME;
    private $BASEDATOS;
    private $USUARIO;
    private $CLAVE;
    private $CONEXION;
    private $ERROR;
    private $QUERY;
    private $RESULT;

    // Constructor
    public function __construct() {
        $this->HOSTNAME = "127.0.0.1";
        $this->USUARIO = "root";
        $this->BASEDATOS = "bd_viajes";
        $this->CLAVE = "";
        $this->QUERY = "";
        $this->RESULT = null;
        $this->ERROR = "";
    }

    // Observadores
    private function getHostname() {
        return $this->HOSTNAME;
    }

    private function getUsuario() {
        return $this->USUARIO;
    }

    private function getClave() {
        return $this->CLAVE;
    }

    private function getBaseDatos() {
        return $this->BASEDATOS;
    }

    public function getError() {
        return $this->ERROR;
    }

    public function getConexion() {
        return $this->CONEXION;
    }

    public function getResult() {
        return $this->RESULT;
    }

    // Modificadores
    private function setConexion($unaConexion) {
        $this->CONEXION = $unaConexion;
    }

    private function setError($unError) {
        $this->ERROR = $unError;
    }

    private function setResult($unResult) {
        $this->RESULT = $unResult;
    }

    private function setQuery($unaQuery) {
        $this->QUERY = $unaQuery;
    }

    // Propios

    /**
     * Inicia la conexion con la base de datos
     * Devuelve true si se pudo conectar o false en caso contrario
     * @return boolean
     */
    public function iniciar() {
        $rta = false;
        $conexion = mysqli_connect($this->getHostname(), $this->getUsuario(), $this->getClave(), $this->getBaseDatos());
        if ($conexion) {
            $this->setConexion($conexion);
            $rta = true;
            // echo "Conexión establecida correctamente a la base de datos." . "\n";
        } else {
            $this->setError(mysqli_connect_errno() . ": " . mysqli_connect_error());
        }
        return $rta;
    }

    /**
     * Ejecuta una consulta en la Base de Datos.
     * Recibe la consulta en una cadena enviada por parametro.
     *
     * @param string $consulta
     * @return boolean
     */
    public function ejecutar($consulta) {
        $rta = false;
        $this->setQuery($consulta);
        $resultado = mysqli_query($this->getConexion(), $consulta);
        if ($resultado) {
            $this->setResult($resultado);
            $rta = true;
        } else {
            $this->setError(mysqli_errno($this->getConexion()) . ": " . mysqli_error($this->getConexion()));
        }
        return $rta;
    }

    /**
     * Devuelve un registro retornado por la ejecucion de una consulta
     * el puntero se desplaza al siguiente registro de la consulta
     */
    public function registro() {
        $rta = null;
        if ($this->getResult()) {
            $registros = mysqli_fetch_assoc($this->RESULT);
            if ($registros) {
                $rta = $registros;
            } else {
                mysqli_free_result($this->RESULT);
            }
        } else {
            $this->setError(mysqli_errno($this->getConexion()) . ": " . mysqli_error($this->getConexion()));
        }
        return $rta;
    }

    /**
     * Cierra la conexion con la base de datos
     */
    public function cerrarConexion() {
        if ($this->getConexion()) {
            mysqli_close($this->getConexion());
            $this->setConexion(null);
        }
    }
}
