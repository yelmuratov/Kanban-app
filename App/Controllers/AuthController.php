<?php
    namespace App\Controllers;
    use App\Models\User\User;
    use App\Helper\Helper;

    class AuthController extends Helper {
    public function login() {
        $this->render('Login/index');
    }

    public function login_user() {
        if(isset($_POST['username']) && isset($_POST['password'])) {
            $username = htmlspecialchars($_POST['username']);
            $password = htmlspecialchars($_POST['password']);

            $user = User::where('username', $username);

            if($user) {
                if(password_verify($password, $user[0]['password'])) {
                    $_SESSION['user'] = $user;
                    header('Location: /');
                }else{
                    $_SESSION['login_error'] = 'Invalid username or password';
                    ?>
                    <script>
                        alert('Invalid username or password');
                        window.location.href = history.back();
                    </script>
                    <?php
                    header('Location: /login');
                }
            }else{
                $_SESSION['login_error'] = 'Invalid username or password';
                ?>
                <script>
                    alert('Invalid username or password');
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
        if(isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password'])) {
            $name = htmlspecialchars($_POST['username']);
            $email = htmlspecialchars($_POST['email']);
            $password = password_hash(htmlspecialchars($_POST['password']), PASSWORD_DEFAULT);

            User::create([
                'username' => $name,
                'email' => $email,
                'password' => $password
            ]);

            $_SESSION['register_success'] = 'User registered successfully';
            header('Location: /login');
        }else{
            $_SESSION['register_error'] = 'Please fill all the fields';
            ?>
            <script>
                alert('Please fill all the fields');
                window.location.href = history.back();
            </script>
            <?php
            header('Location: /register');
        }
    }

    public function logout() {
        session_destroy();
        header('Location: /login');
    }
    }

?>