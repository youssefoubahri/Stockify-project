@extends('layouts.app')

@section('title', 'Produits - Stockify')

@section('content')
<!-- En-tête de page -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-1">Stock des Produits</h3>
        <p class="text-muted mb-0">Consultez et ajustez l'état de votre inventaire en temps réel.</p>
    </div>
    <a href="{{ route('products.create') }}" class="btn btn-primary px-3 shadow-sm">
        <i class="bi bi-plus-lg me-1"></i> Nouveau Produit
    </a>
</div>

<!-- Message de succès après action -->
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<!-- Tableau Principal -->
<div class="card shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-muted small text-uppercase">
                    <tr>
                        <th class="ps-4">Réf.</th>
                        <th>Nom du Produit</th>
                        <th>Catégorie</th>
                        <th>Prix Unitaire</th>
                        <th>Quantité</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                    <tr class="table-row-fade" style="animation-delay: {{ $loop->index * 0.08 }}s;">
                        <td class="ps-4 font-monospace fw-semibold text-secondary">{{ $product->reference }}</td>
                        <td class="fw-bold text-dark">{{ $product->name }}</td>
                        <td>
                            <span class="badge bg-light text-dark border">
                                {{ $product->category->name ?? 'Non assignée' }}
                            </span>
                        </td>
                        <td>{{ number_format($product->price, 2) }} €</td>
                        <td>
                            @if($product->quantity <= $product->alert_stock)
                                <span class="badge badge-soft-danger px-3 py-2 rounded-pill qty-badge">
                                    <i class="bi bi-exclamation-triangle-fill me-1"></i>{{ $product->quantity }}
                                </span>
                            @else
                                <span class="badge badge-soft-success px-3 py-2 rounded-pill qty-badge">
                                    <i class="bi bi-check-circle-fill me-1"></i>{{ $product->quantity }}
                                </span>
                            @endif
                        </td>
                        <td class="text-end pe-4">
                            <div class="d-flex justify-content-end gap-2">
                                <!-- Bouton Modifier -->
                                <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-outline-primary" title="Modifier le produit">
                                    <i class="bi bi-pencil"></i>
                                </a>

                                <!-- Bouton Supprimer -->
                                <form action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce produit ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Supprimer">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="bi bi-box-seam display-6 d-block mb-2 text-secondary opacity-50"></i>
                            Aucun produit enregistré pour le moment.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    <!-- Pagination -->
    @if(method_exists($products, 'links') && $products->hasPages())
        <div class="card-footer bg-white py-3">
            {{ $products->links() }}
        </div>
    @endif
</div>
@endsection