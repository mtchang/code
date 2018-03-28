<?php
// -----------
// 程式功能：
// 檔案名稱：index.php
// 說明：
// 使用 bootstrap 4
//
//----------------
session_start();
require dirname(__FILE__)."/config.php";

// ----------------------------------------------------------------------------
$default_head_js	= '';
$default_extend_js	= '';
$default_content	= '';
// ----------------------------------------------------------------------------



$sql 		= "SELECT * FROM test;";
echo "<br><br><br> $sql <br><br>";
$result 		= runSQLall($sql);
var_dump($result);


$default_content = '
<form>
  <div class="form-group">
    <label for="exampleInputEmail1">Email address</label>
    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
    <small id="emailHelp" class="form-text text-muted">We ll never share your email with anyone else.</small>
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Password</label>
    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
  </div>
  <div class="form-check">
    <input type="checkbox" class="form-check-input" id="exampleCheck1">
    <label class="form-check-label" for="exampleCheck1">Check me out</label>
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
';


// ----------------------------------------------------------------------------
// 準備填入的內容
$tmpl_head_js				= $default_head_js;
$tmpl_extend_js				= $default_extend_js;
$tmpl_content				= $default_content;
// ----------------------------------------------------------------------------
?>

<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="test">
<meta name="author" content="test">
<link rel="icon" href="./favicon.ico">

<title>PAY</title>
<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

<!-- Custom styles for this template
<link href="./ui/def/css/style.css" rel="stylesheet">
-->
</head>
<body>

<header>

<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
	<a class="navbar-brand" href="index.html">test</a>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
	<span class="navbar-toggler-icon"></span>
	</button>
	<div class="collapse navbar-collapse" id="navbarCollapse">
		<ul class="navbar-nav mr-auto">
			<li class="nav-item active">
				<a class="nav-link" href="#">about <span class="sr-only"></span></a>
			</li>
			<li class="nav-item">
				<a class="nav-link disabled" href="#">demo1</a>
			</li>
			<li class="nav-item">
				<a class="nav-link disabled" href="#">demo2</a>
			</li>
		</ul>
	</div>
</nav>

</header>

<main role="main">
	<div class="col-12">

	<?php echo $tmpl_content; ?>

	</div>

	<!-- FOOTER -->
	<footer class="container">
		<p class="float-right"><a href="#">Back to top</a></p>
		<?php echo page_footer(); ?>
	</footer>

</main>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</body>
</html>
