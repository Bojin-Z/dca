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
            ['2024-09-30', 5000, 64520, 0.01115],
            ['2024-10-31', 5000, 71142, 0.00991],
            ['2024-11-28', 5000, 95640, 0.00720],
            ['2024-12-30', 5000, 93830, 0.00733]
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

        // 使用 cURL 抓取网页内容
        function getExchangeRate() {
            $url = 'https://v6.exchangerate-api.com/v6/ea5008a67b6df50f3b2c55cd/latest/USD';
            $response = file_get_contents($url);
            $data = json_decode($response, true);
            $rate = $data["conversion_rates"]["CNY"];
            // 检查响应内容
            if ($response === false) {
                return null;
            } else {
                return $rate;
            }
        }
        
        // 获取汇率
        $rate = getExchangeRate();
        echo "<tr class='total-row'>";
        echo "<td>总计</td>";
        echo "<td>$total_fiat</td>";
        echo "<td>均价($): ".round($total_fiat/$total_bitcoin/$rate,0)."</td>";
        echo "<td>$total_bitcoin</td>";
        echo "</tr>";
        ?>
    </table>

    <h2>当前比特币价格 - <? echo "$current_time"; ?></h2>
    <p><?php echo number_format($current_price, 2); ?> 美元</p>

    <h2>总市值</h2>
    <p>总购买的比特币按当前价格计算的总市值: <?php echo number_format($total_market_value*$rate, 2); ?> 人民币</p>
    
    <h2>浮动盈亏</h2>
    <p><?php
    if ($total_market_value*$rate > 0) {
        echo "<b>+</b>";
    } else {
        echo "<b>-</b>";
    }
    echo "<b>".number_format(($total_market_value*$rate-$total_fiat), 2)."</b>";
    ?> 人民币</p>
</body>
</html>