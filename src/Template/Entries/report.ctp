<html>
    <body>
        <table>
            <caption>For the year ended <?= $year_end->i18nFormat('dd MMM yyyy')?></caption>
            <thead>
                <tr>
                    <th>Code</th><th>Name</th>
                    <th><?= $year_end->year?></th>
                    <th><?= $year_end->year-1?></th>
                </tr>
            </thead>
            <tbody>
<?php ksort($results);?>
<?php foreach ($results as $code=>$result): ?>
<?php 
    $current = array_key_exists('current', $result) ? $result['current'] : '';
    $last = array_key_exists('last', $result) ? $result['last'] : '';
    $factor = preg_match('/^[234]/', $code) ? 1 : -1;
?>
    <?= $this->Html->tablecells([
        $code, $result['name'], $current * $factor, $last * $factor
    ]); ?>
<?php endforeach;?>
            </tbody>
            <tfoot><tr><td>
                As at <?= $year_end->i18nFormat('dd MMM yyyy')?>
            </td></tr></tfoot>
        </table>
    </body>
</html>