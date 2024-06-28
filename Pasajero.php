<?php
include_once 'BaseDatos.php';

class Pasajero extends Persona{
    //Atributos
    private $idPasajero;
    private $idViaje;
    private $nroAsiento;
    private $nroTicket;

    //Constructor
    public function __construct(){
        parent::__construct();
        $this->idPasajero="";
    }
    public function cargar($unNroDocumento,$unNombre,$unApellido,$unTelefono,$unViaje="",$unNroAsiento="",$unNroTicket=""){
        parent::cargar($unNroDocumento,$unNombre,$unApellido,$unTelefono);
        $this->idPasajero="";
        $this->idViaje=$unViaje;
        $this->nroAsiento=$unNroAsiento;
        $this->nroTicket=$unNroTicket;
    }

    //Observadores
    public function getIdPasajero(){
        return $this->idPasajero;
    }
    public function getIdViaje(){
        return $this->idViaje;
    }
    public function getNroAsiento(){
        return $this->nroAsiento;
    }
    public function getNroTicket(){
        return $this->nroTicket;
    }
    

    public function __toString() {
        $cadena = parent::__toString();
        $cadena .= "Id pasajero: " . $this->getIdPasajero() . "\n";
        $cadena .= "ID de viaje: " . $this->getIdViaje() . "\n".
        $cadena .= "Numero asiento: " . $this->getNroAsiento() . "\n";
        $cadena .= "Numero ticket: " . $this->getNroTicket() . "\n";
        return $cadena;
    }

    //Modificadores
    public function setIdPasajero($unIdPasajero){
        $this->idPasajero=$unIdPasajero;
    }
    public function setIdViaje($unIdViaje){
        $this->idViaje=$unIdViaje;
    }
    public function setNroAsiento($unNroAsiento){
        $this->nroAsiento=$unNroAsiento;
    }
    public function setNroTicket($unNroTicket){
        $this->nroTicket=$unNroTicket;
    }

    //Propios

    /**
     * Busca el registro en la tabla Pasajero donde nroDoc coincida con el valor enviado por parametro
     * Retorna true si la encuentra o false en caso contrario
     * @return boolean
     */
    public function buscar($nroDocumento) {
        $base = new BaseDatos();
        $encontrado = false;
        
        if ($base->iniciar()) {
            $consulta = "SELECT * FROM pasajero WHERE nroDocumento=" . $nroDocumento;
            
            if ($base->ejecutar($consulta)) {
                if ($registro = $base->registro()) {
                    parent::buscar($nroDocumento);
                    $this->setIdPasajero($registro['idPasajero']);
                    $this->setNroTicket($registro['nroTicket']);
                    $this->setNroAsiento($registro['nroAsiento']);
                    $this->setIdViaje($registro['idViaje']);
                    $encontrado=true;
                } else {
                    $this->setMensaje("No se encontró ningún pasajero con ese documento.");
                }
            } else {
                $this->setMensaje($base->getError());
            }
        } else {
            $this->setMensaje($base->getError());
        }
        
        return $encontrado;
    }
    
    

    // Método para insertar un nuevo pasajero
    public function insertar(){
        $base=new BaseDatos();
        $agregado=false;
        if($base->iniciar()){
            if(parent::insertar()){
                $consulta="INSERT INTO pasajero(nroDocumento,idViaje,nroAsiento,nroTicket) VALUES ('" .$this->getNroDocumento()."'
                , '".$this->getIdViaje(). "', '".$this->getNroAsiento(). "', '" .$this->getNroTicket(). "')";
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
            $consulta="UPDATE pasajero SET idViaje=".$this->getIdViaje().
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
    public function listar($condicion = "") {
        $colPasajeros = [];
        $base = new BaseDatos();

        if ($base->iniciar()) {
            $consulta = "SELECT * FROM pasajero";
            if ($condicion != "") {
                $consulta .= " WHERE " . $condicion;
            }
            if ($base->ejecutar($consulta)) {
                while ($registro = $base->registro()) {
                    $unPasajero = new Pasajero();
                    $unaPersona=new Persona();
                    $nroAsiento=$registro['nroAsiento'];
                    $nroTicket=$registro['nroTicket'];
                    $idPasajero=$registro['idPasajero'];
                    $idViaje=$registro['idViaje'];
                    $unaPersona->buscar($registro['nroDocumento']);
                    $nombre=$unaPersona->getNombre();
                    $apellido=$unaPersona->getApellido();
                    $nroDocumento=$unaPersona->getNroDocumento();
                    $telefono=$unaPersona->getTelefono();
                    $unPasajero->cargar($nroDocumento,$nombre,$apellido,$telefono,$idViaje,$nroAsiento,$nroTicket);
                    $unPasajero->setIdPasajero($idPasajero);
                    array_push($colPasajeros, $unPasajero);
                }
            } else {
                $this->setMensaje($base->getError());
            }
        } else {
            $this->setMensaje($base->getError());
        }

        return $colPasajeros;
    }

    
    
    
    
    
    
}