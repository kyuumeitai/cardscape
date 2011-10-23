<div class="official_card">
<h1>{$card -> name}</h1>
<div>
 <img src="cardimg.php?name={$official_data.img_url}" alt="{$card -> name}" />
</div>
<table>
 <thead>
  <tr><td>Card id</td><td>revision</td><td>development id</td></tr>
 </thead>
 <tbody>
  <tr>
   <td>{$official_data.id}</td>
   <td>
    <a href="?show_revisions={$official_data.id}">{$official_data.revision}</a>
   </td>
   <td><a href="?show_card={$card -> id}">{$card -> id}</a></td>
  </tr>
 </tbody>
</table>
 This is an official card<br />
 TODO: more information and Discussion board
</div>
