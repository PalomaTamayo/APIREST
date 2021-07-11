<?php

class ControladorRol{

	/*=============================
	MOSTRAR TODOS LOS REGISTROS
	=============================*/

	public function index($page){


		if ($page != null) {
			
			/*============================================
				  Mostrar registros con paginación
			============================================*/

			$cantidad = 10;
			$desde = ($page-1)*$cantidad;

			$rol = ModeloRol::index("rol", $cantidad, $desde);

				}else{

					/*============================================
					Mostrar todos los registros
					============================================*/

					$rol = ModeloRol::index("rol", null, null);
				}
				if (!empty($rol)) {	

					$json = array(
						"status"=>200,
						"total_registros"=>count($rol),
						"detalle"=> $rol
					);

					echo json_encode($json, true);
					return;
				
				}else{
						$json = array(
							"status"=>200,
							"total_registros"=>0,
							"detalle"=> "No hay ningún registro"
						);
						echo json_encode($json, true);
						return;
				}
	}
	/*============================================
	Crear un registro
	============================================*/

	public function create($datos){
		
		/*============================================
		Validar Nombre
		============================================*/

		foreach ($datos as $key => $valueDatos) {
			if (isset($ValueDatos) && !preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/', $ValueDatos)) {

				$json = array(
					"status"=>404,
					"detalle"=>"Error en el campo nombre".$key
				);
				echo json_encode($json, true);
				return;
			}
		}

		/*============================================
		Validar que el nombre no esté repetido
		============================================*/

		$rol = ModeloRol::index("rol", null, null);
		foreach ($rol as $key => $value) {
			
			if ($value->NOMBRE_ROL == $datos["NOMBRE_ROL"]) {

				$json = array(
					"status"=>404,
					"detalle"=>"El nombre ya existe en la base de datos"
				);

				echo json_encode($json, true);
				return;
			}
			
		}

		/*============================================
		Llevar datos al modelo
		============================================*/

		$datos = array( "NOMBRE_ROL"=>$datos["NOMBRE_ROL"],
						"DESCRIPCION"=>$datos["DESCRIPCION"]
					);

		$create = ModeloRol::create("rol", $datos);
			/*============================================
			Respuesta del modelo
			============================================*/

			if ($create == "ok") {

				$json = array(
					"status"=>200,
					"detalle"=>"Su registro ha sido guardado"
				);

				echo json_encode($json, true);
				return;
			}
	}
	/*============================================
	Mostrando un solo registro
	============================================*/

	public function show($id){
			
		/*============================================
		Mostrar todos los registro
		============================================*/

		$rol = ModeloRol::show("rol", $id);

		if (!empty($rol)) {

			$json = array(
				"status"=>200,
				"detalle"=> $rol
			);

			echo json_encode($json, true);
			return;
		}else{

			$json = array(
				"status"=>200,
				"total_registros"=>0,
				"detalle"=> "No hay ningún registro"
			);

			echo json_encode($json, true);
			return;
		}

	}
	/*============================================
	Editar un Registro
	============================================*/

	public function update($id, $datos){

		/*============================================
		Validar datos
		============================================*/

		foreach ($datos as $key => $valueDatos) {
	
			if (isset($ValueDatos) && !preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/', $ValueDatos)) {

				$json = array(
					"status"=>404,
					"detalle"=>"Error en el campo nombre".$key
				);

				echo json_encode($json, true);
				return;
			}

			/*============================================
			Llevar datos al modelo
			============================================*/

			$datos = array( "ID_ROL"=>$id,
							"NOMBRE_ROL"=>$datos["NOMBRE_ROL"],
							"DESCRIPCION"=>$datos["DESCRIPCION"]							
							);

			$update = ModeloRol::update("rol", $datos);
			/*============================================
			Respuesta del modelo
			============================================*/

			if ($update == "ok") {

				$json = array(
					"status"=>200,
					"detalle"=>"Su registro ha sido actualizado"
				);

				echo json_encode($json, true);
				return;
			}
		}
	}
	/*============================================
	Borrar Registro
	============================================*/

	public function delete($id){

		/*============================================
		Llevar datos al modelo
		============================================*/

		$delete = ModeloRol::delete("rol", $id);
		/*============================================
		Respuesta del modelo
		============================================*/

		if ($delete == "ok") {

			$json = array(
				"status"=>200,
				"detalle"=>"Se ha borrado con éxito"
			);

			echo json_encode($json, true);
			return;
		}
	}
}