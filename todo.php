<?php

// Create array to hold list of todo items
$items = array();

// List array items formatted for CLI
function list_items($items){
    $result = '';
    foreach ($items as $key => $item) {
        
        $result .= "[" . ($key + 1). "]" . " " . $item . PHP_EOL;
    }
    return $result;
    // Return string of list items separated by newlines.
    // Should be listed [KEY] Value like this:
    // [1] TODO item 1
    // [2] TODO item 2 - blah
    // DO NOT USE ECHO, USE RETURN
}

// Get STDIN, strip whitespace and newlines, 
// and convert to uppercase if $upper is true
function get_input($upper = false) 
{   // Return filtered STDIN input
    $result = trim(fgets(STDIN));
    return $upper ? strtoupper($result) : $result;
}

// Function to sort menu by user preference
function sort_menu($items) {
    
    echo 'Sort by: (A)-Z, (Z)-A, (O)rder entered, (R)everse order entered : ';
    $input = get_input(TRUE);


    // Sort menu as if
    // if ($input == 'A') {
    //     sort($items);
    // } elseif ($input == 'Z') {
    //     rsort($items);
    // } elseif ($input == 'O') {
    //     ksort($items);
    // } elseif ($input == 'R') {
    //     krsort($items);
    // }

    // Sort menu as switch
    switch ($input) {
        case 'A':
            sort($items, SORT_NATURAL | SORT_FLAG_CASE);
            break;
        case 'Z':
            rsort($items, SORT_NATURAL | SORT_FLAG_CASE);
            break;
        case 'O':
            ksort($items, SORT_NATURAL |SORT_FLAG_CASE);
            break;
        case 'R':
            krsort($items, SORT_NATURAL | SORT_FLAG_CASE);
            break;
    }
    return $items;
}

// The loop!
do {
    // Iterate through list items
    echo list_items($items);

    
    // Show the menu options
    echo '(N)ew item, (R)emove item, (S)ort list, (Q)uit : ';

    // Get the input from user
    // Use trim() to remove whitespace and newlines
    $input = get_input(TRUE);

    // Check for actionable input
    if ($input == 'N') {
        // Ask for entry
        echo 'Enter item: ';
        // Add entry to list array
        $items[] = get_input();
    } elseif ($input == 'R') {
        // Remove which item?
        echo 'Enter item number to remove: ';
        // Get array key
        $key = (get_input()) - 1;
        // Remove from array
        unset($items[$key]);
        // adjusts item numbers in list after deletion
        $items = array_values($items);
    } elseif ($input == 'S'){
        $items = sort_menu($items);
        
    }
// Exit when input is (Q)uit
} while (!($input == 'Q'));

// Say Goodbye!
echo "Goodbye!\n";

// Exit with 0 errors
exit(0);