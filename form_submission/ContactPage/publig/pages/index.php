<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../style.css">
</head>

<body class="contact_page">
    <div class="container">
        <div class="img-container">
            <img src="" alt="">
        </div>
        <div class="title">
            <h2>No otaha yhteyttä</h2>
        </div>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            require_once __DIR__ . '/../../config/db.php';

            $nimi = htmlspecialchars(trim($_POST["name"]));
            $email = htmlspecialchars(trim($_POST["email"]));
            $message = htmlspecialchars(trim($_POST["message"]));

            // Prepare the statement correctly
            $stmt = $pdo->prepare("INSERT INTO contact_messages (name, email, message) VALUES (?, ?, ?)");
            $stmt->execute([$nimi, $email, $message]);

            echo "vastaan otettu";


        } else {
            ?>
            <div class="contact_form_container">
                <form class="contact_form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="name_container">
                        <input id="name" type="text" name="name" placeholder="Insert name">
                        <label for="name" class="label">Name</label>
                    </div>
                    <div class="email_container">
                        <input id="email" type="email" name="email" placeholder="Insert email">
                        <label for="email" class="label">Email</label>
                    </div>
                    <div class="textarea_container">
                        <textarea id="message" name="message" placeholder="Leave message" maxlength="1000"></textarea>
                        <label for="message">Message</label>
                    </div>
                    <div class="submit_btn">
                        <input type="submit" name="submitBtn" value="Send">
                    </div>
                </form>
            </div>
        <?php } ?>
    </div>
</body>

</html>