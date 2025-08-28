@extends('layouts.admin-layout')
@section('noidung')
 <div class="container-xxl flex-grow-1 container-p-y">
            <div class="app-ecommerce">
                <form action="{{ route('Them-vnpay') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <!-- Add Notification -->
                    <div
                        class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
                        <div class="d-flex flex-column justify-content-center">
                            <h4 class="mb-1">Config</h4>
                        </div>
                        <div class="d-flex align-content-center flex-wrap gap-4">
                            <div class="d-flex gap-4">
                                {{-- <button type="button" class="btn btn-label-primary"
                                    onclick="window.location='{{ route('notifications.index') }}'">Cancel</button> --}}
                            </div>
                            <button type="submit" class="btn btn-primary" id="btn-send-notification">Lưu</button>
                        </div>
                    </div>

                    <div class="row">
                        <!-- First column-->
                        <div class="col-12 col-lg-12">
                            <!-- Notification Information -->
                            <div class="card mb-6">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">VNPAY</h5>
                                </div>
                                <div class="card-body">

                                    <div class="input-group mb-6">
                                        <span class="input-group-text" id="basic-addon14">https://</span>
                                        <input type="text" class="form-control" value="{{ !empty(env('VNPAY_WEB_URL')) ? trim(env('VNPAY_WEB_URL')) : env('VNPAY_WEB_URL') }}" name="webUrl" placeholder="URL" id="basic-url1" aria-describedby="basic-addon14">
                                      </div>

                                    <div class="mb-6">
                                        <label class="form-label" for="terminalID">Terminal ID</label>
                                        <input type="text" class="form-control" value="{{ !empty(env('VNPAY_TERMINAL_ID')) ? trim(env('VNPAY_TERMINAL_ID')) : env('VNPAY_TERMINAL_ID') }}" id="terminalID"
                                            placeholder="Terminal ID" name="terminalID"
                                            value="" aria-label="Notification title">
                                    </div>

                                    {{-- <div class="form-password-toggle">
                                        <label class="form-label" for="secretKey">Secret Key</label>
                                        <input type="text" class="form-control" value="{{ !empty(env('VNPAY_SECRET_KEY')) ? trim(env('VNPAY_SECRET_KEY')) : env('VNPAY_SECRET_KEY') }}" id="secretKey"
                                            placeholder="Secret Key" name="secretKey"
                                            value="" aria-label="Notification title">
                                    </div> --}}

                                    <div class="form-password-toggle">
                                        <label class="form-label" for="secretKey">Secret Key</label>
                                        <div class="input-group input-group-merge">
                                            <input type="password" class="form-control" id="secretKey" name="secretKey"
                                                value="{{ !empty(env('VNPAY_SECRET_KEY')) ? trim(env('VNPAY_SECRET_KEY')) : env('VNPAY_SECRET_KEY') }}"
                                                placeholder="············" aria-describedby="basic-default-password">
                                            <span class="input-group-text cursor-pointer" id="basic-default-password"><i
                                                    class="bx bx-hide"></i></span>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
@endsection
