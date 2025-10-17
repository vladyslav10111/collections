<?php declare(strict_types=1); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Unique Character Counter</title>
</head>
<body>
<form method="post">
    <h3>Count Unique Characters</h3>
    <input type="text" name="text" placeholder="Enter string..." required>
    <button type="submit">Count</button>

    <?php if (!empty($result)) { ?>
        <div class="result">
            <?= htmlspecialchars($result) ?>
        </div>
    <?php } ?>
</form>
</body>
</html>
<?php
