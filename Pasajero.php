<?php
include_once 'BaseDatos.php';

class Pasajero extends Persona{
    //Atributos
    private $idPasajero;
    private $idViaje;

    //Constructor
    public function __construct(){
        parent::__construct();
        $this->idPasajero="";
        $this->idViaje="";
    }
    public function cargar($unNroDocumento,$unNombre,$unApellido,$unTelefono,$unIdViaje=""){
        parent::cargar($unNroDocumento,$unNombre,$unApellido,$unTelefono);
        $this->idPasajero="";
        $this->idViaje=$unIdViaje;
    }

    //Observadores
    public function getIdPasajero(){
        return $this->idPasajero;
    }
    public function getIdViaje(){
        return $this->idViaje;
    }
    public function __toString(){
        $cadena=parent::__toString();
        $cadena.="Id pasajero: ".$this->getIdPasajero()."\n".
        "Id viaje: ".$this->getIdViaje()."\n";
        return $cadena;
    }

    //Modificadores
    public function setIdPasajero($unIdPasajero){
        $this->idPasajero=$unIdPasajero;
    }
    public function setIdViaje($unIdViaje){
        $this->idViaje=$unIdViaje;
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
                    if(parent::buscar($registro['nroDocumento'])){
                        $this->setIdPasajero($registro['idPasajero']);
                        $this->setIdViaje($registro['idViaje']); 
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
                $consulta="INSERT INTO pasajero(nroDocumento,idViaje) VALUES ('".$this->getNroDocumento().
                "',".$this->getIdViaje().")";
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
            ",idViaje=".$this->getIdViaje().
            "WHERE idPasajero=".$this->getIdPasajero();
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