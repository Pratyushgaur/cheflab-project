
<div class="col-md-3">
    <div class="ms-panel ms-panel-fh">
        <div class="ms-panel-header">
            <h6>Globel Setting</h6>

        </div>

        <div class="ms-panel-body">
            <div class="accordion" id="accordionExample1">
                <div class="card">
                    <div  <?php echo (request()->route()->getName()=='restaurant.globleseting.ordertime') ? 'class="card-header" aria-expanded="true"' : 'class="card-header collapsed" aria-expanded="false"' ?> data-toggle="collapse" role="button" data-target="#collapseOne" aria-controls="collapseOne">
                        <span>Order Time</span>
                    </div>

                    <div id="collapseOne" class="{{ (request()->route()->getName()=='restaurant.globleseting.ordertime') ? 'collapse show' : 'collapse' }}" data-parent="#accordionExample1">
                        <div class="card-body">
                            <li><a href="{{route('restaurant.globleseting.ordertime')}}" class="">Order Time Setting</a>
                            </li>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div <?php echo (request()->route()->getName()=='restaurant.globleseting.vendor_location') ? 'class="card-header" aria-expanded="true"' : 'class="card-header collapsed" aria-expanded="false"' ?> data-toggle="collapse" role="button" data-target="#collapseOne1"  aria-controls="collapseOne">
                        <span>Location</span>
                    </div>

                    <div id="collapseOne1" class="{{ (request()->route()->getName()=='restaurant.globleseting.vendor_location') ? 'collapse show' : 'collapse' }}" data-parent="#accordionExample1">
                        <div class="card-body">
                            <li><a href="{{route('restaurant.globleseting.vendor_location')}}" class="">Restaurant Location</a></li>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div <?php echo (request()->route()->getName()=='restaurant.dineout.setting') ? 'class="card-header" aria-expanded="true"' : 'class="card-header collapsed" aria-expanded="false"' ?> data-toggle="collapse" role="button" data-target="#collapseOne2" aria-controls="collapseOne">
                        <span>Dining Out</span>
                    </div>

                    <div id="collapseOne2" class="{{ (request()->route()->getName()=='restaurant.dineout.setting') ? 'collapse show' : 'collapse' }}" data-parent="#accordionExample1">
                        <div class="card-body">
                            <li><a href="{{route('restaurant.dineout.setting')}}" class="">Dining Setting</a></li>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div <?php echo (request()->route()->getName()=='restaurant.globleseting.bank_details') ? 'class="card-header" aria-expanded="true"' : 'class="card-header collapsed" aria-expanded="false"' ?> data-toggle="collapse" role="button" data-target="#collapseOne2"  aria-controls="collapseOne">
                        <span>Bank And documents</span>
                    </div>

                    <div id="collapseOne2" class="{{ (request()->route()->getName()=='restaurant.globleseting.bank_details') ? 'collapse show' : 'collapse' }}" data-parent="#accordionExample1">
                        <div class="card-body">
                            <li><a href="{{route('restaurant.globleseting.bank_details')}}" class="">Bank and other documents</a></li>
                        </div>
                    </div>
                </div>



            </div>
        </div>

    </div>

</div>
