<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f4;
        }
        .reset-container {
            background: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 350px;
            text-align: center;
            box-sizing: border-box;
        }
        h2 {
            margin-bottom: 15px;
            font-size: 24px;
            color: #333;
        }
        label {
            display: block;
            text-align: left;
            margin: 10px 0 5px;
            font-weight: bold;
        }
        input {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
            margin-bottom: 20px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
        input:focus {
            border-color: #007BFF;
            outline: none;
        }
        button {
            background: #007BFF;
            color: white;
            border: none;
            padding: 12px 0;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            margin-top: 15px;
            font-size: 16px;
        }
        button:hover {
            background: #0056b3;
        }
        .error {
            color: red;
        }
        .success {
            color: green;
        }
    </style>
</head>
<body>
    <div class="reset-container">
        <h2>Reset Your Password</h2>
        <?php if (session()->getFlashdata('success')): ?>
            <p class="success"><?= session()->getFlashdata('success') ?></p>
        <?php elseif (session()->getFlashdata('error')): ?>
            <p class="error"><?= session()->getFlashdata('error') ?></p>
        <?php endif; ?>
        
        <form action="/auth/process_reset_password" method="post">
            <?= csrf_field() ?>
            <label for="password">New Password:</label>
            <input type="password" name="password" id="password" required placeholder="Enter new password">
            
            <label for="confirm_password">Confirm Password:</label>
            <input type="password" name="confirm_password" id="confirm_password" required placeholder="Confirm new password">
            
            <button type="submit">Reset Password</button>
        </form>
    </div>
</body>
</html>
