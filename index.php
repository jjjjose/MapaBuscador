<?php require_once 'datos.php'; ?>
<!DOCTYPE html>
<html lang="es" class="h-100">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="" />
  <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors" />
  <meta name="generator" content="Jekyll v3.8.5" />
  <title>MiguelMaps</title>

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous" />
  <link href="estilos.css" rel="stylesheet" />
</head>

<body class="d-flex flex-column h-100">
  <main role="main" class="flex-shrink-0">
    <div class="container">
      <h1 class="mt-5">Buscar mapa</h1>
      <div id="map"></div>
      <p class="lead">
        Selecciona un usuario para poder ver su ubicacion en el mapa.
      </p>
      <form action="index.php" method="post">
        <div class="col-auto my-1">
          <label class="mr-sm-2 sr-only" for="inlineFormCustomSelect">Usuarios</label>
          <select class="custom-select mr-sm-2" name="persona">
            <option selected>Selecciona...</option>
            <?php foreach ($dat as  $val) { ?>
              <option value="<?php echo $val['place_id']; ?>"><?php echo $val['name']; ?></option>
            <?php
            }
            ?>

          </select>
        </div>
        <div class="col-auto my-3">
          <button type="submit" class="btn btn-primary btn-block">Ver</button>
        </div>
      </form>
      <a href="index.php" class="btn btn-primary btn-block">Ver tu ubicacion</a>
    </div>
  </main>

  <footer class="footer mt-auto py-3">
    <div class="container">
      <span class="text-muted">Ejemplo sencillo para Miguel</span>
    </div>
  </footer>
  <!-- cargando la api de google -->

  <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBsPSO5_G0TuDzknnplUmZ9JkjcugrQYqo&callback=initMap"></script>

  <script>
    <?php print 'var est=' . $inicio . ";" ?>
    <?php print 'var nom=' . $nom . ";" ?>
    var PA = {
      method: 'POST',
      body: JSON.stringify({
        tip: 'all'
      })
    };
    var PAA = {
      method: 'POST',
      body: JSON.stringify({
        tip: 'name',
        id: nom
      })
    };

    function initMap() {
      // mostrando la ubicacion actual
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
          function(position) {
            var actual = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
            };
            iniciar(actual)
          },
          function(error) {
            var actual = {
              lat: -17.955553,
              lng: -67.112043
            };
            iniciar(actual)
          }
        );
      } else {
        //Caso NO soporta geolocalización
        var actual = {
          lat: -17.955553,
          lng: -67.112043
        };
        iniciar(actual)

      }



      function iniciar(actual) {
        if (est === 0) {
          fetch('api.php', PA)
            .then(res => res.json())
            .then(json => jaja(json))
          var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 15,
            center: actual
          });
          new google.maps.Marker({
            position: actual,
            map: map,
            draggable: true,
            animation: google.maps.Animation.DROP,
            title: "estas aqui...!!!!!!"
          });
          // mostrando todos los marcadores
          function jaja(resu) {
            for (var i = 0; i < resu.length; i++) {
              // mostrando los marcadores
              var marker = new google.maps.Marker({
                position: {
                  lat: parseFloat(resu[i].place_lat),
                  lng: parseFloat(resu[i].place_long)
                },
                map: map,
                title: resu[i].place_lacalizacion
              });
            }
          }
        } else {

          // cuando buscas una direccion
          fetch('api.php', PAA)
            .then(res => res.json())
            .then(json => jeje(json))

          function jeje(dir) {
            var acc = {
              lat: parseFloat(dir[0].place_lat),
              lng: parseFloat(dir[0].place_long)
            };
            var map = new google.maps.Map(document.getElementById('map'), {
              zoom: 15,
              center: acc
            });
            new google.maps.Marker({
              position: acc,
              map: map,
              draggable: true,
              animation: google.maps.Animation.DROP,
              title: dir[0].place_lacalizacion
            });
            fetch('api.php', PA)
              .then(res => res.json())
              .then(json => jaja(json))

            function jaja(resu) {

              for (var i = 0; i < resu.length; i++) {
                // mostrando los marcadores
                var marker = new google.maps.Marker({
                  position: {
                    lat: parseFloat(resu[i].place_lat),
                    lng: parseFloat(resu[i].place_long)
                  },
                  map: map,
                  title: resu[i].place_lacalizacion
                });
              }
            }
          }
          // mostrando todos los marcadores

        }


      }



    }
  </script>
</body>

</html>