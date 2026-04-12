<tbody>
    @foreach ($data as $item)
        <tr class="single-item">
            {{-- MODEL --}}
            <td>
                <div class="fw-semibold">{{ $item->modelPakaian->nama_model }}
                </div>
            </td>
            {{-- BAHAN --}}
            <td>{{ $item->bahanBaku->nama_bahan }}</td>
            {{-- TARGET --}}
            <td class="text-center fw-bold">{{ $item->jumlah_target }}</td>
            {{-- STATUS --}}
            <td>
                @php
                    $statusMap = [
                        'menunggu' => [
                            'class' => 'badge bg-soft-secondary text-secondary',
                            'label' => 'Menunggu',
                        ],
                        'dipotong' => [
                            'class' => 'badge bg-soft-warning text-warning',
                            'label' => 'Dipotong',
                        ],
                        'dijahit' => [
                            'class' => 'badge bg-soft-info text-info',
                            'label' => 'Dijahit',
                        ],
                        'finishing' => [
                            'class' => 'badge bg-soft-primary text-primary',
                            'label' => 'Finishing',
                        ],
                        'selesai' => [
                            'class' => 'badge bg-soft-success text-success',
                            'label' => 'Selesai',
                        ],
                    ];
                    $status = $statusMap[$item->status] ?? null;
                @endphp

                @if ($status)
                    <span class="badge {{ $status['class'] }}">
                        {{ $status['label'] }}
                    </span>
                @else
                    <span class="badge bg-soft-dark text-dark">-</span>
                @endif
            </td>

            {{-- PEMOTONG --}}
            <td>{{ optional($item->pemotongan?->pemotong)->name ?? '-' }}</td>

            {{-- BUKTI POTONG --}}
            <td>
                @if ($item->pemotongan?->foto_bukti)
                    <button type="button" class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#modalBukti"
                        data-img="{{ asset('storage/' . $item->pemotongan->foto_bukti) }}" data-title="Bukti Pemotongan">
                        Lihat
                    </button>
                @else
                    <span class="text-muted">-</span>
                @endif
            </td>

            {{-- PENJAHIT --}}
            <td>{{ optional($item->penjahitan?->penjahit)->name ?? '-' }}</td>

            {{-- BUKTI JAHIT --}}
            <td>
                @if ($item->penjahitan?->foto_bukti)
                    <button type="button" class="btn btn-sm btn-light" data-bs-toggle="modal"
                        data-bs-target="#modalBukti" data-img="{{ asset('storage/' . $item->penjahitan->foto_bukti) }}"
                        data-title="Bukti Penjahitan">
                        Lihat
                    </button>
                @else
                    <span class="text-muted">-</span>
                @endif
            </td>

            {{-- FINISHING --}}
            <td>{{ optional($item->finishing?->finishing)->name ?? '-' }}</td>

            {{-- BUKTI FINISHING --}}
            <td>
                @if ($item->finishing?->foto_bukti)
                    <button type="button" class="btn btn-sm btn-light" data-bs-toggle="modal"
                        data-bs-target="#modalBukti" data-img="{{ asset('storage/' . $item->finishing->foto_bukti) }}"
                        data-title="Bukti Finishing">
                        Lihat
                    </button>
                @else
                    <span class="text-muted">-</span>
                @endif
            </td>

            {{-- AKSI --}}
            <td class="text-end">
                <div class="hstack gap-2 justify-content-end">
                    @if ($item->status === 'menunggu' && $item->pemotongan?->status === 'pending')
                        {{-- ACC Potong --}}
                        <form action="{{ route('admin.job-produksi.acc-pemotongan', $item->id) }}" method="POST">
                            @csrf
                            <button class="btn btn-success btn-sm">ACC Potong</button>
                        </form>
                        {{-- TOLAK Potong --}}
                        <button class="btn btn-danger btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#modalTolak"
                            data-action="{{ route('admin.job-produksi.tolak-pemotongan', $item->id) }}"
                            data-label="Pemotongan Job #{{ $item->id }}">
                            Tolak
                        </button>

                    @elseif ($item->status === 'dipotong' && $item->penjahitan?->status === 'pending')
                        {{-- ACC Jahit --}}
                        <form action="{{ route('admin.job-produksi.acc-penjahitan', $item->id) }}" method="POST">
                            @csrf
                            <button class="btn btn-success btn-sm">ACC Jahit</button>
                        </form>
                        {{-- TOLAK Jahit --}}
                        <button class="btn btn-danger btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#modalTolak"
                            data-action="{{ route('admin.job-produksi.tolak-penjahitan', $item->id) }}"
                            data-label="Penjahitan Job #{{ $item->id }}">
                            Tolak
                        </button>

                    @elseif ($item->status === 'dijahit' && $item->finishing?->status === 'pending')
                        {{-- ACC Finishing --}}
                        <form action="{{ route('admin.job-produksi.acc-finishing', $item->id) }}" method="POST">
                            @csrf
                            <button class="btn btn-success btn-sm">ACC Finishing</button>
                        </form>
                        {{-- TOLAK Finishing --}}
                        <button class="btn btn-danger btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#modalTolak"
                            data-action="{{ route('admin.job-produksi.tolak-finishing', $item->id) }}"
                            data-label="Finishing Job #{{ $item->id }}">
                            Tolak
                        </button>

                    @elseif ($item->status === 'menunggu')
                        <a href="{{ route('admin.job-produksi.edit', $item->id) }}" class="avatar-text avatar-md">
                            <i class="feather-edit"></i>
                        </a>
                        <form action="{{ route('admin.job-produksi.destroy', $item->id) }}" method="POST"
                            class="d-inline form-delete">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="avatar-text avatar-md bg-soft-danger text-danger border-0">
                                <i class="feather-trash-2"></i>
                            </button>
                        </form>
                    @else
                        @if ($item->status === 'menunggu')
                            <span class="badge bg-soft-secondary text-secondary">Menunggu Pemotong</span>
                        @elseif ($item->status === 'dipotong')
                            <span class="badge bg-soft-warning text-warning">Sedang Dijahit</span>
                        @elseif ($item->status === 'dijahit')
                            <span class="badge bg-soft-info text-info">Sedang Finishing</span>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    @endif
                </div>
            </td>
        </tr>
    @endforeach
</tbody>
