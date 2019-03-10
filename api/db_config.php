<?php

	define('DB_DRIVE', "pgsql");
	define('DB_HOST', "");
	define('DB_USER', "");
	define('DB_PASSWORD', "");
	define('DB_DATABASE', "");
	define('DB_SCHEMA', ""); // Only PostgreSQL (pgsql)

	$dsn = DB_DRIVE . ':dbname=' . DB_DATABASE . ';host=' . DB_HOST;
	try {
		$dbh = new PDO($dsn, DB_USER, DB_PASSWORD);
	} catch (PDOException $e) {
		exit("Falha na Conexão: {$e->getMessage()}");
	}

