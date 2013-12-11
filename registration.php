<?php
session_start();
$step = isset($_SESSION['step']) ? $_SESSION['step'] : 0;
if ($step != 2) header("location: index.php");
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
<script src="http://cdn.jquerytools.org/1.2.7/full/jquery.tools.min.js"></script>
<script src="js/formbuilder.js"></script>
<link rel="stylesheet" type="text/css" href="resources/css/all.css"/>
</head>

<body>
<form id="reg_form">
</form>
<script>
	buildForm($("form")[0].id);
</script>
</body>
</html>
