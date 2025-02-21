<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="payment-container">
        <div class="payment-header">
            <button class="back-btn" onclick="window.history.back()">←</button>
            <h2>Payment</h2>
        </div>

        <div class="cart-items">
            <?php foreach ($items as $item): ?>
                <div class="cart-item">
                    <h3><?= htmlspecialchars($item['name']) ?></h3>
                    <p>Price: SAR <?= number_format((float) $item['price'], 2) ?></p>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="cart-summary">
            <p>Total: <span class="cart-total">SAR <?= number_format((float) $total, 2) ?></span></p>
        </div>

        <div class="payment-form">
            <div class="payment-method">
                <label for="payment-method">Select Payment Method</label>
                <select id="payment-method" name="payment-method">
                    <option value="credit-card">Credit Card</option>
                    <option value="Cash">Cash</option>
                </select>
            </div>

            <div class="credit-card-details">
                <label for="credit-card-number">Card Number</label>
                <input type="text" id="credit-card-number" placeholder="Enter card number">
                <label for="credit-card-expiry">Expiry Date</label>
                <input type="text" id="credit-card-expiry" placeholder="MM/YY">
                <label for="credit-card-cvc">CVC</label>
                <input type="text" id="credit-card-cvc" placeholder="Enter CVC">
            </div>

            <!-- تعديل الزر ليكون رابطًا إلى صفحة track_order.php -->
            <a href="track_order.php?total=<?= urlencode($total) ?>&items=<?= urlencode(serialize($items)) ?>" class="checkout-btn">
                Pay Now
            </a>
        </div>
    </div>

    <script>
        // Show credit card details when credit card is selected
        document.getElementById('payment-method').addEventListener('change', function() {
            const cardDetails = document.querySelector('.credit-card-details');
            if (this.value === 'credit-card') {
                cardDetails.style.display = 'block';
            } else {
                cardDetails.style.display = 'none';
            }
        });
    </script>
</body>
</html>








