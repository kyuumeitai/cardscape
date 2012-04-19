<h3>Recent activity</h3>
<table class="recent_activity">
    <thead>
        <tr><th>time</th><th>card</th><th>user</th><th>action</th></tr>
    </thead>
    <tbody>
        {foreach $hist_entries as $entry}
        <tr>
            <td>{$entry.date}</td>
            <td><a href="?show_card={$entry.card_id}">{$entry.card_name}</a></td>
            <td><a href="?show_user={$entry.user_id}">{$entry.username}</a></td>
            <td>{$entry.action}</td>
        </tr>
        {/foreach}
    </tbody>
</table>
{if $offset}
<a href="?browse={$offset - $pagesize}">Previous {$pagesize}</a>
{/if}
{if count( $hist_entries ) == $pagesize}
<a href="?browse={$offset + $pagesize}">Next {$pagesize}</a>
{/if}
