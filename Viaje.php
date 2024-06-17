<?php

class Viaje{
    //Atributos
    private $idViaje;
    private $destino;
    private $cantMaxPasajeros;
    private $importe;
    private $idEmpresa;
    private $numeroEmpleado;
    private $costosAbonados;
    private $colPasajeros;
    private $objEmpresa;
    private $objResponsable;
    private $mensaje;

    //Constructor
    public function __construct(){
        $this->idViaje="";
        $this->destino="";
        $this->cantMaxPasajeros="";
        $this->importe="";
        $this->idEmpresa="";
        $this->numeroEmpleado="";
        $this->costosAbonados="";
        $this->mensaje="";
    }
    public function cargar($unDestino,$unaCantMaxPasajeros,$unImporte,$unIdEmpresa,$unNumeroEmpleado){
        $this->destino=$unDestino;
        $this->cantMaxPasajeros=$unaCantMaxPasajeros;
        $this->importe=$unImporte;
        $this->idEmpresa=$unIdEmpresa;
        $this->numeroEmpleado=$unNumeroEmpleado;
        $this->costosAbonados=0;
    }
    public function cargarColeccion(){
        $base=new BaseDatos();
        if($base->iniciar()){
            $unaPersona=new Pasajero();
            $coleccion=$unaPersona->listar("idViaje=".$this->getIdViaje());
            $this->setColeccionPasajeros($coleccion);
        }else{
            $this->setMensaje($base->getError());
        }
        $this->setColeccionPasajeros($coleccion);
    }
    public function cargarEmpresa(){
        $base=new BaseDatos();
        if($base->iniciar()){
            $unaEmpresa=new Empresa();
            $unaEmpresa->buscar($this->getIdEmpresa());
            $this->setEmpresa($unaEmpresa);
        }else{
            $this->setMensaje($base->getError());
        }
    }
    public function cargarResponsable(){
        $base=new BaseDatos();
        if($base->iniciar()){
            $unResponsable=new Responsable();
            $unResponsable->buscar($this->getNumeroEmpleado());
            $this->setResponsable($unResponsable);
        }else{
            $this->setMensaje($base->getError());
        }
    }

    //Observadores
    public function getIdViaje(){
        return $this->idViaje;
    }
    public function getDestino(){
        return $this->destino;
    }
    public function getCantMaxPasajeros(){
        return $this->cantMaxPasajeros;
    }
    public function getImporte(){
        return $this->importe;
    }
    public function getIdEmpresa(){
        return $this->idEmpresa;
    }
    public function getNumeroEmpleado(){
        return $this->numeroEmpleado;
    }
    public function getCostosAbonados(){
        return $this->costosAbonados;
    }
    public function getColeccionPasajeros(){
        $this->cargarColeccion();
        return $this->colPasajeros;
    }
    public function getEmpresa(){
        $this->cargarEmpresa();
        return $this->objEmpresa;
    }
    public function getResponsable(){
        $this->cargarResponsable();
        return $this->objResponsable;
    }
    public function getMensaje(){
        return $this->mensaje;
    }
    public function __toString(){
        return "IdViaje: ".$this->getIdViaje()."\n".
        "Destino: ".$this->getDestino()."\n".
        "CantMaxPasajeros: ".$this->getCantMaxPasajeros()."\n".
        "Importe: ".$this->getImporte()."\n".
        "IdEmpresa: ".$this->getIdEmpresa()."\n".
        "NumeroEmpleado: ".$this->getNumeroEmpleado()."\n".
        "Cantidad Pasajeros: ".count($this->getColeccionPasajeros())."\n".
        "Costos abonados: ".$this->getCostosAbonados()."\n";
    }

    //Modificadores
    public function setIdViaje($unIdViaje){
        $this->idViaje=$unIdViaje;
    }
    public function setDestino($unDestino){
        $this->destino=$unDestino;
    }
    public function setCantMaxPasajeros($unaCantMaxPasajeros){
        $this->cantMaxPasajeros=$unaCantMaxPasajeros;
    }
    public function setImporte($unImporte){
        $this->importe=$unImporte;
    }
    public function setIdEmpresa($unIdEmpresa){
        $this->idEmpresa=$unIdEmpresa;
    }
    public function setNumeroEmpleado($unNumeroEmpleado){
        $this->numeroEmpleado=$unNumeroEmpleado;
    }
    public function setCostosAbonados($costosAbonados){
        $this->costosAbonados=$costosAbonados;
    }
    public function setColeccionPasajeros($unaColeccion){
        $this->colPasajeros=$unaColeccion;
    }
    public function setEmpresa($unaEmpresa){
        $this->objEmpresa=$unaEmpresa;
    }
    public function setResponsable($unResponsable){
        $this->objResponsable=$unResponsable;
    }
    public function setMensaje($unMensaje){
        $this->mensaje=$unMensaje;
    }

    //Propios

