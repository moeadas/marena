@extends('layouts.app')
@section('content')
<div class="max-w-md mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold text-marena-teal-deep mb-6">Notifications</h1>
    <form method="POST" action="{{ route('settings.notifications.update') }}">
        @csrf
        <div class="card space-y-4">
            @php $p = $prefs ?? []; @endphp
            <label class="flex items-center justify-between cursor-pointer">
                <span class="text-sm font-medium">Email notifications</span>
                <input type="checkbox" name="email_notifications" value="1" @checked(in_array('email_notifications', array_keys($p))) class="w-5 h-5 rounded text-marena-teal">
            </label>
            <label class="flex items-center justify-between cursor-pointer">
                <span class="text-sm font-medium">Push notifications</span>
                <input type="checkbox" name="push_notifications" value="1" @checked(in_array('push_notifications', array_keys($p))) class="w-5 h-5 rounded text-marena-teal">
            </label>
            <label class="flex items-center justify-between cursor-pointer">
                <span class="text-sm font-medium">Visit reminders</span>
                <input type="checkbox" name="visit_reminders" value="1" @checked(in_array('visit_reminders', array_keys($p))) class="w-5 h-5 rounded text-marena-teal">
            </label>
            <label class="flex items-center justify-between cursor-pointer">
                <span class="text-sm font-medium">Message alerts</span>
                <input type="checkbox" name="message_alerts" value="1" @checked(in_array('message_alerts', array_keys($p))) class="w-5 h-5 rounded text-marena-teal">
            </label>
            <label class="flex items-center justify-between cursor-pointer">
                <span class="text-sm font-medium">Service updates</span>
                <input type="checkbox" name="service_updates" value="1" @checked(in_array('service_updates', array_keys($p))) class="w-5 h-5 rounded text-marena-teal">
            </label>
            <label class="flex items-center justify-between cursor-pointer">
                <span class="text-sm font-medium">Weekly summary</span>
                <input type="checkbox" name="weekly_summary" value="1" @checked(in_array('weekly_summary', array_keys($p))) class="w-5 h-5 rounded text-marena-teal">
            </label>
        </div>
        <button type="submit" class="btn-primary w-full mt-4">Save Preferences</button>
    </form>
</div>
@endsection