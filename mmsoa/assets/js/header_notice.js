var user = {}
var noticelist = [];
var messagelist = [];
var socket = io('http://'+document.domain+':2020').connect();;

var url = window.location.host;
var protocol = window.location.protocol + '';
baseurl = protocol + '//' + url + '/OA/mmsoa/';
// index.php/chat/index';
socket.on("newnotice", function(data) {
        console.log("new notice");
        noticelist = data.noticelist;
        messagelist = data.messagelist;
        insertToHeader();
    })


var getNowUser = function() {
    chaturl = baseurl + 'index.php/Chat/getNowUser';
    console.log("getNowUser");
    console.log(chaturl);
    $.ajax({
      type: 'get',
      url: '/OA/mmsoa/index.php/Chat/getNowUser',
      data: {},
      success: function(result) {
        result = JSON.parse(result);
        user.uid = result.uid;
        console.log(result);
        console.log(user.uid);
        checkUnread();
      },
      error: function() {
        console.log("发送请求失败: getNowUser");
      }

    });
  }

    var checkUnread = function() {
      socket.emit('checkunread', {
        userId: user.uid
      })
    }

    var insertToHeader = function(_user, index) {
        $('.navbar-top-links').empty();
        var allnums = noticelist.length + messagelist.length;
        if (allnums == 0) {
            allnums = '';
        }
        let temp =
        '<li class="dropdown">'+
        '    <a class="dropdown-toggle count-info" data-toggle="dropdown" href="index.html#">'+
        '        <i class="fa fa-bell"></i>  <span class="label label-primary">'+ allnums +'</span>'+
        '    </a>'+
        '    <ul class="dropdown-menu dropdown-alerts">'+
        '        <li>'+
        '            <a href="'+baseurl+'index.php/Notify">'+
        '                <div>'+
        '                    <i class="fa fa-envelope fa-fw"></i> 您有'+ noticelist.length +'条未读消息'+
        '                </div>'+
        '            </a>'+
        '        </li>'+
        '        <li class="divider"></li>'+
        '        <li>'+
        '            <a href="'+baseurl+'index.php/chat/index">'+
        '                <div>'+
        '                    <i class="fa fa-qq fa-fw"></i> '+ messagelist.length +'条新回复'+
        '                </div>'+
        '            </a>'+
        '       </li>'+
        '        <li class="divider"></li>'+
        '    </ul>'+
        '</li>'+
        '<li>'+
        '    <a href="'+baseurl+'index.php/Login">'+
        '        <i class="fa fa-sign-out"></i> 退出'+
        '    </a>'+
        '</li>';

        $('.navbar-top-links').append(temp);
      }

    window.onload = function() {
        getNowUser();
        insertToHeader();
    }

