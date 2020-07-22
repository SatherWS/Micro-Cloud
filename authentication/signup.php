<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="todo-bg">
        <div class="form-container">
            <h1>Temp Sign Up Form</h1>
            <form action="../controllers/auth_user.php" method="post">
                <input type="email" name="email" placeholder="Enter valid email address" required>
                <br><br>
                <input type="text" name="usr" placeholder="Enter a username" required>
                <br><br>
                <input type="password" name="pswd" id="" placeholder="Enter a password" required>
                <br><br>
                <input type="text" placeholder="Search team" name="team" required>
                <br><br>
                <input type="submit" value="Sign Up" name="add_user">        
            </form>
        </div>
    </div>

    <!-- new form 
    <div class="todo-bg">
        <form action="../controllers/auth_user.php" method="post" class="spc-pt">
            <div class="form-container">
                <div class="todo-panel">
                    <h1>Login Here</h1>
                    <p>Welcome back, if you wish to return to the home page <a href="../index.html">click here.</a></p>
                    <div class="flex-subs">
                        <label>Email:</label><br>
                        <input type="text" name="email" placeholder="Enter your Email address" class="spc-n login-comp" required>
                        <br><br>
                        <label>Password:</label><br>
                        <input type="password" name="pswd" placeholder="Enter your password" class="spc-n login-comp" required>
                    </div>
                    <br>
                    <p>Don't have an account? <a href="./signup.html">Sign up here.</a></p>
                    <input name="auth_user" class="spc-n spc-m" type="submit" id="form-control2">
                </div>
            </div>
        </form>
    </div>   
    -->
</body>
</html>