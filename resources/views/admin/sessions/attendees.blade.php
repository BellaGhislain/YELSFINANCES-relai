<base href="/">
<x-layouts>
    <!-- Content -->
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center mb-3">
                <div class="col-md mb-2 mb-md-0">
                    <h1 class="page-header-title">
                        Participants à la session
                        {{ is_object($session) && isset($session->formation) ? $session->formation->name : 'Formation inconnue' }}
                        allant du
                        {{
                            is_object($session) && isset($session->start_date) && isset($session->end_date)
                                ? (\Carbon\Carbon::parse($session->start_date)->locale('fr')->translatedFormat('d F Y') . ' au ' . \Carbon\Carbon::parse($session->end_date)->locale('fr')->translatedFormat('d F Y'))
                                : 'Dates inconnues'
                        }}
                        <span class="badge bg-soft-dark text-dark ms-2">{{ $attendees->count() }}</span>
                    </h1>
                    <a class="d-inline-block text-body mb-2 mb-sm-0 me-3" href="javascript:;" data-bs-toggle="modal" data-bs-target="#exportAttendeesModal">
                        <i class="bi-download me-1"></i> Exporter
                    </a>
                </div>
                <div class="col-auto">
                    <a class="btn btn-outline-primary" href="{{ route('admin.sessions.index') }}">
                        <i class="bi-arrow-left me-1"></i> Retour
                    </a>
                </div>
            </div>
        </div>
        <!-- End Page Header -->

        <!-- Card -->
        <div class="card">
            <!-- Header -->
            <div class="card-header card-header-content-sm-between">
                <div class="mb-2 mb-sm-0">
                    <form>
                        <!-- Search -->
                        <div class="input-group input-group-merge input-group-flush">
                            <div class="input-group-prepend input-group-text">
                                <i class="bi-search"></i>
                            </div>
                            <input id="datatableSearch" type="search" class="form-control" placeholder="Rechercher un participant" aria-label="Rechercher des participants">
                        </div>
                        <!-- End Search -->
                    </form>
                </div>

                <div class="d-grid d-sm-flex justify-content-sm-end align-items-sm-center gap-2">
                    <!-- Filtres par colonne -->
                    <div class="dropdown">
                        <button type="button" class="btn btn-white w-100" id="filterDropdown" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                            <i class="bi-funnel me-1"></i> Filtres <span class="badge bg-soft-primary text-primary rounded-circle ms-1">{{ count(array_filter($filters)) }}</span>
                        </button>

                        <div class="dropdown-menu dropdown-menu-end dropdown-card" aria-labelledby="filterDropdown" style="width: 20rem;">
                            <div class="card card-sm">
                                <div class="card-body">
                                    <div class="d-grid gap-3">
                                        <!-- Filtre Prénom -->
                                        <div class="form-group">
                                            <label class="form-label">Prénom</label>
                                            <select class="form-select form-select-sm" id="filterFirstName">
                                                <option value="">Tous les prénoms</option>
                                                @foreach($filters['first_names'] as $first_name)
                                                    <option value="{{ $first_name }}">{{ $first_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Filtre Nom -->
                                        <div class="form-group">
                                            <label class="form-label">Nom</label>
                                            <select class="form-select form-select-sm" id="filterLastName">
                                                <option value="">Tous les noms</option>
                                                @foreach($filters['last_names'] as $last_name)
                                                    <option value="{{ $last_name }}">{{ $last_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Filtre Email -->
                                        <div class="form-group">
                                            <label class="form-label">E-mail</label>
                                            <select class="form-select form-select-sm" id="filterEmail">
                                                <option value="">Tous les emails</option>
                                                @foreach($filters['emails'] as $email)
                                                    <option value="{{ $email }}">{{ $email }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Filtre Téléphone -->
                                        <div class="form-group">
                                            <label class="form-label">Téléphone</label>
                                            <select class="form-select form-select-sm" id="filterPhone">
                                                <option value="">Tous les téléphones</option>
                                                @foreach($filters['phones'] as $phone)
                                                    <option value="{{ $phone }}">{{ $phone }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Filtre Pays -->
                                        <div class="form-group">
                                            <label class="form-label">Pays</label>
                                            <select class="form-select form-select-sm" id="filterCountry">
                                                <option value="">Tous les pays</option>
                                                @foreach($filters['countries'] as $country)
                                                    <option value="{{ $country }}">{{ $country }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Filtre Entreprise -->
                                        <div class="form-group">
                                            <label class="form-label">Entreprise</label>
                                            <select class="form-select form-select-sm" id="filterCompany">
                                                <option value="">Toutes les entreprises</option>
                                                @foreach($filters['companies'] as $company)
                                                    <option value="{{ $company }}">{{ $company }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Filtre Formation -->
                                        <div class="form-group">
                                            <label class="form-label">Formation</label>
                                            <select class="form-select form-select-sm" id="filterFormation">
                                                <option value="">Toutes les formations</option>
                                                @foreach($filters['formations'] as $formation)
                                                    <option value="{{ $formation }}">{{ $formation }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Filtre Session -->
                                        <div class="form-group">
                                            <label class="form-label">Session</label>
                                            <select class="form-select form-select-sm" id="filterSession">
                                                <option value="">Toutes les sessions</option>
                                                @foreach($filters['sessions'] as $sessionName)
                                                    <option value="{{ $sessionName }}">{{ $sessionName }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Bouton Effacer -->
                                        <div class="d-grid">
                                            <button type="button" class="btn btn-outline-secondary btn-sm" id="clearFilters">
                                                <i class="bi-x-circle me-1"></i> Effacer tous les filtres
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Filtres par colonne -->
                </div>
            </div>
            <!-- End Header -->

            <!-- Table -->
            <div class="table-responsive datatable-custom">
                <table id="datatable" class="table table-lg table-borderless table-thead-bordered table-nowrap table-align-middle card-table" data-hs-datatables-options='{
                    "order": [],
                    "info": {
                        "totalQty": "#datatableWithPaginationInfoTotalQty"
                    },
                    "search": "#datatableSearch",
                    "entries": "#datatableEntries",
                    "pageLength": 15,
                    "isResponsive": true,
                    "isShowPaging": true,
                    "pagination": "datatablePagination"
                }'>
                    <thead class="thead-light">
                        <tr>
                            <th class="ps-3">Prénom</th>
                            <th>Nom</th>
                            <th>E-mail</th>
                            <th>Téléphone</th>
                            <th>Pays</th>
                            <th>Entreprise</th>
                            <th>Formation</th>
                            <th>Prix total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($attendees as $attendee)
                            <tr>
                                <td class="ps-3">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <div class="avatar avatar-soft-primary avatar-circle">
                                                <span class="avatar-initials">{{ strtoupper(substr($attendee['first_name'], 0, 1)) }}</span>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <span class="h5 text-inherit">{{ $attendee['first_name'] }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $attendee['last_name'] }}</td>
                                <td>{{ $attendee['email'] }}</td>
                                <td>{{ $attendee['phone'] }}</td>
                                <td>{{ $attendee['country'] }}</td>
                                <td>{{ $attendee['company'] }}</td>
                                <td>{{ $attendee['formation'] }}</td>
                                <td>{{ $attendee['total_price'] }}</td>
                            </tr>
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
                            <span class="me-2">Afficher :</span>
                            <div class="tom-select-custom">
                                <select id="datatableEntries" class="js-select form-select form-select-borderless w-auto" autocomplete="off" data-hs-tom-select-options='{
                                    "searchInDropdown": false,
                                    "hideSearch": true
                                }'>
                                    <option value="10">10</option>
                                    <option value="15" selected>15</option>
                                    <option value="20">20</option>
                                </select>
                            </div>
                            <span class="text-secondary me-2">de</span>
                            <span id="datatableWithPaginationInfoTotalQty">{{ $attendees->count() }}</span>
                        </div>
                    </div>
                    <div class="col-sm-auto">
                        <div class="d-flex justify-content-center justify-content-sm-end">
                            <nav id="datatablePagination" aria-label="Pagination"></nav>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Footer -->
        </div>
        <!-- End Card -->
    </div>
    <!-- End Content -->

    <!-- Modal: Export Attendees -->
    <div class="modal fade" id="exportAttendeesModal" tabindex="-1" aria-labelledby="exportAttendeesModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exportAttendeesModalLabel">Exporter les participants

                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body">
                    <p>Sélectionnez le format d'exportation :</p>
                    <div class="d-grid gap-2">

                        <a href="{{ route('admin.sessions.attendees.export', ['session' => $session->id]) }}?format=xlsx" class="btn btn-outline-success">
                            <img class="avatar avatar-xss avatar-4x3 me-2" src="assets/svg/components/placeholder-csv-format.svg" alt="Image Description">
                            Exporter en Excel
                        </a>
                        <a href="{{ route('admin.sessions.attendees.export', ['session' => $session->id]) }}?format=pdf" class="btn btn-outline-danger">
                            <img class="avatar avatar-xss avatar-4x3 me-2" src="assets/svg/brands/pdf-icon.svg" alt="Image Description">
                            Exporter en PDF
                        </a>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-bs-dismiss="modal">Annuler</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal -->

    <!-- JS Implementing Plugins -->
    <script src="{{ asset('assets/js/vendor.min.js') }}"></script>
    <script src="{{ asset('assets/js/theme.min.js') }}"></script>

    <!-- JS Plugins Init. -->
    <script>
        $(document).on('ready', function () {
            // INITIALIZATION OF DATATABLES
            HSCore.components.HSDatatables.init($('#datatable'), {
                language: {
                    zeroRecords: `<div class="text-center p-4">
                        <img class="mb-3" src="{{ asset('assets/svg/illustrations/oc-error.svg') }}" alt="Image Description" style="width: 10rem;" data-hs-theme-appearance="default">
                        <img class="mb-3" src="{{ asset('assets/svg/illustrations-light/oc-error.svg') }}" alt="Image Description" style="width: 10rem;" data-hs-theme-appearance="dark">
                        <p class="mb-0">Aucun participant à afficher</p>
                    </div>`
                }
            });

            const datatable = HSCore.components.HSDatatables.getItem('datatable');

            $('#datatableSearch').on('input', function () {
                datatable.search(this.value).draw();
            });

            $('#filterFirstName').on('change', function () {
                datatable.column(0).search(this.value).draw();
            });

            $('#filterLastName').on('change', function () {
                datatable.column(1).search(this.value).draw();
            });

            $('#filterEmail').on('change', function () {
                datatable.column(2).search(this.value).draw();
            });

            $('#filterPhone').on('change', function () {
                datatable.column(3).search(this.value).draw();
            });

            $('#filterCountry').on('change', function () {
                datatable.column(4).search(this.value).draw();
            });

            $('#filterCompany').on('change', function () {
                datatable.column(5).search(this.value).draw();
            });

            $('#filterFormation').on('change', function () {
                datatable.column(6).search(this.value).draw();
            });

            $('#filterSession').on('change', function () {
                datatable.column(7).search(this.value).draw();
            });

            $('#clearFilters').on('click', function () {
                $('#filterFirstName, #filterLastName, #filterEmail, #filterPhone, #filterCountry, #filterCompany, #filterFormation, #filterSession').val('');
                datatable.search('').columns().search('').draw();
            });
        });
    </script>

    <!-- JS Plugins Init. -->
    <script>
        (function () {
            window.onload = function () {
                new HSSideNav('.js-navbar-vertical-aside').init();
                new HSFormSearch('.js-form-search');
                HSBsDropdown.init();
                HSCore.components.HSTomSelect.init('.js-select');
                new HsNavScroller('.js-nav-scroller');
            }
        })();
    </script>
</x-layouts>
