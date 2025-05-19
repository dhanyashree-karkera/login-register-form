<?php include 'connection.php'; ?>
<?php include 'header.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-lg">
                    <div class="card-header bg-dark text-white text-center">
                        <h4>Registration Form</h4>
                    </div>
                    <div class="card-body">
                        <form id="registrationForm" action="" method="POST">
                            <div class="mb-3">
                                <label for="first_name" class="form-label">First Name</label>
                                <input type="text" class="form-control" id="first_name" name="first_name" required>
                            </div>
                            <div class="mb-3">
                                <label for="last_name" class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="last_name" name="last_name" required>
                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" class="form-control" id="address" name="address" required>
                            </div>
                            <div class="mb-3">
                                <label for="phone_no" class="form-label">Phone Number</label>
                                <input type="number" class="form-control" id="phone_no" name="phone_no" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="user_type" class="form-label">User Type</label>
                                <select class="form-select" id="user_type" name="user_type" required>
                                    <option value="admin">Admin</option>
                                    <option value="user">User</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="password" name="password" required>
                                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                        <i class="bi bi-eye-slash"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="confirm-password" class="form-label">Confirm Password</label>
                                <div class="input-group">
                                <input type="password" class="form-control" id="confirm-password" name="confirm-password" required>
                                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                        <i class="bi bi-eye-slash"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-dark">Register</button>
                            </div>
                            <div class="text-center mt-3">
                                <p>Already registered? <a href="login.php" class="text-dark fw-bold">Login here</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script>
$('#registrationForm').submit(function (event) {
    event.preventDefault();

    const formData = new FormData(this);

    const data = {
        first_name: formData.get('first_name'),
        last_name: formData.get('last_name'),
        address: formData.get('address'),
        phone_no: formData.get('phone_no'),
        email: formData.get('email'),
        user_type: formData.get('user_type'),
        password: formData.get('password'),
        confirm_password: formData.get('confirm-password')
    };
   
    var passwordValidation = /^(?=.*[A-Z])(?=.*\d)(?=.*[#@$%^&])[a-zA-Z\d#@$%^&]{8,}$/;

    if(data.phone_no.length != 10){
        alert('Invalid Phone Number');
        return;
    } else if (data.password !== data.confirm_password) {
        alert('Passwords do not match!');
        return;
    } else if(!passwordValidation.test(data.password)){
        alert('Please must be at least 8 characters');
        return;
    }


    $.ajax({
        type: 'POST',
        url: 'save-register.php',
        contentType: 'application/json',
        data: JSON.stringify(data),
        success: function (response) {
            alert(response); 
            window.location.href="login.php";
        },
        error: function () {
            alert('An error occurred while submitting the form.');
        }
    });
});

document.getElementById('togglePassword').addEventListener('click', function () {
    const passwordInput = document.getElementById('password');
    const confirmPasswordInput = document.getElementById('confirm-password');
    const icon = this.querySelector('i');

    // Toggle input type
    const isPassword = passwordInput.type === 'password';
    passwordInput.type = isPassword ? 'text' : 'password';

    const isConfirmPassword = confirmPasswordInput.type === 'password';
    confirmPasswordInput.type = isConfirmPassword ? 'text' : 'password';

    // Toggle icon
    icon.classList.toggle('bi-eye');
    icon.classList.toggle('bi-eye-slash');
});

</script>
</body>

</html>