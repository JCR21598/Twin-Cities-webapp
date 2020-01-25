
<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta keywords>
        
        <!--Link to resources-->
        <link href="main.css" rel="stylesheet" type"text/css"/>
        <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
    </head>

    <body>
        <header>
            <div class="card">
                <div class="container">
                    <div class="header">
                        <h1>Twin Cities: Exeter and Rennes</h1>
                    </div>
                </div>
            </div>
        </header>
        <main>
            
    <!-- Weather -->
            <div class="row">
                <div class="column">
                    <div class="card">
                        <div class="container">
                            <h3>Exeter Weather Forecast</h3>
                            <script type='text/javascript' src='https://darksky.net/widget/default/50.7256,-3.5269/uk12/en.js?width=100%&height=200&title=Exeter, Uk&textColor=333333&bgColor=FFFFFF&transparency=false&skyColor=undefined&fontFamily=Default&customFont=&units=uk&htColor=333333&ltColor=C7C7C7&displaySum=yes&displayHeader=yes'></script>
                        </div>
                    </div>
                </div>
                <div class="column">
                    <div class="card">
                        <div class="container">
                            <h3>Rennes Weather Forecast</h3>
                                <div class="weather">
                                   <script type='text/javascript' src='https://darksky.net/widget/default/48.1113,-1.68/uk12/en.js?width=100%&height=200&title=Rennes&textColor=333333&bgColor=FFFFFF&transparency=false&skyColor=undefined&fontFamily=Default&customFont=&units=uk&htColor=333333&ltColor=C7C7C7&displaySum=yes&displayHeader=yes'></script>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        
            <div class="row">
                <div class="column">
                    <div class="card">
                        <div class="container">
                            <h3>Addtional Weather on Exeter</h3>
                            <div id="Exeter-WeatherAPI"></div>
                        </div>
                    </div>
                </div>
                <div class="column">
                    <div class="card">
                        <div class="container">
                            <h3>Addtional Weather on Rennes</h3>
                            <div id="Rennes-WeatherAPI"></div>
                        </div>
                    </div>
                </div>
            </div>

    <!--Maps-->
            <div class="row">
                <div class="column">
                    <div class="card">
                        <div class="container">
                            <h2>Exeter (Devon, United Kingdom)</h2>
                            <div id="emap" style="width:100%"></div>
                        </div>
                    </div>
                </div>
                <div class="column">
                    <div class="card">
                        <div class="container">
                            <h2>Rennes (Brittany, France)</h2>
                            <div id="rmap" style="width:100%"></div>
                        </div>
                    </div>
                </div>
            </div>

    <!-- Overlay hidden until marker mouse clicked -->
            <div id="overlay">
                <div class="overlay-content">
                    <div class="overlay-header">
                        <div class="overlay-POI"></div>
                        <div class="overlay-location"></div>
                        <div class="overlay-postcode"></div>
                    </div>
                    <span class="overlay-image"></span>
                    <div class="overlay-text">
                        <div class= "overlay-tweet"></div>
                        <div class="overlay-description"></div>
                        <div class="overlay-wiki"></div>
                    </div>
                    <span class="overlay-button" onclick="closeOverlay()">&times</span>
                </div>
            </div>
                
    <!--Twitter-->
            <div class="row">
                <div class="column">
                    <div class="ECard card">
                        <div class="container">
                            <h3>Exeter Twitter Feed</h3>
                                <div class = "box">
                                    <div id="ExeterTwitter">
                                        <ul id="ETweets" style="height:100%; width:100%"></ul>
                                    </div> 
                                </div>
                        </div>
                    </div>
                </div>

                <div class="column">
                    <div class="RCard card">
                        <div class="container">
                            <h3>Rennes Twitter Feed</h3>
                                <div class = "box">
                                    <div id="RennesTwitter">
                                        <ul id="RTweets" style="height:100%; width:100%"></ul>         
                                    </div> 
                                </div>
                        </div>
                    </div>
                </div>
            </div>
            
    <!--Flickr-->
            <div class="row">
                <div class="column">
                    <div class="card">
                        <div class="container">
                            <h3>Exeter Pictures</h3>
                            <!--php to call to flickr-->                                
                            <?php include('flickr/ExeterFlickrC.php')?>   
                        </div>
                    </div>
                </div>
                <div class="column">
                    <div class="card">
                        <div class="container">
                            <h3>Rennes Pictures</h3>
                             <!--php to call to flickr--> 
                            <?php include('flickr/RennesFlickrC.php')?>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <footer>
    <!--DB rss-->
            <button class="RSS-button">Toggle RSS Feed</button>
            <div id="rssfeed" class="rssfeed">
                <?php include('rssfeed/rss.php')?>  
            </div>     
        </footer>

        <!--Map script-->
        <script src = "index.js"></script> 
        <!--Link to Google API-->
        <script async defer src="//maps.googleapis.com/maps/api/js?key=AIzaSyA4gbNSGLkjyetmih1AAUDCLnKFYiXrlrM &callback=initMap"></script>
    </body>
</html>