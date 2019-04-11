<?php

$listTable = new List_Table_Server();
$listTable->prepare_items();

?>

<div class="wrap">
    <h2>Últimas analises</h2>
    <form id="movies-filter" method="get">
        <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
        <?php $listTable->display() ?>
    </form>
</div>