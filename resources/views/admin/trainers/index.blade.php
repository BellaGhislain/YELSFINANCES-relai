<base href="/">
<x-layouts>
    <!-- Content -->
    <div class="content container-fluid">
        <!-- Messages d'erreur ou de succès -->
        @if (session('error'))
            <div class="alert alert-danger" role="alert">
                {{ session('error') }}
            </div>
        @endif
        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center mb-3">
                <div class="col-md mb-2 mb-md-0">
                    <h1 class="page-header-title">Formateurs <span class="badge bg-soft-dark text-dark ms-2">{{ $trainers->count() }}</span></h1>
                    <div class="d-sm-flex mt-2">
                        <a class="d-inline-block text-body mb-2 mb-sm-0 me-3" href="javascript:;" data-bs-toggle="modal" data-bs-target="#exportCustomersModal">
                            <i class="bi-download me-1"></i> Export
                        </a>
                    </div>
                </div>
                <div class="col-md-auto">
                    <a class="btn btn-primary" href="{{ route('admin.trainers.create') }}">Ajouter un formateur</a>
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
                        <div class="input-group input-group-merge input-group-flush">
                            <div class="input-group-prepend input-group-text">
                                <i class="bi-search"></i>
                            </div>
                            <input id="datatableSearch" type="search" class="form-control" placeholder="Rechercher..." aria-label="Rechercher...">
                        </div>
                    </form>
                </div>

                <div class="d-grid d-sm-flex justify-content-sm-end align-items-sm-center gap-2">
                    <div id="datatableCounterInfo" style="display: none;">
                        <div class="d-flex align-items-center">
                            <span class="fs-5 me-3">
                                <span id="datatableCounter">0</span>
                                Selected
                            </span>
                            <a class="btn btn-outline-danger btn-sm" href="javascript:;">
                                <i class="bi-trash"></i> Delete
                            </a>
                        </div>
                    </div>

                    <div class="dropdown">
                        <button type="button" class="btn btn-white w-100" id="filterDropdown" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                            <i class="bi-funnel me-1"></i> Filtres <span class="badge bg-soft-primary text-primary rounded-circle ms-1">3</span>
                        </button>

                        <div class="dropdown-menu dropdown-menu-end dropdown-card" aria-labelledby="filterDropdown" style="width: 20rem;">
                            <div class="card card-sm">
                                <div class="card-body">
                                    <div class="d-grid gap-3">
                                        <div class="form-group">
                                            <label class="form-label">Nom complet</label>
                                            <select class="form-select form-select-sm" id="filterNomComplet">
                                                <option value="">Tous les noms</option>
                                                @foreach($trainers->unique(function($t) { return $t->first_name.' '.$t->last_name; }) as $trainer)
                                                    <option value="{{ $trainer->first_name }} {{ $trainer->last_name }}">{{ $trainer->first_name }} {{ $trainer->last_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label">Email</label>
                                            <select class="form-select form-select-sm" id="filterEmail">
                                                <option value="">Tous les emails</option>
                                                @foreach($trainers->unique('email') as $trainer)
                                                    <option value="{{ $trainer->email }}">{{ $trainer->email }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label">Téléphone</label>
                                            <select class="form-select form-select-sm" id="filterTelephone">
                                                <option value="">Tous les téléphones</option>
                                                @foreach($trainers->unique('phone') as $trainer)
                                                    <option value="{{ $trainer->phone }}">{{ $trainer->phone }}</option>
                                                @endforeach
                                            </select>
                                        </div>

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
                </div>
            </div>
            <!-- End Header -->

            <!-- Table -->
            <div class="table-responsive datatable-custom">
                <table id="datatable" class="table table-lg table-borderless table-thead-bordered table-nowrap table-align-middle card-table" data-hs-datatables-options='{
                    "columnDefs": [{
                        "targets": [0, 4],
                        "orderable": false
                    }],
                    "order": [],
                    "info": {
                        "totalQty": "#datatableWithPaginationInfoTotalQty"
                    },
                    "search": "#datatableSearch",
                    "entries": "#datatableEntries",
                    "pageLength": 15,
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
                            <th class="table-column-ps-0">Nom complet</th>
                            <th>Email</th>
                            <th>Téléphone</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($trainers as $trainer)
                        <tr>
                            <td class="table-column-pe-0">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="trainerCheck{{ $trainer->id }}">
                                    <label class="form-check-label" for="trainerCheck{{ $trainer->id }}"></label>
                                </div>
                            </td>
                            <td class="table-column-ps-0">
                                <a class="d-flex align-items-center" href="{{ route('admin.trainers.show', $trainer) }}">
                                    <div class="flex-shrink-0">
                                        @if(isset($trainer->avatar) && $trainer->avatar)
                                            <div class="avatar avatar-circle">
                                                <img class="avatar-img" src="{{ asset($trainer->avatar) }}" alt="Image Description">
                                            </div>
                                        @else
                                            <div class="avatar avatar-soft-primary avatar-circle">
                                                <span class="avatar-initials">{{ strtoupper(substr($trainer->first_name, 0, 1)) }}{{ strtoupper(substr($trainer->last_name, 0, 1)) }}</span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <span class="h5 text-inherit">{{ $trainer->first_name }} {{ $trainer->last_name }}</span>
                                    </div>
                                </a>
                            </td>
                            <td>{{ $trainer->email }}</td>
                            <td>{{ $trainer->phone }}</td>
                            <td>
                                <!-- Unfold -->
                                <div class="hs-unfold">
                                    <button type="button" class="btn btn-ghost-secondary btn-icon btn-sm rounded-circle" id="settingsDropdown{{ $trainer->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi-three-dots-vertical"></i>
                                    </button>

                                    <div class="dropdown-menu dropdown-menu-end mt-1" aria-labelledby="settingsDropdown{{ $trainer->id }}">
                                        <span class="dropdown-header">Actions</span>
                                        <a class="dropdown-item" href="{{ route('admin.trainers.edit', $trainer) }}">
                                            <i class="bi-pencil-fill dropdown-item-icon"></i> Modifier
                                        </a>
                                        {{-- <a class="dropdown-item" href="{{ route('admin.trainers.show', $trainer) }}">
                                            <i class="bi-eye dropdown-item-icon"></i> Voir
                                        </a> --}}
                                        {{-- <a class="dropdown-item" href="javascript:;" data-bs-toggle="modal" data-bs-target="#deactivateTrainerModal{{ $trainer->id }}">
                                            <i class="bi-trash dropdown-item-icon"></i> Désactiver
                                        </a> --}}
                                    </div>
                                </div>
                                <!-- End Unfold -->
                            </td>
                        </tr>

                        <!-- Modal de confirmation pour désactiver -->
                        <div class="modal fade" id="deactivateTrainerModal{{ $trainer->id }}" tabindex="-1" aria-labelledby="deactivateTrainerModalLabel{{ $trainer->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deactivateTrainerModalLabel{{ $trainer->id }}">Confirmer la désactivation</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Voulez-vous vraiment désactiver le formateur <strong>{{ $trainer->first_name }} {{ $trainer->last_name }}</strong> ? Cette action peut être annulée ultérieurement.</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-white" data-bs-dismiss="modal">Annuler</button>
                                        <form action="{{ route('admin.trainers.deactivate', $trainer) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('POST')
                                            <button type="submit" class="btn btn-danger">Désactiver</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
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
                                    <option value="10">10</option>
                                    <option value="15" selected>15</option>
                                    <option value="20">20</option>
                                </select>
                            </div>
                            <span class="text-secondary me-2">of</span>
                            <span id="datatableWithPaginationInfoTotalQty">{{ $trainers->count() }}</span>
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
    <!-- End Content -->

    <!-- JS Implementing Plugins -->
    <script src="assets/js/vendor.min.js"></script>
    <script src="assets/js/theme.min.js"></script>

    <!-- JS Plugins Init. -->
    <script>
        $(document).on('ready', function () {
            // INITIALIZATION OF DATATABLES
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
                        <img class="mb-3" src="./assets/svg/illustrations/oc-error.svg" alt="Image Description" style="width: 10rem;" data-hs-theme-appearance="default">
                        <img class="mb-3" src="./assets/svg/illustrations-light/oc-error.svg" alt="Image Description" style="width: 10rem;" data-hs-theme-appearance="dark">
                        <p class="mb-0">No data to show</p>
                    </div>`
                }
            });

            const datatable = HSCore.components.HSDatatables.getItem('datatable');

            $('.js-datatable-filter').on('change', function() {
                var $this = $(this),
                    elVal = $this.val(),
                    targetColumnIndex = $this.data('target-column-index');
                datatable.column(targetColumnIndex).search(elVal).draw();
            });

            $('#datatableSearch').on('mouseup', function (e) {
                var $input = $(this),
                    oldValue = $input.val();
                if (oldValue == "") return;
                setTimeout(function(){
                    var newValue = $input.val();
                    if (newValue == "") {
                        datatable.search('').draw();
                    }
                }, 1);
            });

            $('#filterNomComplet').on('change', function() {
                datatable.column(1).search(this.value).draw();
            });

            $('#filterEmail').on('change', function() {
                datatable.column(2).search(this.value).draw();
            });

            $('#filterTelephone').on('change', function() {
                datatable.column(3).search(this.value).draw();
            });

            $('#clearFilters').on('click', function() {
                $('#filterNomComplet, #filterEmail, #filterTelephone').val('');
                datatable.search('').columns().search('').draw();
            });
        });
    </script>

    <!-- JS Plugins Init. -->
    <script>
        (function() {
            window.onload = function () {
                new HSSideNav('.js-navbar-vertical-aside').init();
                new HSFormSearch('.js-form-search');
                HSBsDropdown.init();
                HSCore.components.HSTomSelect.init('.js-select');
                new HsNavScroller('.js-nav-scroller');
                new bootstrap.Modal(document.getElementById('exportCustomersGuideModal')).show();
                HSCore.components.HSDropzone.init('.js-dropzone');
            }
        })();
    </script>

    <!-- Style Switcher JS -->
    <script>
        (function () {
            const $dropdownBtn = document.getElementById('selectThemeDropdown');
            const $variants = document.querySelectorAll(`[aria-labelledby="selectThemeDropdown"] [data-icon]`);
            const setActiveStyle = function () {
                $variants.forEach($item => {
                    if ($item.getAttribute('data-value') === HSThemeAppearance.getOriginalAppearance()) {
                        $dropdownBtn.innerHTML = `<i class="${$item.getAttribute('data-icon')}" />`;
                        return $item.classList.add('active');
                    }
                    $item.classList.remove('active');
                });
            };
            $variants.forEach(function ($item) {
                $item.addEventListener('click', function () {
                    HSThemeAppearance.setAppearance($item.getAttribute('data-value'));
                });
            });
            setActiveStyle();
            window.addEventListener('on-hs-appearance-change', function () {
                setActiveStyle();
            });
        })();
    </script>
</x-layouts>
