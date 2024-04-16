<?php

include __DIR__ . '/includes/db.php';

// url search param 
$id = $_GET['id'];

// qua facciamo una fetch dall'id passato tramite link
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?"); // ? placheholder sostitutivo per il valore, con il quale andremo a controllare il valore successivo
$stmt->execute([$id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

include __DIR__ . '/includes/pre.php'

?>



<h1 class="text-center">Page details</h1>

<div class="w-50 mx-auto">
  <?php
  echo "<div class='card text-bg-light mb-3' >
        <div class='card-header'>$user[username]</div>
        <div class='card-body'>
          <h5 class='card-title'>$user[mail]</h5>
          <p class='card-text'>$user[password]</p>
        </div>
      </div>"
  ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>