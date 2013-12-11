<?php

include "../db/db.inc.php";

// Instantiate database.
$database = new clsDataBase();

//Create sql to get the fields for the form
$sql = "SELECT field.field_id, field.name, field.label, field.type, field.id, field.required, field.size FROM field INNER join form_field ON form_field.field_id = field.field_id WHERE form_field.form_id = :form_id";

//Set the query
$database->query($sql);

//Bind the params
$database->bind(':form_id', 1);

//Execute and get the results set.
$fields_info = $database->resultset();


//Loop through the fields.
foreach($fields_info as $field_info)
{
	//Get the field type.
	$field_type = $field_info['type'];

	//An arraay to hold the field stuff.
	$field = array();

	//Set the field id
	$field['id'] = $field_info['id'];

	//Set the field name.
	$field['name'] = $field_info['name'];

	//Set the field label.
	$field['label'] = $field_info['label'];

	//Set the field type.
	$field['type'] = $field_info['type'];

	//Set the required
	$field['required'] = $field_info['required'];

	//Set the field size.
	$field['size'] = $field_info['size'];



	//Is it a select field?
	if ($field_type == "select")
	{

		//Create sql to get the select options source
		$sql = "SELECT `table`, `show_field_name`, `submit_field_name` FROM field_select_options WHERE field_id = :field_id";

		//Set the query
		$database->query($sql);

		//Bind the params
		$database->bind(':field_id', $field_info['field_id']);

		//Execute and get the result set.
		$select_option_source = $database->single();

		//Build sql to get the select options.
		$sql = "SELECT " . $select_option_source['show_field_name'] . " as show_value, " . $select_option_source["submit_field_name"] . " as submit_value FROM " . $select_option_source['table'];

		//Set the query.
		$database->query($sql);

		//Execute and get results.
		$select_options = $database->resultset();


		//Loop through the options.
		foreach ($select_options as $option)
		{
			$field['options'][] = $option;
		}


	}

	else if ($field_type == 'radio')
	{
		//Create sql to get the info for the radio button.
		$sql = "SELECT id, label, value FROM field_radio_options WHERE field_id = :field_id";

		//Set the query.
		$database->query($sql);

		//bind the params.
		$database->bind(':field_id', $field_info['field_id']);

		//Execute and get results.
		$radio_buttons = $database->resultset();

		//Loop through all the radio buttons in the group.
		foreach ($radio_buttons as $radio_button)
		{
			$field['options'][] = $radio_button;
		}
	}

	//Add this field to the array of fields.
	$fields[] = $field;
}

echo json_encode($fields);

/*
$field_array = array();



$field = array("id" => "email", "name" => "email", "label" => "Email", "type" => "email", "required" => true, "value" => "email");
$field_array[] = $field;

$field = array("id" => "fname", "name" => "fname", "label" => "First Name", "type" => "text", "required" => true, "value" => "first");
$field_array[] = $field;

$field = array("id" => "income", "name" => "income", "label" => "Income Level", "type" => "select", "options" => array(array("show_value" => "1000-5000", "submit_value" => "Tier1"), array("show_value" => "5000-10000", "submit_value" => "Tier2")));
$field_array[] = $field;

$field = array("type" => "radio", "label" => "Gender", "name" => "gender", "options" => array(array("label" => "male", "id" => "male", "value" => "m", "checked" => true), array("label" => "female", "id" => "female", "value" => "f", "checked" => false)));
$field_array[] = $field;

$field = array("id" => "agree", "name" => "agree", "label" => "Agree To Terms", "type" => "checkbox", "required" => true, "value" => "agreed");
$field_array[] = $field;

$field = array("id" => "submit1", "name" => "submit", "label" => "Submit", "type" => "submit");
$field_array[] = $field;

echo json_encode($field_array);*/