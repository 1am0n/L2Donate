function popitup(url) {
	newwindow=window.open(url, 'name', 'height=300,width=750, status = 1, scrollbars=1, resizable=1');
	if (window.focus) {newwindow.focus()}
	return false;
}

function resize()
{
	window.moveTo(0,0);
	top.window.resizeTo(screen.availWidth,screen.availHeight);
	return true;
}