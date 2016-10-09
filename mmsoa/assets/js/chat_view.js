var user = {};
var receiveUser = {};
var allUser = [];
var userlist = [];
var noticelist = [];
var messagelist = [];

var url = window.location.host;
var protocol = window.location.protocol + '';
socketurl = protocol + '//' + url + ':2022';
var socket = io('http://'+document.domain+':2020').connect();

    //——————————————————————————————————————————————————
    //服务端事件
    //——————————————————————————————————————————————————
      socket.on('newnotice', function(data) {
        console.log("new notice");
        noticelist = data.noticelist;
        messagelist = data.messagelist;
        //拉取用户列表
        console.log(messagelist);
        updateUserList();
      });
    //拉取历史纪录
    socket.on('initchat', function(data) {
      console.log('----init chat');
      initChat(data);
    });

    socket.on('newmessage', function(data) {
      console.log('----new message');
      getNewMessage(data);
    });

    socket.on('checknewnotice', function(data) {
      checkMessage(receiveUser.uid);
    });

    //——————————————————————————————————————————————————
    //DOM操作
    //——————————————————————————————————————————————————
    //插入一句我的话
    var insertContent = function(str) {
      var temp =
        '<div class=\"chat-message\">' +
        '    <img class=\"message-avatar-right\" src=\"' + user.avatar + '\" alt=\"\">' +
        '    <div class=\"message-right\">' +
        '        <a class=\"message-author\"> ' + user.name + '</a>' +
        '        <span class=\"message-date-right\"> ' + getNowTime() + ' </span>' +
        '        <span class=\"message-content\">' + str + '</span>' +
        '    </div>' +
        '</div>';
      console.log(temp);
      $('.chat-discussion').append(temp);
    }

    //插入一句对方的话
    var insertReceiveContent = function(str) {

      let temp =
        '<div class=\"chat-message\" >' +
        '    <img class=\"message-avatar-left\" src=\"' + receiveUser.avatar + '\" alt=\"\">' +
        '    <div class=\"message-left\">' +
        '        <a class=\"message-author\"> ' + receiveUser.name + '</a>' +
        '        <span class=\"message-date-left\"> ' + getNowTime() + ' </span>' +
        '        <span class=\"message-content\">' + str + '</span>' +
        '    </div>' +
        '</div>';
      $('.chat-discussion').append(temp);
    }

    var insertUserList = function(_user, index) {
        var msgnums = '';
        if(_user.msgnums != 0) {
          msgnums = _user.msgnums + '';
        }
        let temp =
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
      var date = new Date();
      var str = '';
      str = date.toLocaleTimeString();
      return str;
    }

    var choseReceiveUser = function(index) {
      receiveUser = allUser[index];
      //clear对话框
      $('.chat-discussion').empty();
      if(receiveUser.msgnums != 0) {
        for(var i of messagelist) {
          console.log(i);
          console.log(i.receive_uids == user.uid);
          if (i.receive_uids == user.uid) {
            insertReceiveContent(i.body);
            sendAlreadyRead(i.mid);
          }
        }
      }
      else {
        insertReceiveContent("我们可以进行聊天啦～");
      }
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
    var initChat = function() {}

    var getNewMessage = function(data) {
      var mid = data.mid;
      var uid = data.uid;
      var state = data.state;
      var visibility = data.visibility;
      var isread = data.isread;
      var timestamp = data.timestamp;
      var receive_uids = data.receive_uids;
      var body = data.body;

      insertReceiveContent(body);
      sendAlreadyRead(mid);
    }


    var getEnterkey = function() {
      var msg;
      $(".message-input").keydown(function(event) {
        msg = $(".message-input").val();
        if (event.keyCode == 13) {
          console.log(msg);
          insertContent(msg);
          createNotice(msg);
          $(".message-input").val('');
        }
      })
    }

    //——————————————————————————————————————————————————

    //客户端事件
    //——————————————————————————————————————————————————
    var sendAlreadyRead = function(_mid) {
      socket.emit('alreadyread', {
        userId: user.uid,
        mid: _mid,
      });
    }

    var createNotice = function(words) {
      var _noticebody = words + '';
      //0代表私信
      var _visibility = 0;
      var _receive_uids = receiveUser.uid + '';
      socket.emit('createnotice', {
        userId: user.uid,
        noticebody: _noticebody,
        visibility: _visibility,
        receive_uids: _receive_uids
      });
    }
    //检查与指定用户之间是否还有新信息（主要是在对话窗口）
    var checkMessage = function(receiveUser) {
      socket.emit('checkmessage', {
        userId: user.uid,
        receiveUser: receiveUser.uid
      });
    }

    //包括私信以及通知
    var checkUnread = function() {
      console.log("checkUnread");
      socket.emit('checkunread', {
        userId: user.uid
      })
    }

    var getChatHistory = function() {
      socket.emit('newchat', {
        userId: user.uid,
        receiveUser: receiveUser.uid
      });
    }


    var updateUserList = function() {
      $('.users-list').empty();
      console.log("updateUserList");

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
      user.avatar = protocol + '//' + url + '/OA/mmsoa/upload/avatar/sm_' + user.avatar; 

      //处理allUser为以uid为索引的userlist
      for (var _user of userlist) {
        realavatar = protocol + '//' + url + '/OA/mmsoa/upload/avatar/sm_' + _user.avatar;
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

      //进行dom操作
      allUser.forEach(function(temp,index){  
        insertUserList(temp, index);
      })
    }





    //checkUnread会触发new notice，之后调用getUserlist
    //getUserlist在拉取数据后，会回调strat
    var start = function() {
      checkUnread();
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
//         'history' => $history;

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