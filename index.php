<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokemon API - Fabian</title>
    <!-- Enlace al favicon -->
    <link rel="icon" href="img/pokebola.png" type="image/x-icon">
    <!-- Relacionar archivo css -->
    <link href="css/styles.css" rel="stylesheet">
    <script>
    function validarInput(input) {
      // Obtener el valor del input y convertirlo a minúsculas
      var valor = input.value.toLowerCase();
      
      // Eliminar caracteres no permitidos (mayúsculas)
      input.value = valor.replace(/[^a-z]/g, '');
    }
  </script>
</head>
<body>
    <div class="titulo">
        <h1><img class="pokebola" src="img/pokebola.png" alt="Pokebolla" width="40" height="40"> API POKEMÓN - Fabian</h1>
    </div>

    <main class="contenedor sombra">
        <?php
        // Procesar el formulario si se ha enviado
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Validar y procesar los datos del formulario
            $nombre = htmlspecialchars($_POST["nombre"]);

            // Puedes realizar más validaciones aquí
            $url_beta = 'https://pokeapi.co/api/v2/pokemon/';

            $url= $url_beta . $nombre;

            //Inicializar una nueva sesión de cURL
            $ch = curl_init();

            curl_setopt($ch,CURLOPT_URL,$url);
            curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

            $response = curl_exec($ch);

            if(curl_errno($ch)){
                $error_msg = curl_errno($ch);
                echo 'Error al conectarse a la API ' . curl_errno($ch);
            }else{
                curl_close($ch);

                $pokemon_data = json_decode($response,true);

                if($pokemon_data == null){

                    echo '<h1>Nombre inexistente, intente de nuevo</h1>';
                }
                else{
                    echo '<div class="servicios">';

                    echo '<section class="servicio">';
                    echo '<h1>'. $pokemon_data['name']. '</h1>';
                    echo '<div class="iconos">';
                    echo '<img src="'. $pokemon_data['sprites']['front_default'].'" alt="'. $pokemon_data['name'].'" width="250" height="250">';
                    echo '<ul>';
                    echo '<li><strong> Nombre: </strong>' .$pokemon_data['name']. '</li>';
                    echo '<li><strong> Altura: </strong>' .$pokemon_data['height']. '</li>';
                    echo '<li><strong> Anchura: </strong>' .$pokemon_data['weight']. '</li>';

                    echo '<li><strong> Habilidades: </strong>';
                    echo '<ul>';
                    foreach($pokemon_data['abilities'] as $ability){

                        echo '<li>'. $ability['ability']['name']. '</li>';

                    }
                    echo '</ul>';
                    echo '</li>';
                    echo '</ul>';

                    echo '</div>';
                    echo '</section>';
                    echo '</div>';
                }

                
            }
        }
        ?>

        <section>
            <h2 class="buscar">Buscar el pokemón</h2>
            <!-- Formulario recursivo -->
            <form class="formulario" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <fieldset>
                    <legend>Elige tu pokemón !!!</legend>
                    <div class="contenedor-campos">
                        <div class="campo">
                            <label for="nombre">Nombre:</label>
                            <input class="input-text" type="text" name="nombre" placeholder="Ingresa nombre del pokemón" oninput="validarInput(this)" required>
                        </div>
                    </div>
                    
                    <div class="alinear-derecha flex">
                            <input class="boton w-sm-100" type="submit" value="Buscar">
                    </div>
                </fieldset>
            </form>
        </section>
    </main>
    
    

    <footer class="footer">
        <p>Todos los derechos reservados. Fabian Urcia 2023</p>
    </footer>
    
</body>
</html>