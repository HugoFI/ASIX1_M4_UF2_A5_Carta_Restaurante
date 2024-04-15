<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./css/styles.css">
    <script src="https://kit.fontawesome.com/03958213ad.js" crossorigin="anonymous"></script>
    <title>Menú restaurante</title>
</head>
<body>
    <?php
        if (file_exists('./xml/menu.xml')){
            $menu= simplexml_load_file('./xml/menu.xml');
        } else {
            exit('Error abriendo menu.xml');
        }
        
    ?>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="?">PLATOS</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <?php
            $aux = [];
            foreach ($menu->plato as $fila) {
                $tipoPlato = (string) $fila['tipoPlato'];
                if (!in_array($tipoPlato, $aux)) {
                    echo '<li class="nav-item">';
                    
                    if (isset($_GET['tipoPlato']) && $_GET['tipoPlato'] == $tipoPlato) {
                        // htmlspecialchars() es una función de PHP que convierte caracteres especiales en entidades HTML. Esto es útil cuando se quiere mostrar contenido en una página web que puede contener caracteres que tienen un significado especial en HTML, como <, >, &, entre otros.
                        echo '<a class="nav-link active" aria-current="page" href="?tipoPlato=' . urlencode($tipoPlato) . '">' . htmlspecialchars($tipoPlato) . '</a>';
                    } else {
                        echo '<a class="nav-link" aria-current="page" href="?tipoPlato=' . urlencode($tipoPlato) . '">' . htmlspecialchars($tipoPlato) . '</a>';
                    }

                    echo '</li>';
                    $aux[] = $tipoPlato;
                }
            }
            ?>
        </ul>
        </div>
    </div>
    </nav>
    <div class="container">
        <?php
            $xmlPath = './xml/menu.xml';
            if (file_exists($xmlPath)) {
                $menu = simplexml_load_file($xmlPath);
                
                if ($menu !== false) {
                    foreach ($menu->plato as $fila) {
                        if (!isset($_GET['tipoPlato']) || $_GET['tipoPlato'] == $fila['tipoPlato']) {
                            echo '<div class="card">';
                            echo '<div class="card-header">' . htmlspecialchars($fila->nombrePlato) . '</div>';
                            echo '<div class="card-body">';
                            echo '<img src="' . htmlspecialchars($fila->imagen) . '" alt="Imagen de ' . htmlspecialchars($fila->nombrePlato) . '" style="width:100%; height:auto;"></div>';
                            echo '<div><b>Precio: ' . htmlspecialchars($fila->precio) . '</b></div><hr>';
                            echo '<div class="">Descripción: ' . htmlspecialchars($fila->descripcion) . '</div><br><hr>';
                            echo '<div>'.htmlspecialchars($fila->calorias).'</div><br>';
                            
                            echo '<div class="card-footer">Categoría: ';

                            foreach ($fila->caracteristicas->categoria as $categoria) {
                                // Obtener el contenido de la etiqueta categoria
                                $categoriaTexto = (string) $categoria;
                            
                                // Mostrar el icono de fontawesome según la categoría
                                switch ($categoriaTexto) {
                                    case 'ensalada':
                                        echo '<i class="fa-solid fa-leaf" style="color: #0eb602;"></i>';
                                        break;
                                    case 'carne':
                                        echo '<i class="fa-solid fa-drumstick-bite" style="color: #fbbf3c;"></i>';
                                        break;
                                    case 'pescado':
                                        echo '<i class="fa-solid fa-fish" style="color: #5e84a1;"></i>';
                                        break;
                                    case 'fruta':
                                        echo '<i class="fa-solid fa-apple-whole" style="color: #d34c12;"></i>';
                                        break;
                                    case 'picante':
                                        echo '<i class="fa-solid fa-pepper-hot" style="color: #ff0000;"></i>';
                                        break;
                                    case 'semillas':
                                        echo '<i class="fa-solid fa-seedling" style="color: #a3cc33;"></i>';
                                        break;
                                    case 'huevo':
                                        echo '<i class="fa-solid fa-egg" style="color: #f4b071;"></i>';
                                        break;
                                    case 'marisco':
                                        echo '<i class="fa-solid fa-shrimp" style="color: #df6868;"></i>';
                                        break;
                                    case 'arroz':
                                        echo '<i class="fa-solid fa-bowl-rice" style="color: #000000;"></i>';
                                        break;
                                    case 'queso':
                                        echo '<i class="fa-solid fa-cheese" style="color: #e0b310;"></i>';
                                        break;
                                    case 'reposteria':
                                        echo '<i class="fa-solid fa-cake-candles" style="color: #f075d6;"></i>';
                                        break;
                                    case 'citrico':
                                        echo '<i class="fa-solid fa-lemon" style="color: #FFD43B;"></i>';
                                        break;
                                    case 'chocolate':
                                        echo '<i class="fa-brands fa-microsoft" style="color: #6e3302;"></i>';
                                        break;
                                    default:
                                        // Si la categoría no es ninguna de las anteriores
                                        break;
                                }
                            
                                // Agregar un espacio después de cada categoría para separarlas
                                echo ' ';
                            }    


                            echo '</div>';

                            echo '</div>';
                        }
                    }
                } else {
                    echo "<p>No se pudo cargar el archivo XML.</p>";
                }
            } else {
                echo "<p>Archivo XML no encontrado en la ruta especificada.</p>";
            }
        ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body> 
</html>
