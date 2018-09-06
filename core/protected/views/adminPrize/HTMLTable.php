
<style>
    html {
        font-family: Arial, Helvetica, sans-serif;
    }
    
    table {
        border-collapse: collapse;
        font-size: 10pt;
    }
    
    table, th, td {
        border: 1px solid #CCC;
    }
</style>

<html>
    <h2>Store Transaction History</h2>
    <table>
        <thead>
            <tr>
                <th>Transaction ID</th>
                <th>User ID</th>
                <th>Username</th>
                <th>Product ID</th>
                <th>Product Name</th>
                <th>Credit Cost</th>
                <th>Shipping Order</th>
                <th>Date</th>
            </tr>
        </thead>
<?php

foreach($transactions as $transaction)
{
    $prize_id = (!is_null($transaction->prize)) ? $transaction->prize->id : 'null';
    $prize_name = (!is_null($transaction->prize)) ? $transaction->prize->name : 'null';
    
    $url = $this->createUrl('adminGame/printInvoice', array('type' => 'product', 'id' => $transaction->id));
    
    echo "<tr>";
    
    echo "<td>".$transaction->id."</td>";
    echo "<td>".$transaction->user->id."</td>";
    echo "<td>".$transaction->user->username."</td>";
    echo "<td>".$prize_id."</td>";
    echo "<td>".$prize_name."</td>";
    echo "<td>".$transaction->credits."</td>";
    echo '<td><a href="'.$url.'">Shipping Order</a></td>';
    echo "<td>".$transaction->created_on."</td>";
    
    echo "</tr>";
}

?>

    </table>
</html>