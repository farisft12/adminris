@extends('layouts.app')

@section('title', 'Tambah Administrasi')

@section('content')
<div class="mx-auto max-w-3xl px-4 py-6 sm:px-6 lg:px-8" x-data="administrasiForm()" @kode-rekening-selected="kodeRekeningId = $event.detail.id; fetchEtalases()">
    <div class="mb-6">
        <a href="{{ route('administrasi.index', request()->only('sub_kegiatan_id', 'year_id', 'kode_rekening_id')) }}"
            class="inline-flex items-center gap-2 text-sm font-medium text-slate-600 hover:text-slate-900">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Data Administrasi
        </a>
    </div>

    <div class="rounded-xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-200 bg-slate-50 px-6 py-5 sm:px-8">
            <h1 class="text-xl font-semibold text-slate-900">Tambah Data Administrasi</h1>
            <p class="mt-1 text-sm text-slate-500">Isi data belanja. Pajak (PPN, PPH) bisa diisi manual atau pakai tombol isi otomatis.</p>
        </div>

        <form id="administrasi-create-form" method="POST" action="{{ route('administrasi.store') }}" class="space-y-6 px-6 py-6 sm:px-8 sm:py-8">
            @csrf

            {{-- Identitas --}}
            <div class="grid gap-4 sm:grid-cols-2">
                <div>
                    <label for="sub_kegiatan_id" class="mb-1.5 block text-sm font-medium text-slate-700">Sub Kegiatan <span class="text-red-500">*</span></label>
                    <select id="sub_kegiatan_id" name="sub_kegiatan_id" required
                        class="block w-full rounded-lg border border-slate-300 px-3 py-2.5 text-slate-900 focus:border-slate-500 focus:ring-2 focus:ring-slate-500/20"
                        x-model="subKegiatanId"
                        @change="fetchNextNo()">
                        <option value="">-- Pilih Sub Kegiatan --</option>
                        @foreach($subKegiatans as $sk)
                            <option value="{{ $sk->id }}">{{ $sk->nama_sub_kegiatan }} ({{ $sk->year->tahun ?? '' }})</option>
                        @endforeach
                    </select>
                    @error('sub_kegiatan_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">No</label>
                    <input type="text" :value="nextNo" readonly
                        class="block w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-2.5 text-slate-600" />
                </div>
            </div>

            {{-- Uraian --}}
            <div>
                <label for="uraian_belanja" class="mb-1.5 block text-sm font-medium text-slate-700">Uraian Belanja <span class="text-red-500">*</span></label>
                <textarea id="uraian_belanja" name="uraian_belanja" rows="3" required
                    placeholder="Contoh: Pembelian alat tulis kantor"
                    class="block w-full rounded-lg border border-slate-300 px-3 py-2.5 text-slate-900 focus:border-slate-500 focus:ring-2 focus:ring-slate-500/20 @error('uraian_belanja') border-red-500 @enderror">{{ old('uraian_belanja') }}</textarea>
                @error('uraian_belanja')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tagihan & Tanggal --}}
            <div class="grid gap-4 sm:grid-cols-2">
                <div>
                    <label for="tagihan" class="mb-1.5 block text-sm font-medium text-slate-700">Tagihan (Rp) <span class="text-red-500">*</span></label>
                    <input id="tagihan" type="number" name="tagihan" step="0.01" min="0" required
                        x-model.number="tagihan"
                        placeholder="0"
                        class="block w-full rounded-lg border border-slate-300 px-3 py-2.5 text-slate-900 focus:border-slate-500 focus:ring-2 focus:ring-slate-500/20 @error('tagihan') border-red-500 @enderror" value="{{ old('tagihan') }}" />
                    @error('tagihan')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="tanggal_nota_persetujuan" class="mb-1.5 block text-sm font-medium text-slate-700">Tanggal Nota Persetujuan <span class="text-red-500">*</span></label>
                    <input id="tanggal_nota_persetujuan" type="date" name="tanggal_nota_persetujuan" required
                        class="block w-full rounded-lg border border-slate-300 px-3 py-2.5 text-slate-900 focus:border-slate-500 focus:ring-2 focus:ring-slate-500/20 @error('tanggal_nota_persetujuan') border-red-500 @enderror" value="{{ old('tanggal_nota_persetujuan', date('Y-m-d')) }}" />
                    @error('tanggal_nota_persetujuan')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Kode Rekening (searchable) --}}
            <div class="relative" x-data="searchableSelect(
                {{ json_encode($kodeRekenings->map(fn($kr) => ['id' => $kr->id, 'label' => $kr->kode_rekening . ' - ' . $kr->nama_rekening])->values()->all()) }},
                {{ json_encode(old('kode_rekening_id', $selectedKodeRekeningId)) }}
            )">
                <label for="kode_rekening_search" class="mb-1.5 block text-sm font-medium text-slate-700">Kode Rekening <span class="text-red-500">*</span></label>
                <div class="relative">
                    <input type="text" id="kode_rekening_search" x-model="searchQuery" @focus="open = true" @input="open = true"
                        placeholder="Ketik untuk cari kode atau nama..."
                        class="block w-full rounded-lg border border-slate-300 px-3 py-2.5 pr-10 text-slate-900 focus:border-slate-500 focus:ring-2 focus:ring-slate-500/20"
                        autocomplete="off" />
                    <input type="hidden" name="kode_rekening_id" :value="selectedId" form="administrasi-create-form" />
                    <span class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-slate-400">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </span>
                </div>
                <div x-show="open" @click.away="open = false" x-cloak x-transition
                    class="absolute left-0 right-0 z-20 mt-1 max-h-52 overflow-auto rounded-lg border border-slate-200 bg-white shadow-lg">
                    <template x-for="opt in filteredOptions" :key="opt.id">
                        <button type="button" @click="select(opt)"
                            class="block w-full px-4 py-2.5 text-left text-sm text-slate-700 hover:bg-slate-100"
                            x-text="opt.label"></button>
                    </template>
                    <p x-show="filteredOptions.length === 0" class="px-4 py-3 text-sm text-slate-500">Tidak ada hasil</p>
                </div>
                @error('kode_rekening_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Etalase --}}
            <div>
                <label for="etalase_id" class="mb-1.5 block text-sm font-medium text-slate-700">Etalase <span class="text-red-500">*</span></label>
                <select id="etalase_id" name="etalase_id" required
                    class="block w-full rounded-lg border border-slate-300 px-3 py-2.5 text-slate-900 focus:border-slate-500 focus:ring-2 focus:ring-slate-500/20 disabled:bg-slate-100 disabled:text-slate-500"
                    x-model="etalaseId"
                    :disabled="etalases.length === 0">
                    <option value="">Pilih Kode Rekening terlebih dahulu</option>
                    <template x-for="e in etalases" :key="e.id">
                        <option :value="e.id" x-text="e.nama_etalase"></option>
                    </template>
                </select>
                @error('etalase_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Pajak (opsional) --}}
            <div class="rounded-lg border border-slate-200 bg-slate-50/50 p-4 sm:p-5">
                <p class="mb-4 text-sm font-medium text-slate-700">Pajak (opsional)</p>
                <p class="mb-4 text-sm text-slate-500">Isi manual atau klik tombol isi otomatis berdasarkan Tagihan.</p>
                <div class="grid gap-4 sm:grid-cols-3">
                    <div>
                        <label for="ppn" class="mb-1 block text-sm text-slate-600">PPN (11%)</label>
                        <div class="flex flex-col gap-2 sm:flex-row">
                            <input id="ppn" type="number" name="ppn" step="0.01" min="0"
                                x-model.number="ppn"
                                placeholder="0"
                                class="min-w-0 flex-1 rounded-lg border border-slate-300 bg-white px-3 py-2 text-slate-900 focus:border-slate-500 focus:ring-2 focus:ring-slate-500/20" value="{{ old('ppn') }}" />
                            <button type="button" @click="isiPpn()" class="rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">
                                Isi otomatis
                            </button>
                        </div>
                    </div>
                    <div>
                        <label for="pph23" class="mb-1 block text-sm text-slate-600">PPH 23 (2%)</label>
                        <div class="flex flex-col gap-2 sm:flex-row">
                            <input id="pph23" type="number" name="pph23" step="0.01" min="0"
                                x-model.number="pph23"
                                placeholder="0"
                                class="min-w-0 flex-1 rounded-lg border border-slate-300 bg-white px-3 py-2 text-slate-900 focus:border-slate-500 focus:ring-2 focus:ring-slate-500/20" value="{{ old('pph23') }}" />
                            <button type="button" @click="isiPph23()" class="rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">
                                Isi otomatis
                            </button>
                        </div>
                    </div>
                    <div>
                        <label for="pph21" class="mb-1 block text-sm text-slate-600">PPH 21 (5%)</label>
                        <div class="flex flex-col gap-2 sm:flex-row">
                            <input id="pph21" type="number" name="pph21" step="0.01" min="0"
                                x-model.number="pph21"
                                placeholder="0"
                                class="min-w-0 flex-1 rounded-lg border border-slate-300 bg-white px-3 py-2 text-slate-900 focus:border-slate-500 focus:ring-2 focus:ring-slate-500/20" value="{{ old('pph21') }}" />
                            <button type="button" @click="isiPph21()" class="rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">
                                Isi otomatis
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Keterangan --}}
            <div>
                <label for="keterangan" class="mb-1.5 block text-sm font-medium text-slate-700">Keterangan</label>
                <textarea id="keterangan" name="keterangan" rows="2"
                    placeholder="Opsional"
                    class="block w-full rounded-lg border border-slate-300 px-3 py-2.5 text-slate-900 focus:border-slate-500 focus:ring-2 focus:ring-slate-500/20">{{ old('keterangan') }}</textarea>
            </div>

            {{-- Penerima (untuk kwitansi) --}}
            <div>
                <label for="penerima" class="mb-1.5 block text-sm font-medium text-slate-700">Penerima</label>
                <input id="penerima" type="text" name="penerima" value="{{ old('penerima') }}"
                    placeholder="Nama penerima di kwitansi (kosongkan bila tidak diisi)"
                    class="block w-full rounded-lg border border-slate-300 px-3 py-2.5 text-slate-900 focus:border-slate-500 focus:ring-2 focus:ring-slate-500/20" />
                <p class="mt-1 text-xs text-slate-500">Opsional. Jika kosong, kolom &quot;Yang menerima&quot; di kwitansi akan kosong.</p>
            </div>

            {{-- Actions --}}
            <div class="flex flex-col-reverse gap-3 border-t border-slate-200 pt-6 sm:flex-row sm:justify-end sm:gap-3">
                <a href="{{ route('administrasi.index', request()->only('sub_kegiatan_id', 'year_id', 'kode_rekening_id')) }}"
                    class="inline-flex justify-center rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-50">
                    Batal
                </a>
                <button type="submit"
                    class="inline-flex justify-center rounded-lg bg-slate-800 px-4 py-2.5 text-sm font-medium text-white hover:bg-slate-700">
                    Simpan Data
                </button>
            </div>
        </form>
    </div>
