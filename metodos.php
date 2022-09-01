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
        <a href="./index.php" title="Ir la página anterior" class="volver"> <- Volver a la pagina anterior</a>
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
                    ?>
                    <table class="table-1" width="70%" border="0" align="center">
                                <tr  bgcolor="#012d4b">
                                    <td width="10%" align="center" ><b>Código</b></td>
                                    <td width="20%" align="center" ><b>Nombres</b></td>
                                    <td width="20%" align="center"><b>Descripcion</b></td>
                                </tr>
                            <?php
                    while ($datos_distribucion = fgetcsv($fp_distribucion, 0, ",")){ //obtenemos datos del primer csv por filas
                        $fp_alumnos = fopen($archivo_copiado_alumnos, "r");// abrir el archivo2
                        $EstadoAlumno = Estado_alumno($fp_alumnos,$datos_distribucion);
                        if ($EstadoAlumno==(boolean)false && (integer)$datos_distribucion[0]){//si estado no cambia a false y no son alumnos nuevos y la primera columna es entera
                                $arreglo[$indice] = array($datos_distribucion[0],$datos_distribucion[1],"No matriculado");
                                $indice++;
                                ?>
                                <tr>
                                    <th><?php  echo $datos_distribucion[0]?></th>
                                    <th><?php  echo $datos_distribucion[1]?></th>
                                    <th><?php  echo 'No matriculado'?></th>
                                </tr>
                    
                    <?php
                        }
                        fclose($fp_alumnos);// cerramos el archivo2
                        
                    }
                    ?>
                    </table>
                    <?php
                    //CREACION DE ARCHIVO CSV
                    creacion_archivo_cv($ruta,$arreglo);
        }
        public function distribucion_balanceada($fp_distribucion,$archivo_copiado_alumnos,$archivo_copiado_docentes)
        {   
                $indice=0;
                $ruta ="distribucion_balanceada.csv"; //ruta
                ?>
                <div class="table-wapper">
                    <table >
                                <tr  bgcolor="#012d4b">
                                    <td width="10%" align="center" ><b>Código</b></td>
                                    <td width="20%" align="center" ><b>Nombres</b></td>
                                    <td width="20%" align="center"><b>Descripcion</b></td>
                                </tr>
                            <?php
                       
                        
                    
            
                    while ($datos_distribucion = fgetcsv($fp_distribucion, 0, ",")){ //obtenemos datos del primer csv por filas
                        $EstadoAlumno=(boolean)false; // variable booleana igual a "false"
                        $fp_alumnos = fopen($archivo_copiado_alumnos, "r");// abrir el archivo2
                        $fp_docentes = fopen($archivo_copiado_docentes, "r");// abrir el archivo3
                        $EstadoAlumno = Estado_alumno($fp_alumnos,$datos_distribucion);
                        for ($i=0;$i<36;$i = $i + 1) {
                            if ($datos_distribucion[0]==("Docente #".$i)){
                                $arreglo[$indice] = array($datos_distribucion[0],$datos_distribucion[1],"TUTOR");
                                $indice++;
                                ?>
                                <tr>
                                    <th><?php  echo $datos_distribucion[0]?></th>
                                    <th><?php  echo $datos_distribucion[1]?></th>
                                    <th><?php  echo 'TUTOR'?></th>
                                </tr>
                                <?php
                            }elseif($datos_distribucion[0]=="Docente"){
                                $arreglo[$indice] = array($datos_distribucion[0],$datos_distribucion[1],"TUTOR");
                                $indice++;
                                ?>
                                <tr>
                                    <th><?php  echo $datos_distribucion[0]?></th>
                                    <th><?php  echo $datos_distribucion[1]?></th>
                                    <th><?php  echo 'TUTOR'?></th>
                                </tr>
                                <?php
                                break;
                            }
                        }
                        if ($EstadoAlumno==(boolean)true && (integer)$datos_distribucion[0]){//si estado no cambia a false y no son alumnos nuevos y la primera columna es entera
                            $arreglo[$indice] = array($datos_distribucion[0],$datos_distribucion[1],"Tutorados");
                            $indice++;
                            ?>
                                <tr>
                                    <th><?php  echo $datos_distribucion[0]?></th>
                                    <th><?php  echo $datos_distribucion[1]?></th>
                                    <th><?php  echo 'Tutorados'?></th>
                                </tr>
                                <?php
                        }
                        fclose($fp_alumnos);// cerramos el archivo2
                        fclose($fp_docentes);// cerramos el archivo3
                    }   
                    //CREACION DE ARCHIVO CSV
                    creacion_archivo_cv($ruta,$arreglo); 
                    ?>
                    </table>
                </div>
                <?php  
        }
    }
    ?>