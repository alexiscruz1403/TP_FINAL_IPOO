<?php

class Persona{
    //Atributos
    private $nroDocumento;
    private $nombre;
    private $apellido;
    private $telefono;
    private $mensaje;

    //Constructor
    public function __construct(){
        $this->nroDocumento="";
        $this->nombre="";
        $this->apellido="";
        $this->telefono="";
    }
    public function cargar($unNroDocumento,$unNombre,$unApellido,$unTelefono){
        $this->nroDocumento=$unNroDocumento;
        $this->nombre=$unNombre;
        $this->apellido=$unApellido;
        $this->telefono=$unTelefono;
    }

    //Observadores
    public function getNroDocumento(){
        return $this->nroDocumento;
    }
    public function getNombre(){
        return $this->nombre;
    }
    public function getApellido(){
        return $this->apellido;
    }
    public function getTelefono(){
        return $this->telefono;
    }
    public function getMensaje(){
        return $this->mensaje;
    }
    public function __toString(){
        return "NroDocumento: ".$this->getNroDocumento()."\n".
        "Nombre: ".$this->getNombre()."\n".
        "Apellido: ".$this->getApellido()."\n".
        "Telefono: ".$this->getTelefono()."\n";
    }

    //Modificadores
    public function setNroDocumento($unNroDocumento){
        $this->nroDocumento=$unNroDocumento;
    }
    public function setNombre($unNombre){
        $this->nombre=$unNombre;
    }
    public function setApellido($unApellido){
        $this->apellido=$unApellido;
    }
    public function setTelefono($unTelefono){
        $this->telefono=$unTelefono;
    }
    public function setMensaje($unMensaje){
        $this->mensaje=$unMensaje;
    }

    //Propios

    /**
     * Busca el registro en la tabla Persona donde nroDocumento coincida con el valor enviado por parametro
     * Retorna true si la encuentra o false en caso contrario
     * @return boolean
     */
    public function buscar($nroDocumento){
        $base=new BaseDatos();
        $encontrado=false;
        if($base->iniciar()){
            $consulta="SELECT * FROM persona WHERE nroDocumento=".$nroDocumento;
            if($base->ejecutar($consulta)){
                while($registro=$base->registro()){
                    $this->setNroDocumento($registro['nroDocumento']);
                    $this->setNombre($registro['nombre']);
                    $this->setApellido($registro['apellido']);
                    $this->setTelefono(($registro['telefono']));
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
            $consulta="INSERT INTO persona(nroDocumento,nombre,apellido,telefono) VALUES ('".$this->getNroDocumento()."','".
            $this->getNombre()."','".$this->getApellido()."',".$this->getTelefono().")";
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
     * Elimina el registro donde idPasajero coincida con el valor actual de la instancia
     * Retorna true si la encuentra o false en caso contrario
     * @return boolean
     */
    public function eliminar(){
        $base=new BaseDatos();
        $eliminado=false;
        if($base->iniciar()){
            $consulta="DELETE FROM persona WHERE nroDocumento=".$this->getNroDocumento();
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
            $consulta="UPDATE persona SET nombre='".$this->getNombre().
            "',apellido='".$this->getApellido().
            "',telefono=".$this->getTelefono().
            " WHERE nroDocumento=".$this->getNroDocumento();
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
            $consulta="SELECT * FROM persona";
            if($condicion!=""){
                $consulta.=" WHERE ".$condicion;
            }
            if($base->ejecutar($consulta)){
                while($registro=$base->registro()){
                    $nroDocumento=$registro['nroDocumento'];
                    $nombre=$registro['nombre'];
                    $apellido=$registro['apellido'];
                    $telefono=$registro['telefono'];
                    $unPasajero=new Persona();
                    $unPasajero->cargar($nroDocumento,$nombre,$apellido,$telefono);
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