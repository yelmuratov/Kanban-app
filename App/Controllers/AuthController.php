<?php
    namespace App\Controllers;
    use App\Models\User\User;
    use App\Helper\Helper;

    class AuthController extends Helper {
    public function login() {
        $this->render('Login/index');
    }

    public function login_user() {
        if(isset($_POST['email']) && isset($_POST['password'])) {
            $email = htmlspecialchars($_POST['email']);
            $password = htmlspecialchars($_POST['password']);

            $user = User::where('email', $email);

            if($user) {
                if(password_verify($password, $user[0]['password'])) {
                    $_SESSION['user'] = $user;
                    header('Location: /');
                }else{
                    $_SESSION['login_error'] = 'Invalid email or password';
                    ?>
                    <script>
                        alert('Invalid email or password');
                        window.location.href = history.back();
                    </script>
                    <?php
                    header('Location: /login');
                }
            }else{
                $_SESSION['login_error'] = 'Invalid email or password';
                ?>
                <script>
                    alert('Invalid email or password');
                    window.location.href = history.back();
                </script>
                <?php
                header('Location: /login');
            }
        }else{
            $_SESSION['login_error'] = 'Please fill all the fields';
            ?>
            <script>
                alert('Please fill all the fields');
                window.location.href = history.back();
            </script>
            <?php
            header('Location: /login');
        }
    }

    public function register() {
        $this->render('Register/index');
    }

    public function register_user() {
        if (isset($_POST['name']) && isset($_POST['password']) && isset($_POST['email'])) {
            try {
                $name = htmlspecialchars($_POST['name']);
                $password = htmlspecialchars($_POST['password']);
                $email = htmlspecialchars($_POST['email']);
    
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
                // Data to be inserted
                $data = [
                    'name' => $name,
                    'password' => $hashedPassword,
                    'email' => $email
                ];
    
                // Try to create the user (which may throw a duplicate error)
                User::create($data);
    
                // Set a success message and redirect to login
                $_SESSION['register_success'] = 'You have successfully registered';
                header('Location: /login');
                exit();
                
            } catch (PDOException $e) {
                // Handle duplicate email error
                if ($e->getCode() == 23000) { // SQLSTATE[23000] is a constraint violation
                    // Duplicate entry error
                    $_SESSION['register_error'] = 'Email already exists';
                    header('Location: /register');
                    exit();
                } else {
                    $_SESSION['register_error'] = 'An error occurred during registration: ' . $e->getMessage();
                    header('Location: /register');
                    exit();
                }
            }
        } else {
            // If not all fields are filled, return an error
            $_SESSION['register_error'] = 'Please fill all the fields';
            header('Location: /register');
            exit();
        }
    }
    
    public function logout() {
        session_destroy();
        header('Location: /login');
    }
    }

?>