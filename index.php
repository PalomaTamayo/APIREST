<?php 

require_once "controladores/rutas.controlador.php";
require_once "controladores/rol.controlador.php";

require_once "modelos/rol.modelo.php";

$rutas =  new ControladorRutas();
$rutas -> index();