function $( id ) {
	return document.getElementById( id );
}

function increase( fid ) {
	field = $( fid );
	field.value = parseInt( field.value ) + 1;
}

function decrease( fid ) {
	field = $( fid );
	field.value = parseInt( field.value ) - 1;
}

current_highlight = null;
function highlight_comment( id ) {
	if( current_highlight ) {
		current_highlight.style.backgroundColor = null;
	}
	current_highlight = $( id );
	current_highlight.style.backgroundColor = 'yellow';
	return true;
}
