<h2>Card details</h2>
<div class="card">
	<span class="cardimg">
		<img src="cardimg.php?card={$card -> id}" alt="{$card -> name}" />
	</span><span class="cardinfo">
		<table>
			<tr><td>Name</td><td>{$card -> name}</td></tr>
			<tr><td>Status</td><td>{$card -> status}</td></tr>
			<tr><td>Cost</td><td>{$card -> cost}</td></tr>
			<tr><td>Threshold</td><td>{$card -> threshold}</td></tr>
			<tr><td>Faction</td><td>{$card -> faction}</td></tr>
			<tr><td>Type</td><td>{$card -> type}</td></tr>
			<tr><td>Subtype</td><td>{$card -> subtype}</td></tr>
			<tr><td>Ruletext</td><td>{$card -> rules}</td></tr>
			<tr><td>Flavortext</td><td>{$card -> flavor}</td></tr>
			<tr><td>Image description</td><td>{$card -> image}</td></tr>
		</table>
	</span>
	
</div>
<form method="post" action="?edit_card={$card -> id}">
 <input type="submit" value="Create new version of this card" />
</form>
