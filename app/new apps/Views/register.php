<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #4f46e5; /* indigo-600 */
            --secondary-color: #f8f9fa;
            --text-dark: #333;
            --input-border: #ced4da;
            --info-bg: #eef2ff; /* Light Indigo */
            --info-border: #6366f1; /* Slightly darker Indigo */
        }

        body {
            background-color: var(--secondary-color);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .form-container {
            max-width: 450px;
            margin: auto;
            padding: 40px;
            background: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            margin-top: 50px;
        }

        .form-container h2 {
            text-align: center;
            margin-bottom: 15px;
            font-weight: bold;
            color: var(--primary-color);
        }

        .info-box {
            background-color: var(--info-bg);
            border-left: 4px solid var(--info-border);
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 20px;
            text-align: center;
            font-size: 14px;
        }

        .info-box strong {
            color: var(--info-border);
        }

        .input-group-text {
            background-color: var(--secondary-color);
            border: 1px solid var(--input-border);
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background-color: #4338ca; /* Darker indigo */
            border-color: #4338ca;
        }

        .btn-outline-secondary {
            border-color: var(--input-border);
        }
    </style>
</head>
<body>

<div class="container">
    <div class="form-container">
        <div class="icon-container text-center">
            <i class="fas fa-user-plus fa-3x text-indigo-600"></i>
        </div>
        <h2>Create Your Account</h2>

        <!-- INFO BOX (STYLED) -->
        <div class="info-box">
            <strong>Note:</strong> You are registering as a <strong>Student</strong> by default.  
            If you need a different role, please contact the site administrator after signing up.
        </div>

        <?php if (session()->getFlashdata('errors')): ?>
            <div class="alert alert-danger">
                <strong>There were errors with your submission:</strong>
                <ul>
                    <?php foreach (session()->getFlashdata('errors') as $error): ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('/register') ?>" method="post">
            <div class="mb-3">
                <label for="name" class="form-label">Full Name</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                    <input type="text" name="name" id="name" class="form-control" required value="<?= old('name') ?>" placeholder="Enter your full name">
                </div>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                    <input type="email" name="email" id="email" class="form-control" required value="<?= old('email') ?>" placeholder="Enter your email">
                </div>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    <input type="password" name="password" id="password" class="form-control" required placeholder="Create a strong password">
                    <button type="button" id="togglePassword" class="btn btn-outline-secondary">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100">
                <i class="fas fa-user-plus"></i> Create Account
            </button>
        </form>

        <div class="text-center mt-3">
            <small>Already have an account? <a href="/login" class="text-indigo-600">Sign in</a></small>
        </div>
    </div>
</div>

<script>
document.getElementById('togglePassword').addEventListener('click', function() {
    const passwordInput = document.getElementById('password');
    const icon = this.querySelector('i');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        passwordInput.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
});
</script>

</body>
</html>
