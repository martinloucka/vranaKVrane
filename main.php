<?php

$grid = [
    "1 R B", "2 T R", "3 S G", "4 T P", "5 S O", "6 S Y",
    "7 L Y", "8 C O", "9 R Y", "10 C B", "11 L B", "12 S G",
    "13 C B", "14 N B", "15 S R", "16 C R", "17 R O", "18 R G",
    "19 N G", "20 T P", "21 N P", "22 R G", "23 L Y", "24 C Y",
    "25 L R", "26 N R", "27 C P", "28 P P", "29 S Y", "30 S B",
    "31 N P", "32 R O", "33 N Y", "34 P G", "35 C O", "36 P R"
];

define('GRID_SIZE', 6); 

$parsedGrid = [];
foreach ($grid as $entry) {
    list($index, $animal, $color) = explode(' ', $entry);
    $parsedGrid[$index] = [
        'animal' => $animal,
        'color' => $color,
        'index' => (int)$index,
        'row' => floor(($index - 1) / GRID_SIZE),
        'col' => ($index - 1) % GRID_SIZE
    ];
}

function getNextOptions($current, $visited, $grid)
{
    $options = [];
    foreach ($grid as $nextIndex => $info) {
        if (in_array($nextIndex, $visited)) {
            continue;
        }
        if ($info['row'] == $current['row'] || $info['col'] == $current['col']) {
            if ($info['animal'] == $current['animal'] || $info['color'] == $current['color']) {
                $options[] = $nextIndex;
            }
        }
    }
    return $options;
}

function findPath($currentIndex, $visited, $grid)
{
    if (count($visited) == count($grid) && $currentIndex == 36) {
        return $visited;
    }

    $current = $grid[$currentIndex];
    $options = getNextOptions($current, $visited, $grid);

    foreach ($options as $nextIndex) {
        $newVisited = array_merge($visited, [$nextIndex]);
        $path = findPath($nextIndex, $newVisited, $grid);
        if ($path !== null) {
            return $path;
        }
    }

    return null;
}

$path = findPath(1, [1], $parsedGrid);

if ($path) {
    echo "Path found:\n";
    echo implode(" -> ", $path);
} else {
    echo "No valid path found.\n";
}
