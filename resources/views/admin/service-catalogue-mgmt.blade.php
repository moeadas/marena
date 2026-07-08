@extends('layouts.app', ['pageTitle' => 'Service Catalogue Management'])

@section('bottom_nav')
    @include('partials.side-nav-admin', ['current' => 'services'])
@endsection

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-semibold text-marena-teal-deep">Service Catalogue</h1>
        <button class="btn-sm btn-primary">+ New Service</button>
    </div>

    <!-- Categories -->
    <div>
        <x-section-header title="Categories" action-label="Add" action-route="#" />
        <div class="flex flex-wrap gap-2">
            @foreach(['Nursing', 'Physiotherapy', 'Home Care', 'Medication', 'Transport', 'Companionship', 'Palliative'] as $cat)
                <span class="badge-scheduled">{{ $cat }}</span>
            @endforeach
        </div>
    </div>

    <!-- Services -->
    @if(isset($services) && $services->count() > 0)
        <div>
            <x-section-header title="Predefined Services" />
            <div class="space-y-3">
                @foreach($services as $service)
                    <div class="card">
                        <div class="flex items-start justify-between mb-2">
                            <div>
                                <p class="font-medium text-sm text-marena-ink">{{ $service->name ?? 'Service' }}</p>
                                <p class="text-xs text-marena-ink-50">{{ $service->category ?? '' }}</p>
                            </div>
                            <div class="flex gap-2">
                                <span class="badge-pending">{{ $service->funding_label ?? 'Private' }}</span>
                                <button class="p-1.5 rounded-lg hover:bg-marena-sage-mist">
                                    <svg class="w-4 h-4 text-marena-ink-50" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                                </button>
                            </div>
                        </div>
                        <p class="text-xs text-marena-ink-50">{{ $service->checklist_count ?? 0 }} checklist items &middot; {{ $service->default_duration ?? 60 }} min default</p>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <div class="card">
            <x-empty-state icon="M4 19.5A2.5 2.5 0 0 1 6.5 17H20;M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z" title="No services defined" cta="Add a service" cta-route="#" />
        </div>
    @endif
</div>
@endsection