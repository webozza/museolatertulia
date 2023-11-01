

   <style>
        .elementor-column-gap-default>.elementor-column>.elementor-element-populated {
            padding: 0px;
        }
        #fcbb {
            max-height: 100vh!important; 
            overflow-y: auto;
            background-color: #eeeeee;
            padding: 0px;
        }
        #map{
            width: 104%;
            height: 100%;
            top: 0;
        }
        #map{
            left: 0;
            background-color: #FF8EC3;
            overflow: hidden; /* Enmascara el contenido desbordado */
            z-index: 1;
            height: 100vh;
            display: flex;
            align-content: center;
            justify-content: center;
            align-items: center;
            
        }
        #map svg .country:hover {
            fill: #394D62;
        }
        #zoom-controls {
            position: fixed;
            z-index: 10;
            background-color: #ffffff;
            padding: 5px;
            display: flex;
            bottom: 0;
            left: 0;
        }
        button {
            display: block;
            border: none;
            background: transparent;
            cursor: pointer;
        }
        .disenoImg {
            height: 20px;
            padding: 5px;
        }
        .butt-country {
            fill: #ffffff;
            transition-duration: 0.2s;
            cursor: pointer;
            stroke: black;
            stroke-width: 1;
            stroke-linejoin: round;
            stroke-miterlimit: 10;
        }
        .butt-country:hover {
            fill: #a4fffa;
        }



   </style>


    <div class="map_container">
        <div id="map">
            <?php include get_stylesheet_directory(  ) . '/src/map_svj.php'?>
        </div>
    </div>