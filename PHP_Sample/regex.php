<!-- Mainly regex function were used for search purposes -->

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title></title>
    </head>
    <body>
        <?php

            // Here is a string
            $string = "My name is Vinson, Vinson is my name";

            // takes certain strings, and see if certain characters is in the strings
            // preg_match function return true or false (boolean)
            // first parameter is the string you want to search, second parameter is the designated var
            preg_match("/Vinson/", $string);

            // usually, preg_match used like this...
            // this would only return one arrays, if you want to show all strings inside the var
            // you could instead use preg_match_all function
            if (preg_match("/Vinson/", $string, $array)) {
                print_r($array);
            }

            // using preg_match_all function
            // you can also use multiple search strings inside regex function, like this
            // so, the below regex search strings -> Vinson and strings -> on
            if (preg_match_all("/Vins(on)/", $string, $array)) {
                print_r($array);
                // to be precise, you can just echo the array
                echo $array[0][1];
            }

            // besides preg_match, there also preg_replace function to replace strings
            // for example, the below function change the text Vinson into name
            $string2 = preg_replace("/Vinson/", "name", $string);

            echo $string2;

        ?>
    </body>
</html>