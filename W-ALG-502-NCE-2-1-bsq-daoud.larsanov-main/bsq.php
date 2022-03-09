<?php
//si ma variable est affecteé donc i tu incremente 
function myStrlen($str)
{
    $i = 0;
    while (isset($str[$i])) {
        $i++;
    }
    return $i;
}

function myTrim($str)
{
    $strlen = myStrlen($str);
    $newStr = '';

    for ($i = 0; $i < $strlen; $i++) { 
        if ($str[$i] !== "\n") {
            $newStr .= $str[$i];
        }
    }
    return $newStr;
}

/**
 * @return array
 */
function cloneBoard($array, $rowLength)
{
    $newArr = array();

    foreach ($array as $row) {
        for ($i = 0; $i < $rowLength; $i++) {
            if ($row[$i] == "." ) {
                $row[$i] = '1';
            } else {
                $row[$i] = '0';
            }
        }
        $newArr[] = $row;
    }
    return $newArr;
}

function myMin($array)
{
    $min = $array[0];
    foreach ($array as $value) {
        if ($min > $value)
        {
            $min = $value;
        }
    }
    return $min;
}

function check3($cell, $topLeft = 0, $top = 0, $left = 0)
{
    return $cell != 0 ? myMin([$topLeft, $top, $left]) + $cell : 0;
}

/**
 
 * @param array 
 * @var array 
 * @return array 
 */
function maxSquare($array, $rowLength)
{
    $rowIndex = 0;
    $bigSquarePos = array();
    $x = null;
    $y = null;
    $maxNum = 0;

    foreach ($array as $row) {
        for ($i = 0; $i < $rowLength; $i++) {
            
            $topLeft = isset($array[$rowIndex - 1][$i - 1]) ? intval($array[$rowIndex - 1][$i - 1]) : 0;
            $top = isset($array[$rowIndex - 1][$i]) ? intval($array[$rowIndex - 1][$i]) : 0;
            $left = isset($array[$rowIndex][$i - 1]) ? intval($array[$rowIndex][$i - 1]) : 0;
            
            $array[$rowIndex][$i] = check3(intval($row[$i]), $topLeft, $top, $left);
            
            if ($maxNum < $array[$rowIndex][$i]) {
                $maxNum = $array[$rowIndex][$i];
                $x = $i;
                $y = $rowIndex;
            }
        }
        $rowIndex++; 
    }
    return ['size' => $maxNum, "x" => $x, "y" => $y];
}

function displayBigSquare($board, $data)
{
    $size = $data['size'];
    $x = $data['x'];
    $y = $data['y'];
    
    for ($i = 0; $i < $size; $i++) { 
        for ($j = 0; $j < $size; $j++) { 
            $board[$y - $i][$x - $j] = 'x'; 
        }
    }

    foreach ($board as $row) {
        echo "$row\n";
    }

}
function bsq($file)
{
    $numLines;
    $board = array();
    //$file = './generator.pl';
    $handle = @fopen($file, 'r');
    if ($handle) {
        
        $numLines = intval(fgets($handle));
        
        while ($line = fgets($handle)) {
            $board[] = myTrim($line);
        }

        $rowLength = myStrlen($board[0]);
        $board2 = cloneBoard($board, $rowLength);
        $data = maxSquare($board2, $rowLength);
        displayBigSquare($board, $data);
    }
    fclose($handle);
}

bsq($argv[1]);