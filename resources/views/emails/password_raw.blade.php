<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width"/>

    <!-- For development, pass document through inliner -->
    <link rel="stylesheet" href="css/simple.css">

    <style type="text/css">
    * {
      margin: 0;
      padding: 0;
      font-size: 100%;
      font-family: 'Avenir Next', "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;
      line-height: 1.65; }

    img {
      max-width: 100%;
      margin: 0 auto;
      display: block; }

    body,
    .body-wrap {
      width: 100% !important;
      height: 100%;
      background: #efefef;
      -webkit-font-smoothing: antialiased;
      -webkit-text-size-adjust: none; }

    a {
      color: #E08447;
      text-decoration: none; }

    .text-center {
      text-align: center; }

    .text-right {
      text-align: right; }

    .text-left {
      text-align: left; }

    .button {
      display: inline-block;
      color: white;
      background: #E08447;
      border: solid #E08447;
      border-width: 10px 20px 8px;
      font-weight: bold;
      border-radius: 2px; }

    h1, h2, h3, h4, h5, h6 {
      margin-bottom: 20px;
      line-height: 1.25; }

    h1 {
      font-size: 32px; }

    h2 {
      font-size: 28px; }

    h3 {
      font-size: 24px;
      text-align: center; }

    h4 {
      font-size: 20px; }

    h5 {
      font-size: 16px; }

    p, ul, ol {
      font-size: 16px;
      font-weight: normal;
      margin-bottom: 20px; }

    .container {
      display: block !important;
      clear: both !important;
      margin: 0 auto !important;
      max-width: 580px !important; }
      .container table {
        width: 100% !important;
        border-collapse: collapse; }
      .container .masthead {
        padding: 110px 0;
        background: #E08447;
        background-image: url('https://therecord.de/images/email_bg.jpg');
        background-repeat: no-repeat;
        background-size: cover;
        background-position: center center;
        color: white; }
        .container .masthead h1 {
          margin: 0 auto !important;
          max-width: 90%;
          text-transform: uppercase; }
      .container .content {
        background: white;
        padding: 30px 35px; }
        .container .content.footer {
          background: none; }
          .container .content.footer p {
            margin-bottom: 0;
            color: #888;
            text-align: center;
            font-size: 14px; }
          .container .content.footer a {
            color: #888;
            text-decoration: none;
            font-weight: bold; }
    </style>
</head>
<body>
<table class="body-wrap">
    <tr>
        <td class="container">

            <!-- Message start -->
            <table>
                <tr>
                    <td align="center" class="masthead">

                        <h1> </h1>

                    </td>
                </tr>
                <tr>
                    <td class="content">

                        <h2>Hi {{ $username }},</h2>

                        <p>you just told us you forgot your password. Don't panic, we got you covered. Click the following link and use the password below to log in again.</p>

                        <table>
                            <tr>
                                <td align="center">
                                    <p>
                                        <a href="{{ url($link) }}" class="button">Click here</a>
                                    </p>
                                </td>
                            </tr>
                        </table>

                        <p>Your new password:</p>

                        <h3>{{ $password }}</h3>

                        <p>You can change your password again, once you're logged in.</p>

                        <p><em>– Christian from therecord.de</em></p>

                    </td>
                </tr>
            </table>

        </td>
    </tr>
    <tr>
        <td class="container">

            <!-- Message start -->
            <table>
                <tr>
                    <td class="content footer" align="center">
                        <p>Sent by <a href="http://beta.diskollect.com">For the record</a>, Berlin</p>
                        <p>You can turn off email notifications in your <a href="#">profile settings</a>.</p>
                    </td>
                </tr>
            </table>

        </td>
    </tr>
</table>
</body>
</html>
