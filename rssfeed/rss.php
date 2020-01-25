<?php
    //config
    include("config.php");

    //static xml info for rss
    $rssfeed = '<?xml version="1.0"';
    $rssfeed .= '<rss version="2.0">';
    $rssfeed .= '<?xml-stylesheet type="text/css" href="rssfeed/rss.css" ?>';
    $rssfeed .= '<title>Twin Cities: Exeter and Rennes</title>';
    $rssfeed .= '<link>http://localhost/projects/DSA%20CourseWork/Twin-Cities/</link>';
    $rssfeed .= '<description>Twin Cities RSS for Exeter and Rennes</description>';
    $rssfeed .= '<language>en-us</language>';
    


    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 

    //sql for city query
    $sqlCity = "SELECT * from City";
    $cityResult = $conn->query($sqlCity);

	//iterate through city
    while($row = mysqli_fetch_array($cityResult)) {
        extract($row);

        //open city tag
        $rssfeed .= '<city>';
        //city atributes
        $rssfeed .= '<name>' . $Name . '</name>' ;
        $rssfeed .= '<country>' . $Country . '</country>' ;
        $rssfeed .= '<longitude>' . $Geo_location_long . '</longitude>';
        $rssfeed .= '<latitude>' . $Geo_location_lat . '</latitude>';
        $rssfeed .= '<woeid>' . $WOEID . '</woeid>' ;
        $rssfeed .= '<postcode>' . $Postcode . '</postcode>' ;
        $rssfeed .= '<timezone>' . $Time_zone . '</timezone>' ;
        $rssfeed .= '<population>' . $Population_size . '</population>';
        $rssfeed .= '<density>' . $Population_density . '</density>';
        $rssfeed .= '<currency>' .$Currency . '</currency>';
        
        //query for each POI in each city      
        $sqlPOI = "SELECT * FROM `Place_of_interest` WHERE City = '".$Name."'";
        $poiResult = $conn->query($sqlPOI);
        
        //iterate throug POIs
        while($POIrow = mysqli_fetch_array($poiResult)) {
        extract($POIrow);
        
        //open POI tag
        $rssfeed .= '<placeOfInterest>';
        //poi attributes
        $rssfeed .= '<poiName>' . $PName . '</poiName>' ;
        $rssfeed .= '<type>' . $Type . '</type>' ;
		$rssfeed .= '<pcity>' . $City . '</pcity>' ;
        $rssfeed .= '<geo_long>' . $Geo_location_longP . '</geo_long>' ;
        $rssfeed .= '<geo_lat>' . $Geo_location_latP . '</geo_lat>';
        $rssfeed .= '<postcodep>' . $PostcodeP . '</postcodep>' ;
        $rssfeed .= '<capacity>' . $Capacity . '</capacity>' ;
        $rssfeed .= '<constructed>' . $Year_of_construction . '</constructed>' ;
        $rssfeed .= '<link>' . $wiki_link . '</link>' ;
        $rssfeed .= '<sentiment>'. $sentiment_score . '</sentiment>' ;
        $rssfeed .= '<description>' . $Description . '</description>';
        //close POI tag
        $rssfeed .= '</placeOfInterest>';
        }
        //close city tag
        $rssfeed .= '</city>';
        
    }
 
    echo $rssfeed;
    
    //close connection
    mysqli_close($conn)
?>