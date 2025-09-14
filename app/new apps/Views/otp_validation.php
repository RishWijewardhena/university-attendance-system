<form action="<?= base_url('/auth/validate-otp') ?>" method="post">
    <?= csrf_field() ?>
    <label for="otp">Enter OTP:</label>
    <input type="text" name="otp" id="otp" required>
    <button type="submit">Validate OTP</button>
</form>
