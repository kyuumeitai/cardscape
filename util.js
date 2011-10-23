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

function show_comments( comments ) {
	var nodes = new Array(); //comment.id->pos in comments
	for( i = 0; i < comments.length; i++ ) {
		nodes[ comments[ i ].id ] = i;
	}

	var show_comment = function ( comment ) {
		var ret = '<div class="js_comment" ' +
			'id="comment_' + comment.id + '">' +
			'<em>' + comment.author +
			    ' wrote on ' +
			    comment.date +
			    ':</em><hr />' +
			    comment.text +
			    '<hr />&rightarrow; Direct replies (<a ' +
			    'href="" onclick="return toggle_answers( \'' +
			    comment.id + '\', this );">show</a>):';

		if( comment.children.length == 0 ) {
			ret += '<em>None</em>';
		} //else enter loop
		for( var i = 0; i < comment.children.length; i++ ) {
			var child_id = comment.children[ i ];
			var child = comments[ nodes[ child_id ] ];
			ret += show_comment( child );
		}
		ret += '</div>'; //TODO reply form
		return ret;
	}
	
	if( comments.length > 0 ) {
		outarea = document.getElementById( 'js_comment_area' );
		outarea.innerHTML = show_comment( comments[ 0 ] );
	} else {
		//this should never happen since there is always in initial comment for a card in a DB
		//TODO still handle this case
	}
}

function toggle_answers( comment_id, link ) {
	var id = 'comment_' + comment_id;
	var comment = document.getElementById( id );

	link.innerHTML = ( link.innerHTML == 'show' )? 'hide' : 'show';

	for( i = 0; i < comment.childNodes.length; i++ ) {
		node = comment.childNodes[ i ];
		if( node.nodeName == 'DIV' ) {
			if( node.style.display == 'block' ) {
				node.style.display = 'none';
			} else {
				node.style.display = 'block';
			}
		}
	}
	return false; //do not follow link
}
