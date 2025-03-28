<?php
session_start(); // Start session to track authentication

// Prevent back button after logout
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// If user is not logged in, redirect to login page
if (!isset($_SESSION['auth']) || $_SESSION['auth'] !== true) {
    $_SESSION['message'] = "You must log in first!";
    $_SESSION['code'] = "error";
    header("Location: ../../login.php");
    exit();
}

include("../../auth/authentication.php");
include("../../dB/config.php");
include("./includes/header.php");
include("./includes/topbar.php");
include("./includes/sidebar.php");

// Fetch total number of registered users
$user_count_sql = "SELECT COUNT(*) AS total_users FROM users WHERE role = 'user'";
$user_count_result = $conn->query($user_count_sql);
$user_count_row = $user_count_result->fetch_assoc();
$total_users = $user_count_row['total_users'];

// Fetch total sales but exclude failed orders 
$sales_sql = "SELECT SUM(total_price) AS total_sales FROM orders WHERE status != 'Failed'";
$sales_result = $conn->query($sales_sql);
$sales_row = $sales_result->fetch_assoc();
$total_sales = $sales_row['total_sales'] ?? 0; // Default to 0 if no sales


// Fetch count of pending orders
$pending_sql = "SELECT COUNT(*) AS pending_orders FROM orders WHERE status = 'Pending'";
$pending_result = $conn->query($pending_sql);
$pending_row = $pending_result->fetch_assoc();
$pending_orders = $pending_row['pending_orders'] ?? 0;

// Fetch count of completed orders
$completed_sql = "SELECT COUNT(*) AS completed_orders FROM orders WHERE status = 'Completed'";
$completed_result = $conn->query($completed_sql);
$completed_row = $completed_result->fetch_assoc();
$completed_orders = $completed_row['completed_orders'] ?? 0;

// Fetch recent orders with customer name, total price, and status
$orders_sql = "
    SELECT orders.order_id, users.firstName AS customer, orders.total_price, orders.status
    FROM orders
    JOIN users ON orders.userId = users.userId
    ORDER BY orders.created_at DESC
    LIMIT 5;";

$orders_result = $conn->query($orders_sql);
?>

<div class="container mt-4">
    <!-- Overview Section -->
    <div class="row">
        <div class="col-md-3">
            <div class="card bg-primary text-white p-3">
                <h4>Total Sales Today</h4>
                <h2>₱<?php echo number_format($total_sales, 2); ?></h2>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white p-3">
                <h4>Pending Orders</h4>
                <h2><?php echo $pending_orders; ?></h2>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white p-3">
                <h4>Completed Orders</h4>
                <h2><?php echo $completed_orders; ?></h2>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white p-3">
                <h4>Total Customers</h4>
                <h2><?php echo $total_users; ?></h2>
            </div>
        </div>
    </div>

    <!-- Recent Orders Table -->
    <div class="mt-4">
        <h3>Recent Orders</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer</th>
                    <th>Items</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Action</th> 
                </tr>
            </thead>
            <tbody>
            <?php while ($order = $orders_result->fetch_assoc()): ?>
            <tr>
                <td>#<?php echo $order['order_id']; ?></td>
                <td><?php echo htmlspecialchars($order['customer']); ?></td>
                <td>
                    <?php
                    $order_items_sql = "SELECT product_name, quantity FROM order_items WHERE order_id = " . $order['order_id'];
                    $order_items_result = $conn->query($order_items_sql);
                    $items = [];
                    while ($item = $order_items_result->fetch_assoc()) {
                        $items[] = htmlspecialchars($item['product_name']) . ' x' . $item['quantity'];
                    }
                    echo implode(', ', $items);
                    ?>
                </td>
                <td>₱<?php echo number_format($order['total_price'], 2); ?></td>
                <td>
                    <span class="badge 
                        <?php 
                            if ($order['status'] == 'Completed') {
                                echo 'bg-success'; // Green for Completed
                            } elseif ($order['status'] == 'Failed') {
                                echo 'bg-danger'; // Red for Failed
                            } else {
                                echo 'bg-warning'; // Yellow for Pending
                            }
                        ?>">
                        <?php echo htmlspecialchars($order['status']); ?>
                    </span>
                </td>

                <td>
                    <form action="../../controllers/update_order.php" method="POST" class="d-inline">
                        <input type="hidden" name="order_id" value="<?php echo $order['order_id']; ?>">

                        <?php if ($order['status'] === 'Pending'): ?>
                            <button type="submit" name="complete_order" class="btn btn-success btn-sm">✔ Complete</button>
                            <button type="submit" name="fail_order" class="btn btn-warning btn-sm">❌ Fail</button>
                            <button type="button" class="btn btn-danger btn-sm delete-btn" data-id="<?php echo $order['order_id']; ?>">🗑 Delete</button>
                        <?php elseif ($order['status'] === 'Completed'): ?>
                            <span class="badge bg-success">✅ Completed</span>
                        
                        <?php elseif ($order['status'] === 'Failed'): ?>
                            <span class="badge bg-danger">❌ Failed</span>
                        <?php endif; ?>

                    </form>
                </td>
            </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".delete-btn").forEach(button => {
        button.addEventListener("click", function () {
            const orderId = this.getAttribute("data-id");

            Swal.fire({
                title: "Are you sure?",
                text: "This action cannot be undone!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch("../../controllers/update_order.php", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/x-www-form-urlencoded"
                        },
                        body: `delete_order=1&order_id=${orderId}`
                    })
                    .then(response => response.json()) // Expecting JSON response
                    .then(data => {
                        if (data.status === "success") {
                            Swal.fire("Deleted!", data.message, "success").then(() => {
                                location.reload(); // Refresh page after deletion
                            });
                        } else {
                            Swal.fire("Error", data.message, "error");
                        }
                    })
                    .catch(error => {
                        console.error("Error:", error);
                        Swal.fire("Error", "Failed to delete the order.", "error");
                    });
                }
            });
        });
    });
});


</script>


<?php include("./includes/footer.php"); ?>


