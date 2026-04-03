<tbody>
    @foreach ($jobs as $job)
        <tr>
            <td>
                <strong>{{ $job->modelPakaian->nama_model }}</strong>
            </td>
            <td>{{ $job->jumlah_target }} pcs</td>
            <td>{{ $job->penjahitan->pemotong->name ?? '-' }}</td>
            <td>{{ $job->penjahitan->penjahit->name ?? '-' }}</td>
            <td>
                <span class="badge bg-soft-info text-info">
                    Siap Finishing
                </span>
            </td>
            {{-- FORM (SATU FORM AJA, BIAR FILE KEKIRIM) --}}
            <td class="text-end">
                <button class="btn btn-sm btn-outline-success btn-kerjakan" data-id="{{ $job->id }}"
                    data-model="{{ $job->modelPakaian->nama_model }}" data-target="{{ $job->jumlah_target }}">
                    Kerjakan
                </button>
            </td>
        </tr>
    @endforeach
</tbody>
