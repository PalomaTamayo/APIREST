<?php

$arrayRutas = explode("/", $_SERVER['REQUEST_URI']);

if (isset($_GET["page"]) && is_numeric($_GET["page"])) {

	$rol = new ControladorRol();
	$rol -> index($_GET["page"]);

}else{

	if (count(array_filter($arrayRutas)) == 0) {

		/*============================================
		Cuando no se hace ninguna petición a la API
		============================================*/
			$json = array(
			"detalle" => "no encontrado"
		);
			echo json_encode($json, true);
			return;
		
		}else{

		/*====================================================
		 Cuando pasamos solo un índice en el array $arrayRutas
		======================================================*/

			if (count(array_filter($arrayRutas)) == 1) {

				/*============================================
				Cuando se hace peticiones desde rol
				============================================*/

				if (array_filter($arrayRutas)[1] == "registro") {

					/*============================================
					Peticiones GET
					============================================*/

					if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "GET") {
						
						$rol = new ControladorRol();
						$rol -> index(null);

					
				}
					/*============================================
					Peticiones POST
					============================================*/

					else if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST") {

						/*============================================
						Capturar datos
						============================================*/

						$datos = array( "NOMBRE_ROL"=>$_POST["NOMBRE_ROL"],
										"DESCRIPCION"=>$_POST["DESCRIPCION"]);

						$crearRol = new ControladorRol();
						$crearRol -> create($datos);

						echo '<pre>'; print_r($_SERVER["REQUEST_METHOD"]); echo '</pre>';
						
						return;

					}else{
						$json = array(
							"detalle" => "no encontrado 2" 
						);

						echo json_encode($json, true);
						return;
					}

				}else{
					$json = array(
						"detalle" => "no encontrado 3" 
					);

					echo json_encode($json, true);
					return;
				}
			}else{

			/*==============================================
			Cuando se hace peticiones desde un solo registro
			================================================*/

			if (array_filter($arrayRutas)[1] == "registro" && is_numeric(array_filter($arrayRutas)[2])) {

				/*============================================
				Peticiones GET
				============================================*/

				if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "GET") {
					
					$rol = new ControladorRol();
					$rol -> show(array_filter($arrayRutas)[2]);
				}
				/*============================================
				Peticiones PUT
				============================================*/

				else if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "PUT") {

					/*============================================
					Capturar datos
					============================================*/

					$datos = array();
					
					parse_str(file_get_contents('php://input'), $datos);

					$editarRol = new ControladorRol();
					$editarRol -> update(array_filter($arrayRutas)[2], $datos);
				}
				/*============================================
				Peticiones DELETE
				============================================*/

				else if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "DELETE") {
					
					$borrarRol = new ControladorRol();
					$borrarRol -> delete(array_filter($arrayRutas)[2]);

				}else{
					$json = array(
						"detalle" => "no encontrado 4" 
					);

					echo json_encode($json, true);
					return;
				}
			
			}else{
				$json = array(
					"detalle" => "no encontrado 5" 
				);
				echo json_encode($json, true);
				return;
			}
		}
	}
}
