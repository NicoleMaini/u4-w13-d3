<?php
include __DIR__ . '/includes/db.php';

$username = $_POST['username'] ?? '';
$mail = $_POST['mail'] ?? '';
$password = $_POST['password'] ?? '';

// passaggio da rivedere che dovrebbe modificare l'elemento nella tabella, ricomparendo sui campi del form
if ($_SERVER["REQUEST_URI"] !== '/u4-w13-d3/form.php/add') {

  $id = $_GET['id'];
  // $stmt = $pdo->query("SELECT name FROM dishes WHERE id = $id"); // NON FARE MAI!!!!!!
  $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
  $stmt->execute([$id]);
  $user = $stmt->fetch(PDO::FETCH_ASSOC);

  $error = [];
  if (strlen($password) < 8) {
    $error['password'] = 'Please provide a valid password (min length 8).';
  };

  if ($error == []) {
    $stmt = $pdo->prepare("UPDATE users SET username = :username, mail = :mail, password = :password WHERE id = :id");
    $stmt->execute([
      'id' => $id,
      'username' => $username,
      'mail' => $mail,
      'password' => $password,
    ]);
    header('location: http://localhost/u4-w13-d3/index.php');
  };
} else {

  $error = [];
  // if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { // se il valore filter verifica che nel campo email non c'è un email corretta allora
  //   $error['email'] = 'Please provide a valid email.';
  // };
  if (strlen($password) < 1) {
    $error['password'] = 'Please provide a valid password (min length 8).';
  };
  if ($error == []) {
    $stmt = $pdo->prepare("INSERT INTO users (username, mail, password) VALUES (:username, :mail, :password)");
    $stmt->execute([
      'username' => $username,
      'mail' => $mail,
      'password' => password_hash($password, PASSWORD_DEFAULT),
    ]);
    header('location: http://localhost/u4-w13-d3/login.php');
  };
};
// passaggio da rivedere che dovrebbe inserire un nuovo elemento nella tabella
// if (isset($user['username'])) {
// };

include __DIR__ . '/includes/pre.php'

?>


<h2><?= $_SERVER["REQUEST_URI"] !== '/u4-w13-d3/form.php/add' ?  'Modifica' :  'Registrati' ?></h2>
<div class="d-flex justify-content-center mt-5">
  <form class="w-50" action="" method="post" novalidate>
    <div class="mb-3">
      <label for="username" class="form-label">Username</label>
      <input type="text" class="form-control" name="username" id="exampleInputName1" aria-describedby="emailHelp" value=<?= $username ?>>
    </div>
    <div class="mb-3">
      <label for="exampleInputEmail1" class="form-label" value=<?= $mail ?>>Email address</label>
      <input type="email" name="mail" class="form-control is-invalid" id="exampleInputEmail1">
      <div id="validationServer03Feedback" class="invalid-feedback"><?= $error['email'] ?? '' ?></div>
    </div>
    <div class="mb-3">
      <label for="exampleInputPassword1" class="form-label" value=<?= $password ?>>Password</label>
      <input type="password" name="password" class="form-control <?= isset($error['password']) ? 'is-invalid' : '' ?> " id="exampleInputPassword1">
      <div id="validationServer03Feedback" class="invalid-feedback"><?= $error['password'] ?? '' ?>
      </div>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
  </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>