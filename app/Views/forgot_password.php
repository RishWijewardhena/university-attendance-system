<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
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
        .forgot-container {
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
        p {
            color: green;
        }
    </style>
</head>
<body>
    <div class="forgot-container">
        <h2>Reset Your Password</h2>
        <?php if (session()->getFlashdata('success')): ?>
            <p><?= session()->getFlashdata('success') ?></p>
        <?php elseif (session()->getFlashdata('error')): ?>
            <p style="color: red;"><?= session()->getFlashdata('error') ?></p>
        <?php endif; ?>

        <?php if (!session()->get('otp_verified')): ?>
            <?php if (!session()->get('otp_sent')): ?>
                <!-- Step 1: Enter Email -->
                <form action="<?= base_url('/auth/process_forgot_password') ?>" method="post">
                    <?= csrf_field() ?>
                    <label for="email">Enter your email:</label>
                    <input type="email" name="email" id="email" placeholder="Your email address" required>
                    <button type="submit">Send OTP</button>
                </form>
            <?php else: ?>
                <!-- Step 2: Enter OTP -->
                <form action="<?= base_url('/auth/validate_otp') ?>" method="post">
                    <?= csrf_field() ?>
                    <label for="otp">Enter the OTP sent to your email:</label>
                    <input type="text" name="otp" id="otp" placeholder="Enter OTP" required>
                    <button type="submit">Verify OTP</button>
                </form>
            <?php endif; ?>
        <?php else: ?>
            <!-- Step 3: Reset Password -->
            <form action="<?= base_url('/auth/updatePassword') ?>" method="post">
                <?= csrf_field() ?>
                <label for="password">New Password:</label>
                <input type="password" name="password" id="password" placeholder="Enter new password" required>
                <label for="confirm_password">Confirm New Password:</label>
                <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm new password" required>
                <button type="submit">Reset Password</button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>
