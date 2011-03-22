{function numfield fid='' val=1}
  <input type="text" name="{$fid}" id="{$fid}" value="{$val}" size="2" />
  <label for="{$fid}">{$fid}</label>
  <input type="button" value="+" onclick="increase( '{$fid}' )" size="1" />
  <input type="button" value="-" onclick="decrease( '{$fid}' )" size="1" />
  <br />
{/function}

{function textfield fid='' label='' content=''}
  <label for="{$fid}">{$label}</label><br />
  <textarea rows="6" cols="40" id="{$fid}" name="{$fid}">{$content}</textarea><br />
{/function}


<div class="new_card">
 <form method="post"
 {if isset( $smarty.get.edit_card )}{* if an existing card is edited *}
  action="?edit_card_submit={$smarty.get.edit_card}"
 {else}
  action="?new_card_submit"
 {/if} >
  <fieldset><legend>Create a new card</legend>
   <input type="text" name="cardname" id="cardname" value="{$card -> name}" />
   <label for="cardname">Name for new card</label><br />

{html_options name='faction' options=$factionsoptions selected=$card -> faction}
   <label for="faction">Faction of card</label><br />

{html_options name='cardtype' options=$typeoptions selected=$card -> type}
   <label for="cardtype">Type of card</label><br />

  <input type="text" name="subtype" id="subtype" value="{$card -> subtype}" />
  <label for="subtype">Subtype</label><br />

{numfield fid='cost' val=$card -> cost}
{numfield fid='threshold' val=$card -> threshold}
{numfield fid='attack' val=$card -> attack} 
{numfield fid='defense' val=$card -> defense}

{textfield fid='rules' label='rule text' content=$card -> rules}
{textfield fid='flavor' label='flavor text' content=$card -> flavor}
{textfield fid='imgdesc' label='card image description' content=$card -> image}
{textfield fid='reply_text' label='initial comment for card idea/change'}

   <input type="checkbox" name="concept" id="concept" />
   <label for="concept">Only a concept. Not a real card</label><br />

   <input type="submit"
   {if isset( $smarty.get.edit_card )}
    value="save new version of card"
   {else}
    value="propose new card"
   {/if} />
  </fieldset>
 </form>
</div>
