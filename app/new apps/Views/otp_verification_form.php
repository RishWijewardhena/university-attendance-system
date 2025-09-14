<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css'); ?>"> <!-- Link to your custom CSS -->
</head>
<body>
    <div class="container">
        <h2>OTP Verification</h2>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger">
                <?= session()->getFlashdata('error'); ?>
            </div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success">
                <?= session()->getFlashdata('success'); ?>
            </div>
        <?php endif; ?>
        
        <form action="<?= base_url('auth/validate_otp') ?>" method="post">
            <div class="form-group">
                <label for="otp">Enter OTP</label>
                <input type="number" id="otp" name="otp" class="form-control" placeholder="Enter the OTP sent to your email" required>
            </div>
            <button type="submit" class="btn btn-primary">Verify OTP</button>
        </form>
        
        <div class="resend-otp">
            <p>Didn't receive the OTP? <a href="<?= base_url('auth/forgot_password') ?>">Resend OTP</a></p>
        </div>
    </div>
</body>
</html>
