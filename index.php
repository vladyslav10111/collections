<?php

require __DIR__ . '/vendor/autoload.php';

use Vladyslav10111\Collection\UniqueCharCounter;

$counter = new UniqueCharCounter();
$result = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = trim($_POST['text'] ?? '');
    if ($input !== '') {
        $result = $counter->countUniqueChars($input);
    }
}
?>
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

    <?php if ($result !== null) { ?>
        <div class="result">
           <?php echo htmlspecialchars($result); ?>
        </div>
    <?php } ?>

</form>
</body>
</html>
