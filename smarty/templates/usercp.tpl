<div class="usercp">
 <form action="?update_user" method="post">
  <fieldset><legend>Change user data</legend>
   <input type="password" name="password" id="password" size="31" />
   <label for="password">New password (leave empty if no changes are intended)</label>
   <br />

   <input type="text" name="mail" id="mail" value="{$user -> mail}" size="31" />
   <label for="mail">E-Mail address</label>
    (<a href="http://gravatar.com">Gravatar-enabled</a>)
   <br />

  </fieldset>
  {if check_permission( 'user', false )}
  <fieldset><legend>Admin user control</legend>
   <input type="text" name="other_uid" id="other_uid" value="{$user -> uid}" />
   <label for="other_uid">UID of user whose settings are changed now</label>
   <br />

   <input type="text" name="user_name" id="user_name" value="{$user -> name}" />
   <label for="user_name">Username</label>
   <br />

   {html_options name='user_status' options=$user_roles selected=$user -> role}
   <label for="user_status">User status</label> (user logout needed for changes to take effect)
   <br />

  </fieldset>
  {/if}
   <input type="submit" />
 </form>
</div>
