<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Kanban Board</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <!-- Ekko Lightbox -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/overlayscrollbars/1.13.1/css/OverlayScrollbars.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index.html" class="brand-link">
      <img src="https://adminlte.io/themes/v3/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="index.html" class="nav-link">
              <i class="nav-icon fas fa-columns"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="kanban.html" class="nav-link">
              <i class="nav-icon fas fa-columns"></i>
              <p>
                Kanban Board
              </p>
            </a>
          </li>
        </ul>
      </nav>
    </div>
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper kanban">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h1>Kanban Board</h1>
          </div>
          <div class="col-sm-6 d-none d-sm-block">
            <ol class="breadcrumb float-sm-right">
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="fas fa-user"></i> Profile
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="profileDropdown">
                  <a class="dropdown-item" href="#">Profile</a>
                  <a class="dropdown-item" href="#">Settings</a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="#">Logout</a>
                </div>
              </li>
            </ol>
          </div>
        </div>
      </div>
    </section>
  
    <section class="content pb-3">
      <div class="container-fluid h-100">
        <!-- Backlog column -->
        <div class="card card-row card-secondary" id="backlog">
          <div class="card-header">
            <h3 class="card-title">Backlog</h3>
          </div>
          <div class="card-body">
            <div class="card card-info card-outline kanban-item" draggable="true" id="task1">
              <div class="card-header">
                <h5 class="card-title">Create Labels</h5>
              </div>
            </div>
            <!-- More cards can go here -->
          </div>
        </div>
  
        <!-- To Do column -->
        <div class="card card-row card-primary" id="todo">
          <div class="card-header">
            <h3 class="card-title">To Do</h3>
          </div>
          <div class="card-body">
            <div class="card card-primary card-outline kanban-item" draggable="true" id="task2">
              <div class="card-header">
                <h5 class="card-title">Create first milestone</h5>
              </div>
            </div>
            <!-- More cards can go here -->
          </div>
        </div>
  
        <!-- In Progress column -->
        <div class="card card-row card-default" id="inprogress">
          <div class="card-header bg-info">
            <h3 class="card-title">In Progress</h3>
          </div>
          <div class="card-body">
            <div class="card card-light card-outline kanban-item" draggable="true" id="task3">
              <div class="card-header">
                <h5 class="card-title">Update Readme</h5>
              </div>
            </div>
            <!-- More cards can go here -->
          </div>
        </div>
  
        <!-- Done column -->
        <div class="card card-row card-success" id="done">
          <div class="card-header">
            <h3 class="card-title">Done</h3>
          </div>
          <div class="card-body">
            <div class="card card-primary card-outline kanban-item" draggable="true" id="task4">
              <div class="card-header">
                <h5 class="card-title">Create repo</h5>
              </div>
            </div>
            <!-- More cards can go here -->
          </div>
        </div>
      </div>
    </section>
  </div>

  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 3.2.0
    </div>
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
<!-- Ekko Lightbox -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.min.js"></script>
<!-- overlayScrollbars -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/overlayscrollbars/1.13.1/js/jquery.overlayScrollbars.min.js"></script>
<!-- Filterizr -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/filterizr/2.2.4/jquery.filterizr.min.js"></script>

<!-- Drag and Drop Functionality -->
<script>
  $(function() {
    $(".kanban-item").on("dragstart", function (event) {
      event.originalEvent.dataTransfer.setData("text/plain", event.target.id);
    });

    // Allow drop on columns
    $(".card-body").on("dragover", function (event) {
      event.preventDefault(); 
    });

    // Handle dropping of items
    $(".card-body").on("drop", function (event) {
      event.preventDefault();
      var id = event.originalEvent.dataTransfer.getData("text");
      var draggableElement = document.getElementById(id);
      $(this).append(draggableElement); 
    });
  });
</script>

</body>
</html>
