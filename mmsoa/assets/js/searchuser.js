/**
 * 查看用户列表
 */
function showMore(evt){
  var obj = window.event?event.srcElement:evt.target;
  document.cookie = "index="+ obj.value;
}