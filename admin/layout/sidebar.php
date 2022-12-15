 <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

     <!-- Sidebar - Brand -->
     <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
         <div class="sidebar-brand-icon rotate-n-15">
             <i class="fas fa-laugh-wink"></i>
         </div>
         <div class="sidebar-brand-text mx-3">SB Admin <sup>2</sup></div>
     </a>

     <!-- Divider -->
     <hr class="sidebar-divider my-0">

     <!-- Nav Item - Dashboard -->
     <li class="nav-item <?php echo isset($title) && $title ==='dashboard'?'active':'' ?>">
         <a class="nav-link" href="dashboard.php">
             <i class="fas fa-home"></i>
             <span>Dashboard</span>
         </a>
     </li>

     <!-- Divider -->
     <hr class="sidebar-divider">
     <li class="nav-item <?php echo isset($title) && $title ==='category'?'active':'' ?>">
         <a class="nav-link" href="category.php">
             <i class="fas fa-list"></i>
             <span>Category</span>
         </a>
     </li>
     <hr class="sidebar-divider">
    <li class="nav-item <?php echo isset($title) && $title ==='tag'?'active':'' ?>">
         <a class="nav-link" href="tag.php">
             <i class="fas fa-list"></i>
             <span>Tag</span>
         </a>
     </li>
     <hr class="sidebar-divider">
     <li class="nav-item">
         <a class="nav-link" href="dashboard.php">
             <i class="fas fa-newspaper"></i>
             <span>Post</span>
         </a>
     </li>
     <hr class="sidebar-divider">
     <li class="nav-item">
         <a class="nav-link" href="dashboard.php">
             <i class="fas fa-users"></i>
             <span>Users</span>
         </a>
     </li>





     <!-- Divider -->
     <hr class="sidebar-divider">







     <!-- Sidebar Toggler (Sidebar) -->
     <div class="text-center d-none d-md-inline">
         <button class="rounded-circle border-0" id="sidebarToggle"></button>
     </div>



 </ul>