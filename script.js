window.onload = function() {
	document.onclick = function (e) {
		let info = {
			'x': e.pageX,
			'y': e.pageY,
			'timestamp': Math.floor(Date.now()/1000)
		}
		console.log(info);
		var xhr = new XMLHttpRequest();

		var params = 'x=' + encodeURIComponent(info.x) +
			'&y=' + encodeURIComponent(info.y) +
			'&ts=' + encodeURIComponent(info.timestamp) +
			'&site=' + encodeURIComponent(window.location.hostname) +
			'&page=' + encodeURIComponent(window.location.pathname);

		xhr.open("GET", '//filipponik.tk/get_info.php?' + params, true);
		xhr.send();
	}
};