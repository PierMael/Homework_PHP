<!DOCTYPE html>
<html lang="" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title>My friends book</title>
    </head>
    <body style="text-align: left;">
        <header style="background-color: #777; padding: 30px; text-align: center; font-size: 30px; color: white;">
            <h1>Friend book</h1>
        </header>
    <br>
        <form action="index7.php" method="post">
            Name: <input type="text" name="name">
            <input type="submit" value="Add new friend">
        </form>
    <br>
    <h1>My best friends:</h1>
    <br>
    <?php
    //Open and read the file
    $filename = 'friends2.txt';
    $file = fopen( $filename, "r");
    $names = array();
    if ($file != false){
        while(!feof($file)){
            $name = trim(fgets($file));
            if ($name ===""){
                continue;
            }
            array_push($names, $name);
        }
        fclose( $file );
    }

    //Get filter
    $nameFilter="";
    if (isset($_POST['nameFilter'])) {
        $nameFilter = $_POST['nameFilter'];
    }
    
    //Add
    if (isset($_POST['name']) && strlen($_POST['name'])>0) {
        $newFriendName = $_POST['name'];
        array_push($names, $newFriendName); 

        $file = fopen( $filename, "w" );

        for($j = 0; $j < count($names); $j++) { 
            fwrite( $file, "$names[$j]\n" );
        }
        fclose( $file );
    }
    
    //Delete
    if (isset($_POST['delete'])) {
        $indexToBeRemoved = $_POST['delete'];

        unset($names[$indexToBeRemoved]);
        $names = array_values($names);

        $file = fopen( $filename, "w" );
        for($j = 0; $j < count($names); $j++) { 
            fwrite($file, "$names[$j]\n" );
        }
        fclose( $file );
    }

    //Afficher noms
    echo "<ul>";
    for ($i=0; $i < count($names); $i++) {
        $name = $names[$i];
        if (strcmp($name, "") != 0) {
            if (strcmp($nameFilter, "") == 0) { 
                echo "<li>
                        <form action=\"index7.php\" method =\"post\">
                            $name <button type='submit' name='delete' value='$i'>Delete</button>
                        </form>
                    </li>";
            }
            elseif (isset($_POST["startingWith"])) {
                if (strpos($name, $nameFilter) === 0) {
                echo "<li>
                        <form action=\"index7.php\" method =\"post\">
                            $name <button type='submit' name='delete' value='$i'>Delete</button>
                        </form>
                    </li>";
                }
            }
            elseif (strstr($name, $nameFilter) != FALSE) {
                echo "<li>
                        <form action=\"index7.php\" method =\"post\">
                            $name <button type='submit' name='delete' value='$i'>Delete</button>
                        </form>
                    </li>";
            }
        }
    }
    echo "</ul>";
    ?>

        <form action="index7.php" method="post">
            <input type="text" name="nameFilter" value="<?=$nameFilter?>">
            <input type="checkbox" name="startingWith" value="TRUE">Only names starting with
            <input type="submit" value="Filter list">
        </form>
    <br>
        <footer style="background-color: #777; padding: 10px; text-align: center; font-size: 15px; color: white;">
            <h1>Footer</h1>
        </footer>

    </body>
</html>