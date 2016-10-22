var user = {};
var receiveUser = {};
var allUser = [];
var userlist = [];
var noticelist = [];
var messagelist = [];
var scrollHight = 0;

var url = window.location.host;
var protocol = window.location.protocol + '';
socketurl = protocol + '//' + url + ':2022';
var socket = io('http://'+document.domain+':2020').connect();

    //——————————————————————————————————————————————————
    //服务端事件
    //——————————————————————————————————————————————————
    socket.on('new notice', function(data) {
      console.log("new notice");
      noticelist = data.noticelist;
      messagelist = data.messagelist;
      //拉取用户列表
      console.log(noticelist)
      console.log(messagelist);
      updateUserList();
    });

    //拉取历史纪录
    socket.on('init chat', function(data) {
      console.log('----init chat');
      initChat(data);
    });

    socket.on('new message', function(data) {
      console.log('----new message');
      var msglist = data.messagelist;
      for (var i of msglist) {
        getNewMessage(i);
      }
    });

    socket.on('check new notice', function(data) {
      console.log("----check new notice");
      checkMessage();
    });

    //——————————————————————————————————————————————————
    //DOM操作
    //——————————————————————————————————————————————————
    //插入一句我的话
    var insertContent = function(data) {
      var initTime = new Date(data.timestamp);
      initTime = initTime.toLocaleTimeString();

      var temp =
        '<div class=\"chat-message\">' +
        '    <img class=\"message-avatar-right\" src=\"' + user.avatar + '\" alt=\"\">' +
        '    <div class=\"message-right\">' +
        '        <a class=\"message-author\"> ' + user.name + '</a>' +
        '        <span class=\"message-date-right\"> ' + initTime + ' </span>' +
        '        <span class=\"message-content\">' + data.body + '</span>' +
        '    </div>' +
        '</div>';
      $('.chat-discussion').append(temp);
      scrollToEnd();

    }

    //插入一句对方的话
    var insertReceiveContent = function(data) {
      var initTime = new Date(data.timestamp);
      initTime = initTime.toLocaleTimeString();

      var temp =
        '<div class=\"chat-message\" >' +
        '    <img class=\"message-avatar-left\" src=\"' + receiveUser.avatar + '\" alt=\"\">' +
        '    <div class=\"message-left\">' +
        '        <a class=\"message-author\"> ' + receiveUser.name + '</a>' +
        '        <span class=\"message-date-left\"> ' + initTime + ' </span>' +
        '        <span class=\"message-content\">' + data.body + '</span>' +
        '    </div>' +
        '</div>';
      $('.chat-discussion').append(temp);
      scrollToEnd();

    }

    var insertUserList = function(_user, index) {
        var msgnums = '';
        if(_user.msgnums != 0) {
          msgnums = _user.msgnums + '';
        }
        var temp =
          '<div class="chat-user" onclick="choseReceiveUser(' + index + ')">' +
          '    <img class="chat-avatar" src="' + _user.avatar + '" alt="">' +
          '    <span class="pull-right label label-primary">'+ msgnums +'</span>'+
          '    <div class="chat-user-name">' +
          '        <a>' + _user.name + '</a>' +
          '    </div>' +
          '</div>';
        $('.users-list').append(temp);
      }
      //——————————————————————————————————————————————————

    //工具函数
    //——————————————————————————————————————————————————
    var getNowTime = function() {
      var time = new Date();
      return time;
    }

    var choseReceiveUser = function(index) {
      if(receiveUser != allUser[index]) {
     
          scrollHight = 0;
          receiveUser = allUser[index];
          $('.ibox-title').html(receiveUser.name);
          console.log("choseReceiveUser");
          console.log(receiveUser);
          //clear对话框
          $('.chat-discussion').empty();
          //消除
          $('.label-primary').remove();

          getChatHistory();
          // if(receiveUser.msgnums != 0) {
          //   for(var i of messagelist) {
          //     if (i.receive_uids == user.uid) {
          //       insertReceiveContent(i);
          //       if(i.isread == 0)
          //         sendAlreadyRead(i.mid);
          //     }
          //   }
          // }
          // else {
          // }
      }
    }

    var scrollToEnd = function () {

      scrollHight = scrollHight + 80;
      $('.chat-discussion').scrollTop(scrollHight);

    }
    //——————————————————————————————————————————————————

    //ajax请求
    //——————————————————————————————————————————————————
    var getUserList = function() {
        console.log("getUserlist");
        $.ajax({
          type: 'get',
          url: 'getUserList',
          data: {},
          success: function(msg) {
            ret = JSON.parse(msg);
            if (ret['status'] === true) {
              userlist = ret.data;
              user = ret.user;
              user.uid = ret.uid;
              start();
            }
          },
          error: function() {
            console.log("发送请求失败: getUserList");
          }

        });
      }
      //——————————————————————————————————————————————————

    //事件处理函数
    //——————————————————————————————————————————————————
    var initChat = function(data) {
      console.log('----initChat');
      console.log(data);
      for (var i of data.messagelist) {
        initHistoryMessage(i);
      }
    }

    var getNewMessage = function(data) {
      var mid = data.mid;
      var uid = data.uid;
      var state = data.state;
      var visibility = data.visibility;
      var isread = data.isread;
      var timestamp = data.timestamp;
      var receive_uids = data.receive_uids;
      var body = data.body;

      insertReceiveContent(data);
      sendAlreadyRead(mid);
    }

    var initHistoryMessage = function(data) {
      var mid = data.mid;
      var uid = data.uid;
      var state = data.state;
      var visibility = data.visibility;
      var isread = data.isread;
      var timestamp = data.timestamp;
      var receive_uids = data.receive_uids;
      var body = data.body;


      if(uid == user.uid) {
        insertContent(data);
      }

      if (uid == receiveUser.uid) {
        insertReceiveContent(data);
      }

      if(data.isread == 0) {
        sendAlreadyRead(mid);
      } 
    }

    var getEnterkey = function() {
      var msg;
      $(".message-input").keydown(function(event) {
        msg = $(".message-input").val();
        if (event.keyCode == 13) {
          var temp = {};
          temp.body =  msg;
          temp.timestamp = getNowTime();
          insertContent(temp);
          createNotice(msg);

          //等最后一个空格输出后,再清空所有内容
          setTimeout(function() {
            $(".message-input").val("");
          }, 0);
        }
      })
    }

    //——————————————————————————————————————————————————

    //客户端事件
    //——————————————————————————————————————————————————
    var sendAlreadyRead = function(_mid) {
      console.log("Emit: already read");
      socket.emit('already read', {
        userId: user.uid,
        mid: _mid,
      });
    }

    var createNotice = function(words) {
      var _noticebody = words + '';
      //0代表私信
      var _visibility = 0;
      var _receive_uids = receiveUser.uid + '';
      socket.emit('create notice', {
        userId: user.uid,
        noticebody: _noticebody,
        visibility: _visibility,
        receiveUser: _receive_uids
      });
    }
    //检查与指定用户之间是否还有新信息（主要是在对话窗口）
    var checkMessage = function() {
      console.log("receiveUser.uid: ");
      console.log(receiveUser);
      console.log(receiveUser.uid);
      if(receiveUser != "undefine") {
        console.log("Emit : check message");
        socket.emit('check message', {
          userId: user.uid,
          receiveUser: receiveUser.uid
        });
      }

    }

    //包括私信以及通知
    var checkUnread = function() {
      console.log("check Unread");
      socket.emit('check unread', {
        userId: user.uid
      })
    }

    var getChatHistory = function() {
      socket.emit('new chat', {
        userId: user.uid,
        receiveUser: receiveUser.uid
      });
    }


    var updateUserList = function() {
      $('.users-list').empty();
      console.log("updateUserList");

      console.log(allUser);
      console.log(messagelist);
      //处理有新消息的好友
      for (var msg of messagelist) {
        allUser[msg.uid].msgnums++;
      }

      //将有新消息的好友提前
      allUser.sort(function(user1, user2) {
        return parseInt(user2.msgnums,10) - parseInt(user1.msgnums, 10);
      });

      //进行dom操作
      allUser.forEach(function(temp,index){  
        insertUserList(temp, index);
      })
    }

    var addUserList = function() {
      console.log("addUserList");
      allUser = [];
      user.avatar = protocol + '//' + url + '/upload/avatar/sm_' + user.avatar; 

      //处理allUser为以uid为索引的userlist
      for (var _user of userlist) {
        realavatar = protocol + '//' + url + '/upload/avatar/sm_' + _user.avatar;
        _user.avatar = realavatar;
        if(_user.uid != user.uid) {
          allUser[_user.uid] = {
            name: _user.name,
            uid: _user.uid,
            avatar: _user.avatar,
            level: _user.level,
            msgnums: 0
          };
        }
      }

      console.log(allUser);
      //进行dom操作
      allUser.forEach(function(temp,index){  
        insertUserList(temp, index);
      })
    }


    var start = function() {
      // checkUnread();
      addUserList();
      getEnterkey();
    }

    //检查unread，然后得到new notice进行初始化
    getUserList();

