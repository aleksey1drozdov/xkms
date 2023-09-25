<?php
declare(strict_types=1);

/**
* @var array $mysqlData
* @var array $clickhouseData
*/
?>
<div style="display: inline-block; width: 100%">
    <div style="display: inline-block; float: left">
        <table border="1">
            <thead>
            <tr>
                <th colspan="5">Mysql</th>
            </tr>
            <tr>
                <th>минута группировки</th>
                <th>количество строк за минуту</th>
                <th>средняя длина контента</th>
                <th>время первого</th>
                <th>время последнего</th>
            </tr>
            </thead>
            <tbody>
            <?foreach ($mysqlData as $row):?>
            <tr>
                <td><?=$row['created_minute']?></td>
                <td><?=$row['count']?></td>
                <td><?=(int)$row['avg']?></td>
                <td><?=$row['min_created_at']?></td>
                <td><?=$row['max_created_at']?></td>
            </tr>
            <?endforeach;?>
            </tbody>
        </table>
    </div>
    <div style="display: inline-block; float: right">
        <table border="1">
            <thead>
            <tr>
                <th colspan="5">Clickhouse</th>
            </tr>
            <tr>
                <th>минута группировки</th>
                <th>количество строк за минуту</th>
                <th>средняя длина контента</th>
                <th>время первого</th>
                <th>время последнего</th>
            </tr>
            </thead>
            <tbody>
            <?foreach ($clickhouseData as $row):?>
                <tr>
                    <td><?=$row['created_minute']?></td>
                    <td><?=$row['count']?></td>
                    <td><?=(int)$row['avg']?></td>
                    <td><?=$row['min_created_at']?></td>
                    <td><?=$row['max_created_at']?></td>
                </tr>
            <?endforeach;?>
            </tbody>
        </table>    </div>
</div>
