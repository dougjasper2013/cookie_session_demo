
<?php
// Start or resume the session.
// This must run before HTML output.
session_start();

$message = "";

// Store a session variable
if (isset($_POST["create_session"])) {
    $name = trim($_POST["name"] ?? "");

    if ($name !== "") {
        $_SESSION["visitor_name"] = $name;
        $_SESSION["visit_count"] =
            ($_SESSION["visit_count"] ?? 0) + 1;

        $message = "Session data saved.";
    }
}

// Delete just one session variable
if (isset($_POST["delete_variable"])) {
    unset($_SESSION["visitor_name"]);
    $message = "Visitor name removed from the session.";
}

// Destroy the entire session
if (isset($_POST["destroy_session"])) {
    $_SESSION = [];

    // Remove the browser's session ID cookie.
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();

        setcookie(session_name(), "", [
            "expires" => time() - 3600,
            "path" => $params["path"],
            "domain" => $params["domain"],
            "secure" => $params["secure"],
            "httponly" => $params["httponly"],
            "samesite" => $params["samesite"] ?? "Lax"
        ]);
    }

    session_destroy();
    $message = "The session has been destroyed.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PHP Session Demo</title>
</head>
<body>
    <h1>PHP Session Demo</h1>

    <p><?php echo htmlspecialchars($message); ?></p>

    <form method="post">
        <label for="name">Your name:</label>
        <input type="text" id="name" name="name">

        <button type="submit" name="create_session">
            Create / Update Session
        </button>

        <button type="submit" name="delete_variable">
            Delete Name Variable
        </button>

        <button type="submit" name="destroy_session">
            Destroy Session
        </button>
    </form>

    <h2>Current Session Data</h2>

    <?php if (isset($_SESSION["visitor_name"])): ?>
        <p>
            Welcome,
            <?php echo htmlspecialchars(
                $_SESSION["visitor_name"]
            ); ?>
        </p>

        <p>
            Visit count:
            <?php echo (int) $_SESSION["visit_count"]; ?>
        </p>
    <?php else: ?>
        <p>No visitor name stored in the session.</p>
    <?php endif; ?>
</body>
</html>
