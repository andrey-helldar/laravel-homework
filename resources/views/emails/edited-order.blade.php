@component('mail::layout')
@slot('header')
@component('mail::header', ['url' => config('app.url')])
{{ trans('info.orderCompleted', ['id' => $order->id]) }}
@endcomponent
@endslot

@slot('subcopy')
@component('mail::table')
| {{ trans('titles.title') }} | {{ trans('titles.quantity') }} | {{ trans('forms.totalCost') }} |
| --- |:---:|:---:|
@foreach($order->products as $product)
| {{ $product->name }} | {{ $product->pivot->quantity }} | {!! price_format($product->pivot->quantity * $product->pivot->price) !!} {{ trans('orders.symbol') }} |
@endforeach
@endcomponent

{!! trans('info.total', ['value' => price_format($total_cost), 'symbol' => trans('orders.symbol')]) !!}
@endslot

@slot('footer')
@component('mail::footer')
{{ date('Y') }} © {{ config('app.name') }}. All rights reserved.
@endcomponent
@endslot
@endcomponent
