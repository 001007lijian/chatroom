<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.4.1.js"></script>
    <link rel="stylesheet" href="https://g.alicdn.com/de/prismplayer/2.8.7/skins/default/aliplayer-min.css" />
    <script type="text/javascript" charset="utf-8" src="https://g.alicdn.com/de/prismplayer/2.8.7/aliplayer-min.js"></script>
    <title>直播间</title>
</head>
<body>
        <div style="width: 70%;height: 500px;border: 1px solid black;float: left;" class="prism-player" id="player-con"></div>
        <div style="width: 29%;float:right;">
                <input type="button" value="大家说" style="width:49%;height:40px">
                <input type="button" value="粉丝贡献榜" style="width:49%;height:40px">
                <div style="width: 99%; height: 600px; border: 1px solid black;overflow: auto" id="list"></div>
                <input type="text" id="message">
                <input type="button" value="发送" id='btn'>
                <div id="bqlist" style="width: 400px;height: auto;"></div>
        </div>
        <div  style="width: 100px;height: 100px;border: 1px solid black;float: right; margin:15px 15px 15px 15px" ></div>
        <div  style="width: 100px;height: 100px;border: 1px solid black;float: right; margin:15px 15px 15px 15px" ></div>
        <div  style="width: 100px;height: 100px;border: 1px solid black;float: right; margin:15px 15px 15px 15px" ></div>
        <div  style="width: 100px;height: 100px;border: 1px solid black;float: right; margin:15px 15px 15px 15px" ></div>
        <div  style="width: 100px;height: 100px;border: 1px solid black;float: right; margin:15px 15px 15px 15px" ></div>
        <div  style="width: 100px;height: 100px;border: 1px solid black;float: right; margin:15px 15px 15px 15px" ></div>
        <div  style="width: 100px;height: 100px;border: 1px solid black;float: right; margin:15px 15px 15px 15px" ></div>
</body>
<script>
    $(document).on('click','.dajia',function(){
        var _this=$(this);
        var div = _this.parent().parent().html();
        console.log(div);
    });
    var player = new Aliplayer({
        "id": "player-con",
        "source": "rtmp://youke.bianaoao.top/filevido/vido?auth_key=1583117148-0-0-4efcff3b7648a2dac22eb6b65654ecc4",
        "width": "100%",
        "height": "500px",
        "autoplay": true,
        "isLive": false,
        "rePlay": false,
        "playsinline": true,
        "preload": true,
        "controlBarVisibility": "hover",
        "useH5Prism": true
    }, function(player) {
        console.log("The player is created");
    });
    var username = prompt('请输入用户名');
    var ws = new WebSocket("ws://182.92.161.74:9502");
    ws.onopen = function() {
        var message = '{"type":"login","con":"' + username + '"}';
        ws.send(message);
    }
    ws.onmessage = function(res) {
        var data = JSON.parse(res.data);
        if (data.is_me == 1 && data.type == 'login') {
            var con = "<p style='text-align:center'>尊敬的用户：" + data.username + "欢迎您的到来</p>";
        } else if (data.is_me == 0 && data.type == 'login') {
            var con = "<p style='text-align:center'>系统提示：" + data.username + "上线</p>";
        } else if (data.is_me == 1 && data.type == 'message') {
            var con = "<div style='width: 99%; height: 100px;' align='right'><p>来自您的消息</p><p></p><p>" + data.message + "</p></div>"
        } else if (data.is_me == 0 && data.type == 'message') {
            var con = "<div style='width: 300px; height: 100px;' alig='left'><p>来自" + data.username + "的消息</p><p></p><p>" + data.message + "</p></div>"
        } else if (data.is_me == 0 && data.type == 'loginout') {
            var con = "<p style='text-align:center'>系统提示：" + data.username + "离开了聊天室</p>";
        }
        $("#list").append(con);
    }
    $(document).on('click', '#btn', function() {
        var con = $('#message').val();
        var message = '{"type":"message","con":"' + con + '"}';
        ws.send(message);
    });
    $(document).on('click', '#bo', function() {
        // alert(111);
        $.ajax({
            url: './bq.php',
            dataType: 'json',
            success: function(res) {
                var img = '';
                for (var i in res) {
                    // console.log(res[i]);
                    img += "<img class='bqimg' src='./bq/" + res[i] + "' style='width: 70px;height: 70px;'>";
                }
                //   console.log(img);
                $('#bqlist').html(img);
            }
        })
    });
    $(document).on('click', '.bqimg', function() {
        var res = $(this).attr("src");
        var con = "<img class='bqimg' src='" + res + "' style='width: 70px;height: 70px;'>";
        var message = '{"type":"message","con":"' + con + '"}';
        ws.send(message);
    })
</script>
</html>