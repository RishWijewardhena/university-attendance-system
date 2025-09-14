<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
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
        .otp-container {
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
        .error {
            color: red;
        }
    </style>
</head>
<body>
    <div class="otp-container">
        <h2>OTP Verification</h2>
        <?php if (session()->getFlashdata('success')): ?>
            <p><?= session()->getFlashdata('success') ?></p>
        <?php elseif (session()->getFlashdata('error')): ?>
            <p class="error"><?= session()->getFlashdata('error') ?></p>
        <?php endif; ?>

        <form action="<?= base_url('auth/validate_otp') ?>" method="post">
            <?= csrf_field() ?>
            <label for="otp">Enter the OTP sent to your email:</label>
            <input type="text" name="otp" id="otp" placeholder="Enter OTP" required>
            <button type="submit">Verify OTP</button>
        </form>

        <div class="resend-otp">
            <p> <span style="color: black;">Didn't receive the OTP?</span> <a href="<?= base_url('auth/forgot_password') ?>" style="color: red; text-decoration: underline;">Resend OTP</a></p>
        </div>
</div>

    </div>
</body>
</html>
