<?php
session_start();
include 'connect.php';

$errors = [];

if (isset($_GET['logout'])) {
    if(isset($_COOKIE['loggedin'])){
        setcookie('loggedin', '', time() - 3600);
    }
    if(isset($_SESSION['loggedin'])){
        session_destroy();
    }
    header('Location: login.php');
    die();
}


if (isset($_SESSION['loggedin']) || isset($_COOKIE['loggedin'])) {
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
    </head>

    <body>
        <p>You are already logged in</p>
        <form action="" method="get">
            <button name="logout">Logout</button>
        </form>

    </body>

    </html>
<?php
    die();
}

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    if (empty($username)) {
        $errors[] = 'Username is required';
    }
    if (empty($password)) {
        $errors[] = 'Password is required';
    }
    $password = sha1($password);

    if (count($errors) === 0) {
        try {
            $sql = "SELECT * FROM abc12users WHERE username = '$username' AND password_hash = '$password'";
            $res = $conn->query($sql);
            if ($res->num_rows > 0) {
                if(isset($_POST['remember'])){
                    setcookie('loggedin', true, time() + 3600);
                }else{
                    $_SESSION['loggedin'] = true;
                }
                header('Location: login.php');
                echo 'Login successfully Hello ' . $username;
                die();
            } else {
                $errors[] = 'Username or password is incorrect';
            }
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <p>Login form</p>
    <form method="post">
        <div>
            <label>Username: </label>
            <input type="text" name="username" placeholder="Username">
        </div>
        <div>
            <label>Password: </label>
            <input type="password" name="password" placeholder="Password">
        </div>
        <div>
            <input value="remember" type="checkbox" name="remember">
            <label>Remember me !</label>
        </div>
        <input type="submit" name="login" value="Login">
        <?php
        if (count($errors) > 0) {
            echo '<ul>';
            foreach ($errors as $error) {
                echo '<li>' . $error . '</li>';
            }
            echo '</ul>';
        }
        ?>
    </form>
</body>

</html>