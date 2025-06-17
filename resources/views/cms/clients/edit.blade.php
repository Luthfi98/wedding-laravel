@extends('layouts.cms')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">{{ $title }}</h4>
        <div class="d-flex gap-2 mt-2">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bi bi-house-door"></i> Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('clients.index') }}">{{ __('Clients') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit</li>
            </ol>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('clients.update', $client->id) }}" method="POST" enctype="multipart/form-data" id="clientForm">
                @csrf
                @method('PUT')
                <input type="hidden" name="active_tab" id="activeTab" value="basic">
                
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
                                    <label for="name" class="form-label">{{ __('Name') }} <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $client->name) }}" >
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">{{ __('Email') }} <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $client->email) }}" >
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="phone" class="form-label">{{ __('Phone') }}</label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', $client->phone) }}">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="slug" class="form-label">{{ __('Slug') }}</label>
                                    <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug" value="{{ old('slug', $client->slug) }}">
                                    <small class="text-muted">{{ __('Leave empty to auto-generate from name') }}</small>
                                    @error('slug')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">{{ __('Status') }} <span class="text-danger">*</span></label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="status" name="status" value="1" {{ old('status', $client->status) ? 'checked' : '' }}>
                                <label class="form-check-label" for="status" id="statusLabel">{{ __('Active') }}</label>
                            </div>
                            @error('status')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Couple Data Tab -->
                    <div class="tab-pane fade" id="couple" role="tabpanel">
                        <div class="row">
                            <div class="col-md-6">
                                <h5>Groom</h5>
                                <div class="row">
                                    <div class="col-lg-8">
                                        <div class="mb-3">
                                            <label for="groom_name" class="form-label">Name</label>
                                            <input type="text" class="form-control @error('data.groom.name') is-invalid @enderror" id="groom_name" name="data[groom][name]" value="{{ old('data.groom.name', $client->data['groom']['name'] ?? '') }}">
                                            @error('data.groom.name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="groom_nickname" class="form-label">Nickname</label>
                                            <input type="text" class="form-control @error('data.groom.nickname') is-invalid @enderror" id="groom_nickname" name="data[groom][nickname]" value="{{ old('data.groom.nickname', $client->data['groom']['nickname'] ?? '') }}">
                                            @error('data.groom.nickname')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="groom_father" class="form-label">Father's Name</label>
                                    <input type="text" class="form-control @error('data.groom.father') is-invalid @enderror" id="groom_father" name="data[groom][father]" value="{{ old('data.groom.father', $client->data['groom']['father'] ?? '') }}">
                                    @error('data.groom.father')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="groom_mother" class="form-label">Mother's Name</label>
                                    <input type="text" class="form-control @error('data.groom.mother') is-invalid @enderror" id="groom_mother" name="data[groom][mother]" value="{{ old('data.groom.mother', $client->data['groom']['mother'] ?? '') }}">
                                    @error('data.groom.mother')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="groom_birth_order" class="form-label">Birth Order</label>
                                            <input type="number" class="form-control @error('data.groom.birth_order') is-invalid @enderror" id="groom_birth_order" name="data[groom][birth_order]" min="1" value="{{ old('data.groom.birth_order', $client->data['groom']['birth_order'] ?? '') }}">
                                            @error('data.groom.birth_order')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="groom_total_siblings" class="form-label">Total Siblings</label>
                                            <input type="number" class="form-control @error('data.groom.total_siblings') is-invalid @enderror" id="groom_total_siblings" name="data[groom][total_siblings]" min="1" value="{{ old('data.groom.total_siblings', $client->data['groom']['total_siblings'] ?? '') }}">
                                            @error('data.groom.total_siblings')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="groom_instagram" class="form-label">Instagram</label>
                                    <input type="text" class="form-control @error('data.groom.instagram') is-invalid @enderror" id="groom_instagram" name="data[groom][instagram]" value="{{ old('data.groom.instagram', $client->data['groom']['instagram'] ?? '') }}">
                                    @error('data.groom.instagram')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h5>Bride</h5>
                                <div class="row">
                                    <div class="col-lg-8">
                                        <div class="mb-3">
                                            <label for="bride_name" class="form-label">Name</label>
                                            <input type="text" class="form-control @error('data.bride.name') is-invalid @enderror" id="bride_name" name="data[bride][name]" value="{{ old('data.bride.name', $client->data['bride']['name'] ?? '') }}">
                                            @error('data.bride.name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="bride_nickname" class="form-label">Nickname</label>
                                            <input type="text" class="form-control @error('data.bride.nickname') is-invalid @enderror" id="bride_nickname" name="data[bride][nickname]" value="{{ old('data.bride.nickname', $client->data['bride']['nickname'] ?? '') }}">
                                            @error('data.bride.nickname')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="bride_father" class="form-label">Father's Name</label>
                                    <input type="text" class="form-control @error('data.bride.father') is-invalid @enderror" id="bride_father" name="data[bride][father]" value="{{ old('data.bride.father', $client->data['bride']['father'] ?? '') }}">
                                    @error('data.bride.father')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="bride_mother" class="form-label">Mother's Name</label>
                                    <input type="text" class="form-control @error('data.bride.mother') is-invalid @enderror" id="bride_mother" name="data[bride][mother]" value="{{ old('data.bride.mother', $client->data['bride']['mother'] ?? '') }}">
                                    @error('data.bride.mother')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="bride_birth_order" class="form-label">Birth Order</label>
                                            <input type="number" class="form-control @error('data.bride.birth_order') is-invalid @enderror" id="bride_birth_order" name="data[bride][birth_order]" min="1" value="{{ old('data.bride.birth_order', $client->data['bride']['birth_order'] ?? '') }}">
                                            @error('data.bride.birth_order')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="bride_total_siblings" class="form-label">Total Siblings</label>
                                            <input type="number" class="form-control @error('data.bride.total_siblings') is-invalid @enderror" id="bride_total_siblings" name="data[bride][total_siblings]" min="1" value="{{ old('data.bride.total_siblings', $client->data['bride']['total_siblings'] ?? '') }}">
                                            @error('data.bride.total_siblings')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="bride_instagram" class="form-label">Instagram</label>
                                    <input type="text" class="form-control @error('data.bride.instagram') is-invalid @enderror" id="bride_instagram" name="data[bride][instagram]" value="{{ old('data.bride.instagram', $client->data['bride']['instagram'] ?? '') }}">
                                    @error('data.bride.instagram')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Story Tab -->
                    <div class="tab-pane fade" id="story" role="tabpanel">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="mb-0">Love Story</h5>
                            <button type="button" class="btn btn-primary btn-sm" id="add-story">
                                <i class="bi bi-plus"></i> Add Story
                            </button>
                        </div>
                        
                        <div class="table-responsive">
                            <table class="table table-bordered" id="story-table">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th width="100">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($client->data['stories']) && is_array($client->data['stories']))
                                        @foreach($client->data['stories'] as $index => $story)
                                            <tr>
                                                <td>
                                                    <input type="date" class="form-control @error('data.stories.'.$index.'.date') is-invalid @enderror" name="data[stories][{{ $index }}][date]" value="{{ $story['date'] ?? '' }}" >
                                                    @error('data.stories.'.$index.'.date')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control @error('data.stories.'.$index.'.title') is-invalid @enderror" name="data[stories][{{ $index }}][title]" value="{{ $story['title'] ?? '' }}" >
                                                    @error('data.stories.'.$index.'.title')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </td>
                                                <td>
                                                    <textarea class="form-control @error('data.stories.'.$index.'.description') is-invalid @enderror" name="data[stories][{{ $index }}][description]" rows="3" >{{ $story['description'] ?? '' }}</textarea>
                                                    @error('data.stories.'.$index.'.description')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-danger btn-sm remove-story">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Event Location Tab -->
                    <div class="tab-pane fade" id="location" role="tabpanel">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="mb-0">Event Locations</h5>
                            <button type="button" class="btn btn-primary btn-sm" id="add-location">
                                <i class="bi bi-plus"></i> Add Location
                            </button>
                        </div>
                        
                        <div class="table-responsive">
                            <table class="table table-bordered" id="location-table">
                                <thead>
                                    <tr>
                                        <th>Event Name</th>
                                        <th>Date & Time</th>
                                        <th>Location</th>
                                        <th>Address</th>
                                        <th>Google Maps</th>
                                        <th width="100">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($client->data['locations']) && is_array($client->data['locations']))
                                        @foreach($client->data['locations'] as $index => $location)
                                            <tr>
                                                <td>
                                                    <input type="text" class="form-control @error('data.locations.'.$index.'.name') is-invalid @enderror" name="data[locations][{{ $index }}][name]" value="{{ $location['name'] ?? '' }}">
                                                    @error('data.locations.'.$index.'.name')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </td>
                                                <td>
                                                    <input type="datetime-local" class="form-control @error('data.locations.'.$index.'.date') is-invalid @enderror" name="data[locations][{{ $index }}][date]" value="{{ $location['date'] ?? '' }}">
                                                    @error('data.locations.'.$index.'.date')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </td>
                                                <td>
                                                    <textarea class="form-control @error('data.locations.'.$index.'.location') is-invalid @enderror" name="data[locations][{{ $index }}][location]" rows="2">{{ $location['location'] ?? '' }}</textarea>
                                                    @error('data.locations.'.$index.'.location')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </td>
                                                <td>
                                                    <textarea class="form-control @error('data.locations.'.$index.'.address') is-invalid @enderror" name="data[locations][{{ $index }}][address]" rows="2">{{ $location['address'] ?? '' }}</textarea>
                                                    @error('data.locations.'.$index.'.address')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </td>
                                                <td>
                                                    <input type="url" class="form-control @error('data.locations.'.$index.'.maps') is-invalid @enderror" name="data[locations][{{ $index }}][maps]" value="{{ $location['maps'] ?? '' }}">
                                                    @error('data.locations.'.$index.'.maps')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-danger btn-sm remove-location">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Gallery Tab -->
                    <div class="tab-pane fade" id="gallery" role="tabpanel">
                        <div class="mb-3">
                            <label class="form-label">Gallery Images</label>
                            <div class="dropzone" id="gallery-dropzone">
                                <div class="dz-message" data-dz-message>
                                    <span>Drop images here or click to upload</span>
                                    <small class="text-muted d-block">You can upload multiple images at once</small>
                                </div>
                            </div>
                            <div class="row mt-3" id="gallery-container">
                                @if(isset($client->data['gallery']) && is_array($client->data['gallery']))
                                    @foreach($client->data['gallery'] as $index => $image)
                                        <div class="col-md-4 mb-3">
                                            <div class="card">
                                                <img src="{{ asset($image) }}" class="card-img-top" alt="Gallery image">
                                                <div class="card-body">
                                                    <input type="hidden" name="data[gallery][]" value="{{ $image }}">
                                                    <button type="button" class="btn btn-danger btn-sm remove-image">
                                                        <i class="bi bi-trash"></i> Remove
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Bank Account Tab -->
                    <div class="tab-pane fade" id="bank" role="tabpanel">
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="mb-0">Bank Accounts</h5>
                                <button type="button" class="btn btn-primary btn-sm" id="add-bank-account">
                                    <i class="bi bi-plus"></i> Add Bank Account
                                </button>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="bank-accounts-table">
                                    <thead>
                                        <tr>
                                            <th>Bank Name</th>
                                            <th>Account Number</th>
                                            <th>Account Holder</th>
                                            <th width="10%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(isset($client->data['bank_accounts']) && is_array($client->data['bank_accounts']))
                                            @foreach($client->data['bank_accounts'] as $index => $account)
                                                <tr>
                                                    <td>
                                                        <select class="form-control @error('data.bank_accounts.'.$index.'.bank_name') is-invalid @enderror" name="data[bank_accounts][{{ $index }}][bank_name]" >
                                                            <option value="" selected disabled>{{ __('Select Bank') }}</option>
                                                            @foreach($banks as $bank)
                                                                <option value="{{ $bank->code }}" {{ $account['bank_name'] == $bank->code ? 'selected' : '' }}>{{ $bank->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('data.bank_accounts.'.$index.'.bank_name')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control @error('data.bank_accounts.'.$index.'.account_number') is-invalid @enderror" name="data[bank_accounts][{{ $index }}][account_number]" value="{{ $account['account_number'] ?? '' }}" >
                                                        @error('data.bank_accounts.'.$index.'.account_number')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control @error('data.bank_accounts.'.$index.'.account_holder') is-invalid @enderror" name="data[bank_accounts][{{ $index }}][account_holder]" value="{{ $account['account_holder'] ?? '' }}" >
                                                        @error('data.bank_accounts.'.$index.'.account_holder')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </td>
                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-danger btn-sm remove-bank-account">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Other Info Tab -->
                    <div class="tab-pane fade" id="other" role="tabpanel">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="background" class="form-label">Background</label>
                                    <input type="file" class="form-control @error('data.other.background') is-invalid @enderror" id="background" name="data[other][background]" accept="image/*">
                                    @error('data.other.background')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    @if(isset($client->data['other']['background']) && $client->data['other']['background'])
                                        <div class="mt-2">
                                            <img src="{{ asset($client->data['other']['background']) }}" alt="Background" class="img-thumbnail" style="max-height: 200px;">
                                            <input type="hidden" name="data[other][current_background]" value="{{ $client->data['other']['background'] }}">
                                        </div>
                                    @endif
                                </div>
                                
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="file_song" class="form-label">File Song</label>
                                    <input type="file" class="form-control @error('data.other.file_song') is-invalid @enderror" id="file_song" name="data[other][file_song]" accept="audio/*">
                                    @error('data.other.file_song')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    @if(isset($client->data['other']['file_song']) && $client->data['other']['file_song'])
                                        <div class="mt-2">
                                            <audio controls>
                                                <source src="{{ asset($client->data['other']['file_song']) }}" type="audio/mpeg">
                                                Your browser does not support the audio element.
                                            </audio>
                                            <input type="hidden" name="data[other][current_file_song]" value="{{ $client->data['other']['file_song'] }}">
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="template_id" class="form-label">Template</label>
                            <br>
                            <script>
                            function resizeIframe(obj) {
                                obj.style.height = obj.contentWindow.document.documentElement.scrollHeight + 'px';
                            }
                            </script>
                            <div class="row">
                            @foreach ($templates as $template)
                                <div class="col-lg-4 col-md-6 col-sm-12 text-center">
                            @php
                                $fileHtml = $template['file_content']['html'];
                            @endphp
                                    <iframe src="{{ asset($fileHtml) }}" style="width: 100%; height: 500px;"></iframe>
                                    <br>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input @error('data.other.template_id') is-invalid @enderror" type="radio" name="data[other][template_id]" id="template_id_{{ $template->id }}" value="{{ $template->id }}" {{ old('data.other.template_id', $client->data['other']['template_id'] ?? '') == $template->id ? 'checked' : '' }}>
                                        <label class="form-check-label" for="template_id_{{ $template->id }}">{{ $template->name }}</label>
                                    </div>
                                </div>
                            @endforeach
                            </div>
                            @error('data.other.template_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('clients.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                    <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" rel="stylesheet" type="text/css" />
<style>
    .dropzone {
        border: 2px dashed #0087F7;
        border-radius: 5px;
        background: white;
        min-height: 150px;
        padding: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }
    .dropzone .dz-message {
        text-align: center;
        margin: 0;
    }
    .dropzone .dz-preview {
        margin: 10px;
    }
    .dropzone .dz-preview .dz-image {
        border-radius: 5px;
    }
</style>
@endpush

@push('scripts')
<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
<script>
    $(document).ready(function() {
        // Function to find tab with errors
        function findTabWithErrors() {
            let errorTab = null;
            
            // Check basic info tab
            if ($('#basic .is-invalid').length > 0) {
                errorTab = 'basic';
            }
            // Check couple data tab
            else if ($('#couple .is-invalid').length > 0) {
                errorTab = 'couple';
            }
            // Check story tab
            else if ($('#story .is-invalid').length > 0) {
                errorTab = 'story';
            }
            // Check location tab
            else if ($('#location .is-invalid').length > 0) {
                errorTab = 'location';
            }
            // Check gallery tab
            else if ($('#gallery .is-invalid').length > 0) {
                errorTab = 'gallery';
            }
            // Check bank tab
            else if ($('#bank .is-invalid').length > 0) {
                errorTab = 'bank';
            }
            // Check other tab
            else if ($('#other .is-invalid').length > 0) {
                errorTab = 'other';
            }
            
            return errorTab;
        }

        // Function to activate tab
        function activateTab(tabId) {
            $(`#${tabId}-tab`).tab('show');
            $('#activeTab').val(tabId);
        }

        // Check for errors and activate appropriate tab on page load
        const errorTab = findTabWithErrors();
        if (errorTab) {
            activateTab(errorTab);
        } else {
            // If no errors, use the active tab from the server
            const activeTab = $('#activeTab').val();
            if (activeTab) {
                activateTab(activeTab);
            }
        }

        // Track active tab
        $('button[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
            const activeTab = $(e.target).attr('id').replace('-tab', '');
            $('#activeTab').val(activeTab);
        });

        // Function to update status label
        function updateStatusLabel() {
            const isChecked = $('#status').is(':checked');
            $('#statusLabel').text(isChecked ? '{{ __("Active") }}' : '{{ __("Inactive") }}');
            $('#status').val(isChecked ? '1' : '0');
        }

        // Initial call
        updateStatusLabel();

        // Update label when checkbox changes
        $('#status').change(updateStatusLabel);

        // Auto-generate slug from name
        $('#name').on('keyup', function() {
            if ($('#slug').val() === '') {
                let slug = $(this).val()
                    .toLowerCase()
                    .replace(/[^a-z0-9-]/g, '-')
                    .replace(/-+/g, '-')
                    .replace(/^-|-$/g, '');
                $('#slug').val(slug);
            }
        });

        // Initialize Dropzone
        Dropzone.autoDiscover = false;
        
        // Destroy any existing Dropzone instance
        if (Dropzone.instances.length > 0) {
            Dropzone.instances.forEach(instance => {
                instance.destroy();
            });
        }
        
        const myDropzone = new Dropzone("#gallery-dropzone", {
            url: "{{ route('clients.upload-image') }}",
            paramName: "image",
            maxFilesize: 5, // MB
            acceptedFiles: "image/*",
            addRemoveLinks: true,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            params: {
                client_id: "{{ $client->id ?? '' }}"
            },
            init: function() {
                this.on("sending", function(file, xhr, formData) {
                    // Add client_id to formData
                    formData.append("client_id", "{{ $client->id ?? '' }}");
                });

                this.on("success", function(file, response) {
                    if (response.success) {
                        // Add the image to the gallery container
                        const galleryHtml = `
                            <div class="col-md-4 mb-3">
                                <div class="card">
                                    <img src="${response.url}" class="card-img-top" alt="Gallery image">
                                    <div class="card-body">
                                        <input type="hidden" name="data[gallery][]" value="${response.filename}">
                                        <button type="button" class="btn btn-danger btn-sm remove-image">
                                            <i class="bi bi-trash"></i> Remove
                                        </button>
                                    </div>
                                </div>
                            </div>
                        `;
                        $('#gallery-container').append(galleryHtml);
                        
                        // Remove the preview from dropzone
                        this.removeFile(file);
                    } else {
                        alert('Upload failed: ' + response.message);
                        this.removeFile(file);
                    }
                });

                this.on("error", function(file, errorMessage) {
                    alert('Upload failed: ' + errorMessage);
                    this.removeFile(file);
                });
            }
        });

        // Remove gallery image
        $(document).on('click', '.remove-image', function() {
            const imageUrl = $(this).siblings('input').val();
            
            // Send request to delete the image
            $.ajax({
                url: "{{ route('clients.delete-image') }}",
                method: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    image_url: imageUrl
                },
                success: function(response) {
                    if (response.success) {
                        // Remove the image container
                        $(this).closest('.col-md-4').remove();
                    } else {
                        alert('Failed to delete image: ' + response.message);
                    }
                }.bind(this),
                error: function() {
                    alert('Failed to delete image');
                }
            });
        });

        // Location table handling
        let locationIndex = {{ isset($client->data['locations']) ? count($client->data['locations']) : 0 }};

        $('#add-location').click(function() {
            const newRow = `
                <tr>
                    <td>
                        <input type="text" class="form-control @error('data.locations.${locationIndex}.name') is-invalid @enderror" name="data[locations][${locationIndex}][name]" >
                        @error('data.locations.${locationIndex}.name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </td>
                    <td>
                        <input type="datetime-local" class="form-control @error('data.locations.${locationIndex}.date') is-invalid @enderror" name="data[locations][${locationIndex}][date]" >
                        @error('data.locations.${locationIndex}.date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </td>
                    <td>
                        <textarea class="form-control @error('data.locations.${locationIndex}.location') is-invalid @enderror" name="data[locations][${locationIndex}][location]" rows="2" ></textarea>
                        @error('data.locations.${locationIndex}.location')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </td>
                    <td>
                        <textarea class="form-control @error('data.locations.${locationIndex}.address') is-invalid @enderror" name="data[locations][${locationIndex}][address]" rows="2" ></textarea>
                        @error('data.locations.${locationIndex}.address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </td>
                    <td>
                        <input type="url" class="form-control @error('data.locations.${locationIndex}.maps') is-invalid @enderror" name="data[locations][${locationIndex}][maps]">
                        @error('data.locations.${locationIndex}.maps')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </td>
                    <td class="text-center">
                        <button type="button" class="btn btn-danger btn-sm remove-location">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                </tr>
            `;
            $('#location-table tbody').append(newRow);
            locationIndex++;
        });

        // Remove location row
        $(document).on('click', '.remove-location', function() {
            $(this).closest('tr').remove();
        });

        // Bank Account handling
        let bankAccountIndex = {{ isset($client->data['bank_accounts']) ? count($client->data['bank_accounts']) : 0 }};

        $('#add-bank-account').click(function() {
            const newRow = `
                <tr>
                    <td>
                        <select class="form-control @error('data.bank_accounts.${bankAccountIndex}.bank_name') is-invalid @enderror" name="data[bank_accounts][${bankAccountIndex}][bank_name]" >
                            <option value="" selected disabled>{{ __('Select Bank') }}</option>
                            @foreach($banks as $bank)
                                <option value="{{ $bank->code }}">{{ $bank->name }}</option>
                            @endforeach
                        </select>
                        @error('data.bank_accounts.${bankAccountIndex}.bank_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </td>
                    <td>
                        <input type="text" class="form-control @error('data.bank_accounts.${bankAccountIndex}.account_number') is-invalid @enderror" name="data[bank_accounts][${bankAccountIndex}][account_number]" >
                        @error('data.bank_accounts.${bankAccountIndex}.account_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </td>
                    <td>
                        <input type="text" class="form-control @error('data.bank_accounts.${bankAccountIndex}.account_holder') is-invalid @enderror" name="data[bank_accounts][${bankAccountIndex}][account_holder]" >
                        @error('data.bank_accounts.${bankAccountIndex}.account_holder')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </td>
                    <td class="text-center">
                        <button type="button" class="btn btn-danger btn-sm remove-bank-account">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                </tr>
            `;
            $('#bank-accounts-table tbody').append(newRow);
            bankAccountIndex++;
        });

        $(document).on('click', '.remove-bank-account', function() {
            $(this).closest('tr').remove();
        });

        // Story table handling
        let storyIndex = {{ isset($client->data['stories']) ? count($client->data['stories']) : 0 }};

        $('#add-story').click(function() {
            const newRow = `
                <tr>
                    <td>
                        <input type="date" class="form-control @error('data.stories.${storyIndex}.date') is-invalid @enderror" name="data[stories][${storyIndex}][date]" >
                        @error('data.stories.${storyIndex}.date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </td>
                    <td>
                        <input type="text" class="form-control @error('data.stories.${storyIndex}.title') is-invalid @enderror" name="data[stories][${storyIndex}][title]" >
                        @error('data.stories.${storyIndex}.title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </td>
                    <td>
                        <textarea class="form-control @error('data.stories.${storyIndex}.description') is-invalid @enderror" name="data[stories][${storyIndex}][description]" rows="3" ></textarea>
                        @error('data.stories.${storyIndex}.description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </td>
                    <td class="text-center">
                        <button type="button" class="btn btn-danger btn-sm remove-story">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                </tr>
            `;
            $('#story-table tbody').append(newRow);
            storyIndex++;
        });

        // Remove story row
        $(document).on('click', '.remove-story', function() {
            $(this).closest('tr').remove();
        });

        // Form submission
        // $('#clientForm').on('submit', function(e) {
        //     e.preventDefault();
            
        //     // Get active tab
        //     const activeTab = $('#activeTab').val();
            
        //     // Collect form data
        //     const formData = new FormData(this);
            
        //     // Add active tab to form data
        //     formData.append('active_tab', activeTab);
            
        //     // Send AJAX request
        //     $.ajax({
        //         url: $(this).attr('action'),
        //         headers: {
        //             'X-CSRF-TOKEN': "{{ csrf_token() }}"
        //         },
        //         method: 'PUT',
        //         data: formData,
        //         processData: false,
        //         contentType: false,
        //         success: function(response) {
        //             if (response.success) {
        //                 // Show success message
        //                 alert('Data updated successfully');
                        
        //                 // If not on basic tab, stay on current tab
        //                 if (activeTab !== 'basic') {
        //                     return;
        //                 }
                        
        //                 // Redirect to index page
        //                 window.location.href = '{{ route("clients.index") }}';
        //             } else {
        //                 alert('Update failed: ' + response.message);
        //             }
        //         },
        //         error: function(xhr) {
        //             // Handle validation errors
        //             if (xhr.status === 422) {
        //                 const errors = xhr.responseJSON.errors;
        //                 Object.keys(errors).forEach(key => {
        //                     const input = $(`[name="${key}"]`);
        //                     input.addClass('is-invalid');
        //                     input.next('.invalid-feedback').text(errors[key][0]);
        //                 });
        //             } else {
        //                 alert('An error occurred while updating the data');
        //             }
        //         }
        //     });
        // });
    });

</script>

@endpush 