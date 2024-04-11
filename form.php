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

$id = $_GET['id'];
// $stmt = $pdo->query("SELECT name FROM dishes WHERE id = $id"); // NON FARE MAI!!!!!!
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
print_r($user);

$stmt = $pdo->prepare("INSERT INTO dishes (name, price) VALUES (:belnome, :ottimoprezzo)");
$stmt->execute([
  'belnome' => 'Pizza fatta il pomeriggio',
  'ottimoprezzo' => 0.01,
]);

if (isset($user['username'])) {
  $username = $user['username'] ?? '';
  $email = $user['mail'] ?? '';
  $password = $user['password'] ?? '';


  $error = [];

  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { // se il valore filter verifica che nel campo email non c'è un email corretta allora
    $error['email'] = 'Please provide a valid email.';
  };

  if (strlen($password) < 8) {
    $error['password'] = 'Please provide a valid password (min length 8).';
  };

  if ($error == []) {
    header('location: /u4-w13/d2-success.php');
  };

  print_r($error);
};


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
  <h2>Modifica</h2>
  <div class="d-flex justify-content-center mt-5">
    <form class="w-50" action="" method="post" novalidate>
      <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text" class="form-control" name="username" id="exampleInputName1" aria-describedby="emailHelp" value=<?php $username ?>>
      </div>
      <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Email address</label>
        <input type="email" name="email" class="form-control is-invalid" id="exampleInputEmail1">
        <div id="validationServer03Feedback" class="invalid-feedback"><?= $error['email'] ?? '' ?></div>
      </div>
      <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Password</label>
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