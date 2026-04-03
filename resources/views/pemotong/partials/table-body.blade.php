<tbody>
    @foreach ($jobs as $job)
        <tr>
            <td>{{ $job->modelPakaian->nama_model }}</td>
            <td>{{ $job->bahanBaku->nama_bahan }}</td>
            <td>{{ $job->jumlah_target }}</td>
            <td>
                <span class="badge bg-soft-warning text-warning">
                    Menunggu
                </span>
            </td>
            {{-- FORM UPLOAD --}}
            <td class="text-end">
                <button class="btn btn-sm btn-outline-success btn-kerjakan" data-id="{{ $job->id }}"
                    data-model="{{ $job->modelPakaian->nama_model }}" data-target="{{ $job->jumlah_target }}">
                    Kerjakan
                </button>
            </td>
        </tr>
    @endforeach
</tbody>
