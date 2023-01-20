<a href="{{route('admin.order.dashboard')}}" class="btn btn-sm @if($active == 'pending') active @endif" style="border:1px solid black; margin-right:0px;">Pending Orders</a>
<a href="{{route('admin.order.dashboard.status','delay_restaurant')}}" class="btn btn-sm @if($active == 'delay_restaurant') active @endif" style="border:1px solid black;">Delay (Restaurant)</a>
<a href="{{route('admin.order.dashboard.status','delay_rider')}}" class="btn btn-sm @if($active == 'delay_rider') active @endif" style="border:1px solid black;">Delay (Riders)</a>
<a href="{{route('admin.order.dashboard.status','preparing')}}" class="btn btn-sm @if($active == 'preparing') active @endif" style="border:1px solid black;">Preparing</a>
<a href="{{route('admin.order.dashboard.status','not_pickup_rider')}}" class="btn btn-sm @if($active == 'not_pickup_rider') active @endif" style="border:1px solid black;">Not Picked Up (Rider)</a>
<a href="{{route('admin.order.dashboard.status','out_of_dellivery')}}" class="btn btn-sm @if($active == 'out_of_dellivery') active @endif" style="border:1px solid black;">Out for delivery</a>
