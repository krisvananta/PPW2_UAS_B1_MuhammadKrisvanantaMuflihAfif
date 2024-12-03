@extends('layouts')

@section('content')

<div class="d-flex flex-column gap-4">
    <div class="card">
        <div class="card-header">SUMMARY</div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Jumlah Transaksi</h5>
                            <h4><span class="badge text-bg-secondary">{{ number_format($transaksi_count, 0, '.', '.') }}</span></h4>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Jumlah Item Terjual</h5>
                            <h4><span class="badge text-bg-secondary">{{ number_format($jumlah_item_terjual, 0, '.', '.') }}</span></h4>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Omzet</h5>
                            <h4><span class="badge text-bg-secondary">Rp {{ number_format($omzet, 0, '.', '.') }}</span></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">DATA</div>
        <div class="card-body">
            <div class="list-group">
                <a href="{{ route('transaksi.create') }}" class="list-group-item list-group-item-action">Tambah Transaksi</a>
                <a href="{{ route('transaksi.index') }}" class="list-group-item list-group-item-action">Lihat Transaksi</a>
                <a href="{{ route('transaksidetail.index') }}" class="list-group-item list-group-item-action">Lihat Transaksi Detail</a>
            </div>
        </div>
    </div>
</div>

@endsection