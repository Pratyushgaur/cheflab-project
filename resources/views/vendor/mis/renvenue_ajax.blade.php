<div class="row">
        <div class="mb-4 col-sm-6 col-lg-4 mb-4">
                    <div class="card h-100">
                      <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                          <div>
                            <h4 class="fw-normal text-dark">₹{{ number_format($order_sum,2) }}</h4>
                            <p class="subtitle text-sm text-muted mb-0">Gross Revenue</p>
                          </div>
                          <div class="flex-shrink-0 ms-3 symbol_box">
                          A
                          </div>
                        </div>
                      </div>
                      <div class="card-footer py-3 bg-red-light">
                        <div class="row align-items-center text-red">
                          <div class="col-10">
                            <p class="mb-0">Number of orders: {{ $order_count }}</p>
                          </div>
                          <div class="col-2 text-end"><i class="fas fa-caret-up"></i>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="mb-4 col-sm-6 col-lg-4 mb-4">
                    <div class="card h-100">
                      <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                          <div>
                            <h4 class="fw-normal text-dark">₹{{ number_format($additions_count,2) }}</h4>
                            <p class="subtitle text-sm text-muted mb-0">Additions</p>
                          </div>
                          <div class="flex-shrink-0 ms-3 symbol_box">
                          B
                          </div>
                        </div>
                      </div>
                      <div class="card-footer py-3 bg-red-light">
                        <div class="row align-items-center text-red">
                          <div class="col-10">
                           <a href="javascript:void(0);" class="mb-0 text-decoration-underline" onclick="additions()">View Detail</a>
                          </div>
                          <div class="col-2 text-end"><i class="fas fa-caret-up"></i>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="mb-4 col-sm-6 col-lg-4 mb-4">
                    <div class="card h-100">
                      <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                          <div>
                            <h4 class="fw-normal text-dark">₹{{ $deductions }}</h4>
                            <p class="subtitle text-sm text-muted mb-0">Deductions</p>
                          </div>
                          <div class="flex-shrink-0 ms-3 symbol_box">
                          C
                          </div>
                        </div>
                      </div>
                      <div class="card-footer py-3 bg-red-light">
                        <div class="row align-items-center text-red">
                          <div class="col-10">
                           <a href="javascript:void(0);" class="mb-0 text-decoration-underline" onclick="deductions ()">View Detail</a>
                          </div>
                          <div class="col-2 text-end"><i class="fas fa-caret-up"></i>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="mb-4 col-sm-6 col-lg-4 mb-4">
                    <div class="card h-100">
                      <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                          <div>
                            <h4 class="fw-normal text-dark">₹{{ $net_receivables }}</h4>
                            <p class="subtitle text-sm text-muted mb-0">Net receivable[A+B-C]</p>
                          </div>
                          <div class="flex-shrink-0 ms-3 symbol_box">
                          D
                          </div>
                        </div>
                      </div>
                      <div class="card-footer py-3 bg-red-light">
                        <div class="row align-items-center text-red">
                          <div class="col-10">
                            <p class="mb-0"></p>
                          </div>
                          <div class="col-2 text-end"><i class="fas fa-caret-up"></i>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                    <div class="mb-4 col-sm-6 col-lg-4 mb-4">
                    <div class="card h-100">
                      <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                          <div>
                            <h4 class="fw-normal text-dark">₹10,500</h4>
                            <p class="subtitle text-sm text-muted mb-0">Your Settlements (Bank UTRs)</p>
                          </div>
                          <div class="flex-shrink-0 ms-3 symbol_box">
                          G
                          </div>
                        </div>
                      </div>
                      <div class="card-footer py-3 bg-red-light">
                        <div class="row align-items-center text-red">
                          <div class="col-10">
                            <a href="javascript:void(0);" class="mb-0 text-decoration-underline">View Detail</a>
                          </div>
                          <div class="col-2 text-end"><i class="fas fa-caret-up"></i>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

            <!-- client chat -->
        </div>