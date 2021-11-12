<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
</head>
<body>
<pre style="display:block;width:98%;min-height:100%;padding:1%;background:#222;color:#fff;"><?php

    require(__DIR__ . DIRECTORY_SEPARATOR . 'inc' . DIRECTORY_SEPARATOR . 'OldEnglishPound.php');

    /**
     * Sum example
     * Ex: 5p 17s 8d + 3p 4s 10d = 9p 2s 6d
     */
    $sumExample = new OldEnglishPound('5p 17s 8d');
    $sumResult = $sumExample->sum(new OldEnglishPound('3p 4s 10d'));
    echo "SUM: Formatted result: {$sumResult->to_formatted_value()}\n\n";
    echo "DETAILS:\n" . print_r($sumResult, true) . "\n\n\n\n";

    /**
     * Subtraction example
     * 9p 2s 6d - 5p 17s 8d = 3p 4s 10d
     */
    $subExample = new OldEnglishPound('9p 2s 6d');
    $subResult = $subExample->sub(new OldEnglishPound('5p 17s 8d'));
    echo "SUB: Formatted result: {$subResult->to_formatted_value()}\n\n";
    echo "DETAILS:\n" . print_r($subResult, true) . "\n\n\n\n";

    /**
     * Multiplication example
     * 5p 17s 8d * 2 = 11p 15s 4d
     */
    $mulExample = new OldEnglishPound('5p 17s 8d');
    $mulResult = $mulExample->mul(2);
    echo "MUL: Formatted result: {$mulResult->to_formatted_value()}\n\n";
    echo "DETAILS:\n" . print_r($mulResult, true) . "\n\n\n\n";

    /**
     * Division example
     * 18p 16s 1d / 15 = 1p 5s 0d (1s 1d)
     */
    $divExample = new OldEnglishPound('18p 16s 1d');
    $divResult = $divExample->div(15);
    echo "DIV: Formatted result: {$divResult->to_formatted_value()}\n\n";
    echo "DETAILS:\n" . print_r($divResult, true) . "\n\n\n\n";


    /**
     * Concatenation example
     */
    $priceA = new OldEnglishPound('5p 17s 8d');
    $priceB = new OldEnglishPound('3p 4s 10d');
    $concatResult = $priceA->sum($priceB)->mul(2)->div(3);
    echo "CONCATENATION: Formatted result: {$concatResult->to_formatted_value()}\n\n";
    echo "DETAILS:\n" . print_r($concatResult, true) . "\n\n\n\n";

?></pre>
</body>
</html>