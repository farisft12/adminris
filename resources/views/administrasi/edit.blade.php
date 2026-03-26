@extends('layouts.app')

@section('title', 'Edit Administrasi')

@section('content')
<div class="relative min-h-screen bg-slate-50/50 pb-12 font-sans" x-data="administrasiForm()" @kode-rekening-selected="kodeRekeningId = $event.detail.id; fetchEtalases()">
    {{-- Background Decoration --}}
    <div class="pointer-events-none absolute inset-0 -z-10 overflow-hidden">
        <div class="absolute -left-20 top-20 h-[30rem] w-[30rem] rounded-full bg-indigo-100/40 blur-3xl"></div>
        <div class="absolute right-0 bottom-0 h-[25rem] w-[25rem] rounded-full bg-indigo-100/20 blur-3xl"></div>
    </div>

    <div class="mx-auto max-w-4xl px-4 py-8 sm:px-6 lg:px-8">
        {{-- Header Section --}}
        <div class="mb-8 animate-fade-up">
            <nav class="mb-3 flex items-center gap-2 text-[10px] font-bold uppercase tracking-widest text-slate-400">
                <a href="{{ route('administrasi.index', ['sub_kegiatan_id' => $administrasi->sub_kegiatan_id]) }}" class="hover:text-indigo-500 transition-colors">Administrasi</a>
                <i class="fa-solid fa-chevron-right text-[8px] opacity-50"></i>
                <span class="text-indigo-500">Edit Data</span>
            </nav>
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="bg-white text-indigo-600 p-3.5 rounded-2xl shadow-sm border border-slate-100">
                        <i class="fa-solid fa-file-pen text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Edit Administrasi</h1>
                        <p class="text-sm text-slate-500 mt-1 font-medium">Perbarui informasi belanja yang telah tercatat.</p>
                    </div>
                </div>
                <a href="{{ route('administrasi.index', ['sub_kegiatan_id' => $administrasi->sub_kegiatan_id]) }}" 
                    class="hidden sm:inline-flex items-center gap-2 rounded-xl bg-white px-4 py-2 text-xs font-black uppercase tracking-widest text-slate-600 border border-slate-200 hover:bg-slate-50 transition-all shadow-sm">
                    <i class="fa-solid fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>

        {{-- Main Form Card --}}
        <div class="animate-fade-up rounded-[2.5rem] border border-white bg-white/70 shadow-[0_8px_30px_rgb(0,0,0,0.04)] backdrop-blur-xl overflow-hidden" style="animation-delay: 100ms">
            <div class="px-10 py-8 border-b border-slate-100 bg-slate-50/30 flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-black text-slate-800 tracking-tight">Informasi Belanja</h2>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Lengkapi detail transaksi di bawah ini</p>
                </div>
                <div class="px-4 py-1.5 rounded-full bg-indigo-50 text-indigo-600 text-[10px] font-black uppercase tracking-widest border border-indigo-100">
                    No. #{{ $administrasi->no }}
                </div>
            </div>

            <form method="POST" action="{{ route('administrasi.update', $administrasi) }}" class="p-10 space-y-8" @submit="syncPajakToInputs()">
                @csrf
                @method('PUT')

                <div class="grid gap-8 sm:grid-cols-2">
                    {{-- Sub Kegiatan Selection --}}
                    <div class="space-y-2">
                        <label for="sub_kegiatan_id" class="text-[11px] font-black uppercase tracking-widest text-slate-500 ml-1">Sub Kegiatan <span class="text-rose-500">*</span></label>
                        <div class="relative">
                            <select id="sub_kegiatan_id" name="sub_kegiatan_id" required
                                class="block w-full rounded-2xl border-slate-200 bg-white/50 px-4 py-3.5 text-slate-900 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all font-bold text-sm appearance-none">
                                @foreach($subKegiatans as $sk)
                                    <option value="{{ $sk->id }}" {{ old('sub_kegiatan_id', $administrasi->sub_kegiatan_id) == $sk->id ? 'selected' : '' }}>{{ $sk->nama_sub_kegiatan }} ({{ $sk->year->tahun ?? '' }})</option>
                                @endforeach
                            </select>
                            <div class="pointer-events-none absolute right-4 top-1/2 -translate-y-1/2 text-slate-400">
                                <i class="fa-solid fa-chevron-down text-xs"></i>
                            </div>
                        </div>
                        @error('sub_kegiatan_id') <p class="text-[10px] font-bold text-rose-500 ml-1 mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- No. (Readonly) --}}
                    <div class="space-y-2 text-right sm:text-left">
                        <label class="text-[11px] font-black uppercase tracking-widest text-slate-500 ml-1">Nomor Urut Sistem</label>
                        <div class="h-12 flex items-center px-5 rounded-2xl bg-slate-100/50 border border-slate-200 text-slate-500 font-mono font-black text-sm">
                            #{{ $administrasi->no }}
                        </div>
                    </div>
                </div>

                {{-- Uraian Belanja --}}
                <div class="space-y-2">
                    <label for="uraian_belanja" class="text-[11px] font-black uppercase tracking-widest text-slate-500 ml-1">Uraian Belanja <span class="text-rose-500">*</span></label>
                    <textarea id="uraian_belanja" name="uraian_belanja" rows="3" required
                        class="block w-full rounded-2xl border-slate-200 bg-white/50 px-5 py-4 text-slate-900 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all font-medium text-sm @error('uraian_belanja') border-rose-300 @enderror">{{ old('uraian_belanja', $administrasi->uraian_belanja) }}</textarea>
                    @error('uraian_belanja') <p class="text-[10px] font-bold text-rose-500 ml-1 mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="grid gap-8 sm:grid-cols-2">
                    {{-- Nominal Tagihan --}}
                    <div class="space-y-2">
                        <label for="tagihan" class="text-[11px] font-black uppercase tracking-widest text-slate-500 ml-1">Tagihan (Rp) <span class="text-rose-500">*</span></label>
                        <div class="relative">
                            <span class="absolute left-5 top-1/2 -translate-y-1/2 text-slate-400 font-black text-xs">Rp</span>
                            <input id="tagihan" type="number" name="tagihan" step="0.01" min="0" required
                                x-model.number="tagihan"
                                class="block w-full rounded-2xl border-slate-200 bg-white/50 pl-12 pr-5 py-3.5 text-slate-900 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all font-black text-base" value="{{ old('tagihan', $administrasi->tagihan) }}" />
                        </div>
                        @error('tagihan') <p class="text-[10px] font-bold text-rose-500 ml-1 mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Tanggal --}}
                    <div class="space-y-2">
                        <label for="tanggal_nota_persetujuan" class="text-[11px] font-black uppercase tracking-widest text-slate-500 ml-1">Tanggal Nota Persetujuan <span class="text-rose-500">*</span></label>
                        <input id="tanggal_nota_persetujuan" type="date" name="tanggal_nota_persetujuan" required
                            class="block w-full rounded-2xl border-slate-200 bg-white/50 px-5 py-3.5 text-slate-900 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all font-bold text-sm" 
                            value="{{ old('tanggal_nota_persetujuan', $administrasi->tanggal_nota_persetujuan?->format('Y-m-d')) }}" />
                        @error('tanggal_nota_persetujuan') <p class="text-[10px] font-bold text-rose-500 ml-1 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid gap-8 sm:grid-cols-2">
                    {{-- Kode Rekening --}}
                    <div class="space-y-2">
                        <label for="kode_rekening_id" class="text-[11px] font-black uppercase tracking-widest text-slate-500 ml-1">Kode Rekening <span class="text-rose-500">*</span></label>
                        <div class="relative">
                            <select id="kode_rekening_id" name="kode_rekening_id" required
                                class="block w-full rounded-2xl border-slate-200 bg-white/50 px-4 py-3.5 text-slate-900 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all font-bold text-sm appearance-none"
                                x-model="kodeRekeningId" @change="fetchEtalases()">
                                @foreach($kodeRekenings as $kr)
                                    <option value="{{ $kr->id }}" {{ old('kode_rekening_id', $administrasi->kode_rekening_id) == $kr->id ? 'selected' : '' }}>{{ $kr->kode_rekening }} - {{ $kr->nama_rekening }}</option>
                                @endforeach
                            </select>
                            <div class="pointer-events-none absolute right-4 top-1/2 -translate-y-1/2 text-slate-400">
                                <i class="fa-solid fa-magnifying-glass text-xs"></i>
                            </div>
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
                                <option value="">-- Pilih Etalase --</option>
                                <template x-for="e in etalases" :key="e.id">
                                    <option :value="e.id" x-text="e.nama_etalase" :selected="e.id == etalaseId"></option>
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
                                        x-model.number="{{ $key }}" x-ref="{{ $key }}Input"
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
                            class="block w-full rounded-2xl border-slate-200 bg-white/50 px-5 py-3.5 text-slate-900 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all font-medium text-sm">{{ old('keterangan', $administrasi->keterangan) }}</textarea>
                    </div>

                    {{-- Penerima --}}
                    <div class="space-y-2">
                        <label for="penerima" class="text-[11px] font-black uppercase tracking-widest text-slate-500 ml-1">Nama Penerima</label>
                        <div class="relative">
                            <input id="penerima" type="text" name="penerima" value="{{ old('penerima', $administrasi->penerima) }}"
                                class="block w-full rounded-2xl border-slate-200 bg-white/50 px-5 py-3.5 text-slate-900 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all font-bold text-sm" />
                            <div class="absolute right-5 top-1/2 -translate-y-1/2 text-slate-400">
                                <i class="fa-solid fa-signature text-xs"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col-reverse sm:flex-row items-center justify-end gap-4 pt-6 mt-4 border-t border-slate-100">
                    <a href="{{ route('administrasi.index', ['sub_kegiatan_id' => $administrasi->sub_kegiatan_id]) }}"
                        class="w-full sm:w-auto px-8 py-3.5 text-sm font-black text-slate-400 uppercase tracking-widest hover:text-slate-600 transition-all">
                        Batal
                    </a>
                    <button type="submit"
                        class="w-full sm:w-auto px-10 py-4 bg-slate-900 text-white rounded-2xl font-black text-sm uppercase tracking-[0.2em] shadow-xl shadow-slate-900/20 hover:bg-indigo-600 hover:shadow-indigo-600/30 active:scale-95 transition-all">
                        Simpan Perubahan <i class="fa-solid fa-check-double ml-2"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap');
    .font-sans { font-family: 'Inter', sans-serif; }
    @keyframes fadeUp { 0% { opacity: 0; transform: translateY(20px); } 100% { opacity: 1; transform: translateY(0); } }
    .animate-fade-up { animation: fadeUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }
