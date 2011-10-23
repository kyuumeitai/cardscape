<div id="js_comment_area"></div>
<script type="text/javascript">
var comments = new Array();

{foreach $comments as $c}
 comments.push(
	{
	id: {$c -> id},
 	parent_id: {$c -> parent},
 	children: [ {join( ',', $c -> children )} ],
 	author: '{htmlspecialchars($c -> name)}',
 	date: '{$c -> date}',
 	text: '{htmlspecialchars($c -> text, $smarty.const.ENT_QUOTES )}' } );
{/foreach}
show_comments( comments );
</script>
<div><a href="?disable_js&show_card={$card -> id}">disable JavaScript</a></div>
