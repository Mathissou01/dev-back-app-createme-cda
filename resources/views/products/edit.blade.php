@extends('layouts.dashboard')

@push('page-styles')
@endpush

@section('content')
<!-- DÉBUT: En-tête -->
<header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
    <div class="container-xl px-4">
        <div class="page-header-content pt-4">
            <div class="row align-items-center justify-content-between">
                <div class="col-auto mt-4">
                    <h1 class="page-header-title">
                        <div class="page-header-icon"><i class="fa-solid fa-boxes-stacked"></i></div>
                        Modifier le produit
                    </h1>
                </div>
            </div>
            @include('partials._breadcrumbs')
        </div>
    </div>
</header>

<div class="container-xl px-2 mt-n10">
    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('put')
        <div class="row">
            <div class="col-xl-4">
                <!-- Carte d'image du produit -->
                <div class="card mb-4 mb-xl-0">
                    <div class="card-header">Image du produit</div>
                    <div class="card-body text-center">
                        <!-- Image du produit -->
                        <img class="img-account-profile mb-2" src="{{ $product->product_image ? asset('storage/products/'.$product->product_image) : asset('assets/img/products/default.webp') }}" alt="" id="image-preview" />
                        <!-- Bloc d'aide pour l'image du produit -->
                        <div class="small font-italic text-muted mb-2">JPG ou PNG, pas plus de 2 Mo</div>
                        <!-- Champ d'entrée pour l'image du produit -->
                        <input class="form-control form-control-solid mb-2 @error('product_image') is-invalid @enderror" type="file" id="image" name="product_image" accept="image/*" onchange="previewImage();">
                        @error('product_image')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="col-xl-8">
                <!-- DÉBUT: Détails du produit -->
                <div class="card mb-4">
                    <div class="card-header">Détails du produit</div>
                    <div class="card-body">
                        <!-- Groupe de formulaires (nom du produit) -->
                        <div class="mb-3">
                            <label class="small mb-1" for="product_name">Nom du produit <span class="text-danger">*</span></label>
                            <input class="form-control form-control-solid @error('product_name') is-invalid @enderror" id="product_name" name="product_name" type="text" placeholder="" value="{{ old('product_name', $product->product_name) }}" autocomplete="off"/>
                            @error('product_name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <!-- Rangée de formulaires -->
                        <div class="row gx-3 mb-3">
                            <!-- Groupe de formulaires (catégorie de produit) -->
                            <div class="col-md-6">
                                <label class="small mb-1" for="category_id">Catégorie de produit <span class="text-danger">*</span></label>
                                <select class="form-select form-control-solid @error('category_id') is-invalid @enderror" id="category_id" name="category_id">
                                    <option selected="" disabled="">Sélectionnez une catégorie :</option>
                                    @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" @if(old('category_id', $product->category_id) == $category->id) selected="selected" @endif>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <!-- Groupe de formulaires (unité de produit) -->
                            <div class="col-md-6">
                                <label class="small mb-1" for="unit_id">Unité <span class="text-danger">*</span></label>
                                <select class="form-select form-control-solid @error('unit_id') is-invalid @enderror" id="unit_id" name="unit_id">
                                    <option selected="" disabled="">Sélectionnez une unité :</option>
                                    @foreach ($units as $unit)
                                    <option value="{{ $unit->id }}" @if(old('unit_id', $product->unit_id) == $unit->id) selected="selected" @endif>{{ $unit->name }}</option>
                                    @endforeach
                                </select>
                                @error('unit_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <!-- Rangée de formulaires -->
                        <div class="row gx-3 mb-3">
                            <!-- Groupe de formulaires (prix d'achat) -->
                            <div class="col-md-6">
                                <label class="small mb-1" for="buying_price">Prix d'achat <span class="text-danger">*</span></label>
                                <input class="form-control form-control-solid @error('buying_price') is-invalid @enderror" id="buying_price" name="buying_price" type="text" placeholder="" value="{{ old('buying_price', $product->buying_price) }}" autocomplete="off" />
                                @error('buying_price')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <!-- Groupe de formulaires (prix de vente) -->
                            <div class="col-md-6">
                                <label class="small mb-1" for="selling_price">Prix de vente <span class="text-danger">*</span></label>
                                <input class="form-control form-control-solid @error('selling_price') is-invalid @enderror" id="selling_price" name="selling_price" type="text" placeholder="" value="{{ old('selling_price', $product->selling_price) }}" autocomplete="off" />
                                @error('selling_price')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <!-- Groupe de formulaires (stock) -->
                        <div class="mb-3">
                            <label class="small mb-1" for="stock">Stock <span class="text-danger">*</span></label>
                            <input class="form-control form-control-solid @error('stock') is-invalid @enderror" id="stock" name="stock" type="text" placeholder="" value="{{ old('stock', $product->stock) }}" autocomplete="off" />
                            @error('stock')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="small mb-1" for="small_description">Petite description <span class="text-danger">*</span></label>
                            <input class="form-control form-control-solid @error('small_description') is-invalid @enderror" id="small_description" name="small_description" type="text" placeholder="" value="{{ old('small_description', $product->small_description) }}" autocomplete="off" />
                            @error('small_description')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="small mb-1" for="description">Description <span class="text-danger">*</span></label>
                            <input class="form-control form-control-solid @error('description') is-invalid @enderror" id="description" name="description" type="text" placeholder="" value="{{ old('description', $product->description) }}" autocomplete="off" />
                            @error('description')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                          <div class="mb-3">
                            <label class="small mb-1" for="description">Lien d'image du produit<span class="text-danger">*</span></label>
                            <input class="form-control form-control-solid @error('product_image') is-invalid @enderror" id="product_image" name="product_image" type="text" placeholder="" value="{{ old('product_image', $product->product_image) }}" autocomplete="off" />
                            @error('product_image')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label class="small mb-1" for="isActive">Actif<span class="text-danger">*</span></label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="isActive" name="isActive" value="1" @if(old('isActive', $product->isActive) == 1) checked @endif>
                                <label class="form-check-label" for="isActive">Activer le produit</label>
                            </div>
                            @error('isActive')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label class="small mb-1">Matériaux</label>
                            <?php
                            $materialsList = ["wood", "metal", "paper", "plastic", "glass", "cotton", "leather"];
                            ?>
                            @foreach($materialsList as $material)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="materials[]" id="{{ $material }}" value="{{ $material }}" @if(is_array(old('materials')) && in_array($material, old('materials'))) checked @elseif(is_array($product->materials) && in_array($material, $product->materials)) checked @endif>
                                <label class="form-check-label" for="{{ $material }}">
                                    {{ $material }}
                                </label>
                            </div>
                            @endforeach
                            @error('materials')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        
                        <!-- Bouton de soumission -->
                        <button class="btn btn-primary" type="submit">Mettre à jour</button>
                        <a class="btn btn-danger" href="{{ route('products.index') }}">Retour</a>
                    </div>
                </div>
                <!-- FIN: Détails du produit -->
            </div>
        </div>
    </form>
</div>
<!-- FIN: Contenu principal de la page -->
@endsection

@push('page-scripts')
<script src="{{ asset('assets/js/img-preview.js') }}"></script>
@endpush
