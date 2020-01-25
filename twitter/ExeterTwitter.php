<?php
//Author Trent Meier
//Purpose: make twitter API calls and perform sentiment analysis on returned tweets
//Date: 27.3.2019
//Uses code from James Mallison, see https://github.com/J7mbo/twitter-api-php
//AFINN dataset under open source licenes, see http://www2.imm.dtu.dk/pubdb/views/publication_details.php?id=6010
ini_set('display_errors', 1);
include('TwitterAPIExchange.php');
//config file
include("C:/xampp/htdocs/projects/DSA CourseWork/Twin-Cities/config.php");

//access tokens from config
$settings = array(
    'oauth_access_token' => $twitter_oauth_access_token,
    'oauth_access_token_secret' => $twitter_oauth_access_token_secret,
    'consumer_key' => $twitter_consumer_key,
    'consumer_secret' => $twitter_consumer_secret
    );
        
//get request
$url = 'https://api.twitter.com/1.1/search/tweets.json';
//by name and geocode
$getfield = '?q=Exeter&geocode=50.725562,-3.5269108,25km';
$requestMethod = 'GET';
$twitter = new TwitterAPIExchange($settings);
$data=$twitter->setGetfield($getfield)
        ->buildOauth($url, $requestMethod)
        ->performRequest();
    
//Read the JSON into a PHP object
$phpdata = json_decode($data, true);
    

$filename='AFINN-111.txt';

//open file
$file = fopen($filename,"r");

//read line by line into array
$tweet = array();
while(! feof($file)){
    $str = fgets($file);
    $tweet[] = $str;
}
fclose($file);

//initialise counting vars
$pos=0;
$neg=0;
$tots=0;

//Loop through the "statuses" from the api queary
foreach ($phpdata["statuses"] as $status){

    $temp = 0;
    //loop through the array from the sentiment anaylsis
    foreach($tweet as $currentStr){
        
        $test = preg_split('/\s+/', $currentStr);
        
        //test if word is in string
        if(stripos($status["text"], $test[0]) !== false){

            //add dictionary value to temp
            $temp+=(int)$test[1];
        }
    }

    //test if temp is positive or negative
    if($temp > 0){
        $pos +=1;
    }else if($temp < 0){
        $neg +=1;
    }
    $tots +=1;
}

//add html to echo string
$return = '<h5>'. 'Of current Exeter twitter users: '. round(($pos/$tots)*100) . '% are positive';
$return .= ' and: '. round(($neg/$tots)*100) . ' % are negative' .  '</h5>';

//iterate through statuses and add to string
foreach ($phpdata["statuses"] as $status){
    
    $return .= '<p>'.$status["user"]["name"]." tweeted: " .$status["text"].'</p>';
    
}

//echo
echo($return);
?>