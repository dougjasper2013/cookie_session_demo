<?php
$message = "";

// Create a cookie
if (isset($_POST["create_cookie"])) {
    $name = trim($_POST["name"] ?? "");

    if ($name !== "") {
        setcookie("visitor_name", $name, [
            "expires" => time() + 3600,
            "path" => "/",
            "httponly" => true,
            "samesite" => "Lax"
        ]);

        // Make the new value available in this request.
        $_COOKIE["visitor_name"] = $name;

        $message = "Cookie created. It expires in one hour.";
    }
}

// Delete the cookie
if (isset($_POST["delete_cookie"])) {
    setcookie("visitor_name", "", [
        "expires" => time() - 3600,
        "path" => "/",
        "httponly" => true,
        "samesite" => "Lax"
    ]);

    unset($_COOKIE["visitor_name"]);

    $message = "Cookie deleted.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PHP Cookie Demo</title>
</head>
<body>
    <h1>PHP Cookie Demo</h1>

    <p>
        <?php echo htmlspecialchars($message); ?>
    </p>

    <form method="post">
        <label for="name">Your name:</label>
        <input type="text" id="name" name="name">

        <button type="submit" name="create_cookie">
            Create Cookie
        </button>

        <button type="submit" name="delete_cookie">
            Delete Cookie
        </button>
    </form>

    <h2>Current Cookie Value</h2>

    <?php
    if (isset($_COOKIE["visitor_name"])) {
        echo "Welcome, " .
            htmlspecialchars($_COOKIE["visitor_name"]);
    } else {
        echo "No visitor cookie found.";
    }
    ?>
</body>
</html>
