<?php

    header('Access-Control-Allow-Origin: *');
    date_default_timezone_set('UTC');
    header('Access-Control-Allow-Methods: GET, POST');
    header("Access-Control-Allow-Headers: X-Requested-With");
    header('Content-Type: application/json');

    $symbol = $_GET['symbol'];
    $second_symbol = $_GET['second'];
    if($second_symbol=='tsd')
    {
        $url_for_alphavantage = "https://www.alphavantage.co/query?function=TIME_SERIES_DAILY&symbol=" . $symbol . "&interval=daily&outputsize=full&apikey=OGY0S9LG8J8ADNZW";
        $response_from_alphavantage = file_get_contents($url_for_alphavantage);
//            if ($response_from_alphavantage === false) {
//                header('Content-Type: application/json');
//                echo json_encode(json_decode("{}"));
//            }
        echo $response_from_alphavantage;
    }
    if($second_symbol=='stoch')
    {
       $url_for_stoch = "https://www.alphavantage.co/query?function=STOCH&symbol=" . $symbol . "&interval=daily&outputsize=compact&time_period=10&slowkmatype=1&slowdmatype=1&apikey=OGY0S9LG8J8ADNZW";
       $response_for_stoch = @file_get_contents($url_for_stoch);
       echo $response_for_stoch;
    }

    if($second_symbol=='bbands')
    {
       $url_for_bbands = "https://www.alphavantage.co/query?function=BBANDS&symbol=" . $symbol . "&interval=daily&time_period=5&series_type=close&nbdevup=3&nbdevdn=3&apikey=OGY0S9LG8J8ADNZW";
       $response_for_bbands = @file_get_contents($url_for_bbands);
       echo $response_for_bbands;
    }

    if($second_symbol=='sma')
    {
       $url_for_sma = "https://www.alphavantage.co/query?function=SMA&symbol=" . $symbol . "&interval=daily&time_period=10&series_type=close&apikey=OGY0S9LG8J8ADNZW";
       $response_for_sma = @file_get_contents($url_for_sma);
       echo $response_for_sma;
    }

    if($second_symbol=='ema')
    {
       $url_for_ema = "https://www.alphavantage.co/query?function=EMA&symbol=" . $symbol . "&interval=daily&time_period=10&series_type=close&apikey=OGY0S9LG8J8ADNZW";
       $response_for_ema = @file_get_contents($url_for_ema);
       echo $response_for_ema;
    }

    if($second_symbol=='rsi')
    {
       $url_for_rsi = "https://www.alphavantage.co/query?function=RSI&symbol=" . $symbol . "&interval=daily&time_period=10&series_type=close&apikey=OGY0S9LG8J8ADNZW";
       $response_for_rsi = @file_get_contents($url_for_rsi);
       echo $response_for_rsi;
    }

    if($second_symbol=='adx')
    {
       $url_for_adx = "https://www.alphavantage.co/query?function=ADX&symbol=" . $symbol . "&interval=daily&time_period=10&apikey=OGY0S9LG8J8ADNZW";
       $response_for_adx = @file_get_contents($url_for_adx);
       echo $response_for_adx;
    }

    if($second_symbol=='cci')
    {
       $url_for_cci = "https://www.alphavantage.co/query?function=CCI&symbol=" . $symbol . "&interval=daily&time_period=10&apikey=OGY0S9LG8J8ADNZW";
       $response_for_cci = @file_get_contents($url_for_cci);
       echo $response_for_cci;
    }

    if($second_symbol=='macd')
    {
       $url_for_macd = "https://www.alphavantage.co/query?function=MACD&symbol=" . $symbol . "&interval=daily&time_period=10&series_type=close&apikey=OGY0S9LG8J8ADNZW";
       $response_for_macd = @file_get_contents($url_for_macd);
       echo $response_for_macd;
    }

    if($second_symbol=='news')
    {
       $url_for_news = "https://seekingalpha.com/api/sa/combined/" . $symbol . ".xml";
       $response_for_news = @file_get_contents($url_for_news);
       $fileContents = str_replace(array("\n", "\r", "\t"), '', $response_for_news);
       $fileContents = trim(str_replace('"', "'", $fileContents));
       $simpleXml = simplexml_load_string($fileContents);
       $json = json_encode($simpleXml);
       echo $json;
    }

?>