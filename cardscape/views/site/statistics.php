<div class="statistics">
    <h3>{$field}</h3>
    <table>
        <thead>
            <tr><th>what</th><th>how many</th></tr>
        </thead>
        <tbody>
            {foreach $counts as $count}
            <tr>
                <td>{$count@key}</td><td>{$count}</td>
            </tr>
            {/foreach}
        </tbody>
    </table>
</div>