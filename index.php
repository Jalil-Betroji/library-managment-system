<?php
require 'connect.php';
?>

<!DOCTYPE html>
<!-- Coding by CodingLab || www.codinglabweb.com -->
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!--<title>Login & Signup Form</title>-->
    <link rel="stylesheet" href="css/authenfication.css" />

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
        crossorigin="anonymous"></script>

</head>

<body>
    <section class="wrapper">

        <div class="form signup">
            <header>Signup</header>
            <form action="code.php" method="POST">
                <div class="d-flex flex-wrap">
                    <div>
                        <input type="text" class="mt-4 mb-3" name="signup_FN" placeholder="First name" required />
                        <input type="text" class="mb-3" name="signup_LN" placeholder="Last name" required />
                        <input type="email" class="mb-3" name="signup_Email" placeholder="Email address" required />
                        <input type="number" class="mb-3" name="signup_Phone" placeholder="Phone number" required />
                    </div>
                    <div>
                        <input type="text" class="mb-3" name="CIN" placeholder="CIN" required />
                        <input type="text" class="mb-3" name="signup_Address" placeholder="Address" required />
                        <input type="date" class="mb-3" name="birth_Date" placeholder="Birth date" style="width:47.8%;"
                            required />
                        <select name="account_Type" id="" class="mb-3">
                            <option value="select account type" selected> - select account type-</option>
                            <option value="Student">Student</option>
                            <option value="Civil Servant">Civil Servant</option>
                            <option value="Employee">Employee</option>
                            <option value="HouseWife">HouseWife</option>
                        </select>
                        <input type="password" class="mb-1" name="signup_Password" placeholder="Password" required />
                        <input type="password" class="mb-1" name="signup_Re_Password" placeholder="Re-Password"
                            required />
                    </div>
                </div>
                <div class="checkbox">
                    <input type="checkbox" id="signupCheck" />
                    <label for="signupCheck">I accept all terms & conditions</label>
                </div>
                <input type="submit" name="signup" class="container" value="Signup" />
            </form>
        </div>

        <div class="form login">
            <header>Login</header>
            <form action="logincode.php" method="POST" class="d-flex flex-column gap-3 container">
                <input type="text" class="mt-4" name="signin_Email" placeholder="Email address" required />
                <input type="password" name="signin_Password" placeholder="Password" required />
                <a href="#">Forgot password?</a>
                <input type="submit" name="login" value="Login" />
            </form>
        </div>

    </section>
    <script>
        const wrapper = document.querySelector(".wrapper");
        const signupHeader = document.querySelector(".signup header");
        const loginHeader = document.querySelector(".login header");

        loginHeader.addEventListener("click", () => {
            wrapper.classList.add("active");

        });
        signupHeader.addEventListener("click", () => {
            wrapper.classList.remove("active");

        });
    </script>
</body>

</html>