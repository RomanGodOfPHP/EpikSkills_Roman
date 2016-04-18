<html>
<head>
    <meta charset="UTF-8">
    <title>EPIC BLOGGG!!!!!</title>
</head>
<body>
<p><?= $_SESSION['user']['login'] ?> <a href="indexR.php?action=logout&token=<?= $token ?>"> Выйти </a></p>
<h1><a href="indexR.php?action=tyverst2"> Epic blog </a></h1>
<?php if (!empty($messages)): ?>
    <?php foreach ($messages as $message): ?>
        <div class="message">
            <a href="indexR.php?action=tyverst2&message_id=<?= $message['id'] ?>"><h2>message № <?= $message['id'] ?></h2></a>
            <span class="right"><?= $message['message']; ?></span>
            <span class="right"><?= "Data: " . $message['time']; ?></span>
        </div>
        <br/>
    <?php endforeach ?>
<?php endif ?>

<form action="indexR.php?action=save" method="post">
    <textarea name="message" id="message" rows="5" cols="60"><?= empty($message_id) ? '' : $messages[0]['message'] ?></textarea>
    <input type="hidden" name="message_id" value="<?= $message_id ?>">
    <input type="submit" name="action" value="save">
    <input type="hidden" name="token" value="<?= $token ?>">
</form>

<?php for($i=1; $i<=$a; $i++): ?>
    <span class="count">
            <a href="IndexR.php?page=<?= $i ?>"><?= $i; ?></a>
        </span>
<?php endfor ?>
</body>
</html>