<?php
get_header(); // Cargar el encabezado de WordPress
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Zoom de Foto</title>
    <style>
      .drag-container {
        overflow: hidden;
        cursor: grab;
        
      }
  
      .drag-image {
        width: 100%;
        height: 100%;
        user-drag: none;
        user-select: none;
      }

      /* Estilos generales */
        body, html {
        margin: 0;
        padding: 0;
        height: 100%;
        overflow: hidden;
        }

        /* Estilos de la imagen de fondo */
        #fotozoom {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        }

        #fotozoom img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        }

        /* Estilos de la barra de navegación */
        #navegacion {
        position: fixed;
        bottom: 0;
        left: 0;
        padding: 10px;
        background-color: rgba(255, 255, 255);
        white-space: nowrap; /* Evitar el salto de línea */
        overflow-x: auto; /* Agregar scroll horizontal si es necesario */
        display: flex; /* Organizar los botones en una línea horizontal */
        justify-content: flex-start; /* Alinear los botones a la izquierda */
        align-items: center; /* Centrar verticalmente los botones */
        z-index: 2;
        max-height: 30px;
        }

        #navegacion button {
        background: transparent;
        border: none;
        cursor: pointer;
        margin-right: 10px;
        }

        #navegacion img {
        height: 20px;
        }

        /* Estilos de la ficha */
        #ficha {
        position: absolute;
        left: 4px;
        bottom: -300px;
        width: 176px;
        max-height: 300px; /* Altura máxima */
        background-color: white;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
        transition: bottom 0.3s ease-in-out;
        padding: 10px; /* Espacio interno para contenido */
        margin: 10px 0; /* Margen superior e inferior */
        overflow-y: auto; /* Scroll vertical automático */
        display: flex;
        flex-direction: column;
        z-index: 1; /* Cambio el z-index para que esté detrás del botón */
        }

      

        /* Estilos de la fichaotros */
        #fichaotros {
        position: fixed;
        top: 0;
        right: -50%; /* Inicialmente oculta hacia la derecha */
        width: 50%; /* Ocupa la mitad derecha de la pantalla */
        height: 100%;
        background-color: white;
        box-shadow: -5px 0px 10px rgba(0, 0, 0, 0.5);
        transition: right 0.3s ease-in-out;
     
        z-index: 3; /* Por encima de ficha y navegación */
        overflow: auto;
        }

        #obradetalles,
        #obrarelacionados {
        padding: 10px;
        }

        #fichaotros-cerrar {
        position: absolute;
        bottom: 10px;
        left: 10px;
        background: transparent;
        border: none;
        cursor: pointer;
        }

     

        .drag-image {
            width: 100%;
            height: 100%;
            user-drag: none;
            user-select: none;
            transition: transform 0.2s ease; /* Agregar transición para suavizar el zoom */
        }
        .col-lg-5 {
            flex: 0 0 auto;
            width: 41.6666666667%;
            display: none;
        }
        #ficha p {
            text-align: inherit;
            margin: 0;
            flex-grow: 1;
            word-wrap: break-word;
        }

        strong {
            color: #0d0d0d;
         }
    </style>
  </head>
  <body>




    <div id="fotozoom">
      <div class="drag-container">

      <?php

if (have_posts()) {
    while (have_posts()) {
        the_post();
        
        // Obtener las imágenes de la galería ACF
        $imagenes_galeria = get_field('obra-obra_participante_1');
    
        if (!empty($imagenes_galeria)) {
            $ultima_imagen = end($imagenes_galeria); // Obtener la última imagen de la galería
        
            // Mostrar la última imagen en el tamaño de vista previa
            echo '<img id="imgZoom" class="drag-image" src="' . esc_url($ultima_imagen) . '" alt="">';
         
        }
    }
}


