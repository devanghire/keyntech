<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>An Error Occurred</title>
</head>
<body>
    <h1>An Error Occurred</h1>
    <p><?php echo $message; ?></p>
    <p><strong>Filename:</strong> <?php echo $exception->getFile(); ?></p>
    <p><strong>Line Number:</strong> <?php echo $exception->getLine(); ?></p>
</body>
</html>
