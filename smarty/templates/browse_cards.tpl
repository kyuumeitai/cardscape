<h2>Card browser</h2>
<table class="cardbrowser">
 <thead>
  <tr><th>Card name</th><th>Author</th><th>date</th></tr>
 </thead>
 <tbody>
 {foreach $cards as $card}
 <tr>
  <td><a href="?show_card={$card -> id}">{$card -> name}</a></td>
  <td>{$card -> author}</td>
  <td>{$card -> date}</td>
 </tr>
 {/foreach}
 </tbody>
</table>
{if $offset}
 <a href="?browse={$offset - $pagesize}">Previous {$pagesize}</a>
{/if}
{if count( $cards ) == $pagesize}
 <a href="?browse={$offset + $pagesize}">Next {$pagesize}</a>
{/if}
