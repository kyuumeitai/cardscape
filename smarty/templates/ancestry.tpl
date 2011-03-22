<h3>Ancestry</h3>{* TODO integrate card status symbols *}
<div id="ancestor">
 Ancestor:
 {if $ancestor}
  <a href="?show_card={$ancestor -> id}">{$ancestor -> name}</a>
 {else} None
 {/if}
</div>
<div id="decendants">Direct decendants:
 <ul>
  {foreach $descendants as $d}
  <li><a href="?show_card={$d -> id}">{$d -> name}</a></li>
  {/foreach}
 </ul>
<div>
