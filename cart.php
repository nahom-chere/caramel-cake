<?php
session_start();
include "connection.php";
$isLoggedIn = isset($_SESSION['id']);

if (!$isLoggedIn) {
    header('Location: login.php');
    exit;
}

// Fetch cart items
$user_id = $_SESSION['id'];
$stmt = $conn->prepare("SELECT c.cart_id, p.product_id, p.name, p.price, c.quantity FROM cart c JOIN products p ON c.product_id = p.product_id WHERE c.user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$cart_items = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart - Caramel Cake</title>
    <link rel="stylesheet" href="cart.css">
</head>
<body>
    <header>
        <h1>Your Cart</h1>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="contact.php">Contact</a></li>
                <?php if (!$isLoggedIn): ?>
                    <li><a href="register.php">Register</a></li>
                    <li><a href="login.php">Login</a></li>
                <?php else: ?>
                    <li><a href="order.php">Shop</a></li>
                    <li><a href="cart.php">🛒 Cart</a></li>
                    <li><a href="logout.php">Logout</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <section class="cart">
        <h2>Cart Items</h2>
        <div id="cart-items">
            <?php if (empty($cart_items)): ?>
                <p>Your cart is empty</p>
            <?php else: ?>
                <?php foreach ($cart_items as $item): ?>
                    <div class="cart-item" data-cart-id="<?php echo $item['cart_id']; ?>">
                        <h3><?php echo htmlspecialchars($item['name']); ?></h3>
                        <p>Price: <?php echo number_format($item['price'], 2); ?> Birr</p>
                        <p>Quantity: <?php echo $item['quantity']; ?></p>
                        <p class="item-total">Total: <?php echo number_format($item['price'] * $item['quantity'], 2); ?> Birr</p>
                        <button class="btn remove-item">Remove</button>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        
        <div class="cart-summary">
            <p><strong>Total Items: </strong><span id="total-items">
                <?php echo array_sum(array_column($cart_items, 'quantity')); ?>
            </span></p>
            <p><strong>Total Price: </strong><span id="total-price">
                <?php
                $total = 0;
                foreach ($cart_items as $item) {
                    $total += $item['price'] * $item['quantity'];
                }
                echo number_format($total, 2);
                ?></span> Birr
            </p>
        </div>

        <div class="cart-actions">
            <button id="checkout-btn" class="btn checkout-btn" <?php echo empty($cart_items) ? 'disabled' : ''; ?>>
                Proceed to Checkout
            </button>
        </div>
    </section>

    <footer class="footer">
        <div class="footer-content">
            <p>&copy; 2025 Caramel Cake. All Rights Reserved.</p>
            <ul class="footer-links">
                <li><a href="privacy.php">Privacy Policy</a></li>
                <li><a href="terms.php">Terms of Service</a></li>
                <li><a href="contact.php">Contact Us</a></li>
            </ul>
        </div>
    </footer>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Remove item
        document.querySelectorAll('.remove-item').forEach(button => {
            button.addEventListener('click', async function() {
                const cartId = this.closest('.cart-item').dataset.cartId;
                try {
                    const response = await fetch('remove_cart_item.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            cart_id: cartId
                        })
                    });
                    
                    const result = await response.json();
                    if (result.status === 'success') {
                        location.reload();
                    } else {
                        alert(result.message);
                    }
                } catch (error) {
                    alert('Error removing item');
                }
            });
        });

        // Checkout
        document.getElementById('checkout-btn').addEventListener('click', async function() {
            if (!confirm('Proceed to checkout?')) return;
            
            try {
                const response = await fetch('process_checkout.php', {
                    method: 'POST'
                });
                
                const result = await response.json();
                if (result.status === 'success') {
                    alert('Order placed successfully!');
                    window.location.href = 'cart.php';
                } else {
                    alert(result.message);
                }
            } catch (error) {
                alert('Error processing checkout');
            }
        });
    });
    </script>
</body>
</html>
