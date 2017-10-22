<?php

function validaSimbolos($simbolos) {

    $pila = array();

    for ($i = 0; $i < strlen($simbolos); $i++) {
        if ($simbolos[$i] === ')' || $simbolos[$i] === ']' || 
            $simbolos[$i] === '}') {
            $ultimo = array_pop($pila);

            if ($simbolos[$i] === ')' && $ultimo !== '(' || 
                $simbolos[$i] === '}' && $ultimo !== '{' || 
                $simbolos[$i] === ']' && $ultimo !== '[')

                return false;
        } else{
            $pila[] = $simbolos[$i];
        }    
    }

    return !$pila;
}
?>

<html>
<body>
    <form method="post">
      Cadeia de caracteres: <input type="text" name="cadena">      
      <input type="submit" value="Avaliar">
      <?php
            if (isset($_POST)){     
                  echo "<br><br><b>".(validaSimbolos($_POST["cadena"])?'Cadeia de caracteres VÁLIDA':'Cadeia de caracteres INVÁLIDA')."</b>";
            }
       ?>
    </form>
</body>      
</html>





