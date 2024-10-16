<?php
namespace App\Controllers;
use App\Helper\Helper;
use App\Models\Task\Task;
use App\Models\Comment\Comment;

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

    public function updateTaskStatus()
    {
        $taskId = $_POST['task_id'];
        $newStatus = $_POST['status'];
    
        if (!in_array($newStatus, ['backlog', 'todo', 'in_progress', 'done'])) {
            echo json_encode(['message' => 'Invalid status']);
            return;
        }
    
        $data = ['status' => $newStatus];
    
        $updateResult = Task::update($taskId, $data);
    
        if ($updateResult) {
            echo json_encode(['message' => 'Task status updated successfully.']);
        } else {
            echo json_encode(['message' => 'Failed to update task status.']);
        }
    }

    //create comment for task
    public function createComment() {
        // Get the data from POST
        $taskId = $_POST['task_id']; // Assuming task_id is being sent in the POST request
        $userId = $_POST['user_id']; // Assuming user_id is also being sent in the POST request (this could be from the session)
        $comment = $_POST['comment']; // The actual comment text
    
        // Make sure all necessary fields are available
        if (empty($taskId) || empty($userId) || empty($comment)) {
            return ['error' => 'All fields are required.'];
        }
    
        $data = [
            'task_id' => $taskId,
            'user_id' => $userId,
            'comment' => $comment,
        ];

        $commentResult = Comment::create($data);
        if ($commentResult) {
            echo json_encode(['message'=> 'Comment added successfully']);
        } else {
            echo json_encode(['message'=> 'Error adding comment']);
        }
    }
    
    


    
    
    
}

?>