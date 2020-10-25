<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <style>
        body{
            font-size: 14px;
        }
        div{
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div>您的账号：{{ $userModel->username }}</div>
    <div>您的密码：{{ $pwd }}</div>
    <div>您的手机：{{ $userModel->phone }}</div>
</body>
</html>