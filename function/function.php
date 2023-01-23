<?php

// função para pegar a data no formato: x tempo atrás
class Data {

    public static function ExibirTempoDecorrido($date)
    {
        if(empty($date))
        {
            return "Informe a data";
        }
    
        $periodos = array("segundo", "minuto", "hora", "dia", "semana", "mês", "ano", "década");
        $duracao = array("60","60","24","7","4.35","12","10");
    
        $agora = time();
        $unix_data = strtotime($date);
    
        // check validity of date
        if(empty($unix_data))
        {  
            return "Bad date";
        }
    
        // is it future date or past date
        if($agora > $unix_data) 
        {  
            $diferenca     = $agora - $unix_data;
            $tempo         = "atrás";
        } 
        else 
        {
            $diferenca     = $unix_data - $agora;
            $tempo         = "agora";
        }
    
        for($j = 0; $diferenca >= $duracao[$j] && $j < count($duracao)-1; $j++) 
        {
            $diferenca /= $duracao[$j];
        }
    
        $diferenca = round($diferenca);
    
        if($diferenca != 1) 
        {
            $periodos[$j].= "s";
        }
    
        return "$diferenca $periodos[$j] {$tempo}";
    }
}

// function palavras_iguais($string1, $string2, $minlen = 2) {
//     $strlen1 = strlen($string1);
//     $strlen2 = strlen($string2);
//     $palavras = array();
//     for($i=0; $i < $strlen1; $i++) {
//         $palavra = substr($string1, $i, $minlen);
//         if (strpos($string2, $palavra) !== false) {
//             $j = $minlen;
//             do {
//                 $j++;
//             } while (strpos($string2, substr($string1, $i, $j)) !== false && $j < $strlen2);
//             $palavra = substr($string1, $i, $j-1);
//             $i += strlen($palavra)-1;
//             $palavras[] = $palavra;
//         }
//     }
//     return $palavras;   
// }

// usado para pesquisas
function palavras_iguais($words)
{
    $words = array_map('strtolower', array_map('trim', $words));
    $sort_by_strlen = create_function('$a, $b', 'if (strlen($a) == strlen($b)) { return strcmp($a, $b); } return (strlen($a) < strlen($b)) ? -1 : 1;');
    usort($words, $sort_by_strlen);

    // We have to assume that each string has something in common with the first
    // string (post sort), we just need to figure out what the longest common
    // string is. If any string DOES NOT have something in common with the first
    // string, return false.
    $palavras_iguais = array();
    $shortest_string = str_split(array_shift($words));
    while (sizeof($shortest_string)) {
        array_unshift($palavras_iguais, '');
        foreach ($shortest_string as $ci => $char) {
            foreach ($words as $wi => $word) {
                if (!strstr($word, $palavras_iguais[0] . $char)) {
                    // No match
                    break 2;
                }
            }

            // we found the current char in each word, so add it to the first palavras_iguais element,
            // then start checking again using the next char as well
            $palavras_iguais[0].= $char;
        }

        // We've finished looping through the entire shortest_string.
        // Remove the first char and start all over. Do this until there are no more
        // chars to search on.
        array_shift($shortest_string);
    }

    // If we made it here then we've run through everything
    usort($palavras_iguais, $sort_by_strlen);
    return array_pop($palavras_iguais);
}
// ===================================================

function formatBytes($bytes, $precision = 2) { 
    $units = array('B', 'KB', 'MB', 'GB', 'TB'); 

    $bytes = max($bytes, 0); 
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024)); 
    $pow = min($pow, count($units) - 1); 

    // Uncomment one of the following alternatives
    // $bytes /= pow(1024, $pow);
    // $bytes /= (1 << (10 * $pow)); 

    return round($bytes, $precision) . ' ' . $units[$pow]; 
} 


?>