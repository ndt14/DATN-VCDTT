<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml"
    xmlns:o="urn:schemas-microsoft-com:office:office">

<head>
    <meta charset="utf-8"> <!-- utf-8 works for most cases -->
    <meta name="viewport" content="width=device-width"> <!-- Forcing initial-scale shouldn't be necessary -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge"> <!-- Use the latest (edge) version of IE rendering engine -->
    <meta name="x-apple-disable-message-reformatting"> <!-- Disable auto-scale in iOS 10 Mail entirely -->
    <meta name="format-detection" content="telephone=no,address=no,email=no,date=no,url=no">
    <!-- Tell iOS not to automatically link certain text strings. -->
    <meta name="color-scheme" content="light">
    <meta name="supported-color-schemes" content="light">
    <title></title>
    <style>
        @import url('/assets/font/Inter-Regular.ttf');

        /* What it does: Tells the email client that both light and dark styles are provided. A duplicate of meta color-scheme meta tag above. */
        :root {
            color-scheme: light;
            supported-color-schemes: light;
            font-family: Inter, -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
        }

        /* What it does: Remove spaces around the email design added by some email clients. */
        /* Beware: It can remove the padding / margin and add a background color to the compose a reply window. */
        html,
        body {
            margin: 0 auto !important;
            padding: 0 !important;
            height: 100% !important;
            width: 100% !important;
        }

        /* What it does: Stops email clients resizing small text. */
        * {
            -ms-text-size-adjust: 100%;
            -webkit-text-size-adjust: 100%;
        }

        /* What it does: Centers email on Android 4.4 */
        div[style*="margin: 16px 0"] {
            margin: 0 !important;
        }

        /* What it does: forces Samsung Android mail clients to use the entire viewport */
        #MessageViewBody,
        #MessageWebViewDiv {
            width: 100% !important;
        }

        /* What it does: Stops Outlook from adding extra spacing to tables. */
        table,
        td {
            mso-table-lspace: 0pt !important;
            mso-table-rspace: 0pt !important;
        }

        /* What it does: Fixes webkit padding issue. */
        table {
            border-spacing: 0 !important;
            border-collapse: collapse !important;
            table-layout: fixed !important;
        }

        /* What it does: Uses a better rendering method when resizing images in IE. */
        img {
            -ms-interpolation-mode: bicubic;
        }

        /* What it does: Prevents Windows 10 Mail from underlining links despite inline CSS. Styles for underlined links should be inline. */
        a {
            text-decoration: none;
        }

        /* What it does: A work-around for email clients meddling in triggered links. */
        a[x-apple-data-detectors],
        /* iOS */
        .unstyle-auto-detected-links a,
        .aBn {
            border-bottom: 0 !important;
            cursor: default !important;
            color: inherit !important;
            text-decoration: none !important;
            font-size: inherit !important;
            font-family: inherit !important;
            font-weight: inherit !important;
            line-height: inherit !important;
        }

        /* What it does: Prevents Gmail from changing the text color in conversation threads. */
        .im {
            color: inherit !important;
        }

        /* What it does: Prevents Gmail from displaying a download button on large, non-linked images. */
        .a6S {
            display: none !important;
            opacity: 0.01 !important;
        }

        /* If the above doesn't work, add a .g-img class to any image in question. */
        img.g-img+div {
            display: none !important;
        }

        /* What it does: Removes right gutter in Gmail iOS app: https://github.com/TedGoas/Cerberus/issues/89  */
        /* Create one of these media queries for each additional viewport size you'd like to fix */

        /* iPhone 4, 4S, 5, 5S, 5C, and 5SE */
        @media only screen and (min-device-width: 320px) and (max-device-width: 374px) {
            u~div .email-container {
                min-width: 320px !important;
            }
        }

        /* iPhone 6, 6S, 7, 8, and X */
        @media only screen and (min-device-width: 375px) and (max-device-width: 413px) {
            u~div .email-container {
                min-width: 375px !important;
            }
        }

        /* iPhone 6+, 7+, and 8+ */
        @media only screen and (min-device-width: 414px) {
            u~div .email-container {
                min-width: 414px !important;
            }
        }
    </style>
    <!-- CSS Reset : END -->

    <!-- Progressive Enhancements : BEGIN -->
    <style>
        /* What it does: Hover styles for buttons */
        .button-td,
        .button-a {
            transition: all 100ms ease-in;
        }

        .button-td-primary:hover,
        .button-a-primary:hover {
            background: #555555 !important;
            border-color: #555555 !important;
        }

        .in-center {
            margin-left: 60px;
            margin-right: 60px;

        }

        /* Media Queries */
        @media screen and (max-width: 480px) {
            .in-center {
                margin-left: 15px;
                margin-right: 15px;
            }

            /* What it does: Forces table cells into full-width rows. */
            .stack-column,
            .stack-column-center {
                display: block !important;
                width: 100% !important;
                max-width: 100% !important;
                direction: ltr !important;
            }

            /* And center justify these ones. */
            .stack-column-center {
                text-align: center !important;
            }

            /* What it does: Generic utility class for centering. Useful for images, buttons, and nested tables. */
            .center-on-narrow {
                text-align: center !important;
                display: block !important;
                margin-left: auto !important;
                margin-right: auto !important;
                float: none !important;
            }

            table.center-on-narrow {
                display: inline-block !important;
            }

            /* What it does: Adjust typography on small screens to improve readability */
            .email-container p {
                font-size: 17px !important;
            }
        }

        /* Dark Mode Styles : END */
    </style>
    <!-- Progressive Enhancements : END -->

