<?php
function sqlinjection_test($input) {
    // Check for SQL injection patterns
    $patterns = [
        '/\b(SELECT|INSERT|UPDATE|DELETE|DROP|UNION|WHERE|OR|AND)\b/i',
        '/--/',
        '/;/', // semicolon
        '/\b(1=1)\b/i',
        '/\b(NOW|CURRENT_DATE|CURRENT_TIME)\b/i',
        '/\b(CHAR|CONCAT|CAST)\b/i',
        '/\b(LOAD_FILE|INFILE)\b/i',
        '/\b(SLEEP|BENCHMARK)\b/i'
    ];

    foreach ($patterns as $pattern) {
        if (preg_match($pattern, $input)) {
            return false; // SQL injection detected
        }
    }
    return true; // No SQL injection detected
}
?>