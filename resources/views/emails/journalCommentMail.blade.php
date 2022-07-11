<html>
<body>
    <p>{{ $details['text_header'] }}</p>
    <p>
        {!! str_repeat('&nbsp;', 5). $details['detail_1'] !!}
        <a href="https://dirrs-ddc.moph.go.th/">{{ $details['link1'] }}</a>
    </p>
    <p>{{ $details['detail_2'] }}</p>
    <label>{{ $details['detail_31'] }}</label><br>
    <label>{{ $details['detail_32'] }}</label><a href="https://youtube.com/watch?v=makbzXb-XHk">{{ $details['link32'] }}</a><br>
    <label>{{ $details['detail_33'] }}</label><a href="https://youtu.be/nrLqUV6e6Ek">{{ $details['link33'] }}</a><br>
    <br>
    <label>{{ $details['text_footer'] }}</label><br>
    <label>{{ $details['text_footer1'] }}</label><br>
    <label>{{ $details['text_footer2'] }}</label><br>
    <label>{{ $details['text_footer3'] }}</label><br>
    <label>{{ $details['text_footer4'] }}</label><br>
</body>
</html>