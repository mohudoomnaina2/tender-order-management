<h3>Order Created</h3>

<p>Username: {{ $order?->user?->name}}</p>
<p>Order Number: {{ $order?->order_number }}</p>
<p>Total Amount: {{ $order?->total_amount }}</p>
<p>Status: {{ $order?->status }}</p>
