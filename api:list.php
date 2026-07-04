<?php
// Set the JSON content-type header
header('Content-Type: application/json');

$quotes = [
    ["id" => 1, "quote" => "First, solve the problem. Then, write the code.", "author" => "John Johnson"],
    ["id" => 2, "quote" => "Code is like humor. When you have to explain it, it’s bad.", "author" => "Cory House"],
    ["id" => 3, "quote" => "Simplicity is the soul of efficiency.", "author" => "Austin Freeman"],
    ["id" => 4, "quote" => "Make it work, make it right, make it fast.", "author" => "Kent Beck"]
];

// Return data as JSON
echo json_encode($quotes);