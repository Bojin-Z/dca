<!DOCTYPE html>
<html>
<head>
    <title>棒棒妈妈的比特币定投记录</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
            padding: 5px;
        }
        .total-row {
            color: red;
        }
    </style>
</head>
<body>
    <h1>棒棒妈妈的比特币定投记录</h1>
    <table>
        <tr>
            <th>日期</th>
            <th>投入法币数量<br>(RMB)</th>
            <th>买入时比特币价格<br>(USDT)</th>
            <th>买入比特币数量<br></th>
        </tr>
        <?php
        // 示例数据,您可以将其替换为实际的数据库查询结果
        $records = [
            ['2024-03-28', 5000, 70753, 0.00961],
            ['2024-05-23', 5200, 69472, 0.01041],
            ['2024-06-06', 5000, 71552, 0.00961],
            ['2024-06-24', 5000, 61347, 0.01116],
            ['2024-07-07', 5000, 56816, 0.0121],
            ['2024-08-01', 5000, 65696, 0.01048],
            ['2024-08-30', 5000, 59070, 0.0119],
        ];

        $total_fiat = 0;
        $total_bitcoin = 0;

        foreach ($records as $record) {
            echo "<tr>";
            echo "<td>{$record[0]}</td>";
            echo "<td>{$record[1]}</td>";
            echo "<td>{$record[2]}</td>";
            echo "<td>{$record[3]}</td>";
            echo "</tr>";

            $total_fiat += $record[1];
            $total_bitcoin += $record[3];
        }

        // 调用API获取当前比特币价格
        date_default_timezone_set('Asia/Shanghai');
        $current_time = date('Y-m-d H:i:s');
        $api_url = "https://api.coindesk.com/v1/bpi/currentprice.json";
        $response = file_get_contents($api_url);
        $data = json_decode($response, true);
        $current_price = $data["bpi"]["USD"]["rate_float"];
    
        $total_market_value = $total_bitcoin * $current_price;

        echo "<tr class='total-row'>";
        echo "<td>总计</td>";
        echo "<td>$total_fiat</td>";
        echo "<td>均价(RMB): ".round($total_fiat/$total_bitcoin,0)."</td>";
        echo "<td>$total_bitcoin</td>";
        echo "</tr>";
        ?>
    </table>

    <h2>当前比特币价格 - <? echo "$current_time"; ?></h2>
    <p><?php echo number_format($current_price, 2); ?> 美元</p>

    <h2>总市值</h2>
    <p>总购买的比特币按当前价格计算的总市值: <?php echo number_format($total_market_value, 2); ?> 美元</p>
</body>
</html>