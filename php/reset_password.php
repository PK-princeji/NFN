<?php
session_start();
 import pygame
import time
import random

# Initialize pygame
pygame.init()

# Colors
white = (255, 255, 255)
black = (0, 0, 0)
red = (213, 50, 80)
green = (0, 255, 0)

# Display settings
width = 600
height = 400
win = pygame.display.set_mode((width, height))
pygame.display.set_caption("Snake Game")

# Snake settings
snake_block = 10
snake_speed = 15
font_style = pygame.font.SysFont("bahnschrift", 25)

clock = pygame.time.Clock()

def message(msg, color):
    mesg = font_style.render(msg, True, color)
    win.blit(mesg, [width / 6, height / 3])

def draw_snake(snake_block, snake_list):
    for x in snake_list:
        pygame.draw.rect(win, black, [x[0], x[1], snake_block, snake_block])

def gameLoop():
    game_over = False
    game_close = False

    x = width / 2
    y = height / 2
    x_change = 0
    y_change = 0

    snake_list = []
    snake_length = 1

    food_x = round(random.randrange(0, width - snake_block) / 10.0) * 10.0
    food_y = round(random.randrange(0, height - snake_block) / 10.0) * 10.0

    while not game_over:

        while game_close:
            win.fill(white)
            message("Game Over! Press Q-Quit or C-Play Again", red)
            pygame.display.update()

            for event in pygame.event.get():
                if event.type == pygame.KEYDOWN:
                    if event.key == pygame.K_q:
                        game_over = True
                        game_close = False
                    if event.key == pygame.K_c:
                        gameLoop()

        for event in pygame.event.get():
            if event.type == pygame.QUIT:
                game_over = True
            if event.type == pygame.KEYDOWN:
                if event.key == pygame.K_LEFT:
                    x_change = -snake_block
                    y_change = 0
                elif event.key == pygame.K_RIGHT:
                    x_change = snake_block
                    y_change = 0
                elif event.key == pygame.K_UP:
                    y_change = -snake_block
                    x_change = 0
                elif event.key == pygame.K_DOWN:
                    y_change = snake_block
                    x_change = 0

        x += x_change
        y += y_change
        if x >= width or x < 0 or y >= height or y < 0:
            game_close = True

        win.fill(white)
        pygame.draw.rect(win, green, [food_x, food_y, snake_block, snake_block])
        snake_head = []
        snake_head.append(x)
        snake_head.append(y)
        snake_list.append(snake_head)
        if len(snake_list) > snake_length:
            del snake_list[0]

        for segment in snake_list[:-1]:
            if segment == snake_head:
                game_close = True

        draw_snake(snake_block, snake_list)
        pygame.display.update()

        if x == food_x and y == food_y:
            food_x = round(random.randrange(0, width - snake_block) / 10.0) * 10.0
            food_y = round(random.randrange(0, height - snake_block) / 10.0) * 10.0
            snake_length += 1

        clock.tick(snake_speed)

    pygame.quit()
    quit()

gameLoop()

// Initialize error and success message variables
$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'reset_password') {
    // Get the new password and token
    $password = $_POST['password'];
    $token = $_POST['token'];

    // Validate token and check if it is still valid (within 1 hour)
    $sql = "SELECT * FROM users1 WHERE reset_token = ? AND reset_token_expiry > NOW()";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Hash the new password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Update the password in the database
        $sql = "UPDATE users1 SET password = ?, reset_token = NULL, reset_token_expiry = NULL WHERE reset_token = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $hashed_password, $token);
        $stmt->execute();

        $success = "Your password has been successfully reset. You can now log in.";
    } else {
        $error = "Invalid or expired token.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
 <style>
    /* UNIVERSAL RESET */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* BASE STYLES */
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    color: #333;
    line-height: 1.6;
}

/* CONTAINER */
.reset-container {
    max-width: 400px;
    margin: 100px auto;
    background: #fff;
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    text-align: center;
}

/* HEADINGS */
.reset-container h2 {
    margin-bottom: 20px;
    color: #444;
}

/* FORM INPUTS */
input[type="password"],
input[type="submit"] {
    width: 100%;
    padding: 12px;
    margin: 10px 0;
    border: 1px solid #ccc;
    border-radius: 4px;
}

/* SUBMIT BUTTON */
input[type="submit"].btn {
    background-color: #007BFF;
    color: white;
    border: none;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

input[type="submit"].btn:hover {
    background-color: #0056b3;
}

/* ERROR & SUCCESS MESSAGES */
.error {
    color: #d8000c;
    background-color: #ffbaba;
    padding: 10px;
    border-radius: 4px;
    margin-bottom: 10px;
}

.success {
    color: #4F8A10;
    background-color: #DFF2BF;
    padding: 10px;
    border-radius: 4px;
    margin-bottom: 10px;
}

 </style>
<body>

    <div class="reset-container">
        <h2>Reset Your Password</h2>
        <?php if (!empty($error)) { echo "<p class='error'>$error</p>"; } ?>
        <?php if (!empty($success)) { echo "<p class='success'>$success</p>"; } ?>

        <form method="POST">
            <input type="password" name="password" placeholder="Enter new password" required>
            <input type="hidden" name="token" value="<?php echo isset($_GET['token']) ? htmlspecialchars($_GET['token']) : ''; ?>"> <!-- Pass token from URL -->
            <input type="hidden" name="action" value="reset_password">
            <input type="submit" class="btn" value="Reset Password">
        </form>
    </div>

</body>
</html>