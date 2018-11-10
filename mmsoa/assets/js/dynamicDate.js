/**
 * 实时动态时间
 */
/* Dynamic date */
function startTime() { 
	var today=new Date(); 
	var strDate=(" "+(today.getFullYear())+"年"+(today.getMonth()+1)+"月"+today.getDate()+"日"); 
	var n_day=today.getDay(); 
	switch(n_day) {
		case 0: 
		{strDate=strDate+" 星期日 "}break; 
		case 1: 
		{strDate=strDate+" 星期一 "}break; 
		case 2: 
		{strDate=strDate+" 星期二 "}break; 
		case 3: 
		{strDate=strDate+" 星期三 "}break; 
		case 4: 
		{strDate=strDate+" 星期四 "}break; 
		case 5: 
		{strDate=strDate+" 星期五 "}break; 
		case 6: 
		{strDate=strDate+" 星期六 "}break; 
		case 7: 
		{strDate=strDate+" 星期日 "}break; 
	} 
	//增加时分秒 
	// add a zero in front of numbers<10 
	var h=today.getHours(); 
	var m=today.getMinutes(); 
	var s=today.getSeconds() 
	m=checkTime(m); 
	s=checkTime(s); 
	strDate=strDate+" "+h+":"+m+":"+s; 
	document.getElementById('time').innerHTML=strDate; 
	t=setTimeout('startTime()',500) 
} 

function checkTime(i) { 
	if (i<10) {i="0" + i} 
	return i 
}