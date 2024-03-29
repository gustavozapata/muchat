<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link rel="stylesheet" href="./styles/index.css" />
    <link rel="stylesheet" href="./styles/chat.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <title>MUCHAT</title>
  </head>
  <body>
    <header>
      <section class="section-header">
        <div class="logout">
          <a id="arrow-a" href="./controller/logout.php">
            <img src="./images/arrow.png" alt="Back Arrow Image" />
          </a>
          <a href="./controller/logout.php">Log-out</a>
        </div>
        <div class="profile">
          <h2>ZA-QU</h2>
          <span class="profile-image">
            <img src="./images/zantologo.png" alt="Family Za-Qu Photo" />
          </span>
        </div>
      </section>
    </header>

    <!-- USER ONLINE/OFFLINE -->
    <div class="users-connected">
      <div>
        <?php foreach($users as $user): ?>
        <p data-user="<?= $user->id ?>"><span <?php echo $user->online ? 'class="connected" data-on="1"' : 'data-on="0"' ?>></span><?= $user->username ?></p>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- coming soon -->
    <div class="coming-soon">
      <p>Coming soon!</p>
    </div>
    
    <main>
      <section class="chat-log">
        <?php foreach($chat as $msg): ?>
        <div <?php echo $msg->user == $_SESSION["id"] ? 'class="yo"' : null ?>>
          <p class="user"><?= $msg->firstName . " " . $msg->lastName ?></p>
          <p class="time"><?= $msg->time ?></p>
          <p class="message"><?= $msg->message ?></p>
        </div>
        <?php endforeach; ?>
      </section>
      <div id="elchat">
        <form method="POST" autocomplete="off">
          <input id="message" type="text" name="message" autocomplete="off" />
          <img src="./images/camera.png" alt="Camera Image" />
        </form>
      </div>
    </main>
    <script src="./scripts/chat.js"></script>
  </body>
</html>
