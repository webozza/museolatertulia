document.getElementById('colombia').addEventListener('click', function() {
    loadCountryData('Colombia');
    alert("colombia");
});

document.getElementById('argentina').addEventListener('click', function() {
    loadCountryData('Argentina');
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
      let scale = 1;
      let translateX = 0;
      let translateY = 0;

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