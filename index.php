<?php

function solution($B) :bool
{
    $maxRow = count($B);
    $maxColumn = strlen($B[0]);
    $destionation = $maxRow . '-' . $maxColumn;

    list($assasin, $emtyFields, $obstacles, $guards) = mapBoard($B);

    return findPath(
        $assasin,
        getAvailableFields($guards, $emtyFields, $obstacles, $maxRow, $maxColumn),
        $destionation
    );
}

function mapBoard(array $B) :array
{
    $emtyFields = [];
    $obstacles = [];
    $guards = [];

    //Mapping board
    foreach ($B as $rowIndex => $columns) {
        foreach (str_split($columns) as $columnIndex => $field) {
            $key = ($rowIndex + 1) . '-' . ($columnIndex + 1);
            if ($field === 'X') {
                $obstacles[$key] = 1;
            } elseif ($field === '.') {
                $emtyFields[$key] = 1;
            } elseif ($field === 'A') {
                $assasin = $key;
                $emtyFields[$key] = 1;
            } else {
                $guards[$key] = $field;
            }
        }
    }

    return [$assasin, $emtyFields, $obstacles, $guards];
}

function getAvailableFields(array $guards, array $emtyFields, array $obstacles, int $maxRow, int $maxColumn) :array
{
    //Eliminating guard watched fields
    $availableFields = $emtyFields;
    foreach ($guards as $coordinates => $guardType) {
        $guardRowIndex = str_split($coordinates)[0];
        $guardColumnIndex = str_split($coordinates)[2];

        $watchDirections = [
            '>' => [0,1], //watching right
            '<' => [0,-1], //watching left
            '^' => [-1,0], //watching up
            'v' => [1,0], //watching down
        ];

        $watchDirection = $watchDirections[$guardType];

        $step = 1;
        $stepsAvailable = true;
        while ($stepsAvailable) {
            $nextRow = $guardRowIndex + ($watchDirection[0] * $step);
            $nextColumn = $guardColumnIndex + ($watchDirection[1] * $step);
            $nextKey = $nextRow . '-' . $nextColumn;

            if (
                (($nextRow > $maxRow) || ($nextColumn > $maxColumn)) //running out of map
                || isset($guards[$nextKey]) // if there is guard
                || isset($obstacles[$nextKey]) // if there is obstacle
            ) {
                $stepsAvailable = false;
            } else {
                if (isset($availableFields[$nextKey])) {
                    unset($availableFields[$nextKey]);
                }
            }

            $step++;
        }
    }

    return $availableFields;
}

function findPath($assasin, $availabeFields, $destination, $counter = 1) :bool
{
    //If assasin caugh on the spot
    if (!isset($availabeFields[$assasin])) {
        return false;
    }

    //If assasin riched its destination
    if ($assasin == $destination) {
        return true;
    }

    $assasinRow = str_split($assasin)[0];
    $assasinColumn = str_split($assasin)[2];
    $foundPath = false;

    $posibblePathes = [
        [1, 0], //moving right
        [-1, 0], //moving left
        [0, 1], //moving down
        [0, -1], //moving up
    ];

    foreach ($posibblePathes as $offsets) {
        $nextField = ($assasinRow + $offsets[0]) . '-' . ($assasinColumn + $offsets[1]);
        if (isset($availabeFields[$nextField])) {
            $newAvailabeFields = $availabeFields;
            unset($newAvailabeFields[$assasin]);

            $foundPath = findPath($nextField, $newAvailabeFields, $destination, ++$counter);
        }

        if($foundPath) {
            break;
        }
    }

    return $foundPath;
}

$a = ["X.....>", "..v..X.", ".>..X..", "A......"]; //false
$b = ["...", ">.A"]; //false
$c = ["A.v", "..."]; //false
$d = ["...Xv", "AX..^", ".XX.."]; //true

var_dump(solution($a));
var_dump(solution($b));
var_dump(solution($c));
var_dump(solution($d));