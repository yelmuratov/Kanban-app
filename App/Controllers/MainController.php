<?php
namespace App\Controllers;

use App\Models\Author\Author;
use App\Models\Book\Book;
use App\Models\Genre\Genre;
use App\Helper\Helper;
use App\Models\Task\Task;

class MainController extends Helper {
    public function index() {
        $this->render('index'); 
    }

    public function kanban() {
        $this->render('Kanban/index');
    }

    //kanban task create
    public function createTask() {
        $this->render('Kanban/create');
    }

    public function storeTask() {
        if (isset($_POST['title']) && isset($_POST['description']) && isset($_POST['status']) && isset($_POST['user_id'])) {
            $imgName = '';
    
            if (isset($_FILES['img']) && isset($_FILES['img']['name']) && $_FILES['img']['name'] != '') {
                $target_dir = "uploads/";
                $target_file = $target_dir . basename($_FILES["img"]["name"]);
                $imgFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                $extensions_arr = array("jpg", "jpeg", "png", "gif");
    
                if (in_array($imgFileType, $extensions_arr)) {
                    if (move_uploaded_file($_FILES['img']['tmp_name'], $target_dir . $_FILES['img']['name'])) {
                        $imgName = $_FILES['img']['name'];
                    }
                }
            }
    
            $data = [
                'title' => $_POST['title'],
                'description' => $_POST['description'],
                'status' => $_POST['status'],
                'user_id' => $_POST['user_id'],
                'img' => $imgName 
            ];
    
            // Create task using the Task model
            $task = Task::create($data);

            if ($task) {
                $_SESSION['task_success'] = 'Task created successfully';
                header('Location: /kanban');
            } else {
                $_SESSION['task_error'] = 'Task creation failed';
                ?>
                <script>
                    alert('Task creation failed');
                    window.location.href=history.back();
                </script>
                <?php
            }
        } else {
            $_SESSION['task_error'] = 'Please fill all the fields';
            ?>
            <script>
                alert('Please fill all the fields');
                window.location.href=history.back();
            </script>
            <?php
        }
    }

    public function updateTaskStatus() {
        // Check if CSRF token is valid
        if (!isset($_POST['_csrf_token']) || !Helper::validateCsrfToken($_POST['_csrf_token'])) {
            http_response_code(403);
            echo json_encode(['error' => 'Invalid CSRF token']);
            exit;
        }
    
        // Validate the required parameters
        if (isset($_POST['task_id']) && isset($_POST['status'])) {
            $taskId = intval($_POST['task_id']);
            $newStatus = $_POST['status'];
    
            // Validate status
            $validStatuses = ['backlog', 'todo', 'in_progress', 'done'];
            if (!in_array($newStatus, $validStatuses)) {
                http_response_code(400);
                echo json_encode(['error' => 'Invalid status']);
                exit;
            }
    
            // Start a transaction for safety
            DB::beginTransaction();
            
            try {
                // Find the task and update its status
                $task = Task::find($taskId);
                if ($task) {
                    $task->status = $newStatus;
                    $task->save();
    
                    // Commit the transaction
                    DB::commit();
                    
                    echo json_encode(['success' => true]);
                } else {
                    // Rollback if task is not found
                    DB::rollBack();
                    http_response_code(404);
                    echo json_encode(['error' => 'Task not found']);
                }
            } catch (Exception $e) {
                // Rollback on error
                DB::rollBack();
                http_response_code(500);
                echo json_encode(['error' => 'An error occurred while updating the task status.']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid request']);
        }
    }
    
    
    
}

?>