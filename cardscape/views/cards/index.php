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
    'dataProvider' => $filter->search(),
    'itemView' => '_cardrow'
));