    /**
     * Busca el registro en la tabla viaje donde idViaje coincida con el valor enviado por parametro
     * Retorna true si la encuentra o false en caso contrario
     * @param int $idViaje
     * @return boolean
     */
    public function buscar($idViaje){
        $base=new BaseDatos();
        $encontrado=false;
        if($base->iniciar()){
            $consulta="SELECT * FROM viaje WHERE idViaje=".$idViaje;
            if($base->ejecutar($consulta)){
                while($registro=$base->registro()){
                    $this->setIdViaje($registro['idViaje']);
                    $this->setDestino($registro['destino']);
                    $this->setCantMaxPasajeros($registro['cantMaxPasajeros']);
                    $this->setImporte($registro['importe']);
                    $this->setIdEmpresa($registro['idEmpresa']);
                    $this->setNumeroEmpleado($registro['numeroEmpleado']);
                    $this->setCostosAbonados($registro['costosAbonados']);
                    $encontrado=true;
                }
            }else{
                $this->setMensaje($base->getError());
            }
        }else{
            $this->setMensaje($base->getError());
        }
        return $encontrado;
    }

    /**
     * Agrega la instancia actual como un registro en la base de datos
     * Retorna true si la encuentra o false en caso contrario
     * @return boolean
     */
    public function insertar(){
        $base=new BaseDatos();
        $agregado=false;
        if($base->iniciar()){
            $consulta="INSERT INTO viaje(destino,cantMaxPasajeros,importe,idEmpresa,numeroEmpleado,costosAbonados) VALUES ('".$this->getDestino().
            "',".$this->getCantMaxPasajeros().",".$this->getImporte().",".$this->getIdEmpresa().",".$this->getNumeroEmpleado().",".$this->getCostosAbonados().")";
            if($base->ejecutar($consulta)){
                $agregado=true;
            }else{
                $this->setMensaje($base->getError());
            }
        }else{
            $this->setMensaje($base->getError());
        }
        return $agregado;
    }

    /**
     * Elimina el registro donde idEmpresa coincida con el valor actual de la instancia
     * Retorna true si la encuentra o false en caso contrario
     * @return boolean
     */
    public function eliminar(){
        $base=new BaseDatos();
        $eliminado=false;
        if($base->iniciar()){
            $consulta="DELETE FROM viaje WHERE idViaje=".$this->getIdViaje();
            if($base->ejecutar($consulta)){
                $eliminado=true;
            }else{
                $this->setMensaje($base->getError());
            }
        }else{
            $this->setMensaje($base->getError());
        }
        return $eliminado;
    }

    /**
     * Modifica el registro donde idPasajero coincida con el valor actual de la instancia
     * Retorna true si la encuentra o false en caso contrario
     * @return boolean
     */
    public function modificar(){
        $modificado=false;
        $base=new BaseDatos();
        if($base->iniciar()){
            $consulta="UPDATE viaje SET destino='".$this->getDestino().
            "',cantMaxPasajeros=".$this->getCantMaxPasajeros().
            ",importe=".$this->getImporte().
            ",idEmpresa=".$this->getIdEmpresa().
            ",numeroEmpleado=".$this->getNumeroEmpleado().
            " WHERE idViaje=".$this->getIdViaje();
            if($base->ejecutar($consulta)){
                $modificado=true;
            }else{
                $this->setMensaje($base->getError());
            }
        }else{
            $this->setMensaje($base->getError());
        }
        return $modificado;
    }

    /**
     * Crea una coleccion con informacion de todas las empresas
     * Se puede mandar una condicion de manera opcional
     * Si no hay registros, devulve una coleccion vacia
     * @param string $condicion
     * @return array
     */
    public function listar($condicion=""){
        $colPasajeros=array();
        $base=new BaseDatos();
        if($base->iniciar()){
            $consulta="SELECT * FROM viaje";
            if($condicion!=""){
                $consulta.=" WHERE ".$condicion;
            }
            if($base->ejecutar($consulta)){
                while($registro=$base->registro()){
                    $unViaje=new Viaje();
                    $unViaje->buscar($registro['idViaje']);
                    array_push($colPasajeros,$unViaje);
                }
            }else{
                $this->setMensaje($base->getError());
            }
        }else{
            $this->setMensaje($base->getError());
        }
        return $colPasajeros;
    }

    /**
     * Verifica si hay pasajes disponibles para la instancia actual
     * Retorna true si la cantidad de pasajeros en colPasajeros es menor al valor en cantMaxPasajeros o false en caso contrario
     * @return boolean
     */
    public function hayPasajesDisponibles(){
        $cantidadPasajeros=count($this->getColeccionPasajeros());
        $cantidadMaxima=$this->getCantMaxPasajeros();
        return $cantidadPasajeros<$cantidadMaxima;
    }

    /**
     * 
     */
    public function venderPasaje($unPasajero){
        $vendido=false;
        if($this->hayPasajesDisponibles()){
            echo "hay pasajes disponibles\n";
            $unPasajero->setIdViaje($this->getIdViaje());
            if($unPasajero->modificar()){
                echo "un pasajero modificado\n";
                $this->setCostosAbonados($this->getCostosAbonados()+$this->getImporte());
                if($this->modificar()){
                    echo "viaje modificado\n";
                    $vendido=true;
                }else{
                    $this->setMensaje($unPasajero->getMensaje());
                }
            }else{
                $this->setMensaje($unPasajero->getMensaje());
            }
        }
        return $vendido;
    }
}