// 主要事件，都围绕是创建一个通知便条，或者是创建一个聊天窗口来进行
// 
// emit
// ----create notice
// --------通知，创建一个通知（私信或者广播）
//         $userId
//         $noticebody
//         $visibility
//         $receive_uids

// ----check unread
// --------通知，检查未读通知
//          $userId

// ----already read
// --------通知，写入通知已读标记
//         $userId
//         $mid

// ----new chat
// --------聊天窗口：获取对话历史纪录
//         $userId
//         $receiveUser

// ----check message
// --------聊天窗口：检查新对话
//         $userId
//         $receiveUser

// on
// ----check new notice
// --------全体：通知，创建完通知后，广播全体，检查当前是否有新消息

// ----new notice
// --------个人：通知，当检查当前有未读通知是，广播个人未读通知
//         'notice' => $noticelist
//         'user' => $userId;

// ----init chat
// --------个人：聊天窗口，发回个人聊天记录
//         messagelist => $history;

// ----new message
// --------个人：聊天窗口，发回新消息
//         'msg'->msg;
//         
//  
// 过程描述       
// 客户端：用户输入后->触发create notice


// 服务端收到：create notice -> 广播全体check new message

// 客户端收到：check new message -> 触发check message，检查与当前聊天的用户是否有新消息

// 服务端：收到check message -> 拿去数据, 有新消息（无消息则终止） -> 触发new message
