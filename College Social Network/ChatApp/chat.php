<?php 
  session_start();
  include_once "../con_db.php";
  if(!isset($_SESSION['user_id'])){
    // header("location: ../login.php");
    echo "Not Logged in."; die;
  } else {
    // echo "yes Logged in."; die;
  }
?>
<?php include_once "header.php"; ?>
<body>
  <div class="wrapper">
    <section class="chat-area">
      <header>
        <?php 
          $row = '';
          $userID = $_GET['userID'];
          $sql = mysqli_query($conn, "SELECT * FROM users WHERE userID = '{$userID}' ");
          if(! $sql) {
            die($sql);
          }
          if(mysqli_num_rows($sql) > 0){
            $row = mysqli_fetch_assoc($sql);
          }else{
            header("location: users.php");
          }
        ?>
        <a href="users.php" class="back-icon"><i class="fas fa-arrow-left"></i></a>
        <img src="/avatar/<?php echo $row['img']; ?>" alt="">
        <div class="details">
          <span><?php echo $row['name']. " " . $row['surname'] ?></span>
          <p><?php echo $row['status']; ?></p>
        </div>
      </header>
      <div class="chat-box">

      </div>
      <form action="#" class="typing-area">
        <input type="text" class="incoming_id" name="incoming_id" value="<?php echo $userID; ?>" hidden>
        <input type="text" name="message" class="input-field" placeholder="Type a message here..." autocomplete="off">
        <button><i class="fab fa-telegram-plane"></i></button>
      </div>
    </section>
  </div>

  <script src="javascript/chat.js"></script>

</body>
</html>
