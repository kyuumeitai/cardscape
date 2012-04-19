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
          {if isset( $smarty.get.revise_card )}{* if an existing card is revised *}
          action="?revise_card_submit={$smarty.get.revise_card}"
          {elseif isset( $smarty.get.update_card )}{* if existing card is changed
          slightly (admin functionality)*}
          action="?update_card_submit={$smarty.get.update_card}"
          {else}
          action="?new_card_submit"
          {/if} >

          <fieldset>
            {if isset( $smarty.get.update_card)}
            <legend>Update existing card (admin function)</legend>
            {else}
            <legend>Create a new card</legend>
            {/if}

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
            {if isset( $smarty.get.update_card)}
            <p class="notice">You can use this page to either change the traits of a card
                and to change its status. If you do the former, please summarize your changes
                below:</p>
            <input type="text" name="admin_update_comment" id="admin_update_comment"
                   size="31" />
            <label for="admin_update_comment">Summary of changes</label>
            <p class="notice">To change the status of the card, simply select a new status
                from the menu:</p>
            {html_options name='card_status' options=$statusoptions
            selected=$card -> status}
            <label for="card_status">Status of card</label><br />
            <p>Note: Changing this card's status to official does not make it appear in the
                official cards catalogue. Please use the card promotion settings in the
                <a href="?usercp">Admin control panel</a> to manage the official cards. (Using
                a two-step procedure will make the deprecation process of old official cards
                cleaner).</p>

            {else}
            {textfield fid='reply_text' label='initial comment for card idea/change'}
            <input type="checkbox" name="concept" id="concept" />
            <label for="concept">Only a concept. Not a real card</label><br />
            {/if}

            <input type="submit"
                   {if isset( $smarty.get.edit_card ) || isset( $smarty.get.update_card )}
                   value="save new version of card"
                   {else}
                   value="propose new card"
                   {/if} />
        </fieldset>
    </form>
</div>
