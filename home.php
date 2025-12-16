<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lemery Colleges - Homepage</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            height: 100vh;
            background: url('assets/images/lemery_colleges_bg.jpg') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            background: rgba(0, 0, 40, 0.65);
        }

        .container {
            position: relative;
            z-index: 2;
            text-align: center;
            color: #fff;
            padding: 30px;
        }

        .logo img {
            width: 120px;
            height: auto;
            border-radius: 50%;
            margin-bottom: 20px;
            border: 3px solid #f4c430; /* gold border */
        }

        h1 {
            font-size: 2.8em;
            color: #f4c430; /* gold text */
            text-shadow: 2px 2px 6px rgba(0, 0, 0, 0.8);
            margin-bottom: 10px;
        }

        h2 {
            font-size: 1.2em;
            color: #dbe8ff;
            margin-bottom: 40px;
            letter-spacing: 1px;
        }

        .btn {
            display: inline-block;
            padding: 15px 40px;
            margin: 10px;
            border-radius: 50px;
            text-decoration: none;
            font-size: 1.1em;
            font-weight: bold;
            color: #fff;
            transition: all 0.3s ease;
        }

        .btn-admin {
            background: #004aad;
            border: 2px solid #f4c430;
        }

        .btn-admin:hover {
            background: #005ce6;
            transform: scale(1.05);
        }

        .btn-student {
            background: #f4c430;
            color: #003366;
            border: 2px solid #003366;
        }

        .btn-student:hover {
            background: #ffdb4d;
            transform: scale(1.05);
        }

        footer {
            position: absolute;
            bottom: 15px;
            width: 100%;
            text-align: center;
            color: #ccc;
            font-size: 0.9em;
        }

        @media (max-width: 600px) {
            .logo img {
                width: 90px;
            }
            h1 {
                font-size: 2em;
            }
            .btn {
                padding: 12px 25px;
                font-size: 1em;
            }
        }
    </style>
</head>
<body>
    <div class="overlay"></div>
    <div class="container">
        <div class="logo">
            <img src="assets/images/lemery_logo.png" alt="Lemery Colleges Logo">
        </div>
        <h1>Lemery Colleges</h1>
        <h2>Form IX & Graduation Application Portal</h2>
        <a href="admin_login.php" class="btn btn-admin">Admin Login</a>
        <a href="student_login.php" class="btn btn-student">Student Login</a>
    </div>

    <footer>
        © <?php echo date("Y"); ?> Lemery Colleges | All Rights Reserved
    </footer>
</body>
</html>
