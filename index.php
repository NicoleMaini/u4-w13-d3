<?php

$host = 'localhost';
$db   = 'ifoa_user';
$user = 'root';
$pass = '';
$dsn = "mysql:host=$host;dbname=$db";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

$pdo = new PDO($dsn, $user, $pass, $options);

$stmt = $pdo->query('SELECT * FROM users');


?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <h2 class="text-center">TABELLA DATABASE</h2>
    <div class="w-75 mx-auto">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Mail</th>
                    <th scope="col">Password</th>
                    <th scope="col">button</th>
                </tr>
            </thead>
            <tbody>

                <?php foreach ($stmt as $user) {
                    echo
                    "<tr>
                         <th scope='row'></th>
                         <td>$user[username]</td>;
                         <td>$user[mail]</td>;
                         <td>$user[password]</td>;
                         <td>
                            <a href='http://localhost/u4-w13-d3/details.php/?id=$user[id]' class='btn btn-success'>Go</a>
                            <a href='http://localhost/u4-w13-d3/form.php/?id=$user[id]' class='btn btn-warning'>Edit</a>
                            <a href='http://localhost/u4-w13-d3/delete.php/?id=$user[id]' class='btn btn-danger'>Delete</a>
                        </td>
                        </tr>";
                } ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>