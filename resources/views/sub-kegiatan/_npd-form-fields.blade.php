{{--
    Isian bersama untuk form NPD baru dan edit.
    Butuh: $administrasis, $selectedIds, $npdPerKodeRekening, $tanggal
--}}
<div>
    <label for="tanggal" class="block text-sm font-medium text-slate-700">Tanggal NPD</label>
    <input type="date" name="tanggal" id="tanggal" value="{{ $tanggal }}" required class="mt-1 rounded-lg border border-slate-300 px-3 py-2 text-sm">
    @error('tanggal')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

<div>
    <div class="mb-2 flex flex-wrap items-end justify-between gap-2">
        <div>
            <h2 class="text-sm font-semibold text-slate-800">Pilih administrasi yang dicairkan</h2>
            <p class="text-xs text-slate-500">Pencairan per kode rekening dihitung otomatis dari total tagihan yang dicentang. Administrasi yang sudah masuk NPD lain tidak ditampilkan.</p>
        </div>
        @if($administrasis->isNotEmpty())
            <label class="inline-flex items-center gap-2 text-xs font-medium text-slate-600">
                <input type="checkbox" id="npd-check-all" class="rounded border-slate-300"> Pilih semua
            </label>
        @endif
    </div>
    @error('administrasi_ids')
        <p class="mb-2 rounded-lg bg-red-50 px-3 py-2 text-sm text-red-700">{{ $message }}</p>
    @enderror

    @if($administrasis->isEmpty())
        <div class="rounded-xl border border-slate-200 bg-white p-6 text-center text-sm text-slate-600">
            Semua administrasi sub kegiatan ini sudah masuk NPD. Tambahkan data di menu Administrasi terlebih dahulu.
        </div>
    @else
        <div class="overflow-x-auto rounded-xl border border-slate-200 bg-white shadow-sm">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50 text-xs font-semibold uppercase tracking-wider text-slate-600">
                    <tr>
                        <th class="w-10 px-4 py-3"></th>
                        <th class="px-4 py-3 text-left">Tanggal</th>
                        <th class="px-4 py-3 text-left">Penerima / Uraian</th>
                        <th class="px-4 py-3 text-left">Kode Rekening</th>
                        <th class="px-4 py-3 text-right">Tagihan</th>
                        <th class="px-4 py-3 text-right">Pajak</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @foreach($administrasis as $a)
                        <tr class="hover:bg-slate-50">
                            <td class="px-4 py-3 align-top">
                                <input type="checkbox" name="administrasi_ids[]" value="{{ $a->id }}" id="adm-{{ $a->id }}"
                                    class="npd-adm rounded border-slate-300"
                                    data-kr="{{ $a->kode_rekening_id }}" data-tagihan="{{ (float) $a->tagihan }}"
                                    @checked(in_array($a->id, $selectedIds, true))>
                            </td>
                            <td class="whitespace-nowrap px-4 py-3 align-top text-slate-600">
                                <label for="adm-{{ $a->id }}">{{ $a->tanggal_nota_persetujuan?->format('d/m/Y') }}</label>
                            </td>
                            <td class="px-4 py-3 align-top">
                                <label for="adm-{{ $a->id }}" class="block cursor-pointer">
                                    <span class="font-medium text-slate-900">{{ $a->penerima ?: '-' }}</span>
                                    <span class="block text-slate-500">{{ $a->uraian_belanja }}</span>
                                </label>
                            </td>
                            <td class="whitespace-nowrap px-4 py-3 align-top font-mono text-xs text-slate-600">{{ $a->kodeRekening?->kode_rekening }}</td>
                            <td class="whitespace-nowrap px-4 py-3 text-right align-top text-slate-900">Rp {{ number_format($a->tagihan, 0, ',', '.') }}</td>
                            <td class="whitespace-nowrap px-4 py-3 text-right align-top text-slate-500">Rp {{ number_format(($a->ppn ?? 0) + ($a->pph21 ?? 0) + ($a->pph23 ?? 0), 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

<div>
    <h2 class="mb-2 text-sm font-semibold text-slate-800">Ringkasan per kode rekening</h2>
    <div class="overflow-x-auto rounded-xl border border-slate-200 bg-white shadow-sm">
        <table class="min-w-full divide-y divide-slate-200 text-sm">
            <thead class="bg-slate-50 text-xs font-semibold uppercase tracking-wider text-slate-600">
                <tr>
                    <th class="px-4 py-3 text-left">Kode Rekening</th>
                    <th class="px-4 py-3 text-left">Nama Rekening</th>
                    <th class="px-4 py-3 text-right">Anggaran</th>
                    <th class="px-4 py-3 text-right">Akumulasi</th>
                    <th class="px-4 py-3 text-right">Pencairan Saat Ini</th>
                    <th class="px-4 py-3 text-right">Sisa</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @foreach($npdPerKodeRekening as $row)
                    <tr class="npd-row" data-kr="{{ $row['kode_rekening_id'] }}" data-anggaran="{{ $row['anggaran'] }}" data-akumulasi="{{ $row['akumulasi'] }}">
                        <td class="whitespace-nowrap px-4 py-3 font-medium text-slate-900">{{ $row['kode_rekening'] }}</td>
                        <td class="px-4 py-3 text-slate-600">{{ $row['nama_rekening'] }}</td>
                        <td class="whitespace-nowrap px-4 py-3 text-right">Rp {{ number_format($row['anggaran'], 0, ',', '.') }}</td>
                        <td class="whitespace-nowrap px-4 py-3 text-right">Rp {{ number_format($row['akumulasi'], 0, ',', '.') }}</td>
                        <td class="npd-pencairan whitespace-nowrap px-4 py-3 text-right font-semibold text-slate-900">Rp 0</td>
                        <td class="npd-sisa whitespace-nowrap px-4 py-3 text-right">Rp {{ number_format($row['anggaran'] - $row['akumulasi'], 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot class="bg-slate-50">
                <tr>
                    <td colspan="4" class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-600">Jumlah yang diminta</td>
                    <td id="npd-total" class="whitespace-nowrap px-4 py-3 text-right font-bold text-slate-900">Rp 0</td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var boxes = Array.prototype.slice.call(document.querySelectorAll('.npd-adm'));
    var checkAll = document.getElementById('npd-check-all');
    var formatRp = function (n) { return 'Rp ' + Math.round(n).toLocaleString('id-ID'); };

    function recalc() {
        var perKr = {};
        var total = 0;
        boxes.forEach(function (box) {
            if (!box.checked) return;
            var tagihan = parseFloat(box.dataset.tagihan) || 0;
            perKr[box.dataset.kr] = (perKr[box.dataset.kr] || 0) + tagihan;
            total += tagihan;
        });
        document.querySelectorAll('.npd-row').forEach(function (row) {
            var pencairan = perKr[row.dataset.kr] || 0;
            var sisa = (parseFloat(row.dataset.anggaran) || 0) - (parseFloat(row.dataset.akumulasi) || 0) - pencairan;
            row.querySelector('.npd-pencairan').textContent = formatRp(pencairan);
            var sisaCell = row.querySelector('.npd-sisa');
            sisaCell.textContent = formatRp(sisa);
            sisaCell.classList.toggle('text-red-600', sisa < 0);
        });
        document.getElementById('npd-total').textContent = formatRp(total);
        if (checkAll) checkAll.checked = boxes.length > 0 && boxes.every(function (b) { return b.checked; });
    }

    boxes.forEach(function (box) { box.addEventListener('change', recalc); });
    if (checkAll) {
        checkAll.addEventListener('change', function () {
            boxes.forEach(function (box) { box.checked = checkAll.checked; });
            recalc();
        });
    }
    recalc();
});
</script>
