@extends('layouts.app')

@section('title', 'Historique des Mouvements')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-1">Historique des Mouvements</h3>
        <p class="text-muted mb-0">Traçabilité complète des entrées et sorties de stock.</p>
    </div>
    <a href="{{ route('products.index') }}" class="btn btn-outline-secondary px-3 shadow-sm">
        <i class="bi bi-arrow-left me-1"></i> Retour aux Produits
    </a>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-muted small text-uppercase">
                    <tr>
                        <th class="ps-4">Date & Heure</th>
                        <th>Produit</th>
                        <th>Type</th>
                        <th>Quantité</th>
                        <th class="pe-4">Motif / Raison</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($movements as $movement)
                    <tr>
                        <td class="ps-4 text-secondary small">
                            <i class="bi bi-clock me-1"></i>{{ $movement->created_at ? $movement->created_at->format('d/m/Y H:i') : '-' }}
                        </td>
                        <td class="fw-bold text-dark">
                            {{ $movement->product->name ?? 'Produit supprimé' }}
                        </td>
                        <td>
                            @if(in_array(strtolower($movement->type), ['entrée', 'entree', 'in']))
                                <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-pill">
                                    <i class="bi bi-arrow-down-left me-1"></i>Entrée
                                </span>
                            @else
                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-2 rounded-pill">
                                    <i class="bi bi-arrow-up-right me-1"></i>Sortie
                                </span>
                            @endif
                        </td>
                        <td class="fw-semibold">{{ $movement->quantity }}</td>
                        <td class="pe-4 text-muted">{{ $movement->reason ?? 'Non précisé' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            <i class="bi bi-arrow-left-right display-6 d-block mb-2 text-secondary opacity-50"></i>
                            Aucun mouvement enregistré pour le moment.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@if(method_exists($movements, 'links') && $movements->hasPages())
    <div class="mt-4">
        {{ $movements->links() }}
    </div>
@endif
@endsection