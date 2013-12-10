<?php

$field_array = array();

$field = array("id" => "email", "name" => "email", "label" => "Email", "type" => "email", "required" => true, "value" => "email");
$field_array[] = $field;

$field = array("id" => "fname", "name" => "fname", "label" => "First Name", "type" => "text", "required" => true, "value" => "first");
$field_array[] = $field;

$field = array("id" => "income", "name" => "income", "label" => "Income Level", "type" => "select", "options" => array(array("show_value" => "1000-5000", "submit_value" => "Tier1"), array("show_value" => "5000-10000", "submit_value" => "Tier2")));
$field_array[] = $field;

$field = array("type" => "radio", "label" => "Gender", "name" => "gender", "options" => array(array("label" => "male", "id" => "male", "value" => "m", "checked" => true), array("label" => "female", "id" => "female", "value" => "f", "checked" => false)));
$field_array[] = $field;

$field = array("id" => "submit1", "name" => "submit", "label" => "Submit", "type" => "submit");
$field_array[] = $field;

echo json_encode($field_array);