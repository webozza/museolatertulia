
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Maps</title>
   <style>
    body, html {
    margin: 0;
    padding: 0;
    width: 100%;
    height: 100px;
}

.elementor-column-gap-default>.elementor-column>.elementor-element-populated {
    padding: 0px;
}
#fcbb {
    max-height: 100vh!important; 
    overflow-y: auto;
    background-color: #eeeeee;
    padding: 0px;
}


#map-l, #map-r {
    width: 104%;
    height: 100%;
    top: 0;
}

#map-l {
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

#map-r {
    right: 0;
    background-color: #ffffff;
    z-index: 2;
}

#map-l svg .country:hover {
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
  </head>
  <body>
    <div id="map-l">
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
        <?php include get_stylesheet_directory_uri(  ) . '/src/map_svj.php'?>
    </div>
    <div id="map-r">

      
    </div>
    <script>
        document.getElementById('colombia').addEventListener('click', function() {
    openPais("colombia");
});

  document.getElementById('argentina').addEventListener('click', function() {
    openPais("argentina");
});

 document.getElementById('chile').addEventListener('click', function() {
    openPais("chile");
});

 document.getElementById('bolivia').addEventListener('click', function() {
    openPais("bolivia");
});

 document.getElementById('brasil').addEventListener('click', function() {
    openPais("brasil");
});

 document.getElementById('cuba').addEventListener('click', function() {
    openPais("cuba");
});

 document.getElementById('ecuador').addEventListener('click', function() {
    openPais("ecuador");
});

 document.getElementById('usa').addEventListener('click', function() {
    openPais("estados-unidos");
});

 document.getElementById('canada').addEventListener('click', function() {
    openPais("canada");
});


 document.getElementById('venezuela').addEventListener('click', function() {
    openPais("venezuela");
});


function openPais(pais) {
    
  var url1 = "https://bienales.museolatertulia.com/mapaview/?_bienales=i-bienal&_pases=";
  var url2 = "https://bienales.museolatertulia.com/mapaview/?_bienales=ii-bienal&_pases=";
  var url3 = "https://bienales.museolatertulia.com/mapaview/?_bienales=iii-bienal&_pases=";
  var anoGuardado = localStorage.getItem('anoGuardado');

  if (anoGuardado === null) {
    window.location = "https://bienales.museolatertulia.com/mapaview/"
  } else {
    if (anoGuardado == "1971") {
      url1 = url1+pais;
      window.location = url1;
    }
    if (anoGuardado == "1973") {
      url2 = url2+pais;
      window.location = url2;
    }
    if (anoGuardado == "1976") {
      url3 = url3+pais;
      window.location = url3;
    }
    localStorage.setItem('paisGuardado', pais);
  }
  
   

}

document.addEventListener("DOMContentLoaded", function() {
 var paisGuardado = localStorage.getItem('paisGuardado');

var urlActual = window.location.href;

if (urlActual == "https://bienales.museolatertulia.com/mapaview/?_bienales=i-bienal") {
    
} else if (urlActual == "https://bienales.museolatertulia.com/mapaview/?_bienales=ii-bienal") {
    
} else if (urlActual == "https://bienales.museolatertulia.com/mapaview/?_bienales=iii-bienal") {
    
} else {
    var miDiv = document.getElementById(paisGuardado);
    // Agrega un estilo al elemento <div>
    
    if (paisGuardado == "estados-unidos") {
        miDiv = document.getElementById("usa");
    }
    miDiv.style.fill = "#394d62";
}

 
});


function loadCountryData(countryName) {
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'get_country_data.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        if (this.status == 200) {
            document.getElementById('map-r').innerHTML = this.responseText;
        }
    };
    xhr.send('country=' + countryName);
}




const svg = document.querySelector("svg");
      let scale = 0.9;
      let translateX = 0;
      let translateY = 40;
      updateTransform();

      function updateTransform() {
        svg.style.transform = `scale(${scale}) translate(${translateX}px, ${translateY}px)`;
      }

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
      
      
    </script>
  </body>
</html>
