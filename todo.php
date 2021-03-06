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
            asort($items, SORT_NATURAL | SORT_FLAG_CASE);
            break;
        case 'Z':
            arsort($items, SORT_NATURAL | SORT_FLAG_CASE);
            break;
        case 'O':
            ksort($items, SORT_NATURAL | SORT_FLAG_CASE);
            break;
        case 'R':
            krsort($items, SORT_NATURAL | SORT_FLAG_CASE);
            break;
    }
    return $items;
}

function read_file() {
    echo 'Enter file name/path: ';
    $filename = get_input();
    // $handle is pointer to file
    $handle = fopen($filename, 'r');
    $contents = fread($handle, filesize($filename));
    return $contents;
    fclose($handle);
}

function save_file($items) {
    echo 'Enter file location to save: ';
    // When s(A)ve is chosen, the user should be able to enter the path to a file to have it save. 
    // Use fwrite() with the mode that starts at the beginning of a file and removes all the file 
    // contents, or creates a new one if it does not exist. 
    // After save, alert the user the save was successful and redisplay the list and main menu.
    $filename = get_input(false);
    $filecontents = implode(PHP_EOL, $items);
    $handle = fopen($filename, 'w');
    fwrite($handle, $filecontents);
    fclose($handle);
}
// The loop!
do {
    // Iterate through list items
    echo list_items($items);

    
    // Show the menu options
    echo '(N)ew item, (R)emove item, (S)ort list, (O)pen File, s(A)ve File, (Q)uit : ';

    // Get the input from user
    // Use trim() to remove whitespace and newlines
    $input = get_input(TRUE);

    // Check for actionable input
    if ($input == 'N') {
        // Ask for entry
        echo 'Enter item: ';
        // add option to add item to beginning or end of list
        // Add entry to list array
        $temp = get_input();
        echo 'Would you like this item at the (B)eginning or the (E)nd of your list? ';
        // shift or unshift item depending on input
        $input = get_input(TRUE);
        if ($input == 'B') {
            array_unshift($items, $temp);
        } elseif ($input == 'E') {
            array_push($items, $temp);
        } else{
            array_push($items, $temp);
        }
    } elseif ($input == 'R') {
        // Remove which item?
        echo 'Enter item number to remove: ';
        // Get array key
        $key = (get_input()) - 1;
        // Remove from array
        unset($items[$key]);
        // adjusts item numbers in list after deletion
    } elseif ($input == 'S'){
        $items = sort_menu($items);
    } elseif ($input == 'F') {
        array_shift($items);
    } elseif ($input == 'L') {
        array_pop($items);
    } elseif ($input == 'O') {
        //opens file given by user
        $contents = read_file();
        //explode string into array
        $content_array = explode("\n", $contents);
        $items = array_merge($items, $content_array);
    } elseif ($input == 'A') {
        save_file($items);
    }

// Exit when input is (Q)uit
} while ($input != 'Q');

// Say Goodbye!
echo "Goodbye!\n";

// Exit with 0 errors
exit(0);