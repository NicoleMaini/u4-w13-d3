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

$search = $_GET['search'] ?? ""; // se non c'è è stringa vuota
$stmt = $pdo->prepare("SELECT * FROM users WHERE username LIKE ?");
$stmt->execute([
    "%$search%"
]);
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
        <div class="d-flex align-items-center">
            <form action="" method="get" class="input-group mb-3">
                <input type="text" name="search" class="form-control" placeholder="Search" aria-label="Recipient's username" aria-describedby="button-addon2">
                <button class="btn btn-outline-secondary" type="button" id="button-addon2">Cerca</button>
            </form>
            <a href='http://localhost/u4-w13-d3/form.php/add' class='btn btn-info my-2'>Add</a>
        </div>
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
                <?php
                $limit = 4;
                $query = "SELECT count(*) FROM users";

                $s = $pdo->query($query);
                $total_results = $s->fetchColumn();
                $total_pages = ceil($total_results / $limit);

                if (!isset($_GET['page'])) {
                    $page = 1;
                } else {
                    $page = $_GET['page'];
                }

                $starting_limit = ($page - 1) * $limit;
                $show  = "SELECT * FROM users ORDER BY id DESC LIMIT ?,?";

                $r = $pdo->prepare($show);
                $r->execute([$starting_limit, $limit]);

                while ($user = $r->fetch(PDO::FETCH_ASSOC)) :
                ?>
                    <tr>
                        <th scope='row'></th>
                        <td><?= $user['username'] ?></td>
                        <td><?= $user['mail'] ?></td>
                        <td>@@@@@@@@</td>
                        <td>
                            <a href=<?= "http://localhost/u4-w13-d3/details.php/?id=$user[id]" ?> class='btn btn-success'>Go</a>
                            <a href=<?= "http://localhost/u4-w13-d3/form.php/?id=$user[id]" ?> class='btn btn-warning'>Edit</a>
                            <a href=<?= "http://localhost/u4-w13-d3/delete.php/?id=$user[id]" ?> class='btn btn-danger'>Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item">
                    <a class="page-link" href="#" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                <?php for ($page = 1; $page <= $total_pages; $page++) : ?>
                    <li class="page-item"><a class="page-link" href="<?php echo "?page=$page"; ?>"><?php echo $page; ?></a></li>
                <?php endfor; ?>
                <li class="page-item">
                    <a class="page-link" href="#" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>