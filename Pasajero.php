<?php
include_once 'BaseDatos.php';

class Pasajero extends Persona{
    //Atributos
    private $idPasajero;
    private $objViaje;
    private $nroAsiento;
    private $nroTicket;

    //Constructor
    public function __construct(){
        parent::__construct();
        $this->idPasajero="";
    }
    public function cargar($unNroDocumento,$unNombre,$unApellido,$unTelefono,$unViaje="",$unNroAiento="",$unNroTicket=""){
        parent::cargar($unNroDocumento,$unNombre,$unApellido,$unTelefono);
        $this->idPasajero="";
        $this->nroAsiento=$unNroAiento;
        $this->nroTicket=$unNroTicket;
        $this->objViaje=$unViaje;
    }

    //Observadores
    public function getIdPasajero(){
        return $this->idPasajero;
    }
    public function getViaje(){
        return $this->objViaje;
    }
    public function getNroAsiento(){
        return $this->nroAsiento;
    }
    public function getNroTicket(){
        return $this->nroTicket;
    }
    public function __toString(){
        $cadena=parent::__toString();
        $cadena.="Id pasajero: ".$this->getIdPasajero()."\n".
        "Viaje: \n".$this->getViaje().
        "Numero asiento: ".$this->getNroAsiento()."\n".
        "Numero ticket: ".$this->getNroTicket()."\n";
        return $cadena;
    }

    //Modificadores
    public function setIdPasajero($unIdPasajero){
        $this->idPasajero=$unIdPasajero;
    }
    public function setViaje($unViaje){
        $this->objViaje=$unViaje;
    }
    public function setNroAsiento($unNroAsiento){
        $this->nroAsiento=$unNroAsiento;
    }
    public function setNroTicket($unNroTicket){
        $this->nroTicket=$unNroTicket;
    }

    //Propios

    /**
     * Busca el registro en la tabla Pasajero donde idPasajero coincida con el valor enviado por parametro
     * Retorna true si la encuentra o false en caso contrario
     * @return boolean
     */
    public function buscar($idPasajero){
        $base=new BaseDatos();
        $encontrado=false;
        if($base->iniciar()){
            $consulta="SELECT * FROM pasajero WHERE idPasajero=".$idPasajero;
            if($base->ejecutar($consulta)){
                while($registro=$base->registro()){
                    $unViaje=new Viaje();
                    if(parent::buscar($registro['nroDocumento'])){
                        $idPasajero=$registro['idPasajero'];
                        $nroTicket=$registro['nroTicket'];
                        $nroAsiento=$registro['nroAsiento'];
                        $viaje=$unViaje->buscar($registro['idViaje']);
                        $this->setIdPasajero($idPasajero);
                        $this->setNroTicket($nroTicket);
                        $this->setNroAsiento($nroAsiento);
                        $this->setViaje($viaje);
                    }else{
                        $this->setMensaje($base->getError());
                    }
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
            if(parent::insertar()){
                $consulta="INSERT INTO pasajero(nroDocumento,idViaje,nroAsiento,nroTicket) VALUES ('".$this->getNroDocumento().
                "',".$this->getViaje()->getIdViaje().",".$this->getNroAsiento().",".$this->getNroTicket().")";
                if($base->ejecutar($consulta)){
                    $agregado=true;
                }else{
                    $this->setMensaje($base->getError());
                }
            }else{
                $this->setMensaje($base->getError());
            }
        }else{
            $this->setMensaje($base->getError());
        }
        return $agregado;
    }

    /**
     * Elimina el registro donde idPasajero coincida con el valor actual de la instancia
     * Retorna true si la encuentra o false en caso contrario
     * @return boolean
     */
    public function eliminar(){
        $base=new BaseDatos();
        $eliminado=false;
        if($base->iniciar()){
            $consulta="DELETE FROM pasajero WHERE idPasajero=".$this->getIdPasajero();
            if($base->ejecutar($consulta)){
                if(parent::eliminar()){
                    $eliminado=true; 
                }else{
                    $this->setMensaje($base->getError());
                }
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
            $consulta="UPDATE pasajero SET nroDocumento='".$this->getNroDocumento().
            "',idViaje=".$this->getViaje()->getIdViaje().
            ",nroAsiento=".$this->getNroAsiento().
            ",nroTicket=".$this->getNroTicket().
            " WHERE idPasajero=".$this->getIdPasajero();
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
     * Crea una coleccion con informacion de todos los pasajeros
     * Se puede mandar una condicion de manera opcional
     * Si no hay registros, devulve una coleccion vacia
     * @param string $condicion
     * @return array
     */
    public function listar($condicion=""){
        $colPasajeros=array();
        $base=new BaseDatos();
        if($base->iniciar()){
            $consulta="SELECT * FROM pasajero";
            if($condicion!=""){
                $consulta.=" WHERE ".$condicion;
            }
            if($base->ejecutar($consulta)){
                while($registro=$base->registro()){
                    $unPasajero=new Pasajero();
                    $unPasajero->buscar($registro['idPasajero']);
                    array_push($colPasajeros,$unPasajero);
                }
            }else{
                $this->setMensaje($base->getError());
            }
        }else{
            $this->setMensaje($base->getError());
        }
        return $colPasajeros;
    }
}