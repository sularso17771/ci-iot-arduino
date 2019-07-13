
      jQuery.getJSON('http://sim808.herokuapp.com/module/getLonLat', function(data) 
      {
          var lon = parseFloat(data.lon);
          var lat = parseFloat(data.lat);
          var latlon = [lon,lat];



          var layer = new ol.layer.Tile({
            source: new ol.source.OSM()
          });

          var sim808 = ol.proj.transform(latlon, 'EPSG:4326', 'EPSG:3857');
          var view = new ol.View({
            center: sim808,
            zoom: 20
          });
          var map = new ol.Map({
            target: 'map',
            layers: [layer],
            view: view
          });

      });          
