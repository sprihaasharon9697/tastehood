<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>

<header class="header">

   <section class="flex">

      <a href="home.php" class="logo">😋 TasteHood 😋</a>

      <nav class="navbar">
         <a href="home.php">home</a>
         <a href="about.php">about</a>
         <a href="menu.php">menu</a>
         <a href="orders.php">orders</a>
         <a href="contact.php">contact</a>
         <a href="diagnosis.php">Diagnosis</a> <!-- Added -->
        <a href="diet_plans.php">Diet Plans</a><!-- Added -->
      </nav>

      <div class="icons">
         <?php
            $count_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
            $count_cart_items->execute([$user_id]);
            $total_cart_items = $count_cart_items->rowCount();
         ?>
         <a href="search.php"><i class="fas fa-search"></i></a>
         <a href="cart.php"><i class="fas fa-shopping-cart"></i><span>(<?= $total_cart_items; ?>)</span></a>
         <div id="user-btn" class="fas fa-user"></div>
         <div id="menu-btn" class="fas fa-bars"></div>
      </div>

      <div class="profile">
         <?php
            $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
            $select_profile->execute([$user_id]);

            if ($select_profile->rowCount() > 0) {
               $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
         ?>
         <p class="name"><?= htmlspecialchars($fetch_profile['name']); ?></p>
         <div class="flex">
            <a href="profile.php" class="btn">Profile</a>
            
            <!-- Logout button based on user type -->
            <?php if ($fetch_profile['name'] == 'admin') { ?>
               <a href="components/admin_logout.php" onclick="return confirm('Logout from admin panel?');" class="delete-btn">Logout</a>
            <?php } else { ?>
               <a href="components/user_logout.php" onclick="return confirm('Logout from this website?');" class="delete-btn">Logout</a>
            <?php } ?>
         </div>

         <!-- Admin Panel Button (Only for Admins) -->
         <?php if ($fetch_profile['name'] == 'admin') { ?>
            <a href="admin_dashboard.php" class="btn admin-btn">Admin Panel</a>
         <?php } ?>

         <?php
            } else {
         ?>
            <p class="name">Please login first!</p>
            <a href="login.php" class="btn">Login</a>
            <a href="register.php" class="btn">admin</a>
         <?php
            }
         ?>
      </div>

   </section>

</header>


