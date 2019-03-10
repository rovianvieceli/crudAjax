<?php
	require 'db_config.php';

	$sql = '';
	$result = array();
	$per_page = 15;
	$page = (int) isset($_GET["page"]) ? $_GET["page"] : 1;
	$start = ($page-1) * $per_page;
	$search = ((isset($_POST['search'])) ? '%' . htmlspecialchars($_POST['search']) . '%' : (isset($_GET['search'])? '%' . htmlspecialchars($_GET['search']) . '%' : (bool) FALSE));
	$paginate = ((DB_DRIVE == 'pgsql') ? " LIMIT {$per_page} OFFSET {$start}" : (DB_DRIVE == 'mysql' ? " LIMIT {$start}, {$per_page}" : (bool) FALSE));

	if (DB_SCHEMA !== '') {
		$sql = "SET SEARCH_PATH TO " . DB_SCHEMA . ";";
		$stmt = $dbh->prepare($sql);
		$stmt->execute();
	}

	$sql = "SET CLIENT_ENCODING TO 'UTF8';";
	$stmt = $dbh->prepare($sql);
	$stmt->execute();

	if ($search) {
		// $sql = "
		// 	SELECT id, ordem, nome, dtnasc
		// 	FROM " . DB_DATABASE . ".cadastro
		// 	WHERE nome ILIKE :search
		// 	ORDER BY id DESC
		// 	{$paginate}
		// ";

		$sql = "
			SELECT fe.id, fe.ordem, un.nome, un.dtnasc
			FROM cg_fila_espera fe
			INNER JOIN un_unico un ON un.codigo = fe.id_unico
			WHERE un.nome ILIKE :search
			ORDER BY fe.id DESC
			{$paginate}
		";
	} else {
		// $sql = "
		// 	SELECT id, ordem, nome, dtnasc
		// 	FROM " . DB_DATABASE . ".cadastro
		// 	ORDER BY id DESC
		// 	{$paginate}
		// ";

		$sql = "
			SELECT fe.id, fe.ordem, un.nome, un.dtnasc
			FROM cg_fila_espera fe
			INNER JOIN un_unico un ON un.codigo = fe.id_unico
			ORDER BY fe.id DESC
			{$paginate}
		";
	}

	$stmt = $dbh->prepare($sql);
	(!$search)?:$stmt->bindParam(':search', $search);
	$stmt->execute();
	$result['data'] = $stmt->fetchAll(PDO::FETCH_OBJ);

	if (!empty($result['data'])) {
		array_walk($result['data'], function(&$data) {
			$date = new DateTime($data->dtnasc);
			$data->dtnasc = $date->format('d/m/Y');
		});
	}

	$sql = "SELECT * FROM cg_fila_espera;";
	$stmt = $dbh->prepare($sql);
	$stmt->execute();
	$result['total'] = $stmt->rowCount();

	die(json_encode($result));
