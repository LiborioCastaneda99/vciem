<?php
	require_once('../modelo/Conexion.php');  // Se carga la clase conexion
	class loginModel extends Conexion
	{
		public static function Listado_Lineas(){
			$conexion =Conexion::Conectar();
			try {
				$draw = $_POST['draw'];
				$row = $_POST['start'];
				$rowperpage = $_POST['length']; // Rows display per page
				$columnIndex = $_POST['order'][0]['column']; // Column index
				$columnName = $_POST['columns'][$columnIndex]['data']; // Column name
				$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
				$searchValue = $_POST['search']['value']; // Search value
			
				
				// Configuración de las opciones de busqueda
				$searchArray = array();
				# Configuración del parametro de filtro 
				$searchQuery = " ";
				if($searchValue != ''){
					$searchQuery = " AND (
					fld_codlinea LIKE :codigo or 
					fld_nombre LIKE :nombre ) ";
					$searchArray = array( 
					'codigo'=>"%$searchValue%", 
					'nombre'=>"%$searchValue%"
					);
				}
				
				## Calcular el total numero de registros sin filtro
				$sql="SELECT COUNT(*) ";
				$sql .=" AS allcount FROM inv_lineas";
				$stmt = $conexion->prepare($sql);
				$stmt->execute();
				$records = $stmt->fetch();
				$totalRecords = $records['allcount'];
				
				## Total numero de registros con filtro
				$sql="SELECT COUNT(*)";
				$sql .=" AS allcount FROM inv_lineas ";
				$sql .=" WHERE 1 ".$searchQuery." ";
				$stmt = $conexion->prepare($sql);
				$stmt->execute($searchArray);
				$records = $stmt->fetch();
				$totalRecordwithFilter = $records['allcount'];
				
				## Obetener los registros de la tabla.
				$sql ="SELECT fld_econsecutivo as Id";
				$sql.=", fld_codlinea as Codigo";
				$sql.=", fld_nombre as Nombre";
				$sql .=" FROM inv_lineas";
				$sql .="  WHERE 1".$searchQuery." ORDER BY ".$columnName." ".$columnSortOrder." LIMIT :limit,:offset";

				$stmt = $conexion->prepare($sql);
				
				// Bind values
				foreach($searchArray as $key=>$search){
					$stmt->bindValue(':'.$key, $search,PDO::PARAM_STR);
				}
				
				$stmt->bindValue(':limit', (int)$row, PDO::PARAM_INT);
				$stmt->bindValue(':offset', (int)$rowperpage, PDO::PARAM_INT);
				$stmt->execute();
				$empRecords = $stmt->fetchAll();
				
				$data = array();
				
				foreach($empRecords as $row){
					$op =' <button class="btn btn-primary mr-2 icon-paragraph-justify2" id="dropdownMenuButton" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="fas fa-bars"></span></button>
			
				   <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
						<a class="dropdown-item update" href="#" id="'.$row['Id'].'"> Editar</a>
						<a class="dropdown-item icon-eraser2 btnBorrar" href="#" id="'.$row['Id'].'"> Eliminar</a>
					</div>
	
					<button class="btn btn-primary icon-file-text3 view" id="'.$row['Id'].'"></button>';
					# Los titulos de columnas colocados en el formulario deben corresponder exactamente con lo descrito aquí
					
					$data[] = array(
						'Id'=>$row['Id']
						,'Codigo'=>$row['Codigo']
						,'Nombre'=>$row['Nombre']
						,'Accion'=>$op
					);
				}
				
				## respuesta
				$response = array(
				"draw" => intval($draw),
				"iTotalRecords" => $totalRecords,
				"iTotalDisplayRecords" => $totalRecordwithFilter,
				"aaData" => $data
				);
				# Devuelve la información al formulario
				echo json_encode($response);
				$conexion= NULL;
			}catch (Exception $e) {
					
					echo '<span class="label label-danger label-block">Error al cargar los datos</span>';
			}
		}
		public static function Combo_Lineas($searchTerm,$id){
			$conexion =Conexion::Conectar();
			try{
			$numberofrecords = 5;
			if ($id!='')
			{
				$search = $id;// Search text
				
				// Mostrar resultados
				$sql="SELECT fld_codlinea,fld_nombre FROM inv_lineas where fld_codlinea=:codigo";
				$stmt = $conexion->prepare($sql);
				$stmt->bindValue(':codigo',$search, PDO::PARAM_STR);
				$stmt->execute();
				//Variable en array para ser procesado en el ciclo foreach
				$lstResult = $stmt->fetchAll();
			}	
			else {
				if($searchTerm==''){
				
				// Obtener registros a tarves de la consulta SQL
				$sql="SELECT fld_codlinea,fld_nombre FROM inv_lineas ORDER BY fld_nombre LIMIT :limit";
				$stmt = $conexion->prepare($sql);
				$stmt->bindValue(':limit', (int)$numberofrecords, PDO::PARAM_INT);
				$stmt->execute();
				$lstResult = $stmt->fetchAll();

				}else{
				$search = $searchTerm;// Search text
				// Mostrar resultados
				$sql="SELECT fld_codlinea,fld_nombre FROM inv_lineas WHERE fld_nombre like :nombre ORDER BY fld_nombre LIMIT :limit";
				$stmt = $conexion->prepare($sql);
				$stmt->bindValue(':nombre', '%'.$search.'%', PDO::PARAM_STR);
				$stmt->bindValue(':limit', (int)$numberofrecords, PDO::PARAM_INT);
				$stmt->execute();
				//Variable en array para ser procesado en el ciclo foreach
				$lstResult = $stmt->fetchAll();
				}
			}	
			$response = array();
			// Leer los datos de MySQL
			
			foreach($lstResult as $result){
			$response[] = array(
				"id" => $result['fld_codlinea'],
				"text" => $result['fld_nombre']
			);
			}
			

			echo json_encode($response);
			$conexion = NULL;  //Cierra la conexion a la Base de datos
			}catch (Exception $e) {
						
				echo '<span class="label label-danger label-block">Error al cargar los datos</span>';
			}
		}
		public static function Insertar_Lineas($codigo,$nombre,$usrProcess,$usrFecha,$usrHora){
			$conexion =Conexion::Conectar();
			try {
				$sql ="INSERT INTO inv_lineas(fld_codlinea,fld_nombre";
				$sql .=", fld_usuario_graba, fld_fecha_grabacion, fld_hora_grabacion)";
				$sql .=" VALUES(:codigo, :nombre";
				$sql .=", :usrProcess, :usrFecha, :usrHora)";
		
				$consulta = $conexion->prepare($sql);		
				$consulta->execute(
				array(
				':codigo'	=>	$codigo,
				':nombre'	=>	$nombre,
				':usrProcess'	=> $usrProcess,
				':usrFecha'  	=> $usrFecha,
				':usrHora'    	=> $usrHora		
				)
				);
				if ($consulta->rowCount() > 0){
					$data = 1;
					}else{
					$data = 0;
				}
				print json_encode($data, JSON_UNESCAPED_UNICODE);
				$conexion = NULL;
			
			}catch (Exception $e) {
				$data = 2;
				print json_encode($data, JSON_UNESCAPED_UNICODE);
				$conexion = NULL;	
					
			}
		}
		public static function Modificar_Lineas($codigo,$nombre,$id,$usrProcess,$usrFecha,$usrHora){
			$conexion =Conexion::Conectar();
			try {
				$sql ="UPDATE inv_lineas SET ";
				$sql .="  fld_codlinea=:codigo  ";
				$sql .=", fld_nombre=:nombre ";
				$sql .=", fld_usuario_modifica=:usrProcess";
				$sql .=", fld_fecha_modificacion=:usrFecha";
				$sql .=", fld_hora_modificacion=:usrHora";
				$sql .=" WHERE fld_econsecutivo=:id";
		
				$consulta = $conexion->prepare($sql);	
				
				$consulta->execute(
				array(
				':codigo'	=>	$codigo,
				':nombre'	=>	$nombre,
				':usrProcess'	=> $usrProcess,
				':usrFecha'  	=> $usrFecha,
				':usrHora'    	=> $usrHora,
				':id'		=>	$id
				)
				);
				if ($consulta->rowCount()){
					$data = 1;
					}else{
					$data = 0;
				}    
				print json_encode($data, JSON_UNESCAPED_UNICODE);
				$conexion = NULL;   
			}catch (Exception $e) {
				    $data = 2;
					print json_encode($data, JSON_UNESCAPED_UNICODE);
					$conexion = NULL;   
			}
		}
		public static function Consultar_Lineas($id){
			$conexion =Conexion::Conectar();
			try {
				$output = array();

				$sql ="SELECT * FROM inv_lineas";
				$sql .=" WHERE fld_econsecutivo =".$_POST["id"]."  LIMIT 1";

				$statement = $conexion->prepare($sql);
				$statement->execute();
				$result = $statement->fetchAll();
				foreach($result as $row)
				{
					$output["codigo"] = $row["fld_codlinea"]; 
					$output["nombre"] = $row["fld_nombre"]; 
					$output["usuarioguarda"] = $row["fld_usuario_graba"]; 
					$output["fechagrabacion"] = $row["fld_fecha_grabacion"]; 
					$output["horagrabacion"] = $row["fld_hora_grabacion"]; 
					$output["usuariomodifica"] = $row["fld_usuario_modifica"]; 
					$output["fechamodifica"] = $row["fld_fecha_modificacion"]; 
					$output["horamodifica"] = $row["fld_hora_modificacion"]; 
					$output["id"] = $row["fld_econsecutivo"]; 
				}
				echo json_encode($output);
				$conexion = NULL;  //Cierra la conexion a la Base de datos
		
			}catch (Exception $e) {
					
					echo '<span class="label label-danger label-block">ERROR AL CARGAR LOS DATOS, PRESIONE F5</span>';
			}
		}
		public static function Eliminar_Lineas($id){
			$conexion =Conexion::Conectar();
			$response = array();
			try {
				$pid = intval($_POST['id']);

				$sql ="DELETE FROM inv_lineas";
				$sql .=" WHERE fld_econsecutivo=:pid";
				$stmt = $conexion->prepare($sql);
				$stmt->execute(array(':pid'=>$pid));
				
				if ($stmt) {
					$response['status']  = 'success';
					$response['message'] = 'País eliminado correctamente...';
					} else {
					$response['status']  = 'error';
					$response['message'] = 'No se puede eliminar el País ...';
				}
				echo json_encode($response);
				
			}catch (Exception $e) {
					
				$response['status']  = 'error';
				$response['message'] = 'Error de excepcion, comuniquese con servicio al cliente ...';
				echo json_encode($response);
			}
		}
		
	
		
	
	} // Fin de la clase
?>