<?php
$reviewTypes = [
    "host" => [
        "action" => "review_host"
    ],
    "experience" => [
        "action" => "review_experience"
    ]
];

$reviewType ??= "";
$additionalClasses ??= "";

if (!in_array($reviewType, array_keys($reviewTypes))) {
    echo "reviewType is invalid or null";
    return;
}
if (empty($reviewAuthorId) || !is_int($reviewAuthorId)) {
    echo "reviewAuthorId is not set to an integer value";
    return;
}
if (empty($reviewTargetId) || !is_int($reviewTargetId)) {
    echo "reviewTargetId is not set to an integer value";
    return;
}
if (empty($successRedirect)) {
    echo "successRedirect is not set";
    return;
}
if (empty($failRedirect)) {
    echo "failRedirect is not set";
    return;
}

if (session_status() === PHP_SESSION_NONE) session_start();

$errorMsgs = $_SESSION["reviewErrorMsgs"] ?? [];
unset($_SESSION["reviewErrorMsgs"]);
?>

<div class="general-review-form <?php echo $additionalClasses ?>">
    <h2>Submit a Review</h2>
    <?php foreach ($errorMsgs as $msg) { ?>
        <p class="error-msg"><?php echo $msg ?></p>
    <?php } ?>
    <form action="actions/submit-review-action.php" method=POST>
        <input type="hidden" name="author_id" value="<?php echo $reviewAuthorId ?>">
        <input type="hidden" name="target_id" value="<?php echo $reviewTargetId ?>">
        <input type="hidden" name="success_redirect" value="<?php echo $successRedirect ?>">
        <input type="hidden" name="fail_redirect" value="<?php echo $failRedirect ?>">

        <input type="range" name="rating" min="1" max="5" value="5" class="rating-range" required>

        <textarea name="description" id="description" class="rating-description" placeholder="Describe your experience here! (Max 2000 characters)" maxlength="2000" required></textarea>

        <button name="action" value="<?php echo $reviewTypes[$reviewType]["action"] ?>">Submit</button>
    </form>
</div>