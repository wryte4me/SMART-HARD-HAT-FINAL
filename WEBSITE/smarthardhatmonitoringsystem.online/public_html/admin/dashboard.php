
<!DOCTYPE html>
<html>
<head><?php include 'head.php'; ?>
</head>

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">


<?php include 'navbar.php'; ?>
<?php include 'sidebar.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="background: #f5f4f0;">
    <section class="content">
      <div class="row">
        <div class="col-lg-7 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="col-lg-12 table-responsive" style="background-color: #fff;padding: 20px;">
                      <table id="example" class="table">
                        <thead>
                          <tr>
                            <th>ID</th>
                            <th>Images</th>
                            <th>Name</th>
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
                </div>
            </div>
        </div>
        <div class="col-lg-5 col-12">
          <div class="row">
            <div class="col-lg-12">
              <div class="card">
                <div class="card-body" style="background-color: #fff;padding: 20px;">
                    <div id='map' style="height: 87vh;width: 100%;"></div>
                </div>
            </div>
            </div>
          </div>
        </div>
      </div>

    </section>
  </div>

</div>
<!-- ./wrapper -->

<?php include 'footer.php'; ?>

<script>
$(function(){
	/** add active class and stay opened when selected */
	var url = window.location;
  
	// for sidebar menu entirely but not cover treeview
	$('ul.sidebar-menu a').filter(function() {
	    return this.href == url;
	}).parent().addClass('active');

	// for treeview
	$('ul.treeview-menu a').filter(function() {
	    return this.href == url;
	}).parentsUntil(".sidebar-menu > .treeview-menu").addClass('active');

});
</script>

<script type="module">
  // Import the functions you need from the SDKs you need
  import { initializeApp } from "https://www.gstatic.com/firebasejs/10.10.0/firebase-app.js";
  import { getAnalytics } from "https://www.gstatic.com/firebasejs/10.10.0/firebase-analytics.js";
      import { getDatabase, ref, onValue, update, get } from "https://www.gstatic.com/firebasejs/10.10.0/firebase-database.js";

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
    data.forEach((hardHatSnapshot) => {
        const hardHatData = hardHatSnapshot.val();
        const hardHatKey = hardHatSnapshot.key; // Get the key of the Hard Hat

        const { idNumber, imageReturned, isActive, isRequestingImg, locLatitude, locLongitude } = hardHatData;
        const row = document.createElement('tr');

        // Determine the status based on the value of isActive
        const status = isActive ? 'Active' : 'Inactive';

        // Create the HTML for the table row
        row.innerHTML = `
            <td  style="font-size: 20px;">${idNumber}</td>
            <td><img id="imageElement" src="${imageReturned}" alt="Image" width="200px"></td>
            <td style="font-size: 20px;">${hardHatSnapshot.key}</td>
            <td  style="font-size: 20px;">${status}</td>
            <td  style="font-size: 20px;">${locLatitude}</td>
            <td  style="font-size: 20px;">${locLongitude}</td>
            <td>
                <button value="${locLongitude},${locLatitude}" class="showmap btn btn-warning">
                    <i class="fas fa-map-marker-alt"></i> Map
                </button>
            </td>
        `;
        
        // Append the row to the table
        hardHatList.appendChild(row);

        // Access the parent data
        // const parentKey = hardHatSnapshot.ref.parent.key;
        // console.log('Parent Key:', parentKey);

        // Now you can use parentKey to access parent data if needed
    });
}


        // Listen for changes in the database and update the display
        onValue(ref(db, 'hardHats'), (snapshot) => {
            const data = [];
            snapshot.forEach((childSnapshot) => {
                data.push(childSnapshot);
            });
            displayHardHatData(data);
        });

        $(document).on('click', '.update', function() {
    // Get the idNumber associated with the clicked button
    const hardHatSnapshot = $(this).val();
    
    // Get the reference to the Hard Hat object
    const hardHatRef = ref(db, `hardHats/${hardHatSnapshot}`);
    
    // Get the data for the Hard Hat object
    get(hardHatRef)
        .then((snapshot) => {
            // Check if the snapshot exists and the data is not null
            if (snapshot.exists()) {
                // Get the current data of the Hard Hat
                const currentData = snapshot.val();
                // Update only the isRequestingImg field to true
                const newData = { ...currentData, isRequestingImg: true };
                // Update the Hard Hat object with the new data
                update(hardHatRef, newData)
                    .then(() => {
                        console.log(`isRequestingImg updated successfully for Hard Hat ${hardHatSnapshot}`);
                    })
                    .catch((error) => {
                        console.error('Error updating isRequestingImg:', error);
                    });
            } else {
                console.error(`Hard Hat with Category ${hardHatSnapshot} does not exist.`);
            }
        })
        .catch((error) => {
            console.error('Error getting Hard Hat data:', error);
        });
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


new DataTable('#example');
        
</script>


</body>
</html>

