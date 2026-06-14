@extends('layouts.app')
@section('title', 'Settings')
@section('page-title', 'Settings – AI Configuration')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-7">

        @if(session('success'))
            <div class="alert-success-custom">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        <div class="card-box">
            <h5><i class="fas fa-robot"></i> Gemini AI API Key</h5>

            <div style="background:#f0f9ff; border:1px solid #bae6fd; border-radius:10px; padding:14px 16px; margin-bottom:20px; font-size:.85rem; color:#0369a1;">
                <i class="fas fa-info-circle"></i>
                <strong>Save your Gemini API key here.</strong> Students will be able to use the AI assistant.
                <br>Get your key from Google AI Studio:
                <a href="https://aistudio.google.com/app/apikey" target="_blank">aistudio.google.com</a>
            </div>

            <form method="POST" action="{{ route('admin.settings.save') }}">
                @csrf
                <div class="mb-4">
                    <label class="form-label">Gemini API Key</label>
                    <input type="text" name="gemini_api_key" class="form-control"
                           value="{{ $setting->gemini_api_key ?? '' }}"
                           placeholder="AIza... paste your key here">
                    <div style="font-size:.78rem; color:#9ca3af; margin-top:5px;">
                        Keep this key private. Do not share it with anyone.
                    </div>
                </div>
                <button type="submit" class="btn-primary-custom">
                    <i class="fas fa-save"></i> Save Settings
                </button>
            </form>

            @if($setting->gemini_api_key ?? false)
                <div style="margin-top:16px; padding:12px 16px; background:#f0fdf4; border-radius:9px; font-size:.85rem; color:#16a34a;">
                    <i class="fas fa-check-circle"></i>
                    API key is saved. Students can use the AI assistant.
                </div>
            @else
                <div style="margin-top:16px; padding:12px 16px; background:#fef9c3; border-radius:9px; font-size:.85rem; color:#ca8a04;">
                    <i class="fas fa-exclamation-triangle"></i>
                    No API key set. AI assistant will not work for students.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
