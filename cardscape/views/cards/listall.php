<h2>Card browser</h2>
<p>
    Cardscrape distinguishes between official cards and cards in the development 
    area. All official cards can also be found in the development area. If you 
    are only interested in official cards, have a look at the 
    <a href="<?php echo $this->createUrl('cards/browse', array('catalogue' => 'official')); ?>">
        official cards catalogue
    </a>.
</p>

<?php
$this->widget('zii.widgets.CListView', array(
    'dataProvider' => $dataProvider,
    'itemView' => '_cardrow'
));
?>

<!-- 
<table class="cardbrowser">
    <thead>
        <tr>
            <th>Card Name</th>
            <th>Author</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        {foreach $cards as $card}
        <tr>
            <td><a href="?show_card={$card -> id}">{$card -> name}</a></td>
            <td>{$card -> author}</td>
            <td>{$card -> date}</td>
        </tr>
        {/foreach}
    </tbody>
</table>
{if $offset}
<a href="?browse={$offset - $pagesize}">Previous {$pagesize}</a>
{/if}
{if count( $cards ) == $pagesize}
<a href="?browse={$offset + $pagesize}">Next {$pagesize}</a>
{/if}
-->