@extends('layouts.app')

@section('title', 'Tambah Administrasi')

@section('content')
<div class="relative min-h-screen bg-slate-50/50 pb-12 font-sans" x-data="administrasiForm()" @kode-rekening-selected="kodeRekeningId = $event.detail.id; fetchEtalases()">
    {{-- Background Decoration --}}
    <div class="pointer-events-none absolute inset-0 -z-10 overflow-hidden">
        <div class="absolute -left-20 top-20 h-[30rem] w-[30rem] rounded-full bg-indigo-100/40 blur-3xl"></div>
        <div class="absolute right-0 bottom-0 h-[25rem] w-[25rem] rounded-full bg-emerald-100/20 blur-3xl"></div>
    </div>

    <div class="mx-auto max-w-4xl px-4 py-8 sm:px-6 lg:px-8">
        {{-- Header Section --}}
        <div class="mb-8 animate-fade-up">
            <nav class="mb-3 flex items-center gap-2 text-[10px] font-bold uppercase tracking-widest text-slate-400">
                <a href="{{ route('administrasi.index', request()->only('sub_kegiatan_id', 'year_id', 'kode_rekening_id')) }}" class="hover:text-indigo-500 transition-colors">Administrasi</a>
                <i class="fa-solid fa-chevron-right text-[8px] opacity-50"></i>
                <span class="text-indigo-500">Tambah Data</span>
            </nav>
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="bg-white text-indigo-600 p-3.5 rounded-2xl shadow-sm border border-slate-100">
                        <i class="fa-solid fa-file-circle-plus text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Input Administrasi</h1>
                        <p class="text-sm text-slate-500 mt-1 font-medium">Catat pengeluaran belanja baru ke dalam sistem.</p>
                    </div>
                </div>
                <a href="{{ route('administrasi.index', request()->only('sub_kegiatan_id', 'year_id', 'kode_rekening_id')) }}" 
                    class="hidden sm:inline-flex items-center gap-2 rounded-xl bg-white px-4 py-2 text-xs font-black uppercase tracking-widest text-slate-600 border border-slate-200 hover:bg-slate-50 transition-all shadow-sm">
                    <i class="fa-solid fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>

        {{-- Main Form Card --}}
        <div class="animate-fade-up rounded-[2.5rem] border border-white bg-white/70 shadow-[0_8px_30px_rgb(0,0,0,0.04)] backdrop-blur-xl overflow-hidden" style="animation-delay: 100ms">
            <div class="px-10 py-8 border-b border-slate-100 bg-slate-50/30">
                <h2 class="text-lg font-black text-slate-800 tracking-tight">Informasi Belanja</h2>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Lengkapi detail transaksi di bawah ini</p>
            </div>

            <form id="administrasi-create-form" method="POST" action="{{ route('administrasi.store') }}" class="p-10 space-y-8">
                @csrf

                <div class="grid gap-8 sm:grid-cols-2">
                    {{-- Sub Kegiatan Selection --}}
                    <div class="space-y-2">
                        <label for="sub_kegiatan_id" class="text-[11px] font-black uppercase tracking-widest text-slate-500 ml-1">Sub Kegiatan <span class="text-rose-500">*</span></label>
                        <div class="relative">
                            <select id="sub_kegiatan_id" name="sub_kegiatan_id" required
                                class="block w-full rounded-2xl border-slate-200 bg-white/50 px-4 py-3.5 text-slate-900 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all font-bold text-sm appearance-none"
                                x-model="subKegiatanId" @change="fetchNextNo()">
                                <option value="">-- Pilih Sub Kegiatan --</option>
                                @foreach($subKegiatans as $sk)
                                    <option value="{{ $sk->id }}">{{ $sk->nama_sub_kegiatan }} ({{ $sk->year->tahun ?? '' }})</option>
                                @endforeach
                            </select>
                            <div class="pointer-events-none absolute right-4 top-1/2 -translate-y-1/2 text-slate-400">
                                <i class="fa-solid fa-chevron-down text-xs"></i>
                            </div>
                        </div>
                        @error('sub_kegiatan_id') <p class="text-[10px] font-bold text-rose-500 ml-1 mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- No. Urut (Auto) --}}
                    <div class="space-y-2 text-right sm:text-left">
                        <label class="text-[11px] font-black uppercase tracking-widest text-slate-500 ml-1">Nomor Urut Sistem</label>
                        <div class="h-12 flex items-center px-5 rounded-2xl bg-slate-100/50 border border-slate-200 text-slate-400 font-mono font-black text-sm">
                            <span x-text="'#' + (nextNo || '...')"></span>
                        </div>
                    </div>
                </div>

                {{-- Uraian Belanja --}}
                <div class="space-y-2">
                    <label for="uraian_belanja" class="text-[11px] font-black uppercase tracking-widest text-slate-500 ml-1">Uraian Belanja <span class="text-rose-500">*</span></label>
                    <textarea id="uraian_belanja" name="uraian_belanja" rows="3" required
                        placeholder="Masukkan deskripsi barang atau jasa yang dibeli..."
                        class="block w-full rounded-2xl border-slate-200 bg-white/50 px-5 py-4 text-slate-900 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all font-medium text-sm @error('uraian_belanja') border-rose-300 @enderror">{{ old('uraian_belanja') }}</textarea>
                    @error('uraian_belanja') <p class="text-[10px] font-bold text-rose-500 ml-1 mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="grid gap-8 sm:grid-cols-2">
                    {{-- Nominal Tagihan --}}
                    <div class="space-y-2">
                        <label for="tagihan" class="text-[11px] font-black uppercase tracking-widest text-slate-500 ml-1">Tagihan (Rp) <span class="text-rose-500">*</span></label>
                        <div class="relative">
                            <span class="absolute left-5 top-1/2 -translate-y-1/2 text-slate-400 font-black text-xs">Rp</span>
                            <input id="tagihan" type="number" name="tagihan" step="0.01" min="0" required
                                x-model.number="tagihan" placeholder="0"
                                class="block w-full rounded-2xl border-slate-200 bg-white/50 pl-12 pr-5 py-3.5 text-slate-900 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all font-black text-base" />
                        </div>
                        @error('tagihan') <p class="text-[10px] font-bold text-rose-500 ml-1 mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Tanggal --}}
                    <div class="space-y-2">
                        <label for="tanggal_nota_persetujuan" class="text-[11px] font-black uppercase tracking-widest text-slate-500 ml-1">Tanggal Nota Persetujuan <span class="text-rose-500">*</span></label>
                        <input id="tanggal_nota_persetujuan" type="date" name="tanggal_nota_persetujuan" required
                            class="block w-full rounded-2xl border-slate-200 bg-white/50 px-5 py-3.5 text-slate-900 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all font-bold text-sm" 
                            value="{{ old('tanggal_nota_persetujuan', date('Y-m-d')) }}" />
                        @error('tanggal_nota_persetujuan') <p class="text-[10px] font-bold text-rose-500 ml-1 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid gap-8 sm:grid-cols-2">
                    {{-- Kode Rekening (Searchable) --}}
                    <div class="space-y-2 relative" x-data="searchableSelect(
                        {{ json_encode($kodeRekenings->map(fn($kr) => ['id' => $kr->id, 'label' => $kr->kode_rekening . ' - ' . $kr->nama_rekening])->values()->all()) }},
                        {{ json_encode(old('kode_rekening_id', $selectedKodeRekeningId)) }}
                    )">
                        <label class="text-[11px] font-black uppercase tracking-widest text-slate-500 ml-1">Kode Rekening <span class="text-rose-500">*</span></label>
                        <div class="relative">
                            <input type="text" x-model="searchQuery" @focus="open = true" @input="open = true"
                                placeholder="Cari kode atau nama rekening..."
                                class="block w-full rounded-2xl border-slate-200 bg-white/50 px-5 py-3.5 pr-12 text-slate-900 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all font-bold text-sm"
                                autocomplete="off" />
                            <input type="hidden" name="kode_rekening_id" :value="selectedId" />
                            <div class="absolute right-5 top-1/2 -translate-y-1/2 text-slate-400">
                                <i class="fa-solid fa-magnifying-glass text-xs"></i>
                            </div>
                        </div>
                        {{-- Dropdown Results --}}
                        <div x-show="open" @click.away="open = false" x-cloak x-transition
                            class="absolute left-0 right-0 z-50 mt-2 max-h-60 overflow-y-auto rounded-3xl border border-slate-100 bg-white/95 shadow-2xl backdrop-blur-xl p-2">
                            <template x-for="opt in filteredOptions" :key="opt.id">
                                <button type="button" @click="select(opt)"
                                    class="flex w-full items-center px-4 py-3 rounded-2xl text-left text-xs font-bold text-slate-700 hover:bg-indigo-50 hover:text-indigo-600 transition-colors"
                                    x-text="opt.label"></button>
                            </template>
                        </div>
                        @error('kode_rekening_id') <p class="text-[10px] font-bold text-rose-500 ml-1 mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Etalase --}}
                    <div class="space-y-2">
                        <label for="etalase_id" class="text-[11px] font-black uppercase tracking-widest text-slate-500 ml-1">Etalase <span class="text-rose-500">*</span></label>
                        <div class="relative">
                            <select id="etalase_id" name="etalase_id" required
                                class="block w-full rounded-2xl border-slate-200 bg-white/50 px-4 py-3.5 text-slate-900 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all font-bold text-sm appearance-none disabled:opacity-50"
                                x-model="etalaseId" :disabled="etalases.length === 0">
                                <option value="">Pilih Kode Rekening terlebih dahulu</option>
                                <template x-for="e in etalases" :key="e.id">
                                    <option :value="e.id" x-text="e.nama_etalase"></option>
                                </template>
                            </select>
                            <div class="pointer-events-none absolute right-4 top-1/2 -translate-y-1/2 text-slate-400">
                                <i class="fa-solid fa-layer-group text-xs"></i>
                            </div>
                        </div>
                        @error('etalase_id') <p class="text-[10px] font-bold text-rose-500 ml-1 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Taxes Section --}}
                <div class="rounded-3xl border border-white bg-slate-100/30 p-8 space-y-6">
                    <div class="flex items-center gap-3 mb-2">
                        <i class="fa-solid fa-receipt text-indigo-500"></i>
                        <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest">Kalkulasi Pajak</h3>
                    </div>
                    <div class="grid gap-6 sm:grid-cols-3">
                        @foreach(['ppn' => ['label' => 'PPN (11%)', 'calc' => 'isiPpn()'], 'pph23' => ['label' => 'PPH 23 (2%)', 'calc' => 'isiPph23()'], 'pph21' => ['label' => 'PPH 21 (5%)', 'calc' => 'isiPph21()']] as $key => $p)
                            <div class="space-y-2">
                                <label for="{{ $key }}" class="text-[10px] font-black text-slate-400 uppercase tracking-wider ml-1">{{ $p['label'] }}</label>
                                <div class="flex flex-col gap-2">
                                    <input id="{{ $key }}" type="number" name="{{ $key }}" step="0.01" min="0"
                                        x-model.number="{{ $key }}"
                                        class="block w-full rounded-xl border-slate-200 bg-white px-4 py-2.5 text-slate-800 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all font-bold text-sm shadow-sm" />
                                    <button type="button" @click="{{ $p['calc'] }}" 
                                        class="text-[9px] font-black uppercase tracking-widest text-indigo-600 hover:text-indigo-800 transition-colors ml-1 w-fit">
                                        <i class="fa-solid fa-magic mr-1"></i> Isi Otomatis
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="grid gap-8 sm:grid-cols-2">
                    {{-- Keterangan --}}
                    <div class="space-y-2">
                        <label for="keterangan" class="text-[11px] font-black uppercase tracking-widest text-slate-500 ml-1">Keterangan Tambahan</label>
                        <textarea id="keterangan" name="keterangan" rows="2"
                            placeholder="Informasi tambahan (opsional)..."
                            class="block w-full rounded-2xl border-slate-200 bg-white/50 px-5 py-3.5 text-slate-900 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all font-medium text-sm">{{ old('keterangan') }}</textarea>
                    </div>

                    {{-- Penerima --}}
                    <div class="space-y-2">
                        <label for="penerima" class="text-[11px] font-black uppercase tracking-widest text-slate-500 ml-1">Nama Penerima</label>
                        <div class="relative">
                            <input id="penerima" type="text" name="penerima" value="{{ old('penerima') }}"
                                placeholder="Akan tercetak di kwitansi..."
                                class="block w-full rounded-2xl border-slate-200 bg-white/50 px-5 py-3.5 text-slate-900 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all font-bold text-sm" />
                            <div class="absolute right-5 top-1/2 -translate-y-1/2 text-slate-400">
                                <i class="fa-solid fa-signature text-xs"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col-reverse sm:flex-row items-center justify-end gap-4 pt-6 mt-4 border-t border-slate-100">
                    <a href="{{ route('administrasi.index', request()->only('sub_kegiatan_id', 'year_id', 'kode_rekening_id')) }}"
                        class="w-full sm:w-auto px-8 py-3.5 text-sm font-black text-slate-400 uppercase tracking-widest hover:text-slate-600 transition-all">
                        Batal
                    </a>
                    <button type="submit"
                        class="w-full sm:w-auto px-10 py-4 bg-slate-900 text-white rounded-2xl font-black text-sm uppercase tracking-[0.2em] shadow-xl shadow-slate-900/20 hover:bg-indigo-600 hover:shadow-indigo-600/30 active:scale-95 transition-all">
                        Simpan Belanja <i class="fa-solid fa-paper-plane ml-2"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap');
    .font-sans { font-family: 'Inter', sans-serif; }
    [x-cloak] { display: none !important; }
    @keyframes fadeUp { 0% { opacity: 0; transform: translateY(20px); } 100% { opacity: 1; transform: translateY(0); } }
    .animate-fade-up { animation: fadeUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }
</style>

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
