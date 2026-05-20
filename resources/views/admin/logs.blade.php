@extends('admin.layouts.app')

@section('title', 'Error Logs')
@section('page_title', 'Error Logs')

@section('content')
<div class="admin-card" style="margin-bottom: 1.5rem; padding: 1.25rem 1.5rem; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem;">
    <div style="font-size: 0.875rem; color: #666;">
        <strong>{{ $total }}</strong> entri log ditemukan
        @if($truncated)
            <span style="color: #ca8a04; margin-left: 0.5rem;">(Hanya menampilkan 2 MB terakhir dari file log)</span>
        @endif
        &nbsp;·&nbsp; Ukuran file: <strong>{{ number_format($fileSize / 1024, 1) }} KB</strong>
    </div>
    <form action="{{ route('admin.logs.clear') }}" method="POST"
          onsubmit="return confirm('Yakin ingin mengosongkan file log? Tindakan ini tidak dapat dibatalkan.')">
        @csrf
        @method('DELETE')
        <button type="submit" style="background: #dc2626; color: #fff; border: none; padding: 8px 18px; border-radius: 6px; cursor: pointer; font-size: 0.85rem; font-weight: 600;">
            <i class="fas fa-trash-alt" style="margin-right: 6px;"></i> Clear Log
        </button>
    </form>
</div>

@if(session('success'))
    <div style="background: rgba(22,163,74,0.1); border-left: 4px solid #16a34a; padding: 12px 16px; border-radius: 6px; color: #16a34a; margin-bottom: 1.5rem; font-size: 0.875rem;">
        {{ session('success') }}
    </div>
@endif

@if($paginator->isEmpty())
    <div class="admin-card" style="text-align: center; padding: 3rem; color: #888;">
        <i class="fas fa-check-circle" style="font-size: 2.5rem; color: #16a34a; margin-bottom: 1rem; display: block;"></i>
        <p>File log kosong — tidak ada error yang tercatat.</p>
    </div>
@else
    @foreach($paginator as $entry)
    @php
        $colors = [
            'error'     => ['bg' => 'rgba(220,38,38,0.06)',   'border' => '#dc2626', 'badge' => '#dc2626'],
            'critical'  => ['bg' => 'rgba(220,38,38,0.1)',    'border' => '#991b1b', 'badge' => '#991b1b'],
            'alert'     => ['bg' => 'rgba(234,88,12,0.08)',   'border' => '#ea580c', 'badge' => '#ea580c'],
            'emergency' => ['bg' => 'rgba(127,29,29,0.1)',    'border' => '#7f1d1d', 'badge' => '#7f1d1d'],
            'warning'   => ['bg' => 'rgba(202,138,4,0.06)',   'border' => '#ca8a04', 'badge' => '#ca8a04'],
            'notice'    => ['bg' => 'rgba(37,99,235,0.06)',   'border' => '#2563eb', 'badge' => '#2563eb'],
            'debug'     => ['bg' => 'rgba(107,114,128,0.06)', 'border' => '#6b7280', 'badge' => '#6b7280'],
            'info'      => ['bg' => 'rgba(13,76,84,0.06)',    'border' => '#0d4c54', 'badge' => '#0d4c54'],
        ];
        $c = $colors[$entry['level']] ?? $colors['info'];
    @endphp
    <div style="background: {{ $c['bg'] }}; border-left: 4px solid {{ $c['border'] }}; border-radius: 6px; margin-bottom: 0.75rem; padding: 12px 16px; font-family: monospace; font-size: 0.8rem; overflow-x: auto; white-space: pre-wrap; word-break: break-all;">
        <span style="background: {{ $c['badge'] }}; color: #fff; padding: 2px 8px; border-radius: 4px; font-size: 0.7rem; font-weight: 700; margin-right: 8px; font-family: sans-serif; text-transform: uppercase;">{{ $entry['level'] }}</span>{{ $entry['content'] }}
    </div>
    @endforeach

    <div style="margin-top: 1.5rem;">
        {{ $paginator->links() }}
    </div>
@endif
@endsection
