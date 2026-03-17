@extends('layouts.app')

@section('title', 'Edit Administrasi')

@section('content')
<div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8" x-data="administrasiForm()">
    <div class="mb-6">
        <a href="{{ route('administrasi.index') }}" class="text-sm font-medium text-slate-600 hover:text-slate-900">&larr; Kembali</a>
    </div>
    <div class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
        <h2 class="mb-6 text-xl font-semibold text-slate-800">Edit Data Administrasi</h2>
        <form method="POST" action="{{ route('administrasi.update', $administrasi) }}" class="space-y-5" @submit="syncPajakToInputs()">
            @csrf
            @method('PUT')
            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="sub_kegiatan_id" class="mb-1 block text-sm font-medium text-slate-700">Sub Kegiatan <span class="text-red-500">*</span></label>
                    <select id="sub_kegiatan_id" name="sub_kegiatan_id" required
                        class="w-full rounded-lg border border-slate-300 px-3 py-2 text-slate-900 shadow-sm focus:border-slate-500 focus:ring-1 focus:ring-slate-500">
                        @foreach($subKegiatans as $sk)
                            <option value="{{ $sk->id }}" {{ old('sub_kegiatan_id', $administrasi->sub_kegiatan_id) == $sk->id ? 'selected' : '' }}>{{ $sk->nama_sub_kegiatan }} ({{ $sk->year->tahun ?? '' }})</option>
                        @endforeach
                    </select>
                    @error('sub_kegiatan_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700">No</label>
                    <input type="text" value="{{ $administrasi->no }}" readonly class="w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-2 text-slate-600" />
                </div>
            </div>
            <div>
                <label for="uraian_belanja" class="mb-1 block text-sm font-medium text-slate-700">Uraian Belanja <span class="text-red-500">*</span></label>
                <textarea id="uraian_belanja" name="uraian_belanja" rows="3" required
                    class="w-full rounded-lg border border-slate-300 px-3 py-2 text-slate-900 shadow-sm focus:border-slate-500 focus:ring-1 focus:ring-slate-500 @error('uraian_belanja') border-red-500 @enderror">{{ old('uraian_belanja', $administrasi->uraian_belanja) }}</textarea>
                @error('uraian_belanja')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="tagihan" class="mb-1 block text-sm font-medium text-slate-700">Tagihan <span class="text-red-500">*</span></label>
                    <input id="tagihan" type="number" name="tagihan" step="0.01" min="0" required
                        x-model.number="tagihan"
                        class="w-full rounded-lg border border-slate-300 px-3 py-2 text-slate-900 shadow-sm focus:border-slate-500 focus:ring-1 focus:ring-slate-500" value="{{ old('tagihan', $administrasi->tagihan) }}" />
                    @error('tagihan')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="tanggal_nota_persetujuan" class="mb-1 block text-sm font-medium text-slate-700">Tanggal Nota Persetujuan <span class="text-red-500">*</span></label>
                    <input id="tanggal_nota_persetujuan" type="date" name="tanggal_nota_persetujuan" required
                        class="w-full rounded-lg border border-slate-300 px-3 py-2 text-slate-900 shadow-sm focus:border-slate-500 focus:ring-1 focus:ring-slate-500" value="{{ old('tanggal_nota_persetujuan', $administrasi->tanggal_nota_persetujuan?->format('Y-m-d')) }}" />
                    @error('tanggal_nota_persetujuan')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div>
                <label for="kode_rekening_id" class="mb-1 block text-sm font-medium text-slate-700">Kode Rekening <span class="text-red-500">*</span></label>
                <select id="kode_rekening_id" name="kode_rekening_id" required
                    class="w-full rounded-lg border border-slate-300 px-3 py-2 text-slate-900 shadow-sm focus:border-slate-500 focus:ring-1 focus:ring-slate-500"
                    x-model="kodeRekeningId"
                    @change="fetchEtalases()">
                    @foreach($kodeRekenings as $kr)
                        <option value="{{ $kr->id }}" {{ old('kode_rekening_id', $administrasi->kode_rekening_id) == $kr->id ? 'selected' : '' }}>{{ $kr->kode_rekening }} - {{ $kr->nama_rekening }}</option>
                    @endforeach
                </select>
                @error('kode_rekening_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="etalase_id" class="mb-1 block text-sm font-medium text-slate-700">Etalase <span class="text-red-500">*</span></label>
                <select id="etalase_id" name="etalase_id" required
                    class="w-full rounded-lg border border-slate-300 px-3 py-2 text-slate-900 shadow-sm focus:border-slate-500 focus:ring-1 focus:ring-slate-500"
                    x-model="etalaseId"
                    :disabled="etalases.length === 0">
                    <option value="">-- Pilih Etalase --</option>
                    <template x-for="e in etalases" :key="e.id">
                        <option :value="e.id" x-text="e.nama_etalase"></option>
                    </template>
                </select>
                @error('etalase_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            {{-- Pajak (sama seperti create: bisa diedit + tombol isi otomatis) --}}
            <div class="rounded-lg border border-slate-200 bg-slate-50/50 p-4 sm:p-5">
                <p class="mb-4 text-sm font-medium text-slate-700">Pajak (opsional)</p>
                <p class="mb-4 text-sm text-slate-500">Isi manual atau klik tombol isi otomatis berdasarkan Tagihan.</p>
                <div class="grid gap-4 sm:grid-cols-3">
                    <div>
                        <label for="ppn" class="mb-1 block text-sm text-slate-600">PPN (11%)</label>
                        <div class="flex flex-col gap-2 sm:flex-row">
                            <input id="ppn" type="number" name="ppn" step="0.01" min="0"
                                x-model.number="ppn"
                                x-ref="ppnInput"
                                placeholder="0"
                                class="min-w-0 flex-1 rounded-lg border border-slate-300 bg-white px-3 py-2 text-slate-900 focus:border-slate-500 focus:ring-2 focus:ring-slate-500/20" value="{{ old('ppn', $administrasi->ppn) }}" />
                            <button type="button" @click="isiPpn()" class="rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">Isi otomatis</button>
                        </div>
                    </div>
                    <div>
                        <label for="pph23" class="mb-1 block text-sm text-slate-600">PPH 23 (2%)</label>
                        <div class="flex flex-col gap-2 sm:flex-row">
                            <input id="pph23" type="number" name="pph23" step="0.01" min="0"
                                x-model.number="pph23"
                                x-ref="pph23Input"
                                placeholder="0"
                                class="min-w-0 flex-1 rounded-lg border border-slate-300 bg-white px-3 py-2 text-slate-900 focus:border-slate-500 focus:ring-2 focus:ring-slate-500/20" value="{{ old('pph23', $administrasi->pph23) }}" />
                            <button type="button" @click="isiPph23()" class="rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">Isi otomatis</button>
                        </div>
                    </div>
                    <div>
                        <label for="pph21" class="mb-1 block text-sm text-slate-600">PPH 21 (5%)</label>
                        <div class="flex flex-col gap-2 sm:flex-row">
                            <input id="pph21" type="number" name="pph21" step="0.01" min="0"
                                x-model.number="pph21"
                                x-ref="pph21Input"
                                placeholder="0"
                                class="min-w-0 flex-1 rounded-lg border border-slate-300 bg-white px-3 py-2 text-slate-900 focus:border-slate-500 focus:ring-2 focus:ring-slate-500/20" value="{{ old('pph21', $administrasi->pph21) }}" />
                            <button type="button" @click="isiPph21()" class="rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">Isi otomatis</button>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <label for="keterangan" class="mb-1 block text-sm font-medium text-slate-700">Keterangan</label>
                <textarea id="keterangan" name="keterangan" rows="2" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-slate-900 shadow-sm">{{ old('keterangan', $administrasi->keterangan) }}</textarea>
            </div>
            <div>
                <label for="penerima" class="mb-1 block text-sm font-medium text-slate-700">Penerima</label>
                <input id="penerima" type="text" name="penerima" value="{{ old('penerima', $administrasi->penerima) }}"
                    placeholder="Nama penerima di kwitansi (kosongkan bila tidak diisi)"
                    class="w-full rounded-lg border border-slate-300 px-3 py-2 text-slate-900 shadow-sm" />
                <p class="mt-1 text-xs text-slate-500">Opsional. Jika kosong, kolom &quot;Yang menerima&quot; di kwitansi akan kosong.</p>
            </div>
            <div class="flex gap-3 pt-4">
                <button type="submit" class="rounded-lg bg-slate-800 px-4 py-2 text-sm font-medium text-white hover:bg-slate-700 transition">Simpan</button>
                <a href="{{ route('administrasi.index') }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50 transition">Batal</a>
            </div>
        </form>
    </div>
</div>

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
