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
                @foreach ($settingsGroups as $tab => $sections)
                    <li class="nav-item" role="presentation">
                        <button class="nav-link {{ $loop->first ? 'active' : '' }}" id="{{ Str::slug($tab, '_') }}-tab"
                            data-bs-toggle="tab" data-bs-target="#{{ Str::slug($tab, '_') }}" type="button" role="tab">
                            {{ ucfirst($tab) }}
                        </button>
                    </li>
                @endforeach
            </ul>

            <form method="POST" action="{{ route('settings.save') }}" enctype="multipart/form-data">
                @csrf
                <!-- Tabs Content -->
                <div class="tab-content" id="settingsTabContent">
                    @foreach ($settingsGroups as $tab => $sections)
                        <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="{{ Str::slug($tab, '_') }}"
                            role="tabpanel">
                            <div class="fw-bold border-bottom pb-2 mb-3">{{ ucfirst($tab) }} Settings</div>
                            @foreach ($sections as $section => $settings)
                                <h6 class="mt-3 mb-2">{{ ucfirst($section) }}</h6>
                                @foreach ($settings as $key => $setting)
                                    <div class="row mb-3">
                                        <div class="col-lg-6 d-flex align-items-center">
                                            <label class="col-form-label col-lg-3"
                                                for="{{ $key }}">{{ $setting->name }}</label>
                                            <div class="col-lg-9">
                                                @if ($setting['type'] === 'dropdown')
                                                    @if ($setting->key === 'default_country_id')
                                                        <select name="values[{{ $key }}]"
                                                            class="form-control form-select select">
                                                            <option value="">--Select--</option>
                                                            @foreach (countries() as $optionKey => $optionValue)
                                                                <option value="{{ $optionKey }}"
                                                                    name="{{ $key }}"
                                                                    {{ $setting->value == $optionKey ? 'selected' : '' }}>
                                                                    {{ $optionValue }}</option>
                                                            @endforeach
                                                        </select>
                                                    @elseif($setting->key === 'location_system')
                                                        <select name="values[{{ $key }}]"
                                                            class="form-control form-select select">
                                                            @foreach (json_decode($setting->options) as $optionKey => $optionValue)
                                                                <option value="{{ $optionKey }}"
                                                                    name="{{ $key }}"
                                                                    {{ $setting->value == $optionKey ? 'selected' : '' }}>
                                                                    {{ $optionValue }}</option>
                                                            @endforeach
                                                        </select>
                                                    @endif
                                                @elseif($setting['type'] === 'password')
                                                    <input type="password" name="values[{{ $key }}]"
                                                        value="{{ $setting->value }}" class="form-control fw-semibold"
                                                        placeholder="{{ $setting->name }}">
                                                @else
                                                    <input type="text" name="values[{{ $key }}]"
                                                        value="{{ $setting->value }}" class="form-control fw-semibold"
                                                        placeholder="{{ $setting->name }}">
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endforeach
                        </div>
                    @endforeach
                </div>
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Save Changes<i
                            class="ph-paper-plane-tilt ms-2"></i></button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(function() {
            $('.select').select2();
        });
    </script>
@endsection
