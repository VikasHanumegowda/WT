<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

   // if (isset($_GET['submit'])) {
       // $symbol = test_input($_GET["symbol"]);
        $symbol = 'AAPL';
        $data = json_decode("{}");
        $url_for_alphavantage = "https://www.alphavantage.co/query?function=TIME_SERIES_DAILY&symbol=" . $symbol . "&interval=daily&outputsize=full&apikey=OGY0S9LG8J8ADNZW";
        $response_from_alphavantage = file_get_contents($url_for_alphavantage);
        if ($response_from_alphavantage === false) {
            header('Content-Type: application/json');
            echo json_encode(json_decode("{}"));
        }
        header('Content-Type: application/json');
        echo $response_from_alphavantage;
        $data['alphavantage'] = $response_from_alphavantage;

        $url_for_stoch = "https://www.alphavantage.co/query?function=STOCH&symbol=" . $symbol . "&interval=daily&outputsize=compact&time_period=10&slowkmatype=1&slowdmatype=1&apikey=OGY0S9LG8J8ADNZW";
        $response_for_stoch = @file_get_contents($url_for_stoch);
        if ($response_for_stoch === false) {
            header('Content-Type: application/json');
            echo json_encode(json_decode("{}"));
        }
        $data['stoch'] = $response_for_stoch;

        $url_for_bbands = "https://www.alphavantage.co/query?function=BBANDS&symbol=" . $symbol . "&interval=daily&time_period=5&series_type=close&nbdevup=3&nbdevdn=3&apikey=OGY0S9LG8J8ADNZW";
        $response_for_bbands = @file_get_contents($url_for_bbands);
        if ($response_for_bbands === false) {
            header('Content-Type: application/json');
            echo json_encode(json_decode("{}"));
        }
        $data['bbands'] = $response_for_bbands;

        $url_for_sma = "https://www.alphavantage.co/query?function=SMA&symbol=" . $symbol . "&interval=daily&time_period=10&series_type=close&apikey=OGY0S9LG8J8ADNZW";
        $response_for_sma = @file_get_contents($url_for_sma);
        if ($response_for_sma === false) {
            header('Content-Type: application/json');
            echo json_encode(json_decode("{}"));
        }
        $data['sma'] = $response_for_sma;

        $url_for_ema = "https://www.alphavantage.co/query?function=EMA&symbol=" . $symbol . "&interval=daily&time_period=10&series_type=close&apikey=OGY0S9LG8J8ADNZW";
        $response_for_ema = @file_get_contents($url_for_ema);
        if ($response_for_ema === false) {
            header('Content-Type: application/json');
            echo json_encode(json_decode("{}"));
        }
        $data['ema'] = $response_for_ema;

        $url_for_rsi = "https://www.alphavantage.co/query?function=RSI&symbol=" . $symbol . "&interval=daily&time_period=10&series_type=close&apikey=OGY0S9LG8J8ADNZW";
        $response_for_rsi = @file_get_contents($url_for_rsi);
        if ($response_for_rsi === false) {
            header('Content-Type: application/json');
            echo json_encode(json_decode("{}"));
        }
        $data['rsi'] = $response_for_rsi;

        $url_for_adx = "https://www.alphavantage.co/query?function=ADX&symbol=" . $symbol . "&interval=daily&time_period=10&apikey=OGY0S9LG8J8ADNZW";
        $response_for_adx = @file_get_contents($url_for_adx);
        if ($response_for_adx === false) {
            header('Content-Type: application/json');
            echo json_encode(json_decode("{}"));
        }
        $data['adx'] = $response_for_adx;

        $url_for_cci = "https://www.alphavantage.co/query?function=CCI&symbol=" . $symbol . "&interval=daily&time_period=10&apikey=OGY0S9LG8J8ADNZW";
        $response_for_cci = @file_get_contents($url_for_cci);
        if ($response_for_cci === false) {
            header('Content-Type: application/json');
            echo json_encode(json_decode("{}"));
        }
        $data['cci'] = $response_for_cci;

        $url_for_macd = "https://www.alphavantage.co/query?function=MACD&symbol=" . $symbol . "&interval=daily&time_period=10&series_type=close&apikey=OGY0S9LG8J8ADNZW";
        $response_for_macd = @file_get_contents($url_for_macd);
        if ($response_for_macd === false) {
            header('Content-Type: application/json');
            echo json_encode(json_decode("{}"));
        }
        $data['macd'] = $response_for_macd;

        $url_for_news = "https://seekingalpha.com/api/sa/combined/\" . $symbol . \".xml\"";
        $response_for_news = @file_get_contents($url_for_news);
        if ($response_for_news === false) {
            header('Content-Type: application/json');
            echo json_encode(json_decode("{}"));
        }
        $data['news'] = $response_for_news;

        echo json_decode(json_encode($data));
//}
?>