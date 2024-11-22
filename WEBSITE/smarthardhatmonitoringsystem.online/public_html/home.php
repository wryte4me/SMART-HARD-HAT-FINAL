

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset='utf-8' />
    <title>Hard Hat Data</title>
    <meta name='viewport' content='initial-scale=1,maximum-scale=1,user-scalable=no' />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer"
    />
    <!-- Mapbox -->
    <script src='https://api.tiles.mapbox.com/mapbox-gl-js/v1.5.0/mapbox-gl.js'></script>
    <link href='https://api.tiles.mapbox.com/mapbox-gl-js/v1.5.0/mapbox-gl.css' rel='stylesheet' />

    <!-- GeoCoder -->
    <script src='https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v2.3.0/mapbox-gl-geocoder.min.js'></script>
    <link rel='stylesheet' href='https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v2.3.0/mapbox-gl-geocoder.css' type='text/css' />

    <!-- Direction API -->
    <script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v4.1.0/mapbox-gl-directions.js"></script>
    <link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v4.1.0/mapbox-gl-directions.css">
    <!-- Mapbox -->

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="style.css">
</head>
<body style="display: flex;padding: 20px;">

		<div style="padding: 20px;">
			<table>
		      	<thead>
		      		<tr>
		      			<th>ID Number</th>
		      			<th>Images</th>
		      			<th>Active</th>
		      			<th>Latitude</th>
		      			<th>Longitude</th>
		      			<th>Action</th>
		      		</tr>
		      	</thead>
		      	<tbody id="hardHatList">
		      	</tbody>
		    </table>
		</div>
		<div id='map' style="padding: 20px;"></div>

      <script src="dist/js/fontawesome.js"></script>

    <script type="module">
  // Import the functions you need from the SDKs you need
  import { initializeApp } from "https://www.gstatic.com/firebasejs/10.10.0/firebase-app.js";
  import { getAnalytics } from "https://www.gstatic.com/firebasejs/10.10.0/firebase-analytics.js";
      import { getDatabase, ref, onValue } from "https://www.gstatic.com/firebasejs/10.10.0/firebase-database.js";

  // TODO: Add SDKs for Firebase products that you want to use
  // https://firebase.google.com/docs/web/setup#available-libraries

  // Your web app's Firebase configuration
  // For Firebase JS SDK v7.20.0 and later, measurementId is optional
  const firebaseConfig = {
    apiKey: "AIzaSyAy_bQFynVXe_RflYLYgsU0skc8ThOKDYE",
    authDomain: "smarthardhat-22267.firebaseapp.com",
    databaseURL: "https://smarthardhat-22267-default-rtdb.asia-southeast1.firebasedatabase.app",
    projectId: "smarthardhat-22267",
    storageBucket: "smarthardhat-22267.appspot.com",
    messagingSenderId: "1001952473982",
    appId: "1:1001952473982:web:a309b046972d3602d5b92f",
    measurementId: "G-X155LG29H6"
  };

  // Initialize Firebase
  const app = initializeApp(firebaseConfig);
  const analytics = getAnalytics(app);
  const db = getDatabase();

  const hardHatList = document.getElementById("hardHatList");

        // Function to display hard hat data
        function displayHardHatData(data) {
            // Clear previous data
            hardHatList.innerHTML = '';

            // Iterate through the data and display each hard hat
            data.forEach((hardHat, index) => {
                const { idNumber, imageReturned,  isActive, isRequestingImg, locLatitude, locLongitude } = hardHat.val();
                const row = document.createElement('tr');

                row.innerHTML = `
                    <td>${idNumber}</td>
                    <td><img id="imageElement" src="${imageReturned}" alt="Image" width="100px"></td>
                    <td>${isActive}</td>
                    <td>${locLatitude}</td>
                    <td>${locLongitude}</td>
                    <td><button value="${locLongitude},${locLatitude}" class="showmap"><i class="fas fa-map-marker-alt"></i></button></td>
                `;
                hardHatList.appendChild(row);
            });
        }

        // Listen for changes in the database and update the display
        onValue(ref(db, 'Hard Hats'), (snapshot) => {
            const data = [];
            snapshot.forEach((childSnapshot) => {
                data.push(childSnapshot);
            });
            displayHardHatData(data);
        });


         mapboxgl.accessToken = 'pk.eyJ1IjoiZ29kZWdrb2xhIiwiYSI6ImNsb2EwaWVzcTBmdHAycXFicTlsMmxyeXYifQ.wEYJUoOoqnFzHFURicvCgQ';

            var map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/streets-v11',
            zoom: 12,
            center: [123.303406, 8.496130]
        });




       $(document).on('click', '.showmap', function() {
        var value = $(this).val();

        var coordinates = value.split(',');
        var longitude = parseFloat(coordinates[0]);
        var latitude = parseFloat(coordinates[1]);

         var map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/streets-v11',
            zoom: 12,
            center: [longitude, latitude]
        });

  var marker = new mapboxgl.Marker({
        color: 'red' // Change 'red' to any valid CSS color value
    })            .setLngLat([longitude, latitude])
            .addTo(map);
    });

        
</script>
</body>
</html>
