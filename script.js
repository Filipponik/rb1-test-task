
window.onload = function() {
	document.onclick = function (e) {
		let info = {
			'x': e.pageX,
			'y': e.pageY,
			'timestamp': Math.floor(Date.now()/1000)
		}
		console.log(info);
		// Передаём name и surname в параметрах запроса

		var xhr = new XMLHttpRequest();

		var params = 'x=' + encodeURIComponent(info.x) +
		  '&y=' + encodeURIComponent(info.y) + '&ts=' + encodeURIComponent(info.timestamp);

		xhr.open("GET", '//filipponik.tk/get_info.php?' + params, true);

		//xhr.onreadystatechange = ...;

		xhr.send();
    	//const LINE_COLOR = 'black';
    	//const LINE_WIDTH = 1;
    	var canvas = document.getElementById('canvas');
		if (canvas.getContext) {
		    var ctx = canvas.getContext('2d');

		    ctx.beginPath();
		    ctx.arc(info.x, info.y, 20, 0, Math.PI * 2, true);
			ctx.stroke();
		}
	}
};