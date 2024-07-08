```php
@extends('layouts.dashboard')

@section('content')
<!-- BEGIN: Header -->
<header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
    <div class="container-xl px-4">
        <div class="page-header-content">
            <div class="row align-items-center justify-content-between pt-3">
                <div class="col-auto mb-3">
                    <h1 class="page-header-title">
                        <div class="page-header-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file"><path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path><polyline points="13 2 13 9 20 9"></polyline></svg></div>
                        Détails de l'Achat
                    </h1>
                </div>
            </div>
        </div>
    </div>
</header>

<div class="container-xl px-4">
    <div class="row">

        <!-- BEGIN: Informations Fournisseur -->
        <div class="col-xl-12">
            <div class="card mb-4">
                <div class="card-header">
                    Informations Fournisseur
                </div>
                <div class="card-body">
                    <!-- Ligne de Formulaire -->
                    <div class="row gx-3 mb-3">
                        <!-- Groupe de Formulaire (nom du fournisseur) -->
                        <div class="col-md-6">
                            <label class="small mb-1">Nom</label>
                            <div class="form-control form-control-solid">{{ $purchase->supplier->name }}</div>
                        </div>
                        <!-- Groupe de Formulaire (email du fournisseur) -->
                        <div class="col-md-6">
                            <label class="small mb-1">Email</label>
                            <div class="form-control form-control-solid">{{ $purchase->supplier->email }}</div>
                        </div>
                    </div>
                    <!-- Ligne de Formulaire -->
                    <div class="row gx-3 mb-3">
                        <!-- Groupe de Formulaire (numéro de téléphone du fournisseur) -->
                        <div class="col-md-6">
                            <label class="small mb-1">Téléphone</label>
                            <div class="form-control form-control-solid">{{ $purchase->supplier->phone }}</div>
                        </div>
                        <!-- Groupe de Formulaire (date de la commande) -->
                       <div class="col-md-6">
                            <label class="small mb-1">Date de Commande</label>
                            <div class="form-control form-control-solid">{{ \Carbon\Carbon::parse($purchase->purchase_date)->format('d F Y à H:i') }}</div>
                        </div>
                    </div>
                    <!-- Ligne de Formulaire -->
                    <div class="row gx-3 mb-3">
                        <!-- Groupe de Formulaire (numéro d'achat) -->
                        <div class="col-md-6">
                            <label class="small mb-1">N° d'Achat</label>
                            <div class="form-control form-control-solid">{{ $purchase->purchase_no }}</div>
                        </div>
                        <!-- Groupe de Formulaire (montant total) -->
                        <div class="col-md-6">
                            <label class="small mb-1">Total</label>
                            <div class="form-control form-control-solid">{{ $purchase->total_amount }}</div>
                        </div>
                    </div>
                    <!-- Groupe de Formulaire (adresse) -->
                    <div class="mb-3">
                        <label class="small mb-1">Adresse</label>
                        <div class="form-control form-control-solid">{{ $purchase->supplier->address }}</div>
                    </div>

                    @if ($purchase->purchase_status == 0)
                    <form action="{{ route('purchases.updatePurchase') }}" method="POST">
                        @csrf
                        @method('put')
                        <input type="hidden" name="id" value="{{ $purchase->id }}">
                        <!-- Bouton de soumission -->
                        <button type="submit" class="btn btn-success" onclick="return confirm('Êtes-vous sûr de vouloir approuver cet achat ?')">Approuver l'Achat</button>
                        <a class="btn btn-primary" href="{{ URL::previous() }}">Retour</a>
                    </form>
                    @else
                    <a class="btn btn-primary" href="{{ URL::previous() }}">Retour</a>
                    @endif
                </div>
            </div>
        </div>
        <!-- END: Informations Fournisseur -->


        <!-- BEGIN: Tableau des Produits -->
        <div class="col-xl-12">
            <div class="card mb-4 mb-xl-0">
                <div class="card-header">Liste des Produits</div>

                <div class="card-body">
                    <!-- BEGIN: Liste des Produits -->
                    <div class="col-lg-12">
                        <div class="table-responsive">
                            <table class="table table-striped align-middle">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">N°</th>
                                        <th scope="col">Photo</th>
                                        <th scope="col">Nom du Produit</th>
                                        <th scope="col">Code du Produit</th>
                                        <th scope="col">Stock Actuel</th>
                                        <th scope="col">Quantité</th>
                                        <th scope="col">Prix</th>
                                        <th scope="col">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($purchaseDetails as $item)
                                    <tr>
                                        <td scope="row">{{ $loop->iteration }}</td>
                                        <td scope="row">
                                            <div style="max-height: 80px; max-width: 80px;">
                                                <img class="img-fluid" src="{{ $item->product->product_image ? asset('storage/products/'.$item->product->product_image) : asset('assets/img/products/default.webp') }}">
                                            </div>
                                        </td>
                                        <td scope="row">{{ $item->product->product_name }}</td>
                                        <td scope="row">{{ $item->product->product_code }}</td>
                                        <td scope="row"><span class="btn btn-warning">{{ $item->product->stock }}</span></td>
                                        <td scope="row"><span class="btn btn-success">{{ $item->quantity }}</span></td>
                                        <td scope="row">{{ $item->unitcost }}</td>
                                        <td scope="row">
                                            <span class="btn btn-primary">{{ $item->total }}</span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- END: Liste des Produits -->
                </div>
            </div>
        </div>
        <!-- END: Tableau des Produits -->
    </div>
</div>
<!-- END: Contenu Principal -->
@endsection
```