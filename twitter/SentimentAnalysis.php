<?php
//Based on code by James Mallison, see https://github.com/J7mbo/twitter-api-php
ini_set('display_errors', 1);
include('TwitterAPIExchange.php');
//config file
include("C:/xampp/htdocs/projects/DSA CourseWork/Twin-Cities/config.php");
//settings from config
$settings = array(
    'oauth_access_token' => $twitter_oauth_access_token,
    'oauth_access_token_secret' => $twitter_oauth_access_token_secret,
    'consumer_key' => $twitter_consumer_key,
    'consumer_secret' => $twitter_consumer_secret
    );

//create db connection
$connection=mysqli_connect ($host, $username, $password);

//test connection
if (!$connection) {
  die('Not connected : ' . mysqli_error($connection));
}

//test db selection
$db_selected = mysqli_select_db($connection, $dbname);
if (!$db_selected) {
  die ('Can\'t use db : ' . mysqli_error($connection));
}

//create sql queary
$query = "SELECT * FROM Place_of_interest";

//return result set
$result = mysqli_query($connection, $query);

//test if valid result returned
if (!$result) {
  die('Invalid query: ' . mysqli_error($connection));
}

//iterate through resultset returned from POI
while ($row = @mysqli_fetch_assoc($result)){
    
    //inititialise twitter api get call for each POI   
    $url = 'https://api.twitter.com/1.1/search/tweets.json';
    //set get field to vars from resultset
    $getfield = '?q=&geocode='.$row['Geo_location_latP'].','.$row['Geo_location_longP'].',.5km';
    $requestMethod = 'GET';
    $twitter = new TwitterAPIExchange($settings);
    $data=$twitter->setGetfield($getfield)
                ->buildOauth($url, $requestMethod)
                ->performRequest();

    //Read the JSON into a PHP object
    $phpdata = json_decode($data, true);

    //test which city it is to determine which sentiment dictionary to use
    if($row["City"] == "Exeter"){
        $filename='AFINN-111.txt';
    }else if($row["City"]=="Rennes"){
        $filename='AFINN-FR.txt';
    }

    //read in appropriate file
    $file = fopen($filename,"r");
    $tweet = array();
    while(! feof($file)){
        $str = fgets($file);
        $tweet[] = $str;
    }
    fclose($file);
    
    //Loop through the status updates and print out the text of each
    $pos=0;
    $neg=0;
    $tots=0;
    
    //Loop through the status and dic to assign score
    foreach ($phpdata["statuses"] as $status){
        
        $temp = 0;
        
        foreach($tweet as $currentStr){
            $test = preg_split('/\s+/', $currentStr);
            if(stripos($status["text"], $test[0]) !== false){
                $temp+=(int)$test[1];
            }
        }

       if($temp > 0){
           $pos +=1;
       }else if($temp < 0){
           $neg +=1;
       }
       $tots +=1;
    }

    //record positive sentiment into variable
    $score = round(($pos/$tots)*100);
    
    //write to db for each POI by POI id
    $sqlstr = 'UPDATE Place_of_interest SET `sentiment_score`= '.$score.' WHERE `Place_of_interest_ID`= '.$row["Place_of_interest_ID"];

    //test if successful
    if ($connection->query($sqlstr) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $connection->error;
    }
    
    //echo for debugging
    echo("<li>".$row["PName"]." --> ".$score."% of users had a positive experience</li>");
}

//close connection
mysqli_close($connection)
?>