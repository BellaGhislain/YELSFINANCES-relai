<base href="/">
<x-layouts>
    <!-- Content -->
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center mb-3">
                <div class="col-sm">
                    <h1 class="page-header-title">État des paiements <span class="badge bg-soft-dark text-dark ms-2">{{ $payments->count() }}</span></h1>
                    <div class="d-flex mt-2 align-items-center">
                        <a class="d-inline-block text-body mb-2 mb-sm-0 me-3" href="javascript:;" data-bs-toggle="modal" data-bs-target="#exportPaymentsModal">
                            <i class="bi-download me-1"></i> Exporter
                        </a>
                    </div>
                </div>
                <!-- End Col -->
            </div>

            <!-- Modal: Export Payments -->
            <div class="modal fade" id="exportPaymentsModal" tabindex="-1" aria-labelledby="exportPaymentsModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exportPaymentsModalLabel">Exporter les paiements</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                        </div>
                        <div class="modal-body">
                            <p>Sélectionnez le format d'exportation :</p>
                            <div class="d-grid gap-2">
                                <a href="{{ route('admin.payments.export') }}?format=xlsx" class="btn btn-outline-success d-flex align-items-center justify-content-center">
                                    <img class="avatar avatar-xss avatar-4x3 me-2" src="{{ asset('assets/svg/brands/excel-icon.svg') }}" alt="Image Description">
                                    Exporter en Excel
                                </a>
                                <a href="{{ route('admin.payments.export') }}?format=pdf" class="btn btn-outline-danger d-flex align-items-center justify-content-center">
                                    <img class="avatar avatar-xss avatar-4x3 me-2" src="{{ asset('assets/svg/brands/pdf-icon.svg') }}" alt="Image Description">
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
        </div>
        <!-- End Page Header -->

        <!-- Nav Scroller -->
        <div class="js-nav-scroller hs-nav-scroller-horizontal">
            <span class="hs-nav-scroller-arrow-prev" style="display: none;">
                <a class="hs-nav-scroller-arrow-link" href="javascript:;">
                    <i class="bi-chevron-left"></i>
                </a>
            </span>
            <span class="hs-nav-scroller-arrow-next" style="display: none;">
                <a class="hs-nav-scroller-arrow-link" href="javascript:;">
                    <i class="bi-chevron-right"></i>
                </a>
            </span>
        </div>
        <!-- End Nav Scroller -->

        <div class="row justify-content-end mb-3">
            <div class="col-lg">
                <!-- Datatable Info -->
                <div id="datatableCounterInfo" style="display: none;">
                    <div class="d-sm-flex justify-content-lg-end align-items-sm-center">
                        <span class="d-block d-sm-inline-block fs-5 me-3 mb-2 mb-sm-0">
                            <span id="datatableCounter">0</span> Selected
                        </span>
                        <a class="btn btn-outline-danger btn-sm mb-2 mb-sm-0 me-2" href="javascript:;">
                            <i class="bi-trash"></i> Supprimer
                        </a>
                        <a class="btn btn-white btn-sm mb-2 mb-sm-0 me-2" href="javascript:;">
                            <i class="bi-archive"></i> Archive
                        </a>
                        <a class="btn btn-white btn-sm mb-2 mb-sm-0 me-2" href="javascript:;">
                            <i class="bi-upload"></i> Publish
                        </a>
                        <a class="btn btn-white btn-sm mb-2 mb-sm-0" href="javascript:;">
                            <i class="bi-x-lg"></i> Unpublish
                        </a>
                    </div>
                </div>
                <!-- End Datatable Info -->
            </div>
            <!-- End Col -->
        </div>
        <!-- End Row -->

        <!-- Card -->
        <div class="card">
            <!-- Header -->
            <div class="card-header card-header-content-md-between">
                <div class="mb-2 mb-md-0">
                    <form>
                        <!-- Search -->
                         <div class="col-md-12 d-flex align-items-center gap-2">
                    <!-- Filtre par formation (dropdown) -->
                    <div class="dropdown me-2">
                        <button class="btn btn-white dropdown-toggle" type="button" id="formationFilterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi-funnel me-2"></i> Toutes les formations
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="formationFilterDropdown">
                            <li><a class="dropdown-item" href="#" data-formation="all"><i class="bi-check-circle me-2"></i> Toutes les formations</a></li>
                            @foreach($formations as $formation)
                                <li><a class="dropdown-item" href="#" data-formation="{{ $formation->name }}"><i class="bi-circle me-2"></i> {{ $formation->name }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                    <!-- Filtre par session (dropdown) -->
                    <div class="dropdown me-2">
                        <button class="btn btn-white dropdown-toggle" type="button" id="sessionFilterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi-funnel me-2"></i> Toutes les sessions
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="sessionFilterDropdown">
                            <li><a class="dropdown-item" href="#" data-session="all"><i class="bi-check-circle me-2"></i> Toutes les sessions</a></li>
                            @foreach($sessions as $session)
                                <li><a class="dropdown-item" href="#" data-session="{{ \Carbon\Carbon::parse($session->start_date)->locale('fr')->translatedFormat('j F Y') }} - {{ \Carbon\Carbon::parse($session->end_date)->locale('fr')->translatedFormat('j F Y') }}"><i class="bi-circle me-2"></i> {{ \Carbon\Carbon::parse($session->start_date)->locale('fr')->translatedFormat('j F Y') }} - {{ \Carbon\Carbon::parse($session->end_date)->locale('fr')->translatedFormat('j F Y') }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                    <!-- Filtre par statut de paiement -->
                    <div class="dropdown">
                        <button class="btn btn-white dropdown-toggle" type="button" id="statusFilterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi-funnel me-2"></i> Tous les statuts
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="statusFilterDropdown">
                            <li><a class="dropdown-item" href="#" data-status="all"><i class="bi-check-circle me-2"></i> Tous les statuts</a></li>
                            <li><a class="dropdown-item" href="#" data-status="completed"><i class="bi-circle me-2"></i> Payé</a></li>
                            <li><a class="dropdown-item" href="#" data-status="pending"><i class="bi-circle me-2"></i> En attente</a></li>
                            <li><a class="dropdown-item" href="#" data-status="failed"><i class="bi-circle me-2"></i> Échoué</a></li>
                        </ul>
                    </div>
                </div>
                        <!-- End Search -->
                    </form>
                </div>
            </div>
            <!-- End Header -->

            <!-- Table -->
            <div class="table-responsive datatable-custom">
                <table id="datatable" class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table" style="width: 100%" data-hs-datatables-options='{
                    "columnDefs": [{
                        "targets": [0],
                        "orderable": false
                    }],
                    "order": [],
                    "info": {
                        "totalQty": "#datatableWithPaginationInfoTotalQty"
                    },
                    "search": "#datatableSearch",
                    "entries": "#datatableEntries",
                    "pageLength": 12,
                    "isResponsive": false,
                    "isShowPaging": false,
                    "pagination": "datatablePagination"
                }'>
                    <thead class="thead-light">
                        <tr>
                            <th>Participant</th>
                            <th>Date</th>
                            <th>Formation</th>
                            <th>Session</th>
                            <th>Statut de paiement</th>
                            <th>Méthode de paiement</th>
                            <th>Montant</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($payments as $payment)
                            <tr>
                                <td>
                                    <a class="text-body" href="{{ route('admin.orders.show', $payment->order_id) }}">{{ $payment->order->first_name }} {{ $payment->order->last_name }}</a>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($payment->created_at)->locale('fr')->translatedFormat('d F Y H:i') }}</td>
                                <td>{{ $payment->order->orderDetails->first()->formation->name }}</td>
                                <td>{{ \Carbon\Carbon::parse($payment->order->orderDetails->first()->session->start_date)->locale('fr')->translatedFormat('j F Y') }} - {{ \Carbon\Carbon::parse($payment->order->orderDetails->first()->session->end_date)->locale('fr')->translatedFormat('j F Y') }}</td>
                                <td>
                                    <span class="badge {{ $payment->status === 'completed' ? 'bg-soft-success text-success' : ($payment->status === 'pending' ? 'bg-soft-warning text-warning' : 'bg-soft-danger text-danger') }}">
                                        <span class="legend-indicator {{ $payment->status === 'completed' ? 'bg-success' : ($payment->status === 'pending' ? 'bg-warning' : 'bg-danger') }}"></span>
                                        {{ $payment->status === 'completed' ? 'Payé' : ($payment->status === 'pending' ? 'En attente' : 'Échoué') }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($payment->payment_method)
                                            <img class="avatar avatar-xss avatar-4x3 me-2" src="{{ asset('assets/svg/brands/' . ($payment->payment_method === 'mastercard' ? 'mastercard.svg' : ($payment->payment_method === 'visa' ? 'visa.svg' : 'generic-payment.svg'))) }}" alt="Image Description">
                                            <span class="text-dark">{{ $payment->payment_method }}</span>
                                        @else
                                            <span class="text-dark">N/A</span>
                                        @endif
                                    </div>
                                </td>
                                <td>{{ number_format($payment->amount, 0, ',', ' ') }} €</td>
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
                                    <option value="12" selected>12</option>
                                    <option value="14">14</option>
                                    <option value="16">16</option>
                                    <option value="18">18</option>
                                </select>
                            </div>
                            <span class="text-secondary me-2">de</span>
                            <span id="datatableWithPaginationInfoTotalQty">{{ $payments->count() }}</span>
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

    <!-- JS Implementing Plugins -->
    <script src="{{ asset('assets/js/vendor.min.js') }}"></script>
    <script src="{{ asset('assets/js/theme.min.js') }}"></script>

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
                        <img class="mb-3" src="{{ asset('assets/svg/illustrations/oc-error.svg') }}" alt="Image Description" style="width: 10rem;" data-hs-theme-appearance="default">
                        <img class="mb-3" src="{{ asset('assets/svg/illustrations-light/oc-error.svg') }}" alt="Image Description" style="width: 10rem;" data-hs-theme-appearance="dark">
                        <p class="mb-0">Aucun paiement à afficher</p>
                    </div>`
                }
            });

            const datatable = HSCore.components.HSDatatables.getItem('datatable');

            // Recherche globale
            $('#datatableSearch').on('input', function () {
                datatable.search(this.value).draw();
            });


            // Filtre par formation (dropdown)
            $('[data-formation]').on('click', function(e) {
                e.preventDefault();
                const selectedFormation = $(this).data('formation');
                // Update dropdown icon and label
                $('[data-formation] i').removeClass('bi-check-circle').addClass('bi-circle');
                $(this).find('i').removeClass('bi-circle').addClass('bi-check-circle');
                const formationText = $(this).text().trim();
                $('#formationFilterDropdown').html(`<i class="bi-funnel me-2"></i> ${formationText}`);
                // Filter datatable
                if (selectedFormation === 'all') {
                    datatable.column(2).search('').draw();
                } else {
                    datatable.column(2).search(selectedFormation).draw();
                }
            });

            // Filtre par session (dropdown)
            $('[data-session]').on('click', function(e) {
                e.preventDefault();
                const selectedSession = $(this).data('session');
                // Update dropdown icon and label
                $('[data-session] i').removeClass('bi-check-circle').addClass('bi-circle');
                $(this).find('i').removeClass('bi-circle').addClass('bi-check-circle');
                const sessionText = $(this).text().trim();
                $('#sessionFilterDropdown').html(`<i class="bi-funnel me-2"></i> ${sessionText}`);
                // Filter datatable
                if (selectedSession === 'all') {
                    datatable.column(3).search('').draw();
                } else {
                    datatable.column(3).search(selectedSession).draw();
                }
            });

            // Filtre par statut
            $('[data-status]').on('click', function(e) {
                e.preventDefault();
                const selectedStatus = $(this).data('status');
                $('[data-status] i').removeClass('bi-check-circle').addClass('bi-circle');
                $(this).find('i').removeClass('bi-circle').addClass('bi-check-circle');
                const statusText = $(this).text().trim();
                $('#statusFilterDropdown').html(`<i class="bi-funnel me-2"></i> ${statusText}`);

                if (selectedStatus === 'all') {
                    datatable.column(4).search('').draw();
                } else {
                    const statusMap = {
                        'completed': 'Payé',
                        'pending': 'En attente',
                        'failed': 'Échoué'
                    };
                    datatable.column(4).search(statusMap[selectedStatus]).draw();
                }
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
            }
        })();
    </script>
</x-layouts>
