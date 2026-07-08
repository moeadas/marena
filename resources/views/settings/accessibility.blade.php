@extends('layouts.app')
@section('content')
<div class="max-w-md mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold text-marena-teal-deep mb-6">Accessibility</h1>
    <form method="POST" action="{{ route('settings.accessibility.update') }}">
        @csrf
        @php $p = $prefs ?? []; @endphp
        <div class="card space-y-4">
            <label class="flex items-center justify-between cursor-pointer">
                <div>
                    <p class="text-sm font-medium">Large text</p>
                    <p class="text-xs text-marena-ink-50">Increase font size for better readability</p>
                </div>
                <input type="checkbox" name="large_text" value="1" @checked(in_array('large_text', array_keys($p))) class="w-6 h-6 rounded text-marena-teal">
            </label>
            <label class="flex items-center justify-between cursor-pointer">
                <div>
                    <p class="text-sm font-medium">High contrast</p>
                    <p class="text-xs text-marena-ink-50">Increase color contrast</p>
                </div>
                <input type="checkbox" name="high_contrast" value="1" @checked(in_array('high_contrast', array_keys($p))) class="w-6 h-6 rounded text-marena-teal">
            </label>
            <label class="flex items-center justify-between cursor-pointer">
                <div>
                    <p class="text-sm font-medium">Reduced motion</p>
                    <p class="text-xs text-marena-ink-50">Minimize animations</p>
                </div>
                <input type="checkbox" name="reduced_motion" value="1" @checked(in_array('reduced_motion', array_keys($p))) class="w-6 h-6 rounded text-marena-teal">
            </label>
            <label class="flex items-center justify-between cursor-pointer">
                <div>
                    <p class="text-sm font-medium">Voice assistance</p>
                    <p class="text-xs text-marena-ink-50">Read content aloud (coming soon)</p>
                </div>
                <input type="checkbox" name="voice_assistance" value="1" @checked(in_array('voice_assistance', array_keys($p))) class="w-6 h-6 rounded text-marena-teal" disabled>
            </label>
        </div>
        <button type="submit" class="btn btn-primary w-full mt-4">Save Preferences</button>
    </form>
</div>
@endsection