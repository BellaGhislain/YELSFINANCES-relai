<base href="/">
<x-layouts>
    <!-- Content -->
    <div class="content container-fluid">
        <!-- Messages de succès et d'erreur -->
        @if (session('success'))
            <x-alert type="success" :message="session('success')" />
        @endif

        @if (session('error'))
            <x-alert type="error" :message="session('error')" />
        @endif

        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h1 class="page-header-title">Gestion des sessions</h1>
                </div>
                <div class="col-auto">
                    <a class="btn btn-primary" href="{{ route('admin.sessions.create') }}">
                        <i class="bi-plus me-1"></i> Ajouter une session
                    </a>
                </div>
            </div>
        </div>
        <!-- End Page Header -->

        <!-- Card -->
        <div class="card">
            <!-- Header -->
            <div class="card-header card-header-content-md-between">
                <div class="mb-2 mb-md-0 d-flex gap-2 align-items-end">
                    <form class="d-flex gap-3 align-items-end" method="GET" action="{{ route('admin.sessions.index') }}">
                        <!-- Formation -->
                        <div class="d-flex flex-column">
                            <label class="form-label small fw-bold text-muted mb-1">Formation</label>
                            <select class="form-select form-select-sm" name="formation_id" id="formationFilter">
                                <option value="">Toutes les formations</option>
                                @foreach($formations as $formation)
                                    <option value="{{ $formation->id }}" {{ request('formation_id') == $formation->id ? 'selected' : '' }}>
                                        {{ Str::limit($formation->name, 40) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Date de début -->
                        <div class="d-flex flex-column">
                            <label class="form-label small fw-bold text-muted mb-1">Date de début</label>
                            <input type="date" class="form-control form-control-sm" name="start_date" id="startDate" value="{{ request('start_date') }}">
                        </div>

                        <!-- Date de fin -->
                        <div class="d-flex flex-column">
                            <label class="form-label small fw-bold text-muted mb-1">Date de fin</label>
                            <input type="date" class="form-control form-control-sm" name="end_date" id="endDate" value="{{ request('end_date') }}">
                        </div>

                        <!-- Bouton Rechercher -->
                        <button type="submit" class="btn btn-primary btn-sm d-flex align-items-center">
                            <i class="bi-search me-1"></i> Rechercher
                        </button>
                          <button type="button" class="btn btn-outline-primary text-primary btn-sm d-flex align-items-center btn-reset-session" onclick="window.location='{{ route('admin.sessions.index') }}'">
                        <i class="bi-arrow-clockwise me-1"></i> Réinitialiser
                        </button>
                    </form>
                </div>
            </div>
            <!-- End Header -->

            <!-- Table -->
            <div class="table-responsive">
                <table class="table table-borderless table-thead-bordered table-nowrap card-table">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col" class="table-column-pe-0">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="datatableCheckAll">
                                    <label class="form-check-label" for="datatableCheckAll"></label>
                                </div>
                            </th>
                            <th>Formation</th>
                            <th>Date de début</th>
                            <th>Date de fin</th>
                            <th>Localisation</th>
                            <th>Type</th>
                            <th>Prix</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($sessions as $session)
                            <tr>
                                <td class="table-column-pe-0">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="{{ $session->id }}" id="usersDataCheck{{ $session->id }}">
                                        <label class="form-check-label" for="usersDataCheck{{ $session->id }}"></label>
                                    </div>
                                </td>
                                <td>
                                    <a class="d-flex align-items-center" href="#">
                                        <div class="avatar">
                                            <img class="avatar-img" src="https://images.pexels.com/photos/11035471/pexels-photo-11035471.jpeg?auto=compress&cs=tinysrgb&w=800" alt="Formation">
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <span class="card-title h5 text-dark text-inherit">{{ Str::limit($session->formation->name, 40) }}</span>
                                            <span class="d-block fs-6 text-body">
                                                {{ $session->trainers->isNotEmpty() ? $session->trainers->map(fn($trainer) => Str::limit($trainer->first_name, 10))->join(', ') : 'Aucun formateur' }}
                                                •
                                                @if($session->start_date && $session->end_date)
                                                    @php
                                                        $diffDays = $session->start_date->diffInDays($session->end_date);
                                                        $weeks = intdiv($diffDays, 7);
                                                        $days = $diffDays % 7;
                                                    @endphp
                                                    @if($weeks > 0)
                                                        {{ $weeks }} semaine{{ $weeks > 1 ? 's' : '' }}@if($days > 0) {{ $days }} jour{{ $days > 1 ? 's' : '' }}@endif
                                                    @else
                                                        {{ $days }} jour{{ $days > 1 ? 's' : '' }}
                                                    @endif
                                                @else
                                                    N/A
                                                @endif
                                            </span>
                                        </div>
                                    </a>
                                </td>
                                <td>
                                    <span class="text-dark">{{ $session->start_date ? $session->start_date->format('d/m/Y') : 'N/A' }}</span>
                                </td>
                                <td>
                                    <span class="text-dark">{{ $session->end_date ? $session->end_date->format('d/m/Y') : 'N/A' }}</span>
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="fw-bold">{{ $session->city }}, {{ $session->country }}</span>
                                        <span class="text-muted">Centre de formation</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-soft-primary text-primary">{{ $session->type }}</span>
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <x-price :amount="$session->price" currency="€" />
                                    </div>
                                </td>
                                <td>
                                    @if ($session->status == 'en attente')
                                        <span class="badge bg-soft-info text-info">En attente</span>
                                    @elseif ($session->status == 'en cours')
                                        <span class="badge bg-soft-success text-success">En cours</span>
                                    @elseif ($session->status == 'terminée')
                                        <span class="badge bg-soft-secondary text-secondary">Terminée</span>
                                    @elseif ($session->status == 'annulée')
                                        <span class="badge bg-soft-danger text-danger">Annulée</span>
                                    @endif
                                </td>
                                <td>
                                    <!-- Unfold -->
                                    <div class="hs-unfold">
                                        <button type="button" class="btn btn-ghost-secondary btn-icon btn-sm rounded-circle" id="settingsDropdown{{ $session->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bi-three-dots-vertical"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end mt-1" aria-labelledby="settingsDropdown{{ $session->id }}">
                                            <span class="dropdown-header">Actions</span>
                                            @if ($session->status != 'annulée' && $session->status != 'terminée')
                                                <a class="dropdown-item" href="{{ route('admin.sessions.edit', $session) }}">
                                                    <i class="bi-pencil-fill dropdown-item-icon"></i> Modifier
                                                </a>
                                            @endif
                                            <a class="dropdown-item btn-view-session" href="#"
                                               data-bs-toggle="modal"
                                               data-bs-target="#viewSessionModal"
                                               data-title="{{ $session->formation->name }}"
                                               data-instructor="{{ $session->trainers->isNotEmpty() ? $session->trainers->map(fn($trainer) => $trainer->first_name . ' ' . $trainer->last_name)->join(', ') : 'Aucun formateur' }}"
                                               data-start="{{ $session->start_date ? $session->start_date->format('d/m/Y') : 'N/A' }}"
                                               data-end="{{ $session->end_date ? $session->end_date->format('d/m/Y') : 'N/A' }}"
                                               data-location="{{ $session->city }}, {{ $session->country }}"
                                               data-type="{{ $session->type }}"
                                               data-price="{{ $session->price }}"
                                               data-status="{{ ucfirst($session->status) }}">
                                                <i class="bi-eye dropdown-item-icon"></i> Voir
                                            </a>
                                            <a class="dropdown-item" href="{{ route('admin.sessions.attendees', $session->id) }}">
                                                <i class="bi-people-fill dropdown-item-icon"></i> Participants
                                            </a>
                                            @if ($session->status != 'annulée' && $session->status != 'terminée')
                                                <a class="dropdown-item" href="javascript:;" data-bs-toggle="modal" data-bs-target="#deactivateSessionModal{{ $session->id }}">
                                                    <i class="bi-x-circle-fill dropdown-item-icon"></i> Annuler
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                    <!-- End Unfold -->
                                </td>
                            </tr>
                            <!-- Modal de confirmation pour annuler -->
                            @if ($session->status != 'annulée' && $session->status != 'terminée')
                                <div class="modal fade" id="deactivateSessionModal{{ $session->id }}" tabindex="-1" aria-labelledby="deactivateSessionModalLabel{{ $session->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deactivateSessionModalLabel{{ $session->id }}">Confirmer l'annulation</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Voulez-vous vraiment annuler la session <strong>{{ $session->formation->name }}</strong> ? Cette action peut être annulée ultérieurement.</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-white" data-bs-dismiss="modal">Annuler</button>
                                                <form action="{{ route('admin.sessions.deactivate', $session) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('POST')
                                                    <button type="submit" class="btn btn-danger">Annuler la session</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <!-- Fin Modal -->
                        @empty
                            <tr>
                                <td colspan="9" class="text-center p-4">
                                    <img class="mb-3" src="{{ asset('assets/svg/illustrations/oc-error.svg') }}" alt="Image Description" style="width: 10rem;" data-hs-theme-appearance="default">
                                    <img class="mb-3" src="{{ asset('assets/svg/illustrations-light/oc-error.svg') }}" alt="Image Description" style="width: 10rem;" data-hs-theme-appearance="dark">
                                    <p class="mb-0">Aucune session à afficher</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <!-- End Table -->

            <!-- Footer -->
            <div class="card-footer">
                <div class="row justify-content-center justify-content-sm-between align-items-sm-center">
                    <div class="col-sm mb-2 mb-sm-0">
                        <div class="d-flex justify-content-center justify-content-sm-start align-items-center">
                            <span class="me-2">Affichage :</span>
                            <span class="text-secondary me-2">de</span>
                            <span>{{ $sessions->total() }}</span>
                        </div>
                    </div>
                    <div class="col-sm-auto">
                        <div class="d-flex justify-content-center justify-content-sm-end">
                            {{ $sessions->links() }}
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Footer -->
        </div>
        <!-- End Card -->
    </div>
    <!-- End Content -->

    <!-- Modal Voir Session -->
    <div class="modal fade" id="viewSessionModal" tabindex="-1" aria-labelledby="viewSessionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewSessionModalLabel">Détails de la session</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>Formation :</strong> <span id="sessionTitle"></span></li>
                        <li class="list-group-item"><strong>Formateur(s) :</strong> <span id="sessionInstructor"></span></li>
                        <li class="list-group-item"><strong>Date de début :</strong> <span id="sessionStart"></span></li>
                        <li class="list-group-item"><strong>Date de fin :</strong> <span id="sessionEnd"></span></li>
                        <li class="list-group-item"><strong>Lieu :</strong> <span id="sessionLocation"></span></li>
                        <li class="list-group-item"><strong>Type :</strong> <span id="sessionType"></span></li>
                        <li class="list-group-item"><strong>Prix :</strong> <span id="sessionPrice"></span></li>
                        <li class="list-group-item"><strong>Statut :</strong> <span id="sessionStatus"></span></li>
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>

    <!-- JS Implementing Plugins -->
    <script src="{{ asset('assets/js/vendor.min.js') }}"></script>
    <script src="{{ asset('assets/js/theme.min.js') }}"></script>

    <!-- JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Gestion du modal
            const viewButtons = document.querySelectorAll('.btn-view-session');
            viewButtons.forEach(function(btn) {
                btn.addEventListener('click', function() {
                    document.getElementById('sessionTitle').textContent = btn.getAttribute('data-title');
                    document.getElementById('sessionInstructor').textContent = btn.getAttribute('data-instructor');
                    document.getElementById('sessionStart').textContent = btn.getAttribute('data-start');
                    document.getElementById('sessionEnd').textContent = btn.getAttribute('data-end');
                    document.getElementById('sessionLocation').textContent = btn.getAttribute('data-location');
                    document.getElementById('sessionType').textContent = btn.getAttribute('data-type');
                    document.getElementById('sessionPrice').textContent = btn.getAttribute('data-price');
                    document.getElementById('sessionStatus').textContent = btn.getAttribute('data-status');
                });
            });

            // Validation des dates avant soumission
            const form = document.querySelector('form');
            form.addEventListener('submit', function(e) {
                const startDate = document.getElementById('startDate').value;
                const endDate = document.getElementById('endDate').value;
                if (startDate && endDate && startDate > endDate) {
                    e.preventDefault();
                    alert('La date de début ne peut pas être postérieure à la date de fin.');
                }
            });

            // Sélectionner toutes les cases à cocher
            const checkAll = document.getElementById('datatableCheckAll');
            checkAll.addEventListener('change', function() {
                document.querySelectorAll('.form-check-input').forEach(checkbox => {
                    checkbox.checked = checkAll.checked;
                });
            });
        });
    </script>
</x-layouts>
