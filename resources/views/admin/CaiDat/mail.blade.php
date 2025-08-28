@extends('layouts.admin-layout')
@section('noidung')
<div class="container-xxl flex-grow-1 container-p-y">
            <div class="app-ecommerce">
                <form action="{{ route('Them-mail') }}" method="POST" enctype="multipart/form-data">
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
                            <button type="submit" class="btn btn-primary" id="btn-send-notification">Gửi</button>
                        </div>
                    </div>

                    <div class="row">
                        <!-- First column-->
                        <div class="col-12 col-lg-12">
                            <!-- Notification Information -->
                            <div class="card mb-6">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Mail</h5>
                                </div>
                                <div class="card-body">
                                    <div class="mb-6">
                                        <label class="form-label" for="mailUserName">MAIL_FROM_NAME</label>
                                        <input type="mail" class="form-control" value="{{ !empty(env('MAIL_FROM_NAME')) ? trim(env('MAIL_FROM_NAME')) : env('MAIL_FROM_NAME') }}" id="mailUserName"
                                            placeholder="Mail Username" name="MAIL_FROM_NAME"
                                            value="" aria-label="Notification title">
                                            @error('MAIL_FROM_NAME')
                                            <div class="text-danger">
                                                <i class="bx bx-error-circle me-2"></i>{{ $message }}
                                            </div>
                                            @enderror
                                    </div>
                                    <div class="mb-6">
                                        <label class="form-label" for="mailUserName">MAIL_USERNAME</label>
                                        <input type="mail" class="form-control" value="{{ !empty(env('MAIL_USERNAME')) ? trim(env('MAIL_USERNAME')) : env('MAIL_USERNAME') }}" id="mailUserName"
                                            placeholder="Mail Username" name="mailUserName"
                                            value="" aria-label="Notification title">
                                            @error('mailUserName')
                                            <div class="text-danger">
                                                <i class="bx bx-error-circle me-2"></i>{{ $message }}
                                            </div>
                                            @enderror
                                    </div>

                                    <div class="form-password-toggle">
                                        <label class="form-label" for="mailPassWord">MAIL_PASSWORD</label>
                                        <div class="input-group input-group-merge">
                                            <input type="password" class="form-control" id="mailPassWord" name="mailPassWord"
                                                value="{{ !empty(env('MAIL_PASSWORD')) ? trim(env('MAIL_PASSWORD')) : env('MAIL_PASSWORD') }}"
                                                placeholder="············" aria-describedby="basic-default-password">
                                            <span class="input-group-text cursor-pointer" id="basic-default-password"><i
                                                    class="bx bx-hide"></i></span>
                                        </div>
                                    </div>


                                    <div class="accordion mt-4" id="accordionExample">
                                        <div class="card accordion-item">
                                            <h2 class="accordion-header" id="headingMail">
                                                <button type="button" class="accordion-button collapsed"
                                                    data-bs-toggle="collapse" data-bs-target="#accordionMail"
                                                    aria-expanded="false" aria-controls="accordionMail">
                                                    Instructions for Retrieving MAIL_USERNAME and MAIL_PASSWORD
                                                </button>
                                            </h2>
                                            <div id="accordionMail" class="accordion-collapse collapse"
                                                aria-labelledby="headingMail" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <div
                                                        class="ant-space css-14brfei ant-space-vertical ant-space-gap-row-small ant-space-gap-col-small">
                                                        <div class="ant-space-item py-1">
                                                            <span class="ant-typography css-14brfei">
                                                                1. Log in to your email provider account (e.g., Gmail, Outlook, etc.).
                                                            </span>
                                                        </div>
                                                        <div class="ant-space-item py-1">
                                                            <span class="ant-typography css-14brfei">
                                                                2. Navigate to the account settings or security settings page.
                                                            </span>
                                                        </div>
                                                        <div class="ant-space-item py-1">
                                                            <span class="ant-typography css-14brfei">
                                                                3. If using Gmail, enable "Allow less secure apps" or set up an <a
                                                                class="ant-typography css-14brfei"
                                                                href="https://myaccount.google.com/apppasswords"
                                                                target="_blank" rel="noopener noreferrer"> App Password </a> in the Google Account Security settings.
                                                            </span>
                                                        </div>
                                                        <div class="ant-space-item py-1">
                                                            <span class="ant-typography css-14brfei">
                                                                4. For App Passwords, generate a new App Password for "Mail" or "SMTP" and note down the generated password.
                                                            </span>
                                                        </div>
                                                        <div class="ant-space-item py-1">
                                                            <span class="ant-typography css-14brfei">
                                                                5. Use your email address as the `MAIL_USERNAME` and the App Password as the `MAIL_PASSWORD`.
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
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
