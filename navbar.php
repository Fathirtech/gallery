<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bottom Navigation</title>
  <link rel="stylesheet" href="./css/all.min.css">
  <link rel="stylesheet" href="./css/fontawesome.min.css">
  <!-- Include the Tailwind CSS CDN -->
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <!-- Your Alpine.js script -->
  <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
</head>
<body class="bg-gray-100">
  <!-- Your content -->
  
  <nav x-data="{ open: false }" class="md:hidden bottom-0 fixed w-full bg-white border-t border-gray-200 z-50">
  <div class="max-w-screen-xl mx-auto px-4 flex justify-between">
    <a class="text-gray-700 flex flex-col items-center py-2 text-xs" href="index.php">
      <i class="fas fa-home mb-1"></i> Home
    </a>
    <a class="text-gray-700 flex flex-col items-center py-2 text-xs" href="album.php">
      <i class="fas fa-images mb-1"></i> Album
    </a>
    <a class="text-gray-700 flex flex-col items-center py-2 text-xs" href="foto.php">
    <i class="fas fa-image mb-1"></i> Foto
    </a>
    <div x-data="{ openDropdown: false }" class="relative">
      <button @click="openDropdown = !openDropdown" class="text-gray-700 flex flex-col items-center py-2 text-xs">
        <!-- Icon for user -->
        <?php if(isset($_SESSION['userid']) && isset($user['profile_photo'])): ?>
          <img src="./<?= $user['profile_photo'] ?>" class="w-6 h-6 rounded-full" alt="User Icon">
        <?php else: ?>
          <i class="fas fa-user-circle mb-1"></i>
        <?php endif; ?>
      </button>
      <div x-show="openDropdown" class="absolute right-0 bottom-full mt-2 w-48 bg-white rounded-md shadow-lg z-50">
        <?php if(isset($_SESSION['userid'])): ?>
          <a href="profile.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"><i class="fas fa-user mr-2"></i> My Profile</a>
          <a href="logout.php" onclick="return confirm('Apakah Anda yakin ingin logout?');" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"><i class="fas fa-sign-out-alt mr-2"></i> Logout</a>
        <?php else: ?>
          <a href="login.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"><i class="fas fa-sign-in-alt mr-2"></i> Login</a>
          <a href="register.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"><i class="fas fa-user-plus mr-2"></i> Register</a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</nav>




  <!-- Your remaining content -->

  <div class="w-full text-gray-700 bg-white dark-mode:text-gray-200 dark-mode:bg-gray-800 hidden md:block">
    <div x-data="{ open: false }" class="flex flex-col max-w-screen-xl px-4 mx-auto md:items-center md:justify-between md:flex-row md:px-6 lg:px-8">
      <div class="p-4 flex flex-row items-center justify-between">
        <a href="#" class="text-lg font-semibold tracking-widest text-gray-900 uppercase rounded-lg dark-mode:text-white focus:outline-none focus:shadow-outline">MY GALLERY</a>
        <button class="md:hidden rounded-lg focus:outline-none focus:shadow-outline" @click="open = !open">
          <svg fill="currentColor" viewBox="0 0 20 20" class="w-6 h-6">
            <path x-show="!open" fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM9 15a1 1 0 011-1h6a1 1 0 110 2h-6a1 1 0 01-1-1z" clip-rule="evenodd"></path>
            <path x-show="open" fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
          </svg>
        </button>
      </div>
      <nav :class="{'flex': open, 'hidden': !open}" class="flex-col flex-grow pb-4 md:pb-0 hidden md:flex md:justify-end md:flex-row">
        <a class="px-4 py-2 mt-2 text-sm font-semibold text-gray-900 rounded-lg dark-mode:bg-gray-700 dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 md:mt-0 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline" href="index.php">Home</a>
        <a class="px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg dark-mode:bg-transparent dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 md:mt-0 md:ml-4 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline" href="album.php">Album</a>
        <a class="px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg dark-mode:bg-transparent dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 md:mt-0 md:ml-4 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline" href="foto.php">Foto</a>
        <div x-data="{ openDropdown: false }" class="relative md:inline-block" @click.away="openDropdown = false">
          <button @click="openDropdown = !openDropdown" class="px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg dark-mode:bg-transparent dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 md:mt-0 md:ml-4 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline">
              <!-- Tambahkan gaya inline untuk membuat gambar profil menjadi lingkaran -->
              <?php if(isset($_SESSION['userid']) && isset($user['profile_photo'])): ?>
                  <img src="./<?= $user['profile_photo'] ?>" style="width: 30px; height: 30px; border-radius: 50%; object-fit: cover;" alt="User Icon">
              <?php else: ?>
                  <img src="https://cdn-icons-png.flaticon.com/512/9131/9131529.png" style="width: 30px; height: 30px; border-radius: 50%; object-fit: cover;" alt="User Icon">
              <?php endif; ?>
          </button>
          <div x-show="openDropdown" class="absolute md:right-0 mt-2 py-2 w-48 bg-white rounded-md shadow-xl z-10">
              <?php if(isset($_SESSION['userid'])): ?>
                  <a href="profile.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-200">My Profile</a>
                  <a href="logout.php" onclick="return confirm('Apakah Anda yakin ingin logout?');" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-200">Logout</a>
              <?php else: ?>
                  <a href="login.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-200">Login</a>
                  <a href="register.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-200">Register</a>
              <?php endif; ?>
          </div>
        </div>
      </nav>
    </div>
  </div>
</body>
</html>
