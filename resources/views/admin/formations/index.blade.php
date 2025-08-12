<base href="/">
<x-layouts>
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
                    <h1 class="page-header-title">Gestion des formations</h1>
                </div>
                <div class="col-auto">
                    <a class="btn btn-primary" href="{{ route('admin.formations.create') }}">
                        <i class="bi-plus me-1"></i> Ajouter une formation
                    </a>
                </div>
            </div>
        </div>
        <!-- End Page Header -->

        <!-- Card -->
        <div class="card">
            <!-- Header -->
            <div class="card-header card-header-content-md-between">
                <div class="mb-2 mb-md-0">
                    <form>
                        <!-- Search -->
                        <div class="input-group input-group-merge input-group-flush">
                            <div class="input-group-prepend input-group-text">
                                <i class="bi-search"></i>
                            </div>
                            <input id="datatableSearch" type="search" class="form-control" placeholder="Rechercher des formations" aria-label="Rechercher des formations">
                        </div>
                        <!-- End Search -->
                    </form>
                </div>
                <div class="d-grid d-sm-flex justify-content-md-end align-items-sm-center gap-2">
                    <!-- Placeholder pour filtres ou actions supplémentaires si nécessaire -->
                </div>
            </div>
            <!-- End Header -->

            <!-- Table -->
            <div class="table-responsive datatable-custom">
                <table id="datatable" class="table table-borderless table-thead-bordered table-nowrap card-table" data-hs-datatables-options='{
                    "columnDefs": [{"targets": [0, 6], "orderable": false}],
                    "order": [],
                    "info": {"totalQty": "#datatableWithPaginationInfoTotalQty"},
                    "search": "#datatableSearch",
                    "entries": "#datatableEntries",
                    "pageLength": 5,
                    "isResponsive": false,
                    "isShowPaging": false,
                    "pagination": "datatablePagination"
                }'>
                    <thead class="thead-light">
                        <tr>
                            <th scope="col" class="table-column-pe-0">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="datatableCheckAll">
                                    <label class="form-check-label" for="datatableCheckAll"></label>
                                </div>
                            </th>
                            <th>Formation</th>
                            <th>Niveau</th>
                            <!-- <th>Formateurs</th> -->
                            <th>Compétences</th>
                            <th>Présentation</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($formations as $formation)
                        <tr>
                            <td class="table-column-pe-0">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="formationCheck{{ $formation->id }}">
                                    <label class="form-check-label" for="formationCheck{{ $formation->id }}"></label>
                                </div>
                            </td>
                            <td>
                                <span class="card-title h5 text-dark text-inherit">{{ $formation->name }}</span>
                            </td>
                            <td>
                                <span class="badge bg-soft-{{ $formation->level === 'debutant' ? 'success' : ($formation->level === 'intermediaire' ? 'info' : ($formation->level === 'avance' ? 'warning' : 'danger')) }} text-{{ $formation->level === 'debutant' ? 'success' : ($formation->level === 'intermediaire' ? 'info' : ($formation->level === 'avance' ? 'warning' : 'danger')) }}">
                                    {{ ucfirst($formation->level) }}
                                </span>
                            </td>
                            <!-- <td>
                                <div class="text-wrap" style="width: 12rem;">
                                    <p class="mb-0">{{ Str::limit($formation->trainers->map(function($trainer) { return $trainer->first_name . ' ' . $trainer->last_name; })->implode(', '), 30) }}</p>
                                </div>
                            </td> -->
                            <td>
                                <div class="text-wrap" style="width: 12rem;">
                                    <p class="mb-0">{{ Str::limit($formation->skills->pluck('name')->implode(', '), 30) }}</p>
                                </div>
                            </td>
                            <td>
                                <div class="text-wrap" style="width: 15rem;">
                                    <p class="mb-0">{{ Str::limit($formation->presentation, 100) }}</p>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-soft-{{ $formation->is_active ? 'success' : 'danger' }} text-{{ $formation->is_active ? 'success' : 'danger' }}">
                                    {{ $formation->is_active ? 'Actif' : 'Désactivée' }}
                                </span>
                            </td>
                            <td>
                                <!-- Unfold -->
                                <div class="hs-unfold">
                                    <button type="button" class="btn btn-ghost-secondary btn-icon btn-sm rounded-circle" id="settingsDropdown{{ $formation->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi-three-dots-vertical"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end mt-1" aria-labelledby="settingsDropdown{{ $formation->id }}">
                                        <span class="dropdown-header">Actions</span>
                                        <a class="dropdown-item" href="{{ route('admin.formations.show', $formation) }}">
                                            <i class="bi-eye dropdown-item-icon"></i> Voir
                                        </a>
                                        @if($formation->is_active)
                                            <a class="dropdown-item" href="{{ route('admin.formations.edit', $formation) }}">
                                                <i class="bi-pencil-fill dropdown-item-icon"></i> Modifier
                                            </a>
                                        @endif
                                        @if($formation->is_active)
                                            <a class="dropdown-item" href="javascript:;" data-bs-toggle="modal" data-bs-target="#deactivateFormationModal{{ $formation->id }}">
                                                <i class="bi-trash dropdown-item-icon"></i> Désactiver
                                            </a>
                                        @else
                                            <a class="dropdown-item" href="javascript:;" data-bs-toggle="modal" data-bs-target="#activateFormationModal{{ $formation->id }}">
                                                <i class="bi-check-circle dropdown-item-icon"></i> Activer
                                            </a>
                                        @endif
                                    </div>
                                </div>
                                <!-- End Unfold -->
                            </td>
                        </tr>

                        <!-- Modal de confirmation pour désactiver -->
                        @if($formation->is_active)
                        <div class="modal fade" id="deactivateFormationModal{{ $formation->id }}" tabindex="-1" aria-labelledby="deactivateFormationModalLabel{{ $formation->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deactivateFormationModalLabel{{ $formation->id }}">Confirmer la désactivation</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Voulez-vous vraiment désactiver la formation <strong>{{ $formation->name }}</strong> ? Cette action peut être annulée ultérieurement.</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-white" data-bs-dismiss="modal">Annuler</button>
                                        <form action="{{ route('admin.formations.deactivate', $formation) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('POST')
                                            <button type="submit" class="btn btn-danger">Désactiver</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @else
                        <div class="modal fade" id="activateFormationModal{{ $formation->id }}" tabindex="-1" aria-labelledby="activateFormationModalLabel{{ $formation->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="activateFormationModalLabel{{ $formation->id }}">Confirmer l'activation</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Voulez-vous vraiment activer la formation <strong>{{ $formation->name }}</strong> ? Elle sera de nouveau disponible.</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-white" data-bs-dismiss="modal">Annuler</button>
                                        <form action="{{ route('admin.formations.activate', $formation) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('POST')
                                            <button type="submit" class="btn btn-success">Activer</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        <!-- Fin Modal -->
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- End Table -->

            <!-- Footer -->
            <div class="card-footer">
                <div class="row justify-content-center justify-content-sm-between align-items-sm-center">
                    <div class="col-sm mb-2 mb-sm-0">
                        <div class="d-flex justify-content-center justify-content-sm-start align-items-center">
                            <span class="me-2">Showing:</span>
                            <div class="tom-select-custom">
                                <select id="datatableEntries" class="js-select form-select form-select-borderless w-auto" autocomplete="off" data-hs-tom-select-options='{
                                    "searchInDropdown": false,
                                    "hideSearch": true
                                }'>
                                    <option value="5">5</option>
                                    <option value="7" selected>7</option>
                                    <option value="12">12</option>
                                </select>
                            </div>
                            <span class="text-secondary me-2">of</span>
                            <span id="datatableWithPaginationInfoTotalQty">{{ $formations->count() }}</span>
                        </div>
                    </div>
                    <div class="col-sm-auto">
                        <div class="d-flex justify-content-center justify-content-sm-end">
                            <nav id="datatablePagination" aria-label="Activity pagination"></nav>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Footer -->
        </div>
        <!-- End Card -->
    </div>

    <!-- JS Implementing Plugins -->
    <script src="{{ asset('assets/js/vendor.min.js') }}"></script>
    <script src="{{ asset('assets/js/theme.min.js') }}"></script>

    <!-- JS Plugins Init. -->
    <script>
        $(document).on('ready', function () {
            HSCore.components.HSDatatables.init($('#datatable'), {
                select: {
                    style: 'multi',
                    selector: 'td:first-child input[type="checkbox"]',
                    classMap: {
                        checkAll: '#datatableCheckAll',
                        counter: '#datatableCounter',
                        counterInfo: '#datatableCounterInfo'
                    }
                },
                language: {
                    zeroRecords: `<div class="text-center p-4">
                        <img class="mb-3" src="{{ asset('assets/svg/illustrations/oc-error.svg') }}" alt="Image Description" style="width: 10rem;" data-hs-theme-appearance="default">
                        <img class="mb-3" src="{{ asset('assets/svg/illustrations-light/oc-error.svg') }}" alt="Image Description" style="width: 10rem;" data-hs-theme-appearance="dark">
                        <p class="mb-0">Aucune formation à afficher</p>
                    </div>`
                }
            });
        });
    </script>
</x-layouts>
