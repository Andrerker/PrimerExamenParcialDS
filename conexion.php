<!DOCTYPE html>
<html lang="en">  
<head>
    <meta charset="UTF-8">
    <link rel ="stylesheet" type = "text/css" href="estilo.css">
    <title>Formulario</title>
</head>
<!-- clases -->
<?php 
require("metodos.php"); 
$obj= new Metodos();
?>
    <!-- Diseño de la pagina -->
    <tbody>
        <header class="bg_animate">
            <section class="banner contenedor">
                <secrion class="banner_img1">
                        <img src="us.png" alt="">
                </secrion>
                <secrion class="banner_img">
                    <img src="iis.png" alt="">
                </secrion>
            </section>

            <div class="burbujas">
                <div class="burbuja"></div>
                <div class="burbuja"></div>
                <div class="burbuja"></div>
                <div class="burbuja"></div>
                <div class="burbuja"></div>
                <div class="burbuja"></div>
                <div class="burbuja"></div>
                <div class="burbuja"></div>
                <div class="burbuja"></div>
                <div class="burbuja"></div>
            </div>
        </header>
    </tbody>
    <!-- Ingreso de datos -->
    <body>
        <main id="contenedor">
            <div class="form">
                <label class=label1>Descargado con exito...</label>
                <?php
                $opciones=$_POST['opciones']; // segun la opcion que tomemos en la interfaz
                //Ingreso de archivo alumnos
                $archivo_alumnos = $_FILES["archivo_alumnos"]["name"];
                $archivo_copiado_alumnos = $_FILES["archivo_alumnos"]["tmp_name"]; // copiamos el archivo_alumnos en un temporal
                //Ingreso de archivo docentes
                
                $archivo_docentes = $_FILES["archivo_docentes"]["name"];
                $archivo_copiado_docentes = $_FILES["archivo_docentes"]["tmp_name"];// copiamos el archivo_docentes en un temporal
                //Ingreso de archivo distribucion Docente x Alumno semestre anterior
                $archivo_distribucion = $_FILES["archivo_distribucion"]["name"];
                $archivo_copiado_distribucion = $_FILES["archivo_distribucion"]["tmp_name"];// copiamos el archivo_distribucion en un temporal
                
                if (file_exists($archivo_copiado_alumnos)){// verificacion si se subio el primer archivo
                    $file_open_alumnos = fopen($archivo_copiado_alumnos, "r");// abrir el archivo_alumnos
                    if (file_exists($archivo_copiado_docentes)){// verificacion si se subio el segundo archivo
                        $file_open_docentes = fopen($archivo_copiado_docentes, "r");// abrir el archivo_docentes
                        if (file_exists($archivo_copiado_distribucion)){// verificacion si se subio el segundo archivo
                            $file_open_distribucion = fopen($archivo_copiado_distribucion, "r");// abrir el archivo_docentes
                            if($opciones=='opcion1'){//Archivo CSV Lista de alumnos ya no son considerados en la tutoría (Alumnos no matriculados en el presente semestre).
                                $obj->no_tutorados($file_open_distribucion,$archivo_copiado_alumnos);
                            }elseif($opciones=='opcion2'){//Archivo CSV Distribución balanceada de tutorías para el presente semestre.
                                $obj->distribucion_balanceada($file_open_distribucion,$archivo_copiado_alumnos,$archivo_copiado_docentes);
                            }
                        }
                    }
                }
                ?>
                
            </div>
        </main> 
    </body>
</html>