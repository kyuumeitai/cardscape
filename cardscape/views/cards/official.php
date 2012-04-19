<h2>Official cards catalogue</h2>

<table class="cardbrowser">
    <thead>
        <tr>
            <th>Card id</th>
            <th>Card revision</th>
            <th>Card name</th>
            <th>Faction</th>
        </tr>
    </thead>
    <tbody>
        {foreach $cards as $card}
        <tr>
            <td>{$card -> id}</td>
            <td>{$card -> revision}</td>
            <td><a href="?show_official_card={$card -> id}">{$card -> name}</a></td>
            <td>{$card -> faction}</td>
        </tr>
        {/foreach}
    </tbody>
</table>
