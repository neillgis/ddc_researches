<html>
<body>
    <p>{{ $details['text_header'] }}</p>
    <p>
        {!! str_repeat('&nbsp;', 5). $details['detail_1'] !!}
    </p>
    <p>{{ $details['detail_2'] }}</p>
    <label>{{ $details['detail_31'] }}</label><br>
    <label>{{ $details['detail_32'] }}</label><br>
    <label>{{ $details['detail_33'] }}</label><br>
    <br>
    <label>{{ $details['text_footer'] }}</label><br>
    <label>{{ $details['text_footer1'] }}</label><br>
    <label>{{ $details['text_footer2'] }}</label><br>
    <label>{{ $details['text_footer3'] }}</label><br>
    <label>{{ $details['text_footer4'] }}</label><br>
</body>
</html>