<div class="reply_sheet">
 <form name="comment_reply" id="comment_reply" method="post" action="?comment_reply_submit={$reply_to}">
  <fieldset><legend>Write a reply</legend>
   <textarea rows="20" cols="60" id="reply_text" name="reply_text"></textarea>
   <br />
   <input type="submit" value="reply">
  </fieldset>  
 </form>
 <table>
  {foreach $comments as $c}
  <tr><td>{$c.name}<br />{$c.date}</td><td>{$c.text}</td></tr>
  {/foreach}
 </table>
</div>