?>
       
      </div>
    </div>

    <div id="ficha">
    


    <?php

        if (have_posts()) {
            while (have_posts()) {
                the_post();
                
                // Obtener las imágenes de la galería ACF
                $obra_nombre_completo = get_field('obra-nombre_completo');
                $obrafecha = get_field('obra-fecha');
                $obrabienal = get_field('obra-bienal');
                $obraedicion = get_field('obra-edicion');
                $obradimensiones = get_field('obra-dimensiones');
                $obratecnica_materiales = get_field('obra-tecnica_materiales');
                $obranacionalidad = get_field('obra-nacionalidad');
                
                $categoria = get_field('Categorías');
                $obra_id = get_the_ID(); // Reemplaza 123 con el ID de la obra que deseas consultar
                $taxonomia = 'categoria'; // Reemplaza 'tu_taxonomia' con la clave de la taxonomía
                $terminos = wp_get_post_terms($obra_id, $taxonomia);
                $categorias = "";
                if (!empty($terminos) && !is_wp_error($terminos)) {
                    foreach ($terminos as $termino) {
                        $categorias =  $categorias. $termino->name . ",";
                       
                    }
                } 

                $taxonomia = 'etiqueta'; // Reemplaza 'tu_taxonomia' con la clave de la taxonomía
                $terminos = wp_get_post_terms($obra_id, $taxonomia);
                $TAGS = "";
                if (!empty($terminos) && !is_wp_error($terminos)) {
                    foreach ($terminos as $termino) {
                        $TAGS =  $TAGS. $termino->name . ",";
                       
                    }
                } 
                
            echo '<h5 style="font-size: 11px;font-weight: bold;">' . $obra_nombre_completo . '</h5>';
           
            echo '<p style="font-size: 11px;font-weight: bold;">' . $obrafecha . '</p>';
            echo '<br>';
            echo '<p style="font-size: 11px;font-weight: bold;">Asociada  a ' . $obrabienal . '</p>'; 
            echo '<p style="font-size: 11px;font-weight: bold;">' . $obraedicion . '</p>';
            echo '<p style="font-size: 11px;font-weight: bold;">' . $obradimensiones . '</p>';
            echo '<p style="font-size: 11px;font-weight: bold;"><strong>Tecnica:</strong> ' . $obratecnica_materiales . '</p>';
            echo '<p style="font-size: 11px;font-weight: bold;"><strong>Nacionalidad:</strong> ' . $obranacionalidad . '</p>';
            echo '<br>';
            echo '<p style="font-size: 11px;font-weight: bold;"><strong>Categoria:</strong> ' . $categorias . '</p>';
            echo '<p style="font-size: 11px;font-weight: bold;"><strong>TAGS:</strong> ' . $TAGS . '</p>';
          
            }
        }
        ?>
    </div>

    <div id="navegacion">
      <button id="ficha-open">
        <img src="https://bienales.museolatertulia.com/wp-content/uploads/2023/10/but-open.png" alt="Botón Ficha" />
      </button>
      <button id="cerrarobra">
        <img src="https://bienales.museolatertulia.com/wp-content/uploads/2023/10/but-close.png" alt="Botón Cerrar Obra" />
      </button>
      <button id="relacionados">
        <img src="https://bienales.museolatertulia.com/wp-content/uploads/2023/10/but-files.png" alt="Botón Relacionados" />
      </button>
      <button id="zoomIn">
        <img src="https://bienales.museolatertulia.com/wp-content/uploads/2023/10/but-zoomin.png" alt="Botón Zoom In" />
      </button>
      <button id="zoomout">
        <img src="https://bienales.museolatertulia.com/wp-content/uploads/2023/10/but-zoomout.png" alt="Botón Zoom Out" />
      </button>
    </div>

    <div id="fichaotros">
      <div id="obradetalles">
        <!-- Contenido de los detalles de la obra -->
        <h4 style="
    color: black;
    font-weight: 700;
    font-size: 23px;
    font-family: initial;
">Detalles</h4>
<?php
// Obtener las imágenes de la galería ACF
$imagenes_galeria = get_field('obra-obra_participante_1');

if (!empty($imagenes_galeria)) {
    echo '<div class="galeria-obra">';

    // Definir la cantidad de imágenes por fila (en este caso, 3)
    $imagenes_por_fila = 3;
    $contador = 0;

    foreach ($imagenes_galeria as $imagen) {
        // Obtener la URL de la imagen
        $imagen_url = $imagen;

        // Mostrar la imagen
        echo '<a style="width: 270px;display: inline-table;" href="' . esc_url($imagen_url) . '" target="_blank"> <img style="width: 270px;padding:20px;display: block;" src="' . esc_url($imagen_url) . '" alt="Imagen ' . ($contador + 1) . '"></a>';

        // Incrementar el contador
        $contador++;

        // Si se han mostrado 3 imágenes, hacer un salto de línea
        if ($contador % $imagenes_por_fila === 0) {
            echo '<br>';
        }
    }

    echo '</div>';
}
?> 

      </div>
      <div id="obrarelacionados">
      <h4 style="
    color: black;
    font-weight: 700;
    font-size: 23px;
    font-family: initial;
">Documentos Relacionados</h4>
        <!-- Contenido de obras relacionadas -->
        <?php
// Obtener las imágenes de la galería ACF
$imagenes_galeria = get_field('obra-documentos');

