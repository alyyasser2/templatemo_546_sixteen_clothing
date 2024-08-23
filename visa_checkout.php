<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visa Payment Form</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h3>Visa Payment Form</h3>
        <form action="visa_checkout.php" method="POST">
            <div class="form-group">
                <label for="cardNumber">Card Number:</label>
                <input type="text" class="form-control" id="cardNumber" name="cardNumber" required>
            </div>
            <div class="form-group">
                <label for="expiryDate">Expiry Date:</label>
                <input type="text" class="form-control" id="expiryDate" name="expiryDate" placeholder="MM/YYYY" required>
            </div>
            <div class="form-group">
                <label for="cvv">CVV:</label>
                <input type="text" class="form-control" id="cvv" name="cvv" required>
            </div>
            <button type="submit" class="btn btn-primary">Pay Now</button>
        </form>
    </div>
</body>
</html>
