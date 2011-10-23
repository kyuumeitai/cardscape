<h2>Card browser</h2>
<p>Cardscrape distinguishes between official cards and cards in the development
area. All official cards can also be found in the development area. If you are
ony interested in official cards, have a look at the <a
href="?browse_official_cards">official cards catalogue</a>.</p>

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
