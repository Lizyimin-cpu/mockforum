<!DOCTYPE html>
<html lang="en">
<?php
session_start();
include('./db_connect.php');
?>

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Staff Forum System</title>


    <?php include('./header.php'); ?>
    <?php
    if (isset($_SESSION['login_id']))
        header("location:index.php?page=home");

    ?>

</head>
<style>
    body {
        width: 100%;
        height: calc(100%);
    }

    main#main {
        width: 100%;
        height: 100vh;
        background: url('./assets/img/bg-login.jpg') no-repeat;
        background-size: cover;
        background-position: center center;
    }

    #login-right {
        position: absolute;
        right: 0;
        width: 40%;
        height: calc(100%);
        display: flex;
        align-items: center;
    }

    #login-left {
        position: absolute;
        left: 0;
        width: 60%;
        height: calc(100%);
        background: transparent;
        display: flex;
        /* align-items: center; */
    }

    #login-left h3 {
        color: #315972;
        margin: 50px 30px;
        border-bottom: 1px solid #607D8B;
        height: fit-content;
        padding: 10px 0;
    }

    #login-right .card {
        margin: auto;
        z-index: 1
    }

    .logo {
        margin: auto;
        font-size: 8rem;
        background: white;
        padding: .5em 0.7em;
        border-radius: 50% 50%;
        color: #000000b3;
        z-index: 10;
    }

    div#login-right::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: calc(100%);
        height: calc(100%);
        background: transparent;
    }

    #login-form h4,
    #login-form p {
        text-align: center;
        width: 100%;
    }
</style>

<body>


    <main id="main" class=" bg-dark">
        <div id="login-left">
            <h3>Staff Forum System</h3>
        </div>

        <div id="login-right">
            <div class="card col-md-8">
                <div class="card-body">

                    <form id="login-form">
                        <h4>Login</h4>
                        <div class="form-group">
                            <label for="username" class="control-label">Nickname</label>
                            <input type="text" id="name" name="name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="username" class="control-label">Email/User name</label>
                            <input type="text" id="username" name="username" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="password" class="control-label">Password</label>
                            <input type="password" id="password" name="password" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="type">User type</label>
                            <select name="type" id="type" class="custom-select">
                                <option value="3" <?php echo isset($meta['type']) && $meta['type'] == 3 ? 'selected' : '' ?>>Student</option>
                                <option value="2" <?php echo isset($meta['type']) && $meta['type'] == 2 ? 'selected' : '' ?>>Others</option>
                                <option value="1" <?php echo isset($meta['type']) && $meta['type'] == 1 ? 'selected' : '' ?>>Administrator</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="file" class="control-label">profile photo</label>
                            <input type="file" name="image" id="imgUpload">
                            <img src="" alt="" id="imgPath" width="75">
                            <input type="hidden" name="imagePath" value="">
                        </div>
                        <p>已有账号，<a href="./login.php">go to login</a></p>
                        <center><button class="btn-sm btn-block btn-wave col-md-4 btn-primary">Register</button></center>
                    </form>
                </div>
            </div>
        </div>


    </main>

    <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>


</body>
<script>
    $('#login-form').submit(function(e) {
        e.preventDefault()
        $('#login-form button[type="button"]').attr('disabled', true).html('Signup in...');
        if ($(this).find('.alert-danger').length > 0)
            $(this).find('.alert-danger').remove();
        $.ajax({
            url: 'ajax.php?action=signup',
            method: 'POST',
            data: $(this).serialize(),
            error: err => {
                console.log(err)
                $('#login-form button[type="button"]').removeAttr('disabled').html('注册');

            },
            success: function(resp) {
                if (resp == 1) {
                    $('#login-form').prepend('<div class="alert alert-success">注册成功</div>')
                    location.href = 'login.php';
                } else if (resp == 2) {
                    $('#login-form').prepend('<div class="alert alert-danger">邮箱/用户名已存在</div>')
                    $('#login-form button[type="button"]').removeAttr('disabled').html('注册');
                } else if (resp == 3) {

                    $('#login-form').prepend('<div class="alert alert-danger">注册信息不能为空</div>')
                    $('#login-form button[type="button"]').removeAttr('disabled').html('注册');

                } else if (resp == 4) {

                    $('#login-form').prepend('<div class="alert alert-danger">请上传头像</div>')
                    $('#login-form button[type="button"]').removeAttr('disabled').html('注册');

                } else {
                    $('#login-form').prepend('<div class="alert alert-danger">注册失败</div>')
                    $('#login-form button[type="button"]').removeAttr('disabled').html('注册');
                }
            }
        })
    })

    $('#imgUpload').change(function() {
        var imgObj = this.files[0];
        if (!/^image/.test(imgObj.type)) {
            alert("The picture format is incorrect");
            return;
        }
        if (imgObj.size > 52428800) {
            alert("The file is too large.");
            return;
        }
        var formData = new FormData();
        formData.append('file', imgObj);
        $.ajax({
            url: 'ajax.php?action=upload',
            data: formData,
            dataType: "json",
            async: false,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success: function(res) {
                if (res.code == 1) {
                    $("#imgPath").attr("src", res.data.file);
                    $("[name='imagePath']").val(res.data.file);
                } else {
                    alert_toast("error")
                    setTimeout(function() {
                        location.reload()
                    }, 1500)
                }
            }
        })
    });
</script>

</html>