<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "store_data";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname); //variables can be used

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
} else {
  echo "connected succesfully" . "<br/>";
}

//creating a new table and checking for errors or duplicates.
$check = "CREATE TABLE planets (ID int NOT NULL AUTO_INCREMENT, name text,rotation_period int,orbital_period int,diameter int,climate text,gravity text,terrain text,surface_water int,population int,created text,edited text,url text, PRIMARY KEY (ID))";

if ($conn->query($check) === TRUE) {
  echo "planets created successfully<br>";
} else {
  echo $conn->error;
}

// Create a new cURL resource and set the file URL to fetch through cURL
$curl = curl_init('https://swapi.dev/api/planets');
if (!$curl) {
  die("Couldn't initialize a cURL handle");
};
//This option will return data as a string instead of direct output
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

// carry out the request
$result = curl_exec($curl);
// check for any errors
if (curl_errno($curl)) {
  echo (curl_error($curl));
  die();
};
// close CURL resource to free up system resources
curl_close($curl);
//Convert data into a JSON format, with Arrays
$response_data = json_decode($result, true);
// Print out the array format of the data from the Star Wars API
$data = $response_data['results'];

foreach ($data as $key => $value) {

  foreach ($value as $val) {
    $name = $value["name"];
    $rotation_period = $value["rotation_period"];
    $orbital_period = $value["orbital_period"];
    $diameter = $value["diameter"];
    $climate = $value["climate"];
    $gravity = $value["gravity"];
    $terrain = $value["terrain"];
    $surface_water = $value["surface_water"];
    $population = $value["population"];
    $created = $value["created"];
    $edited = $value["edited"];
    $url = $value["url"];
  }

  $query = "INSERT INTO planets (name,rotation_period,orbital_period,diameter,climate,gravity,terrain,surface_water,population,created,edited,url) 
  VALUES('$name','$rotation_period' , '$orbital_period', '$diameter','$climate','$gravity','$terrain','$surface_water','$population','$created','$edited','$url')";

  $conn->query($query);
  if ($conn->errno) {
    echo ($conn->error);
    die();
  }
}
