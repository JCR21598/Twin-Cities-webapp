<?php
//config file
include("config.php");

//function to parse xml
function parseToXML($htmlStr) {
  $xmlStr=str_replace('<','&lt;',$htmlStr);
  $xmlStr=str_replace('>','&gt;',$xmlStr);
  $xmlStr=str_replace('"','&quot;',$xmlStr);
  $xmlStr=str_replace("'",'&#39;',$xmlStr);
  $xmlStr=str_replace("&",'&amp;',$xmlStr);
  return $xmlStr;
  }
  
  // Create connection to db
  $connection=mysqli_connect ($host, $username, $password);
  
  //test connection
  if (!$connection) {
    die('Not connected : ' . mysqli_error($connection));
  }
  
  //test db
  $db_selected = mysqli_select_db($connection, $dbname);
  if (!$db_selected) {
    die ('Can\'t use db : ' . mysqli_error($connection));
  }
  
  //sql queary to select info
  $query = "SELECT Place_of_interest.*, Photo.* FROM Place_of_interest JOIN Photo ON Place_of_interest.Place_of_interest_ID = Photo.Place_of_interest_Place_of_interest_ID";
  
  //make query
  $result = mysqli_query($connection, $query);
  
  //test if result returned
  if (!$result) {
    die('Invalid query: ' . mysqli_error($connection));
  }
  
  //set header for xml doc
  header("Content-type: text/xml");
  // Start XML file, echo parent node
  echo "<?xml version='1.0' ?>";
  echo '<markers>';
  //counter var
  $ind=0;
  // Iterate through the rows, printing XML nodes for each
  while ($row = @mysqli_fetch_assoc($result)){
    // Add to XML document node
    echo '<marker ';
    echo 'id="' . $row['Place_of_interest_ID'] . '" ';
    echo 'name="' . $row['PName'] . '" ';
    echo 'type="' . $row['Type'] . '" ';
    echo 'city="' . $row['City'] . '" ';
    echo 'country="' . $row['PCountry'] . '" ';
    echo 'WOEID="' . $row['City_WOEID'] . '" ';
    echo 'postcode="' . $row['PostcodeP'] . '" ';
    echo 'capacity="' . $row['Capacity'] . '" ';
    echo 'construction="' . $row['Year_of_construction'] . '" ';
    echo 'cityid="' . $row['City_City_ID'] . '" ';
    echo 'wikilink="' . $row['wiki_link'] . '" ';
    echo 'latitude="' . $row['Geo_location_latP'] . '" ';
    echo 'longitude="' . $row['Geo_location_longP'] . '" ';
    echo 'icon_name="' . $row['icon_name'] . '" ';
    echo 'photo_path="' . $row['Image_filepath'] . '" ';
    echo 'description="' . $row['Description'] .'" ';
    echo 'tweet="' . $row['sentiment_score'] .'" ';
    echo '>';
    echo '</marker>';
    $ind = $ind + 1;
  }
  // End XML file
  echo '</markers>';
  ?>
