<?php
// Author Sam Kirk 20/02/2019
// The twitter api code is based on code by Asif Ahmed (http://lifesforlearning.com/connecting-to-the-flickr-api-with-php/) but has been modified.
// The purpose of this code is to pull images from Flickr based on coordinates and key terms. Additionally, the code does some server side caching, if it has
// been longer than a day the code will pull new images from flickr and save them over the current images. If it has been less than a day since the file was
// was modified the code will just use the images in that have been cached.

$file = "C:/xampp/htdocs/projects/DSA CourseWork/Twin-Cities/flickr/pictures/"; // location of cache file
$current_time = time();
$cache_last_modified = filemtime($file.'0.jpg'); // time when the cache file was last modified
$file_exists_count = 0;

for($i = 0; $i < 25; $i++) {
    // check there all files present
    if(file_exists($file.$i.".jpg")){
        $file_exists_count++;
    }
}


//IF cache exists use cache, if not make cache
if(($file_exists_count = 25) && ($current_time < strtotime('+1 sec', $cache_last_modified))){ //check if cache file exists and hasn't expired yet
    // use cached files
    for($i=0;$i<25;$i++){
        print "<img class='myImages' id='myImg' title='Exeter Flickr image ".$i."' src='http://localhost/projects/DSA%20CourseWork/Twin-Cities/flickr/pictures/'".$i.".jpg' />";
    }
}
else {
    // use api
    include("config.php");
    
    $api_key = $flickr_key;
    $tag = 'building,castle,grass,quay';
    $lat = $exeter_lat;
    $lon =$exeter_lon;
    $radius = 3;
    $perPage = 25;
    
    $url = $flickr_url;
    $url.= '&tags='.$tag;
    $url.='&lat='.$lat;
    $url.='&lon='.$lon;
    $url.='&radius='.$radius;
    $url.= '&per_page='.$perPage;
    $url.= '&format=json';
    $url.= '&nojsoncallback=1';


    //Decode json file into response then navigate to photos
    $response = json_decode(file_get_contents($url));
    $photo_array = $response->photos->photo;
    
    $i = 0;

    foreach($photo_array as $single_photo){
        
        $farm_id = $single_photo->farm;
        $server_id = $single_photo->server;
        $photo_id = $single_photo->id;
        $secret_id = $single_photo->secret;
        $size = 'q';
        
        $title = $single_photo->title;
        
        $photo_url = 'http://farm'.$farm_id.'.staticflickr.com/'.$server_id.'/'.$photo_id.'_'.$secret_id.'_'.$size.'.'.'jpg';

        //save to folder
        copy($photo_url, "C:/xampp/htdocs/projects/DSA CourseWork/Twin-Cities/flickr/pictures/".$i.'.jpg');

        $i++;

        print "<img class='myImages' id='myImg' title='".$title."' src='".$photo_url."' />";
    }

}

?>