<?php

class BaseDatos{
    private $HOSTNAME;
    private $BASEDATOS;
    private $USUARIO;
    private $CLAVE;
    private $CONEXION;
    private $ERROR;
    private $QUERY;
    private $RESULT;

    //Constructor
    public function __construct(){
        $this->HOSTNAME="127.0.0.1";
        $this->USUARIO="root";
        $this->BASEDATOS="bd_viajes";
        $this->CLAVE="";
        $this->QUERY="";
        $this->RESULT=0;
        $this->ERROR="";
    }

    //Observadores
    private function getHostname(){
        return $this->HOSTNAME;
    }
    private function getUsuario(){
        return $this->USUARIO;
    }
    private function getClave(){
        return $this->CLAVE;
    }
    private function getBaseDatos(){
        return $this->BASEDATOS;
    }
    public function getError(){
        return $this->ERROR;
    }
    public function getConexion(){
        return $this->CONEXION;
    }
    public function getResult(){
        return $this->RESULT;
    }

    //Modificadores
    public function setConexion($unaConexion){
        $this->CONEXION=$unaConexion;
    }
    public function setError($unError){
        $this->ERROR=$unError;
    }
    public function setResult($unResult){
        $this->RESULT=$unResult;
    }
    public function setQuery($unaQuery){
        $this->QUERY=$unaQuery;
    }

    //Propios

    /**
     * Inicia la conexion con la base de datos
     * Devuelve true si se pudo conectar o false en caso contrario
     * @return boolean
     */
    public function iniciar(){
        $rta=false;
        $conexion=mysqli_connect($this->getHostname(),$this->getUsuario(),$this->getClave(),$this->getBaseDatos());
        if($conexion){
            if (mysqli_select_db($conexion,$this->getBaseDatos())){
            $this->setConexion($conexion);
            $rta=true;
            }else{
                $this->setError(mysqli_errno($conexion));
            }
        }else{
            $this->setError(mysqli_errno($conexion));
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
    public function ejecutar($consulta){
        $rta=false;
        $this->setQuery($consulta);
        $this->setResult(mysqli_query($this->getConexion(),$consulta));
        if($this->getResult()){
            $rta=true;
        } else {
            $this->setError(mysqli_errno($this->getConexion()));
        }
        return $rta;
    }

    /**
     * Devuelve un registro retornado por la ejecucion de una consulta
     * el puntero se despleza al siguiente registro de la consulta
     */
    public function registro() {
        $rta=null;
        if($this->getResult()){
            $registros=mysqli_fetch_assoc($this->RESULT);
            if($registros){
                $rta=$registros;
            }else{
                mysqli_free_result($this->RESULT);
            }
        }else{
            $this->setError(mysqli_errno($this->getConexion()));
        }
        return $rta;
    }
    
}