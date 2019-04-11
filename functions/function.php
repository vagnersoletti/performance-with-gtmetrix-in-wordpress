<?php
/**
 * Return value grade 
 */
function score_to_grade( $score ) {
    if ($score == 100) {
        $grade = 'A';
    } else if ($score < 50) {
        $grade = 'F';
    } else {
        $grade = html_entity_decode('&#' . (74 - floor( $score / 10 )) . ';');
    }
    return $grade;
}

/**
 * Converter BYTES in MB
 */
function By2M( $size ) {
    $filesizename = array(" Bytes", " KB", " MB", " GB", " TB", " PB", " EB", " ZB", " YB");
    return $size ? round($size/pow(1024, ($i = floor(log($size, 1024)))), 2) : '0 Bytes';
}




?>