</head>

<body width="100%" style="margin: 0; padding: 0 !important; mso-line-height-rule: exactly; background-color: #fff"
    class="email-bg">
    <center role="article" aria-roledescription="email" lang="en" style="width: 100%; background-color: #fff;"
        class="email-bg">
        <div style="max-width: 700px; margin: 0 auto;" class="email-container">
            <table width="100%"
                style="margin: auto;  background-image: url(images/top-right-of-email.png); background-position: 100% 0%; background-repeat: no-repeat;">
                <tbody>
                    <!-- header -->

                    <tr>
                        <td style="margin-top: 40rem;">
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="auto"
                                class="in-center" style="margin-top: 86px;margin-bottom: 56px; ">
                                <tr style="margin-bottom: 5rem">
                                    <td style=" text-align: left;">
                                        <a href="#S" target="_blank">
                                            <img src="images/logo.jpg" width="200" height="50" alt="alt_text"
                                                border="0" style="height: auto;">
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- end header -->

                    <!-- content -->
                    <tr>
                        <td>
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="auto"
                                class="in-center" style="margin-bottom: 25px;">
                                <tr>
                                    <td style="font-size: 15px; line-height: 20px; color: #222222;">
                                        <div
                                            style="margin: 0 0 10px; font-size: 32px; line-height: 30px; color: #222222; font-weight: normal;">
                                            Xin chào! <span style="color: #0D6EFD;">[Name],</span></div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="auto"
                                class="in-center" style="margin-bottom: 25px;">
                                <tr>
                                    <td>
                                        <div style="margin: 0 0 10px; font-size: 18px;">{{ $status }}</div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="auto"
                                class="in-center" style="margin-bottom: 38px;">
                                <tr>
                                    <td style="padding: 20px 0;">
                                        <p style="margin: 0 0 10px; font-size: 18px;">Hóa đơn của bạn:</p>
                                        <table border="1" style="border-color: #878787;">
                                            <tr>
                                                <th style="padding: 20px;">Thông tin mua hàng</th>
                                                <th style="padding: 20px;">Địa chỉ nhận hàng</th>
                                            </tr>
                                            <tr>
                                                <td style="padding: 20px;">{{ $name }}<br>
                                                    {{ $email }} <br>
                                                    {{ $phone_number }}</td>
                                                <td style="padding: 20px;">{{ $address }}</td>
                                            </tr>
                                            <tr>
                                                <th style="padding: 20px;" colspan="2">Phương thức thanh toán</th>
                                            </tr>
                                            <tr>
                                                @if ($payment_status == 1)
                                                    <td style="padding: 20px;" colspan="2">Chưa thanh toán</td>
                                                @endif
                                                @if ($payment_status == 2)
                                                    <td style="padding: 20px;" colspan="2">{{ $purchase_method }}
                                                    </td>
                                                @endif
                                            </tr>
                                            <tr>
                                                <th style="padding: 20px;" colspan="2">Thông tin đơn hàng</th>
                                            </tr>
                                            <tr colspan="2">
                                                @if {{ $transaction_id }} != null <td style="padding: 20px;">
                                                    {{ $transaction_id }}</td>
                                                @endif
                                                @if ($payment_status == 2)
                                                    Đã thanh toán lúc <td style="padding: 20px;">{{ $updated_at }}
                                                    </td>
                                                @endif
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 100%;">
                            <table role="presentation" cellspacing="0" cellpadding="0" width="auto" class="in-center"
                                border="0" style="margin-bottom: 96px">
                                <tr>
                                    <td>
                                        <a style="font-size: 15px; line-height: 15px; color: #fff; text-decoration: none; padding: 12px 20px; background-color: #0D6EFD; border-radius: 5px;"
                                            target="_blank" href="http://datn-vcdtt.test:5173/user/tours">Kiểm tra đơn
                                            hàng của bạn</a>
                                    </td>
                                </tr>
                            </table>

                        </td>
                    </tr>
                    <!-- end content -->

                    <!-- footer -->
                    <tr style="background-color: #F5FBFF;">
                        <td>
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0"
                                height="auto" width="50%" style="margin: 30px auto;">
                                <tr>
                                    <td style="  text-align: center;">
                                        <div style="font-size: 14px; line-height: 18px; color: #434343;">VCDTT luôn
                                            đồng hành cũng bạn trong mọi chuyến đi, mọi thắc mắc vui lòng liên hệ đội
                                            ngũ hỗ trợ.</div>
                                    </td>
                                </tr>
                            </table>
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0"
                                height="auto" width="auto"
                                style="margin-bottom: 30px;margin-left: auto;margin-right: auto;">
                                <tr>
                                    <td style=" font-size: 16px;">
                                        <div
                                            style="color: #0D6EFD; margin-left: auto;margin-right: auto; width: auto; display: flex; justify-items: center; justify-content: center;">
                                            <span style="margin: 0 9px; border-bottom: #0D6EFD solid 1px;">
                                                <a target="_blank" href="#"
                                                    style="text-decoration: none; color: #222222;">Chính sách</a>
                                            </span>
                                            <span style="margin: 0 9px; border-bottom: #0D6EFD solid 1px;">
                                                <a target="_blank" href="#"
                                                    style="text-decoration: none; color: #222222;">Liên hệ</a>
                                            </span>
                                            <span style="margin: 0 9px; border-bottom: #0D6EFD solid 1px;">
                                                <a target="_blank" href="#Ư"
                                                    style="text-decoration: none; color: #222222;">VCDTT</a>
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0"
                                width="auto" style="margin-bottom: 37px; margin-left: auto; margin-right: auto;">
                                <tr style="margin-bottom: 5rem">
                                    <td>
                                        <img src="images/logo.jpg" width="128" height="45" alt="alt_text"
                                            border="0" style="height: auto;">
                                    </td>
                                </tr>

                            </table>
                        </td>
                    </tr>

                    <!-- end footer -->
                </tbody>
            </table>
        </div>
    </center>
</body>

</html>
