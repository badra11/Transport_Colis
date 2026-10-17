<x-layouts::app :title="__('Accueil')">

    {{-- En-tête --}}
    <div class="mb-8">
        <x-page-header :description="__('Tableau de bord de gestion des colis')">
            <x-slot name="title">
                {{ __('Tableau de Bord') }}
            </x-slot>
        </x-page-header>
    </div>

    {{-- Messages flash --}}
    @if(session('success'))
        <div class="mb-4 p-4 rounded-lg bg-green-100 text-green-800 border border-green-200">
            {{ session('success') }}
        </div>
    @endif

    {{-- ===== CARTES STATISTIQUES PRINCIPALES ===== --}}
    <div class="grid auto-rows-min gap-4 md:grid-cols-2 lg:grid-cols-6 mb-6">
        
        {{-- Total Colis envoyer et rendus --}}
        <div class="relative overflow-hidden rounded-xl border border-default bg-gradient-to-br from-blue-500 to-blue-600 p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium mb-1">Total Colis Envoyer</p>
                    <p class="text-3xl font-bold">{{ number_format($colisEnvoyer) }}</p>
                </div>
                <div class="bg-white/20 rounded-lg p-3">
                    <flux:icon name="cube" class="w-8 h-8 text-white"/>
                </div>
            </div>
            <div class="mt-4 text-blue-100 text-xs">
                {{ $colisEnvoyerAujourdhui }} aujourd'hui <br>
                {{ $colisEnvoyerCetteSemaine }} cette semaine
            </div>
        </div>

        {{-- Colis Envoyer et Rendus Aujourd'hui --}}
        <div class="relative overflow-hidden rounded-xl border border-default bg-gradient-to-br from-green-500 to-green-600 p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-medium mb-1">Rendus Aujourd'hui</p>
                    <p class="text-3xl font-bold">{{ number_format($colisRendus) }}</p>
                </div>
                <div class="bg-white/20 rounded-lg p-3">
                    <flux:icon name="check-circle" class="w-8 h-8 text-white"/>
                </div>
            </div>
            <div class="mt-4 text-green-100 text-xs">
                {{ $colisRendusAujourdhui }} aujourd'hui <br>
                {{ $colisRendusCetteSemaine }} cette semaine 
            </div>
        </div>

        {{-- Montant Total --}}
        <div class="relative overflow-hidden rounded-xl border border-default bg-gradient-to-br from-purple-500 to-purple-600 p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm font-medium mb-1">Montant Total</p>
                    <p class="text-1xl font-bold">{{ number_format($montantColisEnvoyer, 0, ',', ' ') }} FCFA</p>
                </div>
                <div class="bg-white/20 rounded-lg p-3">
                    <flux:icon name="banknotes" class="w-8 h-8 text-white"/>
                </div>
            </div>
            <div class="mt-4 text-purple-100 text-xs">
                {{ number_format($montantColisRendu, 0, ',', ' ') }} FCFA rendus
            </div>
        </div>

        {{-- Colis Annulés --}}
        <div class="relative overflow-hidden rounded-xl border border-default bg-gradient-to-br from-red-500 to-red-600 p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-red-100 text-sm font-medium mb-1">Colis Annulés Définitivement</p>
                    <p class="text-3xl font-bold">{{ number_format($colisAnnules) }}</p>
                </div>
                <div class="bg-white/20 rounded-lg p-3">
                    <flux:icon name="x-circle" class="w-8 h-8 text-white"/>
                </div>
            </div>
            <div class="mt-4 text-red-100 text-xs">
                Montant à restituer <br>
                {{ number_format($montantColisAnnuler, 0, ',', ' ') }} FCFA
            </div>
        </div>

        <div class="relative overflow-hidden rounded-xl border border-default bg-gradient-to-br from-red-500 to-red-600 p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-red-100 text-sm font-medium mb-1">Colis Annulés</p>
                    <p class="text-3xl font-bold">{{ number_format($colisAnnules) }}</p>
                </div>
                <div class="bg-white/20 rounded-lg p-3">
                    <flux:icon name="x-circle" class="w-8 h-8 text-white"/>
                </div>
            </div>
            <div class="mt-4 text-red-100 text-xs">
                Définitivement annulés
            </div>
        </div>

        <div class="relative overflow-hidden rounded-xl border border-default bg-gradient-to-br from-red-500 to-red-600 p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-red-100 text-sm font-medium mb-1">Colis Annulés</p>
                    <p class="text-3xl font-bold">{{ number_format($colisAnnules) }}</p>
                </div>
                <div class="bg-white/20 rounded-lg p-3">
                    <flux:icon name="x-circle" class="w-8 h-8 text-white"/>
                </div>
            </div>
            <div class="mt-4 text-red-100 text-xs">
                Définitivement annulés
            </div>
        </div>
    </div>

    {{-- ===== STATISTIQUES PAR STATUT ===== --}}
    <div class="grid auto-rows-min gap-4 md:grid-cols-3 lg:grid-cols-6 mb-6">
        @foreach([
            ['label' => 'Dépôt', 'value' => $colisParStatut['depot'], 'color' => 'gray', 'icon' => 'archive-box'],
            ['label' => 'En Cours', 'value' => $colisParStatut['en_cours'], 'color' => 'yellow', 'icon' => 'truck'],
            ['label' => 'Arrivés', 'value' => $colisParStatut['arriver'], 'color' => 'blue', 'icon' => 'map-pin'],
            ['label' => 'Rendus', 'value' => $colisParStatut['rendu'], 'color' => 'green', 'icon' => 'check-badge'],
            ['label' => 'En Attente', 'value' => $colisParStatut['annuler'], 'color' => 'orange', 'icon' => 'clock'],
            ['label' => 'Annulés', 'value' => $colisParStatut['annulee'], 'color' => 'red', 'icon' => 'no-symbol'],
        ] as $stat)
            <div class="relative overflow-hidden rounded-xl border border-default bg-neutral-primary-soft p-5 shadow-xs">
                <div class="flex items-center gap-3">
                    <div class="bg-{{ $stat['color'] }}-100 rounded-lg p-2">
                        <flux:icon name="{{ $stat['icon'] }}" class="w-6 h-6 text-{{ $stat['color'] }}-600"/>
                    </div>
                    <div>
                        <p class="text-neutral-500 text-xs font-medium">{{ $stat['label'] }}</p>
                        <p class="text-xl font-bold text-heading">{{ number_format($stat['value']) }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- ===== STATISTIQUES GARE DE L'UTILISATEUR (si applicable) ===== --}}
    @if($userGareId)
        <div class="mb-6">
            <h3 class="text-lg font-bold text-heading mb-4 flex items-center gap-2">
                <flux:icon name="building-office" class="w-5 h-5 text-blue-500"/>
                Ma Gare
            </h3>
            <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                <div class="relative overflow-hidden rounded-xl border border-default bg-neutral-primary-soft p-5 shadow-xs">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-neutral-500 text-sm font-medium">Colis vers ma gare</p>
                            <p class="text-2xl font-bold text-blue-600">{{ number_format($colisVersMaGare) }}</p>
                        </div>
                        <flux:icon name="arrow-down-tray" class="w-8 h-8 text-blue-400"/>
                    </div>
                </div>
                <div class="relative overflow-hidden rounded-xl border border-default bg-neutral-primary-soft p-5 shadow-xs">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-neutral-500 text-sm font-medium">En attente de réception</p>
                            <p class="text-2xl font-bold text-yellow-600">{{ number_format($colisArrivesMaGare) }}</p>
                        </div>
                        <flux:icon name="bell-alert" class="w-8 h-8 text-yellow-400"/>
                    </div>
                </div>
                <div class="relative overflow-hidden rounded-xl border border-default bg-neutral-primary-soft p-5 shadow-xs">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-neutral-500 text-sm font-medium">Colis réceptionnés</p>
                            <p class="text-2xl font-bold text-green-600">{{ number_format($colisRendusMaGare) }}</p>
                        </div>
                        <flux:icon name="check-circle" class="w-8 h-8 text-green-400"/>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- ===== GRAPHIQUES ===== --}}
    <div class="grid auto-rows-min gap-4 md:grid-cols-2 mb-6">
        
        {{-- Graphique: Colis par mois --}}
        <div class="relative overflow-hidden rounded-xl border border-default bg-neutral-primary-soft p-6 shadow-xs">
            <h3 class="text-lg font-bold text-heading mb-4 flex items-center gap-2">
                <flux:icon name="chart-bar" class="w-5 h-5 text-blue-500"/>
                Colis par Mois (12 derniers mois)
            </h3>
            <div class="h-64">
                <canvas id="chartColisParMois"></canvas>
            </div>
        </div>

        {{-- Graphique: Colis rendus par jour (7 derniers jours) --}}
        <div class="relative overflow-hidden rounded-xl border border-default bg-neutral-primary-soft p-6 shadow-xs">
            <h3 class="text-lg font-bold text-heading mb-4 flex items-center gap-2">
                {{-- <flux:icon name="chart-line" class="w-5 h-5 text-green-500"/> --}}
                Colis Rendus par Jour (7 derniers jours)
            </h3>
            <div class="h-64">
                <canvas id="chartColisRendusParJour"></canvas>
            </div>
        </div>
    </div>

    {{-- ===== TOP GARES ===== --}}
    <div class="grid auto-rows-min gap-4 md:grid-cols-2 mb-6">
        
        {{-- Top Gares d'envoi --}}
        <div class="relative overflow-hidden rounded-xl border border-default bg-neutral-primary-soft p-6 shadow-xs">
            <h3 class="text-lg font-bold text-heading mb-4 flex items-center gap-2">
                <flux:icon name="paper-airplane" class="w-5 h-5 text-purple-500"/>
                Top 5 Gares d'Envoi
            </h3>
            <div class="space-y-3">
                @forelse($topGaresEnvois as $gare)
                    <div class="flex items-center justify-between p-3 bg-neutral-secondary-soft rounded-lg">
                        <div class="flex items-center gap-3">
                            <div class="bg-purple-100 rounded-full w-8 h-8 flex items-center justify-center text-purple-600 font-bold text-sm">
                                {{ $loop->iteration }}
                            </div>
                            <span class="font-medium">{{ $gare->gareEnvois->gare ?? 'N/A' }}</span>
                        </div>
                        <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-sm font-bold">
                            {{ $gare->total }}
                        </span>
                    </div>
                @empty
                    <p class="text-neutral-400 text-center py-4">Aucune donnée disponible</p>
                @endforelse
            </div>
        </div>

        {{-- Top Gares de destination --}}
        <div class="relative overflow-hidden rounded-xl border border-default bg-neutral-primary-soft p-6 shadow-xs">
            <h3 class="text-lg font-bold text-heading mb-4 flex items-center gap-2">
                <flux:icon name="map-pin" class="w-5 h-5 text-teal-500"/>
                Top 5 Gares de Destination
            </h3>
            <div class="space-y-3">
                @forelse($topGaresDestination as $gare)
                    <div class="flex items-center justify-between p-3 bg-neutral-secondary-soft rounded-lg">
                        <div class="flex items-center gap-3">
                            <div class="bg-teal-100 rounded-full w-8 h-8 flex items-center justify-center text-teal-600 font-bold text-sm">
                                {{ $loop->iteration }}
                            </div>
                            <span class="font-medium">{{ $gare->gare->gare ?? 'N/A' }}</span>
                        </div>
                        <span class="bg-teal-100 text-teal-700 px-3 py-1 rounded-full text-sm font-bold">
                            {{ $gare->total }}
                        </span>
                    </div>
                @empty
                    <p class="text-neutral-400 text-center py-4">Aucune donnée disponible</p>
                @endforelse
            </div>
        </div>
    </div>

    {{-- ===== DERNIERS COLIS ===== --}}
    <div class="grid auto-rows-min gap-4 md:grid-cols-2 mb-6">
        
        {{-- Derniers colis rendus --}}
        <div class="relative overflow-hidden rounded-xl border border-default bg-neutral-primary-soft p-6 shadow-xs">
            <h3 class="text-lg font-bold text-heading mb-4 flex items-center gap-2">
                <flux:icon name="check-circle" class="w-5 h-5 text-green-500"/>
                Derniers Colis Réceptionnés
            </h3>
            <div class="space-y-3">
                @forelse($derniersColisRendus as $colisRendu)
                    <div class="flex items-center justify-between p-3 bg-neutral-secondary-soft rounded-lg border-l-4 border-green-500">
                        <div>
                            <p class="font-medium text-sm">
                                {{ $colisRendu->colis->nom_destinataire ?? 'N/A' }}
                            </p>
                            <p class="text-xs text-neutral-400">
                                {{ $colisRendu->colis->numero_année ?? '' }}-{{ $colisRendu->colis->numero_journée ?? '' }} 
                                | Par: {{ $colisRendu->user->name ?? 'N/A' }}
                            </p>
                        </div>
                        <span class="text-xs text-green-600 font-medium">
                            {{ $colisRendu->created_at->format('d/m/Y H:i') }}
                        </span>
                    </div>
                @empty
                    <p class="text-neutral-400 text-center py-4">Aucun colis réceptionné récemment</p>
                @endforelse
            </div>
            <div class="mt-4 text-center">
                <flux:button :href="route('recupererColis.colisRendus')" size="sm" color="green" variant="outline">
                    Voir tout
                </flux:button>
            </div>
        </div>

        {{-- Derniers colis créés --}}
        <div class="relative overflow-hidden rounded-xl border border-default bg-neutral-primary-soft p-6 shadow-xs">
            <h3 class="text-lg font-bold text-heading mb-4 flex items-center gap-2">
                <flux:icon name="plus-circle" class="w-5 h-5 text-blue-500"/>
                Derniers Colis Créés
            </h3>
            <div class="space-y-3">
                @forelse($derniersColisCrees as $coli)
                    <div class="flex items-center justify-between p-3 bg-neutral-secondary-soft rounded-lg border-l-4 border-blue-500">
                        <div>
                            <p class="font-medium text-sm">
                                {{ $coli->nom_destinataire }} 
                                <span class="text-neutral-400">→ {{ $coli->gare->gare ?? 'N/A' }}</span>
                            </p>
                            <p class="text-xs text-neutral-400">
                                {{ $coli->numero_année }}-{{ $coli->numero_journée }} 
                                | {{ $coli->TypeColis->type ?? 'N/A' }}
                            </p>
                        </div>
                        <span class="text-xs text-blue-600 font-medium">
                            {{ $coli->created_at->format('d/m/Y H:i') }}
                        </span>
                    </div>
                @empty
                    <p class="text-neutral-400 text-center py-4">Aucun colis créé récemment</p>
                @endforelse
            </div>
        </div>
    </div>

    {{-- ===== GRAPHIQUE CIRCULAIRE: RÉPARTITION PAR STATUT ===== --}}
    <div class="relative overflow-hidden rounded-xl border border-default bg-neutral-primary-soft p-6 shadow-xs mb-6">
        <h3 class="text-lg font-bold text-heading mb-4 flex items-center gap-2">
            <flux:icon name="chart-pie" class="w-5 h-5 text-orange-500"/>
            Répartition des Colis par Statut
        </h3>
        <div class="h-64 flex justify-center">
            <canvas id="chartRepartitionStatut"></canvas>
        </div>
    </div>

    {{-- ===== SCRIPTS POUR GRAPHIQUES ===== --}}
    @push('js')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            // Graphique: Colis par mois
            const ctxMois = document.getElementById('chartColisParMois').getContext('2d');
            new Chart(ctxMois, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($colisParMois->pluck('nom_mois')) !!},
                    datasets: [{
                        label: 'Colis créés',
                        data: {!! json_encode($colisParMois->pluck('total')) !!},
                        backgroundColor: 'rgba(59, 130, 246, 0.7)',
                        borderColor: 'rgb(59, 130, 246)',
                        borderWidth: 1,
                        borderRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: { beginAtZero: true, ticks: { precision: 0 } }
                    }
                }
            });

            // Graphique: Colis rendus par jour
            const ctxJour = document.getElementById('chartColisRendusParJour').getContext('2d');
            new Chart(ctxJour, {
                type: 'line',
                data: {
                    labels: {!! json_encode($colisRendusParJour->pluck('nom_jour')) !!},
                    datasets: [{
                        label: 'Colis rendus',
                        data: {!! json_encode($colisRendusParJour->pluck('total')) !!},
                        backgroundColor: 'rgba(34, 197, 94, 0.2)',
                        borderColor: 'rgb(34, 197, 94)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4,
                        pointRadius: 4,
                        pointBackgroundColor: 'rgb(34, 197, 94)'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: { beginAtZero: true, ticks: { precision: 0 } }
                    }
                }
            });

            // Graphique circulaire: Répartition par statut
            const ctxPie = document.getElementById('chartRepartitionStatut').getContext('2d');
            new Chart(ctxPie, {
                type: 'doughnut',
                data: {
                    labels: ['Dépôt', 'En Cours', 'Arrivés', 'Rendus', 'En Attente', 'Annulés'],
                    datasets: [{
                        data: [
                            {{ $colisParStatut['depot'] }},
                            {{ $colisParStatut['en_cours'] }},
                            {{ $colisParStatut['arriver'] }},
                            {{ $colisParStatut['rendu'] }},
                            {{ $colisParStatut['annuler'] }},
                            {{ $colisParStatut['annulee'] }}
                        ],
                        backgroundColor: [
                            'rgb(156, 163, 175)',  // gray - depot
                            'rgb(234, 179, 8)',     // yellow - en_cours
                            'rgb(59, 130, 246)',    // blue - arriver
                            'rgb(34, 197, 94)',     // green - rendu
                            'rgb(249, 115, 22)',    // orange - annuler
                            'rgb(239, 68, 68)'      // red - annulee
                        ],
                        borderWidth: 2,
                        borderColor: 'white'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'right',
                            labels: { padding: 20, usePointStyle: true }
                        }
                    }
                }
            });
        </script>
    @endpush

</x-layouts::app>
{{-- <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="grid auto-rows-min gap-4 md:grid-cols-4">
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
            </div>
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
            </div>
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
            </div>
             <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
            </div>
        </div>
        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
        </div>
    </div> --}}
