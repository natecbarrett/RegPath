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
<link rel="stylesheet" type="text/css" href="resources/css/all.css"/>
</head>

<body>
<form id="reg_form">
</form>
<script>
	$(document).ready(function() {

		$.post("ajax/get_reg_fields.php", function(data) {

		}).done(function(data) {

			var field_array = $.parseJSON(data);
			var submit_id = '';
			$.each(field_array, function(index, value) {

				$("<p>").appendTo("#reg_form");

				if (value.type == 'submit')
				{

					$("<button type='submit' id='" + value.id + "'>" + value.label + "</button>").appendTo("#reg_form");
					submit_id = value.id;
				}
				else if (value.type == 'text' || value.type == "email" || value.type == "checkbox")
				{
					default_value = (typeof value.value != 'undefined') ? value.value : '';
					item = "<label>" + value.label + "*</label><input type='" + value.type + "' value='" + default_value + "'";
					if (value.required) item += " required='required'";
					if (value.size) item += " size='" + value.size + "'";
					item += "/><br/>";
					$(item).attr("id", value.id).attr("name", value.name).appendTo("#reg_form");
				}

				else if (value.type == "radio")
				{
					group_name = value.name;
					label = "<label>" + value.label + "</label>";
					$(label).appendTo("#reg_form");
					$.each(value.options, function(index,value) {
						radio = "<input type='radio' name='" + group_name + "' id='" + value.id + "' value='" + value.value + "'/><label class='radiotype' for = '" + value.id + "'>" + value.label + "</label>";
						$(radio).appendTo("#reg_form");
					});


				}

				else if (value.type == "select")
				{

					item = "<label>" + value.label + "*</label><select name='" + value.name + "' id='" + value.id + "'>";
					$.each(value.options, function(index,value) {
						item += "<option value='" + value.submit_value + "'>" + value.show_value + "</option>";
					});

					item += "</select><br/>";

					$(item).appendTo("#reg_form");
				}

				$("</p>").appendTo("#reg_form");

			});

			$("#" + submit_id).click(function(event) {
				event.preventDefault();
				var check = $("#reg_form :input").validator();
				if (check.data("validator").checkValidity() == true)
				{

					window.location.href = "survey.php";
				}

			});

		}).fail(function(data) {
			alert(data.statusText);
		});


	});
</script>
</body>
</html>
