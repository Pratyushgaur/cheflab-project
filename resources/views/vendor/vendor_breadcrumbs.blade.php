
<nav aria-label = "breadcrumb">
    <ol class = "breadcrumb pl-0">
        @foreach($breadcrumb as $k=>$v)
            <li class = "breadcrumb-item"><a href = "<?php echo $v['route'];?>"><?php echo isset($v['icon']) ? $v['icon']: '' ?>{{$v['name']}}</a></li>
        @endforeach
{{--        <li class = "breadcrumb-item"><a href = "#"><i class = "material-icons">home</i> Home</a></li>--}}
{{--        <li class = "breadcrumb-item active" aria-current = "page">Orders</li>--}}
{{--        <li class = "breadcrumb-item active" aria-current = "page">Orders List</li>--}}
    </ol>
</nav>
