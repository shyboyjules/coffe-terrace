<?php
session_start();
include("../../auth/authenticationForUser.php"); 
include("../../dB/config.php");
include("../users/includes/header.php");
include("../users/includes/topbar.php");
include("../users/includes/sidebar.php");

// Check if user is logged in
if (!isset($_SESSION['authUser']) || empty($_SESSION['authUser'])) {
    header("Location: ../../login.php"); 
    exit();
}

$user = $_SESSION['authUser']; // Get user data

// Fetch all products
$query = "SELECT * FROM products";
$result = $conn->query($query);
?>

<?php if (isset($_SESSION['message'])): ?>
    <div class="alert alert-<?= isset($_SESSION['message_type']) && $_SESSION['message_type'] === 'error' ? 'danger' : 'success' ?> alert-dismissible fade show" role="alert">
        <?= htmlspecialchars($_SESSION['message']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php unset($_SESSION['message'], $_SESSION['message_type']); ?> <!-- Clear message after displaying -->
<?php endif; ?>



<main id="main" class="main">
    <div class="pagetitle">
        <h1>Welcome, <?= htmlspecialchars($user['firstName'] ?? 'User') ?>!</h1>
    </div>

    <section class="section">
        <div class="row">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $available_stock = $row['quantity']; // Get stock quantity
            ?>
                    <div class="col-md-3 mb-4">
                        <div class="card shadow-sm h-100 d-flex flex-column">
                            <img src="../../assets/img/<?= htmlspecialchars($row['image'] ?? 'default.png') ?>" 
                                 class="card-img-top img-fluid" 
                                 style="height: 200px; object-fit: cover;" 
                                 alt="<?= htmlspecialchars($row['product_name']) ?>">
                            
                            <div class="card-body d-flex flex-column text-center">
                                <h6 class="card-title"><?= htmlspecialchars($row['product_name']) ?></h6>
                                <p class="text-muted">₱<?= number_format($row['price'], 2) ?></p>
                                <p class="text-warning">Stock: <?= $available_stock ?></p> <!-- Show stock -->

                                <form action="../../controllers/add_to_cart.php" method="POST" class="mt-auto">
                                    <input type="hidden" name="product_id" value="<?= $row['product_id'] ?>">
                                    <input type="hidden" name="product_name" value="<?= $row['product_name'] ?>">
                                    <input type="hidden" name="brand" value="<?= $row['brand'] ?>">
                                    <input type="hidden" name="price" value="<?= $row['price'] ?>">
                                    <input type="hidden" name="image" value="<?= $row['image'] ?>">
                                    
                                    <input type="number" name="quantity" value="1" min="1" max="<?= $available_stock ?>" class="form-control mb-2">
                                    <button type="submit" class="btn btn-success w-100" <?= $available_stock <= 0 ? 'disabled' : '' ?>>
                                        <?= $available_stock > 0 ? 'Add to Cart' : 'Out of Stock' ?>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
            <?php
                }
            } else {
                echo "<p class='text-center'>No products available.</p>";
            }
            ?>
        </div>
    </section>
</main>

<?php
include("../users/includes/footer.php");
$conn->close();
?>
