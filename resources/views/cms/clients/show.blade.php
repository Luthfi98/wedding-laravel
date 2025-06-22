@extends('layouts.cms')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">{{ $title }}</h4>
        <div class="d-flex gap-2 mt-2">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bi bi-house-door"></i> Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('clients.index') }}">{{ __('Clients') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">Detail</li>
            </ol>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <ul class="nav nav-tabs" id="clientTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="basic-tab" data-bs-toggle="tab" data-bs-target="#basic" type="button" role="tab">Basic Info</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="couple-tab" data-bs-toggle="tab" data-bs-target="#couple" type="button" role="tab">Couple Data</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="story-tab" data-bs-toggle="tab" data-bs-target="#story" type="button" role="tab">Love Story</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="location-tab" data-bs-toggle="tab" data-bs-target="#location" type="button" role="tab">Event Location</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="gallery-tab" data-bs-toggle="tab" data-bs-target="#gallery" type="button" role="tab">Gallery</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="bank-tab" data-bs-toggle="tab" data-bs-target="#bank" type="button" role="tab">Bank Account</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="other-tab" data-bs-toggle="tab" data-bs-target="#other" type="button" role="tab">Other Info</button>
                </li>
            </ul>

            <div class="tab-content pt-4" id="clientTabsContent">
                <!-- Basic Info Tab -->
                <div class="tab-pane fade show active" id="basic" role="tabpanel">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">{{ __('Name') }}</label>
                                <p class="form-control-plaintext">{{ $client->name }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">{{ __('Email') }}</label>
                                <p class="form-control-plaintext">{{ $client->email }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">{{ __('Phone') }}</label>
                                <p class="form-control-plaintext">{{ $client->phone ?? '-' }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">{{ __('Slug') }}</label>
                                <p class="form-control-plaintext">{{ $client->slug ?? '-' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">{{ __('Status') }}</label>
                        <p class="form-control-plaintext">
                            <span class="badge bg-{{ $client->status ? 'success' : 'danger' }}">
                                {{ $client->status ? __('Active') : __('Inactive') }}
                            </span>
                        </p>
                    </div>
                </div>

                <!-- Couple Data Tab -->
                <div class="tab-pane fade" id="couple" role="tabpanel">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Groom</h5>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Name</label>
                                <p class="form-control-plaintext">{{ $data['groom']['name'] ?? '-' }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Nickname</label>
                                <p class="form-control-plaintext">{{ $data['groom']['nickname'] ?? '-' }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Father's Name</label>
                                <p class="form-control-plaintext">{{ $data['groom']['father'] ?? '-' }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Mother's Name</label>
                                <p class="form-control-plaintext">{{ $data['groom']['mother'] ?? '-' }}</p>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Birth Order</label>
                                        <p class="form-control-plaintext">{{ $data['groom']['birth_order'] ?? '-' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Total Siblings</label>
                                        <p class="form-control-plaintext">{{ $data['groom']['total_siblings'] ?? '-' }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Instagram</label>
                                <p class="form-control-plaintext">{{ $data['groom']['instagram'] ?? '-' }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h5>Bride</h5>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Name</label>
                                <p class="form-control-plaintext">{{ $data['bride']['name'] ?? '-' }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Nickname</label>
                                <p class="form-control-plaintext">{{ $data['bride']['nickname'] ?? '-' }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Father's Name</label>
                                <p class="form-control-plaintext">{{ $data['bride']['father'] ?? '-' }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Mother's Name</label>
                                <p class="form-control-plaintext">{{ $data['bride']['mother'] ?? '-' }}</p>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Birth Order</label>
                                        <p class="form-control-plaintext">{{ $data['bride']['birth_order'] ?? '-' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Total Siblings</label>
                                        <p class="form-control-plaintext">{{ $data['bride']['total_siblings'] ?? '-' }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Instagram</label>
                                <p class="form-control-plaintext">{{ $data['bride']['instagram'] ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Story Tab -->
                <div class="tab-pane fade" id="story" role="tabpanel">
                    <h5 class="mb-3">Love Story</h5>
                    
                    @if(isset($data['stories']) && is_array($data['stories']) && count($data['stories']) > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Title</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data['stories'] as $story)
                                        <tr>
                                            <td>{{ $story['date'] ?? '-' }}</td>
                                            <td>{{ $story['title'] ?? '-' }}</td>
                                            <td>{{ $story['description'] ?? '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle"></i> No love stories added yet.
                        </div>
                    @endif
                </div>

                <!-- Event Location Tab -->
                <div class="tab-pane fade" id="location" role="tabpanel">
                    <h5 class="mb-3">Event Locations</h5>
                    
                    @if(isset($data['locations']) && is_array($data['locations']) && count($data['locations']) > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Event Name</th>
                                        <th>Date & Time</th>
                                        <th>Location</th>
                                        <th>Address</th>
                                        <th>Google Maps</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data['locations'] as $location)
                                        <tr>
                                            <td>{{ $location['name'] ?? '-' }}</td>
                                            <td>{{ $location['date'] ?? '-' }}</td>
                                            <td>{{ $location['location'] ?? '-' }}</td>
                                            <td>{{ $location['address'] ?? '-' }}</td>
                                            <td>
                                                @if(isset($location['maps']) && $location['maps'])
                                                    <a href="{{ $location['maps'] }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                        <i class="bi bi-geo-alt"></i> View Map
                                                    </a>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle"></i> No event locations added yet.
                        </div>
                    @endif
                </div>

                <!-- Gallery Tab -->
                <div class="tab-pane fade" id="gallery" role="tabpanel">
                    <h5 class="mb-3">Gallery Images</h5>
                    
                    @if(isset($data['gallery']) && is_array($data['gallery']) && count($data['gallery']) > 0)
                        <div class="row" id="gallery-container">
                            @foreach($data['gallery'] as $image)
                                <div class="col-md-4 mb-3">
                                    <div class="card">
                                        <img src="{{ asset($image) }}" class="card-img-top" alt="Gallery image" style="height: 200px; object-fit: cover;">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle"></i> No gallery images added yet.
                        </div>
                    @endif
                </div>

                <!-- Bank Account Tab -->
                <div class="tab-pane fade" id="bank" role="tabpanel">
                    <h5 class="mb-3">Bank Accounts</h5>
                    
                    @if($banks)
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Bank Name</th>
                                        <th>Account Number</th>
                                        <th>Account Holder</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($banks as $account)
                                        <tr>
                                            <td>
                                                {{ $account['bank_name'] ?? '-' }}
                                            </td>
                                            <td>{{ $account['account_number'] ?? '-' }}</td>
                                            <td>{{ $account['account_holder'] ?? '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle"></i> No bank accounts added yet.
                        </div>
                    @endif
                </div>

                <!-- Other Info Tab -->
                <div class="tab-pane fade" id="other" role="tabpanel">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Background</label>
                                @if(isset($data['other']['background']) && $data['other']['background'])
                                    <div class="mt-2">
                                        <img src="{{ asset($data['other']['background']) }}" alt="Background" class="img-thumbnail" style="max-height: 200px;">
                                    </div>
                                @else
                                    <p class="form-control-plaintext">-</p>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">File Song</label>
                                @if(isset($data['other']['file_song']) && $data['other']['file_song'])
                                    <div class="mt-2">
                                        <audio controls>
                                            <source src="{{ asset($data['other']['file_song']) }}" type="audio/mpeg">
                                            Your browser does not support the audio element.
                                        </audio>
                                    </div>
                                @else
                                    <p class="form-control-plaintext">-</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Template</label>
                        @if(isset($data['other']['template_id']))

                            @if($data['other']['template'])
                                <div class="row">
                                    <div class="col-lg-4 col-md-6 col-sm-12 text-center">
                                        @php
                                            $fileHtml = $data['other']['template']['file_content']['html'];
                                        @endphp
                                        <iframe src="{{ asset($fileHtml) }}" style="width: 100%; height: 500px;"></iframe>
                                        <br>
                                        <p class="mt-2 fw-bold">{{ $data['other']['template']->name }}</p>
                                    </div>
                                </div>
                            @else
                                <p class="form-control-plaintext">-</p>
                            @endif
                        @else
                            <p class="form-control-plaintext">-</p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="{{ route('clients.index') }}" class="btn btn-secondary">{{ __('Back') }}</a>
                @if(auth()->user()->can('update client'))
                    <a href="{{ route('clients.edit', $client->id) }}" class="btn btn-primary">{{ __('Edit') }}</a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 