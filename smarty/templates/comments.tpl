<h3>Card discussion</h3>
<table class="comments_table">
 {foreach $comments as $c}
 <tr><td>
  <a name="comment{$c -> id}" id="comment{$c -> id}" href="#comment{$c -> id}">{$c -> date}</a><br />
  {$c -> name}<br />{* TODO replace direction symbols with arrows *}

  {if $c -> parent != 0} <a href="#comment{$c -> parent}"
  onclick="highlight_comment( 'comment{$c -> parent}' )"
  title="Go to parent comment">&uarr;</a>{/if}

  {if $c -> elder != null} <a href="#comment{$c -> elder}"
  onclick="highlight_comment( 'comment{$c -> elder}' )"
  title="Go to previous reply to this parent's comment">&larr;</a>{/if}

  {if $c -> younger != null} <a href="#comment{$c -> younger}"
  onclick="highlight_comment( 'comment{$c -> younger}' )"
  title="Go to next reply to this parent's comment">&rarr;</a>{/if}

  {if count( $c -> children ) > 0} <a href="#comment{$c -> children[ 0 ]}"
  onclick="highlight_comment( 'comment{$c -> children[ 0 ]}' )"
  title="Go to first answer to this comment">&darr;</a>{/if}

  </td>
  <td>{$c -> text}<hr /><a href="?comment_reply={$c -> id}">Reply</a></td></tr>
 {/foreach}
</table>
