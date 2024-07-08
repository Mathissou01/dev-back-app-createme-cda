@extends('layouts.dashboard')

@section('content')
<!-- DÉBUT : En-tête -->
<header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
    <div class="container-xl px-4">
        <div class="page-header-content pt-4">
            <div class="row align-items-center justify-content-between">
                <div class="col-auto my-4">
                    <h1 class="page-header-title">
                        <div class="page-header-icon"><i class="fa-solid fa-cash-register"></i></div>
                        Liste des Achats
                    </h1>
                </div>
                <div class="col-auto my-4">
                    <a href="{{ route('purchases.getPurchaseReport') }}" class="btn btn-success add-list my-1"><i class="fa-solid fa-file-export me-3"></i>Exporter</a>
                    <a href="{{ route('purchases.createPurchase') }}" class="btn btn-primary add-list my-1"><i class="fa-solid fa-plus me-3"></i>Ajouter</a>
                    <a href="{{ route('purchases.allPurchases') }}" class="btn btn-danger add-list my-1"><i class="fa-solid fa-trash me-3"></i>Effacer la Recherche</a>
                </div>
            </div>

            @include('partials._breadcrumbs')
        </div>
    </div>

    @include('partials.session')
</header>

<div class="container px-2 mt-n10">
    <div class="card mb-4">
        <div class="card-body">
            <div class="row mx-n4">
                <div class="col-lg-12 card-header mt-n4">
                    <form action="#" method="GET">
                        <div class="d-flex flex-wrap align-items-center justify-content-between">
                            <div class="form-group row align-items-center">
                                <label for="row" class="col-auto">Ligne :</label>
                                <div class="col-auto">
                                    <select class="form-control" name="row">
                                        <option value="10" @if(request('row') == '10')selected="selected"@endif>10</option>
                                        <option value="25" @if(request('row') == '25')selected="selected"@endif>25</option>
                                        <option value="50" @if(request('row') == '50')selected="selected"@endif>50</option>
                                        <option value="100" @if(request('row') == '100')selected="selected"@endif>100</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row align-items-center justify-content-between">
                                <label class="control-label col-sm-3" for="search">Rechercher :</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <input type="text" id="search" class="form-control me-1" name="search" placeholder="Rechercher une commande" value="{{ request('search') }}">
                                        <div class="input-group-append">
                                            <button type="submit" class="input-group-text bg-primary"><i class="fa-solid fa-magnifying-glass font-size-20 text-white"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <hr>

                <div class="col-lg-12">
                    <div class="table-responsive">
                        <table class="table table-striped align-middle">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">No.</th>
                                    <th scope="col">ACHAT</th>
                                    <th scope="col">@sortablelink('supplier.name', 'Ouvrier attribué')</th>
                                    <th scope="col">@sortablelink('purchase_date', 'Date de paiement')</th>
                                    <th scope="col">@sortablelink('Total payé')</th>
                                    <th scope="col">Statut</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($purchases as $purchase)
                                <tr>
                                    <th scope="row">{{ (($purchases->currentPage() * (request('row') ? request('row') : 10)) - (request('row') ? request('row') : 10)) + $loop->iteration  }}</th>
                                    <td>{{ $purchase->purchase_no }}</td>
                                    <td>{{ $purchase->supplier->name }}</td>
                                    <td>{{ \Carbon\Carbon::parse($purchase->purchase_date)->format('Y-m-d H:i:s') }}</td>
                                    <td>{{ $purchase->total_amount }}</td>
                                    @if ($purchase->status === "paid")
                                        <td>
                                            <span class="btn btn-success btn-sm text-uppercase">PAYÉ</span>
                                        </td>
                                        <td>
                                            <div class="d-flex">
                                                <a href="{{ route('purchases.purchaseDetails', $purchase->id) }}" class="btn btn-outline-success btn-sm mx-1"><i class="fa-solid fa-eye"></i></a>
                                            </div>
                                        </td>
                                    @else
                                        <td>
                                            <span class="btn btn-warning btn-sm text-uppercase">EN ATTENTE</span>
                                        </td>
                                        <td>
                                            <div class="d-flex">
                                                <a href="{{ route('purchases.purchaseDetails', $purchase->id) }}" class="btn btn-outline-success btn-sm mx-1"><i class="fa-solid fa-eye"></i></a>
                                                <form action="{{ route('purchases.deletePurchase', $purchase->id) }}" method="POST">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet enregistrement ?')">
                                                        <i class="far fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    @endif
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{ $purchases->links() }}
            </div>
        </div>
    </div>
</div>
<!-- FIN : Contenu de la Page Principale -->
@endsection