if (!empty($imagenes_galeria)) {
    echo '<div class="galeria-obra">';

    // Definir la cantidad de imágenes por fila (en este caso, 3)
    $imagenes_por_fila = 3;
    $contador = 0;

    foreach ($imagenes_galeria as $imagen) {
        // Obtener la URL de la imagen
        $imagen_url = $imagen['url'];

        // Mostrar la imagen
        echo '<a style="width: 270px;display: inline-table;" href="' . esc_url($imagen_url) . '" target="_blank"> <img style="width: 270px;padding:20px;display: block;" src="' . esc_url($imagen_url) . '" alt="Imagen ' . ($contador + 1) . '"></a>';

        // Incrementar el contador
        $contador++;

        // Si se han mostrado 3 imágenes, hacer un salto de línea
        if ($contador % $imagenes_por_fila === 0) {
            echo '<br>';
        }
    }

    echo '</div>';
}
?>
      </div>
      <button id="fichaotros-cerrar">
        <img src="https://bienales.museolatertulia.com/wp-content/uploads/2023/10/but-close.png" alt="Botón Cerrar Ficha Otros" />
      </button>
    </div>

    <script>
      // JavaScript para mostrar/ocultar la ficha
const fichaButton = document.getElementById('ficha-open');
const fichaDiv = document.getElementById('ficha');

let fichaVisible = false;

fichaButton.addEventListener('click', () => {
    if (!fichaVisible) {
        fichaDiv.style.bottom = '35px'; // Agregamos el margen en la parte inferior
    } else {
        fichaDiv.style.bottom = '-320px';
    }
    fichaVisible = !fichaVisible;
});


const cerrarObraButton = document.getElementById('cerrarobra');
const relacionadosButton = document.getElementById('relacionados');
const fichaOtrosDiv = document.getElementById('fichaotros');
const fichaOtrosCerrarButton = document.getElementById('fichaotros-cerrar');

cerrarObraButton.addEventListener('click', () => {
    window.history.back(); // Volver a la página anterior
});

relacionadosButton.addEventListener('click', () => {
    fichaOtrosDiv.style.right = '0'; // Mostrar la fichaotros desde la derecha
});

fichaOtrosCerrarButton.addEventListener('click', () => {
    fichaOtrosDiv.style.right = '-50%'; // Ocultar la fichaotros hacia la derecha
});

fichaOtrosDiv.addEventListener('click', (event) => {
    if (event.target === fichaOtrosDiv) {
        fichaOtrosDiv.style.right = '-50%'; // Ocultar la fichaotros hacia la derecha al hacer clic por fuera
    }
});



const obrazoomButton = document.getElementById('obrazoom');
//const obrazoomoutButton = document.getElementById('obrazoomout');
const fotozoomDiv = document.getElementById('fotozoom');

let isZoomed = false;


/*
obrazoomoutButton.addEventListener('click', () => {
    if (isZoomed) {
        fotozoomDiv.style.cursor = 'auto'; // Restablece el cursor
        fotozoomDiv.style.transform = 'scale(1)'; // Restablece el zoom al 100%
        obrazoomoutButton.style.display = 'none'; // Oculta el botón obrazoomout
        obrazoomButton.style.display = 'block'; // Muestra el botón obrazoom
        isZoomed = false; // Restablece el estado de zoom
    }
});
*/
const container = document.querySelector('.drag-container');
const image = document.querySelector('.drag-image');
let isDragging = false;
let startX, startY, translateX, translateY;

container.addEventListener('mousedown', (e) => {
  e.preventDefault(); // Evita la selección de texto mientras arrastras
});

image.addEventListener('dragstart', (e) => {
  e.preventDefault(); // Evita que la imagen sea arrastrada por defecto
});

container.addEventListener('mousedown', (e) => {
  if (e.button !== 0) return; // Ignorar clics que no sean el botón izquierdo
  isDragging = true;
  startX = e.clientX;
  startY = e.clientY;
  translateX = image.getBoundingClientRect().left;
  translateY = image.getBoundingClientRect().top;
  container.style.cursor = 'grabbing';
});

window.addEventListener('mouseup', () => {
  isDragging = false;
  container.style.cursor = 'grab';
});

window.addEventListener('mousemove', (e) => {
            if (!isDragging) return;
            translateX = e.clientX - startX;
            translateY = e.clientY - startY;
            image.style.transform = `translate(${translateX}px, ${translateY}px) scale(${scale})`;
        });

container.addEventListener('mouseleave', () => {
  if (isDragging) {
    isDragging = false;
    container.style.cursor = 'grab';
  }
});
let scale = 0.5;
updateTransform();
 
      function updateTransform() {
        const svg = document.getElementById("imgZoom");
    
        svg.style.transform = `scale(${scale}) `;
      }

      document.getElementById("zoomIn").addEventListener("click", () => {
        
        scale += 0.2; 
       
        updateTransform();
      });
      document.getElementById("zoomout").addEventListener("click", () => {
        
        scale -= 0.2; 
       
        updateTransform();
      });

      document.getElementById("cerrarobra").addEventListener("click", () => {
        
        window.location = "https://bienales.museolatertulia.com/"
      });
    
    </script>
  </body>
</html>


  