

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

        .map_container{
            position: relative;
        }



   </style>


    <div class="map_container">
        <div id="map">
            <?php include get_stylesheet_directory(  ) . '/src/map_svj.php'?>
        </div>

        <div id="zoom-controls">
        <button id="zoomIn">
          <img style="width:35px;height: 35px !important; padding: 5px;" src="https://bienales.museolatertulia.com/wp-content/uploads/2023/10/but-zoomin.png" />
        </button>
        <button id="zoomOut">
          <img style="width:35px;height: 35px !important; padding: 5px;" src="https://bienales.museolatertulia.com/wp-content/uploads/2023/10/but-zoomout.png" />
        </button>
        <button id="moveLeft">
          <img style="width:35px;height: 35px !important; padding: 5px;" src="https://bienales.museolatertulia.com/wp-content/uploads/2023/10/but-izq.png" />
        </button>
        <button id="moveRight">
          <img style="width:35px;height: 35px !important; padding: 5px;" class="disenoImg" src="https://bienales.museolatertulia.com/wp-content/uploads/2023/10/but-der.png" />
        </button>
        <button id="moveUp">
          <img style="width:35px;height: 35px !important; padding: 5px;" src="https://bienales.museolatertulia.com/wp-content/uploads/2023/10/but-arri.png" />
        </button>
        <button id="moveDown">
          <img style="width:35px;height: 35px !important; padding: 5px;" src="https://bienales.museolatertulia.com/wp-content/uploads/2023/10/but-abaj.png" />
        </button>
    </div>
    </div>


    
    <script>
        const svg = document.querySelector("svg");
                let scale = 0.9;
                let translateX = 0;
                let translateY = 40;
                updateTransform();

        function updateTransform() {
                    svg.style.transform = `scale(${scale}) translate(${translateX}px, ${translateY}px)`;
                }

        function mapController(){
            document.getElementById("zoomIn").addEventListener("click", () => {
                scale += 0.1;
                updateTransform();
            });

            document.getElementById("zoomOut").addEventListener("click", () => {
                scale -= 0.1;
                updateTransform();
            });

            document.getElementById("moveLeft").addEventListener("click", () => {
                translateX -= 30;
                updateTransform();
            });

            document.getElementById("moveRight").addEventListener("click", () => {
                translateX += 30;
                updateTransform();
            });

            document.getElementById("moveUp").addEventListener("click", () => {
                translateY -= 30;
                updateTransform();
            });

            document.getElementById("moveDown").addEventListener("click", () => {
                translateY += 30;
                updateTransform();
            });
            
      }
      mapController()
    </script>

