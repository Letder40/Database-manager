<?php 
session_start();
if($_SESSION['logged_in'] != true){
    header('Location: index.php');
}

$title = "Encuestas Database Manager";
$rand_text = ["espero que pases un gran dia" , "disfruta de tu estancia", "las bases de datos no son tan dificiles como suenan", "¿Que tal tu dia?", "nada mejor que una encuesta para obtener datos", "recuerda comentar si encuentras algun error en la página"];
$banner = "Bienvenid@ " . $_SESSION['username'] . " " . $rand_text[random_int(0,5)];
include "includes/header.php";
include "includes/db.php";

    
$stmt = $conn->prepare("SELECT table_name FROM information_schema.tables where table_schema = 'ssencuesta' ");
$stmt->execute();
$tables = $stmt->fetchAll();

$table = $_GET["table"];
$id = $_GET["id"];

if(!empty($id) and empty($table)){
    $error_text="No hay ninguna tabla seleccionada";
}
if(!empty($table)){
    for($i=0;$i<count($tables);$i++){
        $table_name = $tables[$i][0];
        if($table_name == $table){
            $verificado = true;
        }
    }
    if($verificado != true){
        die("Intento de hackeo detectado reportando al administrador... ");
    }
    $error_text="<span style='color: green'>tabla seleccionada: " . $table  . "</span>";
}


?>  
    <div id="home-main-container">

        <nav id="home-nav">

            <a id="nav-object" class="default-flex" href="home.php" >Home</a>
            <a id="nav-object" class="default-flex" href="home.php?id=1&table=<?php echo $table ?>" >Show data</a>
            <a id="nav-object" class="default-flex" href="home.php?id=2&table=<?php echo $table ?>" >Add data</a>
            <a id="nav-object" class="default-flex" href="add_user.php" >Add user</a>
            
        </nav>

        <div id="dinamyc-zone" class="default-flex">
            <div class="error_text default-flex"><?php echo $error_text ?></div>
        
            <?php if(empty($id) or empty($table)){ 
            
            echo '<div id="table_selector">';

            for($i=0;$i<count($tables);$i++){
                $table_name = $tables[$i][0];
                if($table_name  == "administrators"){
                    continue;
                }
                echo "<a class='default-flex hover' href='home.php?table=" . $table_name  . "'>" . $table_name . "</a>";
            }
            echo '</div>';
        }else{
            if($id == 1){
                echo '<div id="show_data" class="default-flex">';
                    $stmt = $conn->prepare("SELECT * FROM $table ");
                    $stmt->execute();                    
                    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $index = $_GET["index"];
                    if(empty($index)){
                         for($i=1;$i<=count($data);$i++){
                            echo "<a href='home.php?index=$i&id=1&table=$table'><div class='show-object default-flex'>tabla $table fila $i</div></a>";
                        }
                    }else{
                        if($table == "diabetes"){
                            $questions = [
                                1 => '¿Tiene alguna formación acreditada en diabetes? (si/no)',
                                2 => '¿Se siente suficientemente formado? (si/no)',
                                3 => '¿Ha realizado algún master en diabetes? ¿cuál?',
                                4 => '¿Cree debrían formarle más?',
                                5 => '¿Algun Experto? ¿Cuál?',
                                6 => '¿Cree debe formarse usted mismo en su tiempo? (si/no)',
                                7 => '¿Cuándo realizó el último curso en diabetes? y ¿cuál?',
                                8 => 'Del 1 al 10, ¿cuánto se considera formado?',
                                9 => '¿Tiene formación en sensores Flash? ¿cuál?',
                                10 => '¿Tiene alguna formación sobre hábitos saludables?',
                                11 => '¿Se siente preparado para actuar ante un paciente diabético complejo?',
                                12 => '¿Cree que sus pacientes están bien atendidos con sus conocimientos?',
                                13 => '¿Le supone un problema insulinizar a un paciente por miedo?',
                                14 => '¿Piensa que debería tener alguna figura referente en su centro a quien pasar un paciente muy complejo?',
                                15 => '¿Está motivado para atender sus pacientes diabéticos en su consulta?',
                                16 => '¿Su consulta reúne las condiciones adecuadas para hacer una educación terapéutica?',
                                17 => '¿Considera que tiene interrupciones cuando ve a sus pacientes diabéticos?',
                                18 => '¿Ha realizado alguna vez un programa de educación terapéutica en diabetes individual?',
                                19 => '¿Se siente temeroso o inseguro con la diabetes?',
                                20 => '¿Y grupal?'
                            ];
                            for($i=1;$i<=count($questions);$i++){
                                echo '<div class="show-block">
                                        <div class="question">' . $questions[$i] . '</div>
                                        <div class="answer">' . $data[$index - 1]["pregunta$i"] . '</div>
                                    </div>';
                            }
                        }else{

                            $stmt = $conn->prepare("select column_name from information_schema.columns where table_name = '$table' and table_schema = 'ssencuesta'");
                            $stmt->execute();
                            $columns = $stmt->fetchAll();
                            
                            $columns_name = [];
                            for($i=0;$i<count($columns);$i++){
                                $column_name = $columns[$i][0];
                                if($column_name == "id"){
                                    continue;
                                }
                                array_push($columns_name, $column_name);
                            }
                            for($i=0;$i<count($columns_name);$i++){
                                echo '<div class="show-block">
                                        <div class="question">' . "columna ->" . $columns_name[$i] . " :" . '</div>
                                        <div class="answer">' . "valor -> " . $data[$index - 1][$columns_name[$i]] . '</div>
                                    </div>';
                            }
                        }
                    }
                echo "</div>";
            }elseif($id == 2){
                
                echo '<form action="add.php" method="post" id="add_data" class="default-flex">';
                    $stmt = $conn->prepare("select column_name from information_schema.columns where table_name = '$table' and table_schema = 'ssencuesta'");
                    $stmt->execute();
                    $columns = $stmt->fetchAll();
                    
                    for($i=0;$i<count($columns);$i++){
                        $column_name = $columns[$i][0];
                        if($column_name == "id"){
                            continue;
                        }
                        echo "<div class='add-form-object default-flex'>";
                        echo "<label for='$column_name'>$column_name</label>";
                        echo "<input type='text' name='$column_name' required>";
                        echo "</div>";
                    }
                    echo "<input type='hidden' value='$table' name='table'>";
                    echo '<input type="submit" value="add data" id="submit">';
                    
                echo '</form>';
        
            }elseif($id == 3){
                echo '<div id="show_data" class="default-flex">';
                echo "</div>";
            }
        }
        ?>
            
            
        </div>





    </div>

    <footer id="home-footer" class="default-flex">Database manager created by &nbsp<a href='https://www.linkedin.com/in/adri%C3%A1n-rojas-61b633226/'> letder40</a></footer>

    </body>
</html>
