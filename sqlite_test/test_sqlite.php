<!DOCTYPE html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta charset="UTF-8">
    <title>test</title>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">

	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>

  </head>
  <body>
    
    <div class="row">
		
<?php 


$dbName = "test_sqlite.db";
if (!file_exists($dbName)) {
    die("Could not find database file.");
}

$db = new SQLite3("$dbName");

$results = $db->query('SELECT * FROM test');
while ($row = $results->fetchArray()) {
    var_dump($row);
}


?>
	</div>
  </body>
</html>