</style>

@push('scripts')
<script>
function administrasiForm() {
    return {
        kodeRekeningId: @json(old('kode_rekening_id', $administrasi->kode_rekening_id)),
        etalaseId: @json(old('etalase_id', $administrasi->etalase_id)),
        tagihan: {{ (float) old('tagihan', $administrasi->tagihan) }},
        ppn: {{ (float) old('ppn', $administrasi->ppn) }},
        pph23: {{ (float) old('pph23', $administrasi->pph23) }},
        pph21: {{ (float) old('pph21', $administrasi->pph21) }},
        etalases: @json($etalases),
        init() {
            if (this.kodeRekeningId) this.fetchEtalases();
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
            this.etalases = [];
            if (!id) return;
            fetch(`{{ url('api/etalases') }}?kode_rekening_id=${id}`, {
                headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
            })
            .then(r => r.json())
            .then(data => {
                this.etalases = data;
                // If initial load and current etalase exists in new list, don't clear it
                if (!data.find(e => e.id == this.etalaseId)) this.etalaseId = '';
            })
            .catch(() => {});
        },
        syncPajakToInputs() {
            if (this.$refs.ppnInput) this.$refs.ppnInput.value = this.ppn ?? '';
            if (this.$refs.pph23Input) this.$refs.pph23Input.value = this.pph23 ?? '';
            if (this.$refs.pph21Input) this.$refs.pph21Input.value = this.pph21 ?? '';
        }
    };
}
</script>
@endpush
@endsection
