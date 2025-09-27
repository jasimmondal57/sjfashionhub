@php
    $settings = \App\Models\AnalyticsSetting::first();
@endphp

@if($settings && $settings->isGoogleAnalyticsActive())
<!-- Google Analytics 4 -->
<script async src="https://www.googletagmanager.com/gtag/js?id={{ $settings->google_analytics_id }}"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', '{{ $settings->google_analytics_id }}', {
    page_title: '{{ $title ?? '' }}',
    page_location: '{{ url()->current() }}',
    send_page_view: true
  });
</script>
@endif
