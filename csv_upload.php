<?php

// Read CSV and create an array containing each row.
$tmpName = $_FILES['csvfile']['tmp_name'];

$file = fopen($tmpName, 'r');
$data = [];
while(! feof($file)) {
	$data[] = fgetcsv($file);
}
fclose($file);

// Remove first row containing the headers
array_shift($data);

// var_dump($data[1][2]);

// Validate $values
// All not empty - electronic should be 0 or 1
$valid = true;
$errors = []; 
foreach ($data as $key => $row) {
	// check each column isn't empty
	foreach ($row as $data) {
		if(trim($data) === '') {
			$valid = 'false';
			// echo 'A column is missing data';
			$row['error'] = 'A column is missing data';
			$row['row'] = $key;
			$errors[] = $row; 
		}
	}
	// check electronic is only 0 or 1
	if($row[2] !== "0" && $row[2] !== "1") {
		$valid = false;
		$row['error'] = 'Electronic should only contain 0 or 1';
		$row['row'] = $key;
		$errors[] = $row;
		// echo 'electronic should only contain 0 or 1';
	}
}

// echo $valid;
if(!$valid) {
	foreach ($errors as $error) {
		echo $error['error'] . ' in row ' . $error['row'] . '.<br>';
	}
	// var_dump($errors);
	echo 'Please correct these errors and reupload the csv.';
}

if($valid) {
	echo 'csv uploaded sucessfully';
	// Add each item to the db and the form
}

?>

<!-- <h1>CSV upload</h1> -->