<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #333;
        }

        p {
            color: #666;
        }

        .order-details {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }

        .order-details th, .order-details td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .order-details th {
            background-color: #f2f2f2;
        }

        .thank-you {
            margin-top: 20px;
            font-weight: bold;
        }

        .contact-info {
            margin-top: 20px;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007BFF;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
        }

        .footer {
            margin-top: 20px;
            font-size: 12px;
            color: #888;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Order Confirmation</h1>
    <p>Hello [Customer's Name],</p>
    <p>Your order [#12345] has been successfully received on [Order Date].</p>

    <table class="order-details">
        <thead>
        <tr>
            <th>Product</th>
            <th>Quantity</th>
            <th>Price</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>Product 1</td>
            <td>2</td>
            <td>$50.00</td>
        </tr>
        <tr>
            <td>Product 2</td>
            <td>1</td>
            <td>$30.00</td>
        </tr>
        </tbody>
    </table>

    <p>Total Amount: $80.00</p>

    <p>Your order will be shipped/delivered to you on [Delivery Date].</p>
    <p>If you have any questions or need further assistance, please don't hesitate to <a href="mailto:support@example.com" class="btn">Contact Us</a>.</p>

    <p class="thank-you">Thank you for your order!</p>

    <div class="contact-info">
        <p>Contact Information:</p>
        <p>Email: [Your Email]</p>
        <p>Phone: [Your Phone Number]</p>
    </div>

    {!! ($data['id']) !!}


    <p class="footer">This is an automated email. Please do not reply to this message.</p>
</div>
</body>
</html>
