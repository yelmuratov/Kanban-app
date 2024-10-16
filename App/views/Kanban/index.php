<?php
use App\Helper\Helper;
use App\Models\User\User;
use App\Models\Task\Task;
use App\Models\Comment\Comment;

$users = User::getAll();
Helper::checkAuth();

$tasks = Task::getAll();
$comments = Comment::getAll();
?>

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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="/" class="brand-link">
        <img src="https://adminlte.io/themes/v3/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">AdminLTE 3</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
            <li class="nav-item">
              <a href="/" class="nav-link">
                <i class="nav-icon fas fa-columns"></i>
                <p>Dashboard</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="/kanban" class="nav-link">
                <i class="nav-icon fas fa-columns"></i>
                <p>Kanban Board</p>
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
                  <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-toggle="dropdown">
                    <i class="fas fa-user"></i> Profile
                  </a>
                  <div class="dropdown-menu dropdown-menu-right" aria-labelledby="profileDropdown">
                    <a class="dropdown-item" href="#">Profile</a>
                    <a class="dropdown-item" href="#">Settings</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="/logout">Logout</a>
                  </div>
                </li>
              </ol>
            </div>
            <?php if ($_SESSION['user'] && $_SESSION['user'][0]['role'] == 'admin') { ?>
              <div class="col-sm-6">
                <button class="btn btn-primary float-right" data-toggle="modal" data-target="#createTaskModal">
                  <i class="fas fa-plus"></i> New Task
                </button>
              </div>
            <?php } ?>
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
              <?php foreach ($tasks as $task) {
                if ($task['status'] == 'backlog') { ?>
                  <div class="card mb-3 kanban-item" draggable="true" id="task<?php echo $task['id']; ?>" data-task-id="<?php echo $task['id']; ?>">
                    <div class="card-body">
                      <p class="card-text"><?php echo nl2br(htmlspecialchars($task['description'], ENT_QUOTES, 'UTF-8')); ?></p>
                      <?php if (!empty($task['img'])) { ?>
                        <img src="/uploads/<?php echo htmlspecialchars($task['img'], ENT_QUOTES, 'UTF-8'); ?>" alt="Task Image" class="img-fluid rounded mb-3">
                      <?php } ?>
                      <button type="button" class="btn btn-sm btn-link toggle-comments" data-task-id="<?php echo $task['id']; ?>">
                        <i class="fas fa-pencil-alt"></i> Comments
                      </button>
                    </div>
                    <div class="card-footer bg-transparent border-top-0">
                      <small class="text-muted">Assigned to:
                        <?php foreach ($users as $user) {
                          if ($user['id'] == $task['user_id']) {
                            echo htmlspecialchars($user['name'], ENT_QUOTES, 'UTF-8');
                            break;
                          }
                        } ?>
                      </small>
                    </div>

                    <!-- Comments Section (Initially Hidden) -->
                    <div class="card-footer comments-section" id="comments<?php echo $task['id']; ?>" style="display: none;">
                      <h5>Comments</h5>
                      <?php
                      foreach ($comments as $comment) {
                        if ($comment['task_id'] == $task['id']) {
                          $commentUser = '';
                          foreach ($users as $user) {
                            if ($user['id'] == $comment['user_id']) {
                              $commentUser = htmlspecialchars($user['name'], ENT_QUOTES, 'UTF-8');
                              break;
                            }
                          }
                          ?>
                          <div class="comment mb-2">
                            <strong><?php echo $commentUser; ?>:</strong>
                            <p><?php echo nl2br(htmlspecialchars($comment['comment'], ENT_QUOTES, 'UTF-8')); ?></p>
                            <small class="text-muted"><?php echo htmlspecialchars($comment['created_at'], ENT_QUOTES, 'UTF-8'); ?></small>
                          </div>
                          <?php
                        }
                      }
                      ?>
                      <!-- Add Comment Form -->
                      <form action="/createComment" method="POST">
                        <input type="hidden" name="task_id" value="<?php echo $task['id']; ?>">
                        <input type="hidden" name="user_id" value="<?php echo $_SESSION['user'][0]['id']; ?>">
                        <div class="form-group">
                          <textarea class="form-control" name="comment" rows="2" placeholder="Add a comment..." id="commentInput<?php echo $task['id']; ?>"></textarea>
                        </div>
                        <button type="submit" class="btn btn-sm btn-primary">Post Comment</button>
                      </form>
                    </div>
                  </div>
                <?php }
              } ?>
            </div>
          </div>

          <!-- To Do column -->
          <div class="card card-row card-primary" id="todo">
            <div class="card-header">
              <h3 class="card-title">To Do</h3>
            </div>
            <div class="card-body">
              <?php foreach ($tasks as $task) {
                if ($task['status'] == 'todo') { ?>
                  <div class="card mb-3 kanban-item" draggable="true" id="task<?php echo $task['id']; ?>" data-task-id="<?php echo $task['id']; ?>">
                    <div class="card-body">
                      <p class="card-text"><?php echo nl2br(htmlspecialchars($task['description'], ENT_QUOTES, 'UTF-8')); ?></p>
                      <?php if (!empty($task['img'])) { ?>
                        <img src="/uploads/<?php echo htmlspecialchars($task['img'], ENT_QUOTES, 'UTF-8'); ?>" alt="Task Image" class="img-fluid rounded mb-3">
                      <?php } ?>
                      <button type="button" class="btn btn-sm btn-link toggle-comments" data-task-id="<?php echo $task['id']; ?>">
                        <i class="fas fa-pencil-alt"></i> Comments
                      </button>
                    </div>
                    <div class="card-footer bg-transparent border-top-0">
                      <small class="text-muted">Assigned to:
                        <?php foreach ($users as $user) {
                          if ($user['id'] == $task['user_id']) {
                            echo htmlspecialchars($user['name'], ENT_QUOTES, 'UTF-8');
                            echo '<br>' . $task['created_at'];
                            break;
                          }
                        } ?>
                      </small>
                    </div>

                    <!-- Comments Section (Initially Hidden) -->
                    <div class="card-footer comments-section" id="comments<?php echo $task['id']; ?>" style="display: none;">
                      <h5>Comments</h5>
                      <?php
                      foreach ($comments as $comment) {
                        if ($comment['task_id'] == $task['id']) {
                          $commentUser = '';
                          foreach ($users as $user) {
                            if ($user['id'] == $comment['user_id']) {
                              $commentUser = htmlspecialchars($user['name'], ENT_QUOTES, 'UTF-8');
                              break;
                            }
                          } 
                          ?>
                          <div class="comment mb-2">
                            <strong><?php echo $commentUser; ?>:</strong>
                            <p><?php echo nl2br(htmlspecialchars($comment['comment'], ENT_QUOTES, 'UTF-8')); ?></p>
                            <small class="text-muted"><?php echo htmlspecialchars($comment['created_at'], ENT_QUOTES, 'UTF-8'); ?></small>
                          </div>
                          <?php
                        }
                      }
                      ?>
                      <!-- Add Comment Form -->
                      <form action="/createComment" method="POST">
                        <input type="hidden" name="task_id" value="<?php echo $task['id']; ?>">
                        <input type="hidden" name="user_id" value="<?php echo $_SESSION['user'][0]['id']; ?>">
                        <div class="form-group">
                          <textarea class="form-control" name="comment" rows="2" placeholder="Add a comment..." id="commentInput<?php echo $task['id']; ?>"></textarea>
                        </div>
                        <button type="submit" class="btn btn-sm btn-primary">Post Comment</button>
                      </form>
                    </div>
                  </div>
                <?php }
              } ?>
            </div>
          </div>

          <!-- In Progress column -->
          <div class="card card-row card-default" id="in_progress">
            <div class="card-header bg-info">
              <h3 class="card-title">In Progress</h3>
            </div>
            <div class="card-body">
              <?php foreach ($tasks as $task) {
                if ($task['status'] == 'in_progress') { ?>
                  <div class="card mb-3 kanban-item" draggable="true" id="task<?php echo $task['id']; ?>" data-task-id="<?php echo $task['id']; ?>">
                    <div class="card-body">
                      <p class="card-text"><?php echo nl2br(htmlspecialchars($task['description'], ENT_QUOTES, 'UTF-8')); ?></p>
                      <?php if (!empty($task['img'])) { ?>
                        <img src="/uploads/<?php echo htmlspecialchars($task['img'], ENT_QUOTES, 'UTF-8'); ?>" alt="Task Image" class="img-fluid rounded mb-3">
                      <?php } ?>
                      <button type="button" class="btn btn-sm btn-link toggle-comments" data-task-id="<?php echo $task['id']; ?>">
                        <i class="fas fa-pencil-alt"></i> Comments
                      </button>
                    </div>
                    <div class="card-footer bg-transparent border-top-0">
                      <small class="text-muted">Assigned to:
                        <?php foreach ($users as $user) {
                          if ($user['id'] == $task['user_id']) {
                            echo htmlspecialchars($user['name'], ENT_QUOTES, 'UTF-8');
                            echo '<br>Created at: ' . $task['created_at'];
                            break;
                          }
                        } ?>
                      </small>
                    </div>

                    <!-- Comments Section (Initially Hidden) -->
                    <div class="card-footer comments-section" id="comments<?php echo $task['id']; ?>" style="display: none;">
                      <h5>Comments</h5>
                      <?php
                      foreach ($comments as $comment) {
                        if ($comment['task_id'] == $task['id']) {
                          $commentUser = '';
                          foreach ($users as $user) {
                            if ($user['id'] == $comment['user_id']) {
                              $commentUser = htmlspecialchars($user['name'], ENT_QUOTES, 'UTF-8');
                              break;
                            }
                          }
                          ?>
                          <div class="comment mb-2">
                            <strong><?php echo $commentUser; ?>:</strong>
                            <p><?php echo nl2br(htmlspecialchars($comment['comment'], ENT_QUOTES, 'UTF-8')); ?></p>
                            <small class="text-muted"><?php echo htmlspecialchars($comment['created_at'], ENT_QUOTES, 'UTF-8'); ?></small>
                          </div>
                          <?php
                        }
                      }
                      ?>
                      <!-- Add Comment Form -->
                      <form action="/createComment" method="POST">
                        <!-- hiddent input for task and user id -->
                        <input type="hidden" name="task_id" value="<?php echo $task['id']; ?>">
                        <input type="hidden" name="user_id" value="<?php echo $_SESSION['user'][0]['id']; ?>">
                        <div class="form-group">
                          <textarea class="form-control" name="comment" rows="2" placeholder="Add a comment..." id="commentInput<?php echo $task['id']; ?>"></textarea>
                        </div>
                        <button type="submit" class="btn btn-sm btn-primary">Post Comment</button>
                      </form>
                    </div>
                  </div>
                <?php }
              } ?>
            </div>
          </div>

          <!-- Done column -->
          <div class="card card-row card-success" id="done">
            <div class="card-header">
              <h3 class="card-title">Done</h3>
            </div>
            <div class="card-body">
              <?php foreach ($tasks as $task) {
                if ($task['status'] == 'done') { ?>
                  <div class="card mb-3 kanban-item" draggable="true" id="task<?php echo $task['id']; ?>" data-task-id="<?php echo $task['id']; ?>">
                    <div class="card-body">
                      <p class="card-text"><?php echo nl2br(htmlspecialchars($task['description'], ENT_QUOTES, 'UTF-8')); ?></p>
                      <?php if (!empty($task['img'])) { ?>
                        <img src="/uploads/<?php echo htmlspecialchars($task['img'], ENT_QUOTES, 'UTF-8'); ?>" alt="Task Image" class="img-fluid rounded mb-3">
                      <?php } ?>
                      <button type="button" class="btn btn-sm btn-link toggle-comments" data-task-id="<?php echo $task['id']; ?>">
                        <i class="fas fa-pencil-alt"></i> Comments
                      </button>
                    </div>
                    <div class="card-footer bg-transparent border-top-0">
                      <small class="text-muted">Assigned to:
                        <?php foreach ($users as $user) {
                          if ($user['id'] == $task['user_id']) {
                            echo htmlspecialchars($user['name'], ENT_QUOTES, 'UTF-8');
                            echo '<br>Created at: ' . $task['created_at'];
                            break;
                          }
                        } ?>
                      </small>
                    </div>

                    <!-- Comments Section (Initially Hidden) -->
                    <div class="card-footer comments-section" id="comments<?php echo $task['id']; ?>" style="display: none;">
                      <h5>Comments</h5>
                      <?php
                      foreach ($comments as $comment) {
                        if ($comment['task_id'] == $task['id']) {
                          $commentUser = '';
                          foreach ($users as $user) {
                            if ($user['id'] == $comment['user_id']) {
                              $commentUser = htmlspecialchars($user['name'], ENT_QUOTES, 'UTF-8');
                              break;
                            }
                          }
                          ?>
                          <div class="comment mb-2">
                            <strong><?php echo $commentUser; ?>:</strong>
                            <p><?php echo nl2br(htmlspecialchars($comment['comment'], ENT_QUOTES, 'UTF-8')); ?></p>
                            <small class="text-muted"><?php echo htmlspecialchars($comment['created_at'], ENT_QUOTES, 'UTF-8'); ?></small>
                          </div>
                          <?php
                        }
                      }
                      ?>
                      <!-- Add Comment Form -->
                      <form action="/createComment" method="POST">
                      <input type="hidden" name="task_id" value="<?php echo $task['id']; ?>">
                      <input type="hidden" name="user_id" value="<?php echo $_SESSION['user'][0]['id']; ?>">
                        <div class="form-group">
                          <textarea class="form-control" name="comment" rows="2" placeholder="Add a comment..." id="commentInput<?php echo $task['id']; ?>"></textarea>
                        </div>
                        <button type="submit" class="btn btn-sm btn-primary">Post Comment</button>
                      </form>
                    </div>
                  </div>
                <?php }
              } ?>
            </div>
          </div>

          <!-- Create Task Modal -->
          <?php if ($_SESSION['user'] && $_SESSION['user'][0]['role'] == 'admin') { ?>
            <div class="modal fade" id="createTaskModal" tabindex="-1" role="dialog" aria-labelledby="createTaskModalLabel">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="createTaskModalLabel">Create New Task</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <form action="/storeTask" method="POST" enctype='multipart/form-data'>
                    <div class="modal-body">
                      <div class="form-group">
                        <label for="taskTitle">Title</label>
                        <input type="text" class="form-control" id="taskTitle" name="title" required>
                      </div>
                      <div class="form-group">
                        <label for="taskDescription">Description</label>
                        <textarea class="form-control" id="taskDescription" name="description" rows="3" required></textarea>
                      </div>
                      <div class="form-group">
                        <label for="taskAssignee">Assignee</label>
                        <select class="form-control" id="taskAssignee" name="user_id" required>
                          <?php foreach ($users as $user) {
                            if ($user['role'] == 'user') { ?>
                              <option value="<?php echo $user['id']; ?>"><?php echo $user['name']; ?></option>
                            <?php }
                          } ?>
                        </select>
                      </div>
                      <div class="mb-3">
                        <label for="formFile" class="form-label">Image (optional)</label>
                        <input class="form-control" type="file" id="formFile" name="img">
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-primary">Save Task</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          <?php } ?>
          <aside class="control-sidebar control-sidebar-dark"></aside>
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

        <script>
          $(document).ready(function () {
            $('.toggle-comments').on('click', function () {
              var taskId = $(this).data('task-id');
              $('#comments' + taskId).slideToggle();
            });
          });

          function addComment(taskId) {
            var commentInput = document.getElementById('commentInput' + taskId);
            var commentText = commentInput.value.trim();

            if (commentText === '') {
              alert('Please enter a comment.');
              return;
            }

            var commentDiv = document.createElement('div');
            commentDiv.className = 'comment mb-2';

            var commentAuthor = document.createElement('strong');
            commentAuthor.textContent = 'You:';
            commentDiv.appendChild(commentAuthor);

            var commentContent = document.createElement('p');
            commentContent.textContent = commentText;
            commentDiv.appendChild(commentContent);

            var commentTime = document.createElement('small');
            commentTime.className = 'text-muted';
            var now = new Date();
            commentTime.textContent = now.toLocaleString();
            commentDiv.appendChild(commentTime);

            var commentsSection = document.getElementById('comments' + taskId);
            commentsSection.insertBefore(commentDiv, commentsSection.querySelector('form'));

            commentInput.value = '';
          }
        </script>

        <script>
          $(function () {
            $(document).on("dragstart", ".kanban-item", function (event) {
              event.originalEvent.dataTransfer.setData("text/plain", event.target.id);
            });

            $(".card-body").on("dragover", function (event) {
              event.preventDefault();
            });

            $(".card-body").on("drop", function (event) {
              event.preventDefault();
              var id = event.originalEvent.dataTransfer.getData("text");
              var draggableElement = document.getElementById(id);
              $(this).append(draggableElement);
              var newStatus = $(this).parent().attr('id');

              var taskId = id.replace('task', '');

              console.log('Task ID: ' + taskId);

              $.ajax({
                url: '/updateTaskStatus',
                type: 'POST',
                data: {
                  task_id: taskId,
                  status: newStatus
                },
                success: function (response) {
                  console.log(response);
                },
                error: function (xhr, status, error) {
                  alert('An error occurred while updating the task status: ' + error);
                }
              });
            });
          });
        </script>
</body>
</html>
