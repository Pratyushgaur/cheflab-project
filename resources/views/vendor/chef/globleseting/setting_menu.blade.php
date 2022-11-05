<div class="col-md-3">
    <div class="ms-panel ms-panel-fh">
        <div class="ms-panel-header">
            <h6>Globel Setting</h6>

        </div>

        <div class="ms-panel-body">
            <div class="accordion" id="accordionExample1">
                <div class="card">
                    <div class="card-header" data-toggle="collapse" role="button" data-target="#collapseOne"
                         aria-expanded="true" aria-controls="collapseOne">
                        <span>Order Time</span>
                    </div>

                    <div id="collapseOne" class="collapse show" data-parent="#accordionExample1">
                        <div class="card-body">
                            <li><a href="{{route('chef.globleseting.ordertime')}}" class="">Order Time Setting</a>
                            </li>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" data-toggle="collapse" role="button" data-target="#collapseOne1"
                         aria-expanded="true" aria-controls="collapseOne">
                        <span>Location</span>
                    </div>

                    <div id="collapseOne1" class="collapse show" data-parent="#accordionExample1">
                        <div class="card-body">
                            <li><a href="{{route('chef.globleseting.vendor_location')}}" class="">chef Location</a></li>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header" data-toggle="collapse" role="button" data-target="#collapseOne2"
                         aria-expanded="true" aria-controls="collapseOne">
                        <span>Dine Out</span>
                    </div>

                    <div id="collapseOne2" class="collapse show" data-parent="#accordionExample1">
                        <div class="card-body">
                            <li><a href="{{route('chef.dineout.setting')}}" class="">Dine Out Setting</a></li>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header" data-toggle="collapse" role="button" data-target="#collapseOne2"
                         aria-expanded="true" aria-controls="collapseOne">
                        <span>Bank And documents</span>
                    </div>

                    <div id="collapseOne2" class="collapse show" data-parent="#accordionExample1">
                        <div class="card-body">
                            <li><a href="{{route('chef.globleseting.bank_details')}}" class="">Bank and other documents</a></li>
                        </div>
                    </div>
                </div>



            </div>
        </div>

    </div>

</div>
