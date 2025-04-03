<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (empty($_SESSION["userData"])) return;
if ($_SESSION["userData"]["id"] !== $profileData["id"]) return;

require_once(__DIR__ . "/../../src/db.php");
$user = getUserById($pdo, $_SESSION["userData"]["id"]);
if ($user["role_id"] === 2) return;

$isProfilePublic = $user["country_id"] != 0 && $user["subdivision_id"] != 0;
?>

<div class="centered-container">
    <div class="become-host centered-container">
        <div>
            <h2>Become A Host</h2>
            <p>Ready to share your passion for food with others? See the requirements below to become a host!</p>
        </div>
        <div class="requirements">
            <h3>Requirements</h3>
            <label><input type="checkbox" onclick="return false" <?php echo $isProfilePublic ? "checked" : "" ?>> Display your location</label>
        </div>
        <form action="actions/edit-profile-action.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $user["id"] ?>">
            <button name="action" value="promote_to_host" onclick="return confirm('Are you sure you want to upgrade your account to a host?\nYou cannot undo this action.')" <?php echo !$isProfilePublic ? "disabled" : "" ?>>Become a Host!</button>
        </form>
    </div>
</div>