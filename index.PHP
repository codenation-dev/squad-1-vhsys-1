<?php
 
    $atribuicao = array( 
        [
            '1' => 'I',
            '2' => 'II',
            '3' => 'III',
            '4' => 'IV',
            '5' => 'V',
            '6' => 'VI',
            '7' => 'VII',
            '8' => 'VIII',
            '9' => 'IX',
            '10' => 'X',
            '20' => 'XX',
            '30' => 'XXX',
            '40' => 'XL',
            '50' => 'L',
        ]
        );
    
if (isset($_POST['numero'])) {
       $numero = $_POST['numero'];
    
       if ($numero > 0 && ($numero <= 10 || $numero == 20 || $numero == 30 || $numero == 40 || $numero == 50))
       {
           print_r($atribuicao[0][$numero]);
       }
       else if ($numero > 0 && ($numero % 10 <= 9 && $numero < 51))
       {
           $resto = $numero % 10;
            $soma3 = $numero - $resto;
            print_r(($atribuicao[0][$soma3]).($atribuicao[0][$resto]));
            
       }
       else if ($numero == 0 || $numero >50) {
           print_r("Valor inválido");
       }
    }
?>

<form method="POST">
    <input name="numero" type="text">
    <input type="submit">
</form>