<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AGAGAGAGG</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0 !important;
            mso-line-height-rule: exactly;
            background-color: #222222;
            color: #ffffff;
        }

        .email-container {
            width: 100%;
            margin: auto;
            padding: 20px;
        }

        table {
            border: 1px solid #dddddd;
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid #dddddd;
            padding: 10px;
        }

        h1 {
            color: #333333;
            font-size: 25px;
            line-height: 30px;
            font-weight: normal;
            margin: 0 0 10px;
        }

        p {
            color: #555555;
            font-size: 15px;
            line-height: 20px;
            margin: 0 0 10px;
        }

        /* Button Styles */
        .button-td {
            border-radius: 4px;
            background: #ffffff;
            padding: 13px 17px;
        }

        .button-a {
            background: #222222;
            border: 1px solid #000000;
            font-family: sans-serif;
            font-size: 15px;
            line-height: 15px;
            text-decoration: none;
            color: #ffffff;
            display: block;
            border-radius: 4px;
        }

        .button-a:hover {
            background: #cccccc;
            border-color: #cccccc;
        }
    </style>
</head>
<body>
    <!-- Email Body : BEGIN -->
    <center role="article" aria-roledescription="email" lang="en" style="width: 100%; background-color: #222222;">
        <!--[if mso | IE]>
        <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #222222;">
        <tr>
        <td>
        <![endif]-->

        <!-- Email Container : BEGIN -->
        <table align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" width="600" class="email-container">
            <!-- Email Header : BEGIN -->
            <tr>
                <td style="padding: 20px 0; text-align: center; background-color: #dddddd;">
                    <h2 width="200" height="50" alt="alt_text" border="0" style="height: auto; font-family: sans-serif; font-size: 15px; line-height: 15px; color: #555555;">VCDTT </h2>
                </td>
            </tr>
            <!-- Email Header : END -->

            <!-- Email Content : BEGIN -->
            <tr>
                <td style="background-color: #ffffff;">
                    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                        <tr>
                            <td style="padding: 20px;">
                                <h1>Xin chào!</h1>
                                <p>Đơn hàng của bạn đã được phê duyệt. Giờ đây bạn đã có thể đi tour mà bạn đã đặt. Chúc quý khách thượng lộ bình an</p>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 0 20px 20px;">
                                <!-- Button : BEGIN -->
                                <table align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" style="margin: auto;">
                                    <tr>
                                        <td class="button-td">
                                            <a class="text-center" style="color=#ffffff" href="http://datn-vcdtt.test:5173/user/tours">Kiểm tra đơn hàng của bạn</a>
                                        </td>
                                    </tr>
                                </table>
                                <!-- Button : END -->
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 0 20px 20px;">
                                <p>Hóa đơn của bạn:</p>
                                <table border="1">
                                    <tr>
                                        <th>Thông tin mua hàng</th>
                                        <th>Địa chỉ nhận hàng</th>
                                    </tr>
                                    <tr>
                                        <td>{{ $name }}<br>
                                            {{ $email }} <br>
                                            {{ $phone_number }}</td>
                                        <td>{{ $address }}</td>
                                    </tr>
                                    <tr>
                                        <th>Phương thức thanh toán</th>
                                        <th>Phương thức vận chuyển</th>
                                    </tr>
                                    <tr>
                                        <td>{{ $payment_method }}</td>
                                        <td>Giao hàng tận nơi</td>
                                    </tr>
                                    <tr>
                                        <th>Thông tin đơn hàng</th>
                                    </tr>
                                    <tr>
                                        <td>{{ $transaction_id }}</td>
                                        <td>{{ $updated_at }}</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <!-- Email Content : END -->
        </table>
        <!-- Email Container : END -->

        <!--[if mso | IE]>
        </td>
        </tr>
        </table>
        <![endif]-->
    </center>
    <!-- Email Body : END -->
</body>
</html>
