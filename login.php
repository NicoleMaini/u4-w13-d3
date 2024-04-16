<?php
include __DIR__ . '/includes/db.php';

if ($user_db) header('Location: /u4-w13-d3/'); // se l'utente è già selezionato non si può riloggare e viene rimandato in home

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username;");
    $stmt->execute([
        'username' => $_POST['username'],
    ]);

    $user_db = $stmt->fetch();

    if ($user_db) {
        // confrontare gli hash
        if (password_verify($_POST['password'], $user_db["password"])) {
            // se gli hash coincidono => utente loggato, altrimenti errore
            $_SESSION['user_id'] = $user_db['id'];
            // TODO: non arriva qui sotto
            header('Location: /u4-w13-d3/');
            exit;
        }
    }

    $errors = [];
    // popolare l'array degli errori
    $errors['credentials'] = 'Credenziali non valide';
}


include __DIR__ . '/includes/pre.php';

?>

<h2>Login</h2>
<div class="d-flex justify-content-center mt-5">
    <form class="w-50" action="" method="post" novalidate>
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" name="username" id="exampleInputName1" aria-describedby="emailHelp" value=<?= $username ?>>
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Password</label>
            <input type="password" name="password" class="form-control " id="exampleInputPassword1">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
</div>
</form>
</div>