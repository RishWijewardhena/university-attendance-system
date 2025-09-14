<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complete Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            width: 100%;
            max-width: 400px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
        }
        .container h1 {
            font-size: 24px;
            color: #333;
            margin-bottom: 10px;
        }
        .container p {
            font-size: 14px;
            color: #555;
            margin-bottom: 20px;
        }
        .container form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        .container label {
            font-size: 14px;
            color: #333;
            text-align: left;
        }
        .container select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .container button {
            padding: 10px;
            font-size: 16px;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .container button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Complete Your Profile</h1>
        <p>Welcome, <?= session('google_name'); ?>! Please select your role to proceed.</p>

        <form action="<?= base_url('googlelogin/saveProfile') ?>" method="post">
        <?= csrf_field() ?>
        <label for="role_id">Your Role:</label>
        <select name="role_id" id="role_id" required readonly>
            <option value="student" selected>Student</option>
        </select>
        <button type="submit">Save Profile</button>
        </form>

    </div>
    <script>
        document.getElementById('role_id').addEventListener('change', function() {
            console.log(this.value); // Log the selected role_id
        });
    </script>
</body>
</html>
