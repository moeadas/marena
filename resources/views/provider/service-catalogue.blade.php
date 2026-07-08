@extends('layouts.app', ['pageTitle' => 'Service Catalogue'])

@section('bottom_nav')
    @include('partials.bottom-nav-provider', ['current' => 'dashboard'])
@endsection

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-xl font-semibold text-marena-teal-deep">Service Catalogue</h1>
        <button class="btn-sm btn-primary">+ Add Service</button>
    </div>

    @if(isset($services) && $services->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            @foreach($services as $service)
                <div class="card">
                    <div class="flex items-start justify-between mb-2">
                        <div>
                            <p class="font-medium text-sm text-marena-ink">{{ $service->name ?? 'Service' }}</p>
                            <p class="text-xs text-marena-ink-50 mt-0.5">{{ $service->category ?? '' }}</p>
                        </div>
                        <span class="badge-pending">{{ $service->funding_type ?? 'Private' }}</span>
                    </div>
                    <div class="flex items-center gap-4 mt-3 pt-3 border-t border-marena-ink-10">
                        <div>
                            <p class="text-xs text-marena-ink-50">Duration</p>
                            <p class="text-sm font-medium text-marena-teal-deep">{{ $service->duration ?? '60' }} min</p>
                        </div>
                        <div>
                            <p class="text-xs text-marena-ink-50">Tariff</p>
                            <p class="text-sm font-medium text-marena-teal-deep">€{{ $service->tariff ?? '0' }}</p>
                        </div>
                    </div>
                    <button class="btn-sm btn-outline w-full mt-3">Edit Checklist Template</button>
                </div>
            @endforeach
        </div>
    @else
        <div class="card">
            <x-empty-state icon="M4 19.5A2.5 2.5 0 0 1 6.5 17H20;M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z" title="No services yet" cta="Add a service" cta-route="#" />
        </div>
    @endif
</div>
@endsection