<?php
$greetingMessage = "";
$errorMsg = "";

// Check if the form was submitted via GET
if (isset($_GET['username'])) {
    try {
        // Prepare the API URL with the input parameter
        $inputName = urlencode($_GET['username']);
        
        // Dynamically build the absolute URL to the local API
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
        $host = $_SERVER['HTTP_HOST'];
        $currentDir = dirname($_SERVER['PHP_SELF']);
        $apiUrl = $protocol . $host . rtrim($currentDir, '/\\') . "/api/greet.php?name=" . $inputName;

        // Call the endpoint
        $apiResponse = @file_get_contents($apiUrl);

        if ($apiResponse === false) {
            throw new Exception("Could not connect to the greeting service.");
        }

        // Decode the JSON data
        $data = json_decode($apiResponse, true);

        if (!$data || !isset($data['message'])) {
            throw new Exception("Invalid response received from the server.");
        }

        // Store the successful response message
        $greetingMessage = $data['message'];

    } catch (Exception $e) {
        // Catch any failures and set a friendly error message
        $errorMsg = "Oops! Something went wrong: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dev Motivation Portal</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Dev Motivation Portal</h1>
        <p class="subtitle">Enter your name below to get a personalized developer boost!</p>

        <form action="index.php" method="GET" class="greet-form">
            <input 
                type="text" 
                name="username" 
                placeholder="e.g. Sam" 
                value="<?php echo isset($_GET['username']) ? htmlspecialchars($_GET['username'], ENT_QUOTES, 'UTF-8') : ''; ?>"
                required
            >
            <button type="submit">Get Greeting</button>
        </form>

        <?php if (!empty($greetingMessage)): ?>
            <div class="result-box success">
                <h3>Server Response:</h3>
                <p><?php echo htmlspecialchars($greetingMessage, ENT_QUOTES, 'UTF-8'); ?></p>
            </div>
        <?php endif; ?>

        <?php if (!empty($errorMsg)): ?>
            <div class="result-box error">
                <h3>Error:</h3>
                <p><?php echo htmlspecialchars($errorMsg, ENT_QUOTES, 'UTF-8'); ?></p>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>