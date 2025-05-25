@extends('emails.layouts.main')
@section('content')

<h1>Stock Quote for {{ $stock->getSymbol() }}</h1>

<p>Name: {{ $stock->getName() }}</p>
<p>Symbol: {{ $stock->getSymbol() }}</p>
<p>Price: {{ $stock->getPrice() }}</p>
<p>Open: {{ $stock->getOpen() }}</p>
<p>High: {{ $stock->getHigh() }}</p>
<p>Low: {{ $stock->getLow() }}</p>
<p>Close: {{ $stock->getClose() }}</p>
<p>Created At: {{ $stock->getCreatedAt() }}</p>

@endsection
