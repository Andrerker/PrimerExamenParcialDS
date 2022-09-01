<?php 
    function creacion_archivo_cv($ruta,$arreglo){
        $encapsulador='"'; 
        $delimitador=',';
        $file_handle = fopen($ruta, 'w');
        foreach ($arreglo as $linea) {
            fputcsv($file_handle, $linea, $delimitador, $encapsulador);
        }
        rewind($file_handle);
        fclose($file_handle); 
        ?>
        <a href="./index.php" title="Ir la página anterior">Volver</a>
        <?php
    }
    function Estado_alumno($fp_alumnos,$datos_distribucion){
        while ($datos_alumnos = fgetcsv($fp_alumnos, 0, ",")){//obtenemos datos del segundo csv por filas
            if ($datos_distribucion[0]==$datos_alumnos[1]){ // comparamos los codigos del archivo1 y los del archivo2
                return true;// si se repite estadoalumno se vuelve true
                break;
            }
        }
        return false;
    } 
    class Metodos
    {
        public function no_tutorados($fp_distribucion,$archivo_copiado_alumnos)
        {
                    $indice=0;
                    $ruta ="no_matriculados.csv"; //ruta
                    while ($datos_distribucion = fgetcsv($fp_distribucion, 0, ",")){ //obtenemos datos del primer csv por filas
                        $fp_alumnos = fopen($archivo_copiado_alumnos, "r");// abrir el archivo2
                        $EstadoAlumno = Estado_alumno($fp_alumnos,$datos_distribucion);
                        if ($EstadoAlumno==(boolean)false && (integer)$datos_distribucion[0]){//si estado no cambia a false y no son alumnos nuevos y la primera columna es entera
                                $arreglo[$indice] = array($datos_distribucion[0],$datos_distribucion[1],"No matriculado");
                                $indice++;
                        }
                        fclose($fp_alumnos);// cerramos el archivo2
                        
                    }
                    //CREACION DE ARCHIVO CSV
                    creacion_archivo_cv($ruta,$arreglo);
        }
        public function distribucion_balanceada($fp_distribucion,$archivo_copiado_alumnos,$archivo_copiado_docentes)
        {   
                $indice=0;
                $ruta ="distribucion_balanceada.csv"; //ruta
                
            
                    while ($datos_distribucion = fgetcsv($fp_distribucion, 0, ",")){ //obtenemos datos del primer csv por filas
                        $EstadoAlumno=(boolean)false; // variable booleana igual a "false"
                        $fp_alumnos = fopen($archivo_copiado_alumnos, "r");// abrir el archivo2
                        $fp_docentes = fopen($archivo_copiado_docentes, "r");// abrir el archivo3
                        $EstadoAlumno = Estado_alumno($fp_alumnos,$datos_distribucion);
                        for ($i=0;$i<36;$i = $i + 1) {
                            if ($datos_distribucion[0]==("Docente #".$i)){
                                $arreglo[$indice] = array($datos_distribucion[0],$datos_distribucion[1],"TUTOR");
                                $indice=$indice+1;
                            }elseif($datos_distribucion[0]=="Docente"){
                                $arreglo[$indice] = array($datos_distribucion[0],$datos_distribucion[1],"TUTOR");
                                $indice=$indice+1;
                                break;
                            }
                        }
                        if ($EstadoAlumno==(boolean)true && (integer)$datos_distribucion[0]){//si estado no cambia a false y no son alumnos nuevos y la primera columna es entera
                            $arreglo[$indice] = array($datos_distribucion[0],$datos_distribucion[1],"Tutorados");
                            $indice=$indice+1;
                        }
                        fclose($fp_alumnos);// cerramos el archivo2
                        fclose($fp_docentes);// cerramos el archivo3
                    }   
                    //CREACION DE ARCHIVO CSV
                    creacion_archivo_cv($ruta,$arreglo);   
        }
    }
    ?>
