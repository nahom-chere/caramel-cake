<?php
session_start();
include "connection.php";
$isLoggedIn = isset($_SESSION['id']);

// Fetch products from database
$stmt = $conn->prepare("SELECT * FROM products WHERE stock > 0");
$stmt->execute();
$result = $stmt->get_result();
$products = $result->fetch_all(MYSQLI_ASSOC);

// Handle adding to cart
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $isLoggedIn) {
    $user_id = $_SESSION['id'];
    $product_id = $_POST['product_id'];
    $quantity = 1; // Default quantity

    // Check if product already in cart
    $stmt = $conn->prepare("SELECT cart_id, quantity FROM cart WHERE user_id = ? AND product_id = ?");
    $stmt->bind_param("ii", $user_id, $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Update existing cart item
        $cart_item = $result->fetch_assoc();
        $new_quantity = $cart_item['quantity'] + 1;
        $stmt = $conn->prepare("UPDATE cart SET quantity = ? WHERE cart_id = ?");
        $stmt->bind_param("ii", $new_quantity, $cart_item['cart_id']);
    } else {
        // Insert new cart item
        $stmt = $conn->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)");
        $stmt->bind_param("iii", $user_id, $product_id, $quantity);
    }

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Item added to cart']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to add item']);
    }

    if (isset($_POST['ajax'])) {
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop - Caramel Cake</title>
    <link rel="stylesheet" href="order.css">
</head>
<body>
    <header>
        <h1>Welcome to Caramel Cake Shop</h1>
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

    <section class="shop">
        <h2>Our Cakes</h2>
        <p>Browse through our delightful collection of cakes, handmade with love and the finest ingredients.</p>
        <div class="product-grid">
            <?php foreach ($products as $product): ?>
                <div class="product">
                    <?php if (!empty($product['image_url'])): ?>
                        <img src="images/<?php echo htmlspecialchars($product['image_url']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                    <?php else: ?>
                        <img src="images/placeholder.jpg" alt="Placeholder Image">
                    <?php endif; ?>
                    <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                    <p><?php echo htmlspecialchars($product['description']); ?></p>
                    <p><strong><?php echo number_format($product['price'], 2); ?> Birr</strong></p>
                    <p>In Stock: <?php echo $product['stock']; ?></p>
                    <button class="add-to-cart" 
                            data-product-id="<?php echo $product['product_id']; ?>"
                            data-name="<?php echo htmlspecialchars($product['name']); ?>"
                            data-price="<?php echo $product['price']; ?>">
                        Add to Cart
                    </button>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <footer class="footer">
        <div class="footer-content">
            <p>&copy; 2025 Caramel Cake. All Rights Reserved.</p>
            <ul class="footer-links">
            <li><a href="privecy.php">Privacy Policy</a></li>
                <li><a href="terms.php">Terms of Service</a></li>
                <li><a href="contact.php">Contact Us</a></li>
            </ul>
        </div>
    </footer>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add to cart functionality
        document.querySelectorAll('.add-to-cart').forEach(button => {
            button.addEventListener('click', async function() {
                if (!document.cookie.includes('PHPSESSID')) {
                    alert('Please log in to add items to cart');
                    window.location.href = 'login/login.php';
                    return;
                }

                const productId = this.getAttribute('data-product-id');
                
                try {
                    const formData = new FormData();
                    formData.append('product_id', productId);
                    formData.append('ajax', true);

                    const response = await fetch('order.php', {
                        method: 'POST',
                        body: formData
                    });

                    const result = await response.json();
                    
                    if (result.status === 'success') {
                        alert('Item added to cart!');
                    } else {
                        alert(result.message);
                    }
                } catch (error) {
                    alert('Error adding item to cart');
                }
            });
        });
    });
    </script>
</body>
</html>