function buildForm(formid)
{
	formSelector = "#" + formid;

	$(document).ready(function() {

		$.post("ajax/get_reg_fields.php", function(data) {

		}).done(function(data) {

			var field_array = $.parseJSON(data);
			var submit_id = '';
			$.each(field_array, function(index, value) {

				$("<p>").appendTo(formSelector);

				if (value.type == 'submit')
				{

					$("<button type='submit' id='" + value.id + "'>" + value.label + "</button>").appendTo(formSelector);
					submit_id = value.id;
				}
				else if (value.type == 'text' || value.type == "email" || value.type == "checkbox")
				{
					default_value = (typeof value.value != 'undefined') ? value.value : '';
					item = "<label>" + value.label + "*</label><input type='" + value.type + "' value='" + default_value + "'";
					if (value.required) item += " required='required'";
					if (value.size) item += " size='" + value.size + "'";
					item += "/><br/>";
					$(item).attr("id", value.id).attr("name", value.name).appendTo(formSelector);
				}

				else if (value.type == "radio")
				{
					group_name = value.name;
					label = "<label>" + value.label + "</label>";
					$(label).appendTo("#reg_form");
					$.each(value.options, function(index,value) {
						radio = "<input type='radio' name='" + group_name + "' id='" + value.id + "' value='" + value.value + "'/><label class='radiotype' for = '" + value.id + "'>" + value.label + "</label>";
						$(radio).appendTo(formSelector);
					});


				}

				else if (value.type == "select")
				{

					item = "<label>" + value.label + "*</label><select name='" + value.name + "' id='" + value.id + "'>";
					$.each(value.options, function(index,value) {
						item += "<option value='" + value.submit_value + "'>" + value.show_value + "</option>";
					});

					item += "</select><br/>";

					$(item).appendTo(formSelector);
				}

				$("</p>").appendTo(formSelector);

			});

			$("#" + submit_id).click(function(event) {
				event.preventDefault();
				var check = $(formSelector + " :input").validator();
				if (check.data("validator").checkValidity() == true)
				{

					window.location.href = "survey.php";
				}

			});

		}).fail(function(data) {
			alert(data.statusText);
		});


	});
}