<h3>Card history</h3>
<table class="card_history">
 <thead>
  <tr><th>time</th><th>user</th><th>action</th></tr>
 </thead>
 <tbody>
 {foreach $hist_entries as $entry}
  <tr><td>{$entry.date}</td><td>{$entry.name}</td><td>{$entry.action}</td></tr>
 {/foreach}
 </tbody>
</table>
