async function send_mouse_position(e) {
	let params = new URLSearchParams({
		'x': e.pageX,
		'y': e.pageY,
		'ts': Math.floor(Date.now()/1000),
		'site': window.location.hostname,
		'page': window.location.pathname,
	}).toString();
	let url = '//filipponik.tk/get_info.php';

	let res = await fetch(url+'?'+params);
	let json_res = await res.json();
	if (res.ok && json_res.status == 'success')
		return true;
	else if (json_res.status == 'error')
		return json_res.error_text;

	return false;
}
document.onclick = function (e) {
	end_mouse_position(e);
};