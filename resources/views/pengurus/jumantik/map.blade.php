@extends('layouts.admin')
@section('title', 'Peta Jumantik -')
@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
<style>
    .jumantik-map { height: 70vh; width: 100%; position: relative; z-index: 0; }
    .jumantik-cluster-wrap { background: none; border: 0; }
    .jumantik-cluster {
        border-radius: 9999px;
        background: #2563eb;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        border: 3px solid #fff;
        box-shadow: 0 1px 4px rgba(0, 0, 0, .35);
    }
    .jumantik-cluster.has-jentik { background: #dc2626; }
</style>
@endpush
@section('content')
<div class="p-2">
    @php
        $listQuery = array_filter(['rt' => $selectedRt, 'jentik' => $selectedJentik]);
        $scopeLabel = $selectedRt ? 'RT. '.$selectedRt : ($rts->isEmpty() ? 'RT. '.auth()->user()->rt : 'Semua RT');
    @endphp
    <div class="flex items-center justify-between gap-2 py-2">
        <h1 class="font-bold text-xl">Peta Laporan Jumantik</h1>
        <a href="{{ route('pengurus.jumantik.index', $listQuery) }}" class="btn btn-outline btn-sm">Kembali</a>
    </div>
    <p class="text-sm pb-2">{{ $scopeLabel }}{{ $selectedJentik === 'ya' ? ' · ditemukan jentik' : '' }}{{ $selectedJentik === 'tidak' ? ' · tidak ditemukan jentik' : '' }}. {{ $points->count() }} dari {{ $totalReports }} laporan punya titik.</p>
    <div class="flex flex-wrap gap-3 text-sm pb-2">
        <span class="inline-flex items-center gap-1"><span class="inline-block w-3 h-3 rounded-full" style="background:#dc2626"></span> Ditemukan jentik</span>
        <span class="inline-flex items-center gap-1"><span class="inline-block w-3 h-3 rounded-full" style="background:#2563eb"></span> Tidak ditemukan</span>
        <span class="inline-flex items-center gap-1"><span class="inline-block w-3 h-3 rounded-full border border-base-content" style="background:#2563eb;opacity:.45"></span> Koordinat default RT</span>
        <span>Angka pada peta adalah jumlah laporan saat tampilan dijauhkan.</span>
    </div>
    @if($points->isEmpty())
    <p class="italic text-primary pb-2">Belum ada laporan dengan koordinat.</p>
    @endif
    <div id="jumantik-map" class="jumantik-map rounded-lg border border-base-300"></div>
    @if($unmapped->isNotEmpty())
    <div class="pt-3">
        <p class="font-semibold text-sm">Tanpa koordinat</p>
        <ul class="text-sm list-disc pl-5">
            @foreach($unmapped as $report)
            <li>{{ $report->name }} - RT. {{ $report->rt }}</li>
            @endforeach
        </ul>
    </div>
    @endif
</div>
@endsection
@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script src="https://unpkg.com/leaflet.markercluster@1.5.3/dist/leaflet.markercluster.js"></script>
<script>
    const jumantikMapPoints = @json($points);
    const jumantikMapFocus = @json($focus);

    const map = L.map('jumantik-map').setView([-6.191, 106.768], 15);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; OpenStreetMap'
    }).addTo(map);

    function escapeHtml(value) {
        return String(value ?? '')
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;');
    }

    function markerOffset(index, total) {
        if (total < 2) {
            return [0, 0];
        }
        const angle = (2 * Math.PI * index) / total;
        const radius = 0.00012;
        return [Math.cos(angle) * radius, Math.sin(angle) * radius];
    }

    function markerStyle(point) {
        const color = point.has_jentik ? '#dc2626' : '#2563eb';
        return {
            radius: 9,
            color: color,
            fillColor: color,
            fillOpacity: point.source === 'rt' ? 0.45 : 0.9,
            weight: 2,
        };
    }

    function popupHtml(point) {
        const jentik = point.has_jentik ? 'Ditemukan jentik' : 'Tidak ditemukan jentik';
        const source = point.source === 'rt' ? 'Koordinat default RT' : 'Koordinat laporan';
        return '<strong>' + escapeHtml(point.name) + '</strong><br>RT. ' + escapeHtml(point.rt)
            + '<br>' + escapeHtml(point.address)
            + '<br>' + escapeHtml(point.created_at)
            + '<br>' + jentik
            + '<br><em>' + source + '</em>';
    }

    const groups = new Map();
    jumantikMapPoints.forEach(function (point) {
        const key = Number(point.latitude).toFixed(5) + ',' + Number(point.longitude).toFixed(5);
        if (!groups.has(key)) {
            groups.set(key, []);
        }
        groups.get(key).push(point);
    });

    const cluster = L.markerClusterGroup({
        showCoverageOnHover: false,
        maxClusterRadius: 60,
        spiderfyOnMaxZoom: true,
        disableClusteringAtZoom: 18,
        iconCreateFunction: function (group) {
            const children = group.getAllChildMarkers();
            const total = children.length;
            const hasJentik = children.some(function (marker) {
                return marker.options.jumantikJentik;
            });
            const size = total >= 100 ? 52 : (total >= 10 ? 44 : 36);

            return L.divIcon({
                html: '<div class="jumantik-cluster' + (hasJentik ? ' has-jentik' : '') + '" style="width:' + size + 'px;height:' + size + 'px;font-size:' + (total >= 100 ? 16 : 14) + 'px"><span>' + total + '</span></div>',
                className: 'jumantik-cluster-wrap',
                iconSize: [size, size],
            });
        },
    });

    const bounds = [];
    let focused = null;
    groups.forEach(function (group) {
        group.forEach(function (point, index) {
            const shift = markerOffset(index, group.length);
            const latlng = [Number(point.latitude) + shift[0], Number(point.longitude) + shift[1]];
            const marker = L.circleMarker(latlng, Object.assign(markerStyle(point), {
                jumantikJentik: point.has_jentik,
            }));
            marker.bindPopup(popupHtml(point));
            cluster.addLayer(marker);
            bounds.push(latlng);
            if (jumantikMapFocus && Number(point.id) === Number(jumantikMapFocus)) {
                focused = marker;
            }
        });
    });

    map.addLayer(cluster);

    if (bounds.length && ! focused) {
        map.fitBounds(bounds, { padding: [32, 32], maxZoom: 16 });
    }
    if (focused) {
        cluster.zoomToShowLayer(focused, function () {
            focused.openPopup();
        });
    }
    map.invalidateSize();
</script>
@endpush
