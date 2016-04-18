<html>
<head>
    <meta charset="UTF-8">
    <title>EPIC BLOGGG!!!!!</title>
</head>
<body>
<form action="indexR.php?action=login" method="POST">
    <input type="text" name="login" value="<?= $login ?>" title="login">
    <input type="password" name="password" title="password">
    <input type="submit" name = "action" value = "login">
    <input type="hidden" name="token" value="<?= $token ?>">
</form>
</body>
</html>