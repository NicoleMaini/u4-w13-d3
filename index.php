<?php

include __DIR__ . '/includes/db.php';

$stmt = $pdo->query('SELECT * FROM users');

$search = $_GET['search'] ?? ""; // se non c'è è stringa vuota

$page = $_GET['page'] ?? 1; // numero pag
$limit = $_GET['limit'] ?? 4; // limitare gli argomenti per pagina
$limit = $limit > 100 ? 4 : $limit; // limitare gli argomenti per pagina

$starting_limit = ($page - 1) * $limit;

// query di paginazione, non più efficente ma fa quel che basta per noi
$stmt = $pdo->prepare("SELECT * FROM users WHERE username LIKE :search LIMIT :limit OFFSET :offset"); // ---- da impararsi a memo
$stmt->execute([
    'search' => "%$search%",
    'limit' =>  $limit,
    'offset' => $starting_limit,
]);

$users = $stmt->fetchAll();

$stmt = $pdo->prepare('SELECT COUNT(*) AS person FROM users WHERE username LIKE :search');
$stmt->execute([
    'search' => "%$search%",
]);

$total_results = $stmt->fetch()['person'];
$total_pages = ceil($total_results / $limit);

include __DIR__ . '/includes/pre.php'
?>

<h2 class="text-center">TABELLA DATABASE</h2>
<div class="w-75 mx-auto">
    <div class="d-flex align-items-center mb-3">
        <form action="" method="get" class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search" aria-label="Recipient's username" aria-describedby="button-addon2" value="search">
            <button class="btn btn-outline-secondary" type="button" id="button-addon2">Cerca</button>
        </form>
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
            <?php foreach ($users as $user) {
                echo
                "<tr>
                         <th scope='row'></th>
                         <td>$user[username]</td>
                         <td>$user[mail]</td>
                         <td>@@@@@@@@@</td>
                         <td>
                            <a href='http://localhost/u4-w13-d3/details.php/?id=$user[id]' class='btn btn-success'>Go</a>
                            <a href='http://localhost/u4-w13-d3/form.php/?id=$user[id]' class='btn btn-warning'>Edit</a>
                            <a href='http://localhost/u4-w13-d3/delete.php/?id=$user[id]' class='btn btn-danger'>Delete</a>
                        </td>
                        </tr>";
            } ?>

        </tbody>
    </table>
    <div aria-label="Page navigation example">
        <ul class="pagination">
            <li class="page-item <?= $page == 1 ? ' disabled' : '' ?>">
                <a class="page-link" href="/u4-w13-d3/?page<?= $page - 1 ?><?= $search ? "&search=$search" : '' ?>" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
            <?php for ($page = 1; $page <= $total_pages; $page++) : ?>
                <li class="page-item<?= $page == $i ? ' active' : '' ?>"><a class="page-link" href="/u4-w13-d3/<?php echo "?page=$page" ?><?= $search ? "&search=$search" : '' ?>"><?php echo $page; ?></a></li>
            <?php endfor; ?>
            <li class="page-item<?= $page == $tot_pages ? ' disabled' : '' ?>">
                <a class="page-link" href="/u4-w13-d3/?page<?= $page + 1 ?><?= $search ? "&search=$search" : '' ?>" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </div>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>