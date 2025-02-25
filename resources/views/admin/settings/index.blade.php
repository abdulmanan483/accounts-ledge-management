@extends('admin.layout.app')

@section('title', 'Settings')

@section('header')
    <div class="page-header-content d-lg-flex">
        <div class="d-flex">
            <h4 class="page-title mb-0">
                Home - <span class="fw-normal">Settings</span>
            </h4>
        </div>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Settings</h5>
        </div>
        <div class="card-body">
            <!-- Tabs Navigation -->
            <ul class="nav nav-tabs mb-3" id="settingsTab" role="tablist">
                @foreach($settingsGroups as $key => $group)
                    <li class="nav-item" role="presentation">
                        <button class="nav-link {{ $loop->first ? 'active' : '' }}" id="{{ $key }}-tab" data-bs-toggle="tab" data-bs-target="#{{ $key }}" type="button" role="tab">
                            {{ ucfirst($key) }}
                        </button>
                    </li>
                @endforeach
            </ul>

            <form method="POST" action="{{ route('settings.save') }}" enctype="multipart/form-data">
                @csrf
                <!-- Tabs Content -->
                <div class="tab-content" id="settingsTabContent">
                    @foreach($settingsGroups as $key => $group)
                        <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="{{ $key }}" role="tabpanel">
                            <div class="fw-bold border-bottom pb-2 mb-3">{{ ucfirst($key) }} Settings</div>
                            @foreach($group as $setting)
                                <div class="row mb-3">
                                    <div class="col-lg-6 d-flex align-items-center">
                                        <label class="col-form-label col-lg-3">{{ $setting['label'] }}</label>
                                        <div class="col-lg-9">
                                            @if($setting['type'] === 'select')
                                                <select name="values[{{ $setting['key'] }}]" class="form-control form-select select" required>
                                                    <option value="">--Select--</option>
                                                    @foreach($setting['options'] as $optionKey => $optionValue)
                                                        <option value="{{ $optionKey }}" {{ settings($setting['key']) == $optionKey ? 'selected' : '' }}>{{ $optionValue }}</option>
                                                    @endforeach
                                                </select>
                                            @elseif($setting['type'] === 'password')
                                                <input type="password" name="values[{{ $setting['key'] }}]" value="{{ settings($setting['key']) }}" class="form-control fw-semibold" placeholder="{{ $setting['label'] }}">
                                            @else
                                                <input type="text" name="values[{{ $setting['key'] }}]" value="{{ settings($setting['key']) }}" class="form-control fw-semibold" placeholder="{{ $setting['label'] }}">
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Save Changes<i class="ph-paper-plane-tilt ms-2"></i></button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
<script>
    $(function(){
        $('.select').select2();
    });
</script>
@endsection
