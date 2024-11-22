 mapboxgl.accessToken = 'pk.eyJ1IjoiZ29kZWdrb2xhIiwiYSI6ImNsb2EwaWVzcTBmdHAycXFicTlsMmxyeXYifQ.wEYJUoOoqnFzHFURicvCgQ';
  var map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/streets-v11',
            zoom: 12,
            center: [120.968617, 14.2141925]
        });
        

        // Add a marker at the center
        var marker = new mapboxgl.Marker()
            .setLngLat([120.968617, 14.2141925])
            .addTo(map);