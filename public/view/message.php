<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <script src="https://cdn.bootcss.com/jquery/3.3.1/jquery.js"></script>
</head>
<body>
<div class="jumbotron" style="background: #ffffff;">
    <div class="container" style="text-align: center;margin-top: 100px">
        <h1><?php echo $msg;?></h1>
        <p><a href="<?php echo $this->url;?>"><span id="time">3</span>s之后自动跳转,或点击此处跳转</a></p>
        <p>
            <a class="btn btn-primary btn-lg">关于作者</a>
        </p>
    </div>
</div>
<script>
    window.<?php echo $this->url;?>;
    $(function(){
        setInterval(function () {
            var time=$('#time').html();
            time--;
            if(time<0){
                console.log()
                //location.href="<?php //echo $this->url;?>//"
                return
            }
            $('#time').html(time)

        },1000)


    })
</script>
</body>
</html>