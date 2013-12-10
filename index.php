<?php
session_start();

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
<script src="http://cdn.jquerytools.org/1.2.7/full/jquery.tools.min.js"></script>
<link rel="stylesheet" type="text/css" href="resources/css/all.css"/>
</head>

<body>
<form id="reg_form">
  <fieldset>
    <center><h3>Registration form</h3>
    <p>Please enter your email address to continue. </p></center>

    <p>
      <label>email *</label>
      <input type="email" name="email" required="required" />
    </p>
    <p id="terms">
      <label>I accept the terms</label>
      <input type="checkbox" required/>
    </p>
    <button type="submit" id="submit1">Submit form</button>
    <button type="reset">Reset</button>
  </fieldset>
</form>
<script>
	$(document).ready(function() {
		$("#submit1").click(function(event) {
			var check = $("#reg_form :input").validator();
			if (check.data("validator").checkValidity() == true)
			{
				event.preventDefault();
				window.location.href = "registration.php";
			}

		});
	});
</script>
</body>
</html>