</div>

@push('styles')
<style>[x-cloak]{display:none!important}</style>
@endpush
@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('searchableSelect', (options, initialId) => ({
        options: options || [],
        selectedId: initialId || '',
        selectedLabel: '',
        searchQuery: '',
        open: false,
        get filteredOptions() {
            const q = (this.searchQuery || '').toLowerCase();
            if (!q) return this.options;
            return this.options.filter(o => (o.label || '').toLowerCase().includes(q));
        },
        init() {
            if (this.selectedId) {
                const o = this.options.find(x => x.id == this.selectedId);
                if (o) { this.selectedLabel = o.label; this.searchQuery = o.label; }
            }
            this.$watch('selectedId', (v) => {
                const o = this.options.find(x => x.id == v);
                this.selectedLabel = o ? o.label : '';
                this.searchQuery = this.selectedLabel;
            });
        },
        select(opt) {
            this.selectedId = opt.id;
            this.selectedLabel = opt.label;
            this.searchQuery = opt.label;
            this.open = false;
            this.$dispatch('kode-rekening-selected', { id: opt.id });
        }
    }));
});

function administrasiForm() {
    return {
        subKegiatanId: @json(old('sub_kegiatan_id', $selectedSubKegiatanId)),
        kodeRekeningId: @json(old('kode_rekening_id', $selectedKodeRekeningId)),
        etalaseId: @json(old('etalase_id')),
        tagihan: {{ (float) old('tagihan', 0) }},
        ppn: {{ (float) old('ppn', 0) }},
        pph23: {{ (float) old('pph23', 0) }},
        pph21: {{ (float) old('pph21', 0) }},
        nextNo: {{ (int) $nextNo }},
        etalases: @json($etalases),
        init() {
            if (this.kodeRekeningId) this.fetchEtalases();
            if (this.subKegiatanId) this.fetchNextNo();
        },
        isiPpn() {
            const t = Number(this.tagihan) || 0;
            this.ppn = Math.round(t * 0.11 * 100) / 100;
        },
        isiPph23() {
            const t = Number(this.tagihan) || 0;
            this.pph23 = Math.round(t * 0.02 * 100) / 100;
        },
        isiPph21() {
            const t = Number(this.tagihan) || 0;
            this.pph21 = Math.round(t * 0.05 * 100) / 100;
        },
        fetchEtalases() {
            const id = this.kodeRekeningId;
            this.etalaseId = '';
            this.etalases = [];
            if (!id) return;
            fetch(`{{ url('api/etalases') }}?kode_rekening_id=${id}`, {
                headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
            })
            .then(r => r.json())
            .then(data => { this.etalases = data; })
            .catch(() => {});
        },
        fetchNextNo() {
            if (!this.subKegiatanId) { this.nextNo = 1; return; }
            fetch(`{{ url('api/administrasi/next-no') }}?sub_kegiatan_id=${this.subKegiatanId}`, {
                headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
            })
            .then(r => r.json())
            .then(data => { this.nextNo = data.next_no || 1; })
            .catch(() => { this.nextNo = 1; });
        }
    };
}
</script>
@endpush
@endsection
