@extends('layouts.app')

@section('title', 'Accueil - Stockify')

@section('content')
<!-- Section de Bienvenue / Hero -->
<div class="card bg-primary text-white p-4 mb-4 border-0 shadow-sm" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);">
    <div class="row align-items-center">
        <div class="col-md-8">
            <h2 class="fw-bold mb-2">Bienvenue sur Stockify !</h2>
            <p class="text-white-50 mb-3">Votre solution moderne pour gérer vos stocks, suivre vos mouvements et garder un œil sur vos réapprovisionnements en temps réel.</p>
            <div class="d-flex gap-2">
                <a href="{{ route('products.index') }}" class="btn btn-primary px-3 shadow-sm">
                    <i class="bi bi-box-seam me-1"></i> Gérer le Stock
                </a>
                <a href="{{ route('products.create') }}" class="btn btn-outline-light px-3">
                    <i class="bi bi-plus-lg me-1"></i> Ajouter un Produit
                </a>
            </div>
        </div>
        <div class="col-md-4 text-center d-none d-md-block">
            <i class="bi bi-box-seam text-primary opacity-50" style="font-size: 6rem;"></i>
        </div>
    </div>
</div>

<!-- Cartes d'indicateurs (KPIs) avec animation CSS icon-circle -->
<div class="row g-4 mb-4">
    <div class="col-md-4 stat-card">
        <div class="card card-kpi-primary p-3">
            <div class="d-flex align-items-center justify-content-between ps-2">
                <div>
                    <span class="text-muted small fw-semibold">Total Produits</span>
                    <h3 class="fw-bold mb-0 mt-1">{{ $totalProducts }}</h3>
                </div>
                <div class="icon-circle bg-primary bg-opacity-10 text-primary">
                    <i class="bi bi-boxes fs-4"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4 stat-card">
        <div class="card card-kpi-danger p-3">
            <div class="d-flex align-items-center justify-content-between ps-2">
                <div>
                    <span class="text-muted small fw-semibold">Produits en Alerte</span>
                    <h3 class="fw-bold mb-0 mt-1 text-danger">{{ $lowStockProducts }}</h3>
                </div>
                <div class="icon-circle bg-danger bg-opacity-10 text-danger">
                    <i class="bi bi-exclamation-triangle fs-4"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4 stat-card">
        <div class="card card-kpi-success p-3">
            <div class="d-flex align-items-center justify-content-between ps-2">
                <div>
                    <span class="text-muted small fw-semibold">Total Mouvements</span>
                    <h3 class="fw-bold mb-0 mt-1 text-success">{{ $totalMovements }}</h3>
                </div>
                <div class="icon-circle bg-success bg-opacity-10 text-success">
                    <i class="bi bi-arrow-down-up fs-4"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Derniers Produits Ajoutés -->
<div class="card shadow-sm">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="fw-bold mb-0">Derniers Produits Ajoutés</h5>
        <a href="{{ route('products.index') }}" class="btn btn-sm btn-link text-decoration-none">Voir tout <i class="bi bi-arrow-right"></i></a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-muted small text-uppercase">
                    <tr>
                        <th class="ps-4">Référence</th>
                        <th>Nom</th>
                        <th>Prix</th>
                        <th>Quantité</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentProducts as $product)
                    <tr>
                        <td class="ps-4 font-monospace fw-semibold text-secondary">{{ $product->reference }}</td>
                        <td class="fw-bold text-dark">{{ $product->name }}</td>
                        <td>{{ number_format($product->price, 2) }} DH</td>
                        <td>
                            @if($product->quantity <= $product->alert_stock)
                                <span class="badge badge-soft-danger qty-badge px-3 py-2 rounded-pill">{{ $product->quantity }} (Alerte)</span>
                            @else
                                <span class="badge badge-soft-success qty-badge px-3 py-2 rounded-pill">{{ $product->quantity }}</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-4 text-muted">Aucun produit trouvé.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection