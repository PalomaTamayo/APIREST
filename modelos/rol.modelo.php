<?php

require_once "conexion.php";

class ModeloRol{

	/*============================================
	Mostrar todos los Registros
	============================================*/

	static public function index($tabla, $cantidad, $desde){

		if ($cantidad != null) {
			
			$stmt = Conexion::conectar()->prepare("SELECT $tabla.ID_ROL, $tabla.NOMBRE_ROL, $tabla.DESCRIPCION FROM $tabla LIMIT $desde, $cantidad");

		}else{

			$stmt = Conexion::conectar()->prepare("SELECT $tabla.ID_ROL, $tabla.NOMBRE_ROL, $tabla.DESCRIPCION FROM $tabla");

		}

		$stmt -> execute();
		return $stmt -> fetchAll(PDO::FETCH_CLASS);
		$stmt -> close();
		$stmt = null;
	}

	/*============================================
	Crear Registro 
	============================================*/

	static public function create($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(NOMBRE_ROL, DESCRIPCION)  VALUES (:NOMBRE_ROL, :DESCRIPCION)");

		$stmt -> bindParam(":NOMBRE_ROL", $datos["NOMBRE_ROL"], PDO::PARAM_STR);
		$stmt -> bindParam(":DESCRIPCION", $datos["DESCRIPCION"], PDO::PARAM_STR);
		
		
		if ($stmt -> execute()) {
				
			return "ok";

			}else{

				print_r(Conexion::conectar()->errorInfo());

			}

			$stmt-> close();
			$stmt= null;

	}
	/*============================================
	Mostrar un solo registro
	============================================*/

	static public function show($tabla, $id){

		$stmt = Conexion::conectar()->prepare("SELECT $tabla.ID_ROL, $tabla.NOMBRE_ROL, $tabla.DESCRIPCION FROM $tabla WHERE $tabla.ID_ROL = :ID_ROL");
		
		$stmt -> bindParam(":ID_ROL", $id, PDO::PARAM_INT);

		$stmt -> execute();
		return $stmt -> fetchAll(PDO::FETCH_CLASS);
		$stmt -> close();
		$stmt = null;
	}

	/*============================================
	Actualizacion de un registro
	============================================*/

	static public function update($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET NOMBRE_ROL = :NOMBRE_ROL,DESCRIPCION = :DESCRIPCION  WHERE ID_ROL = :ID_ROL");

		$stmt -> bindParam(":ID_ROL", $datos["ID_ROL"], PDO::PARAM_INT);
		$stmt -> bindParam(":NOMBRE_ROL", $datos["NOMBRE_ROL"], PDO::PARAM_STR);
		$stmt -> bindParam(":DESCRIPCION", $datos["DESCRIPCION"], PDO::PARAM_STR);

			if ($stmt -> execute()) {
				
				return "ok";

			}else{

				print_r(Conexion::conectar()->errorInfo());

			}

			$stmt-> close();
			$stmt= null;

	}
	/*============================================
	Borrar registro
	============================================*/

	static public function delete($tabla, $id){

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE ID_ROL = :ID_ROL");

		$stmt -> bindParam(":ID_ROL", $id, PDO::PARAM_INT);

			if ($stmt -> execute()) {
				
				return "ok";

			}else{

				print_r(Conexion::conectar()->errorInfo());

			}

		$stmt-> close();
		$stmt= null;

	}
}