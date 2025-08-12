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
                <div class="col-sm mb-2 mb-sm-0">
                    <h1 class="page-header-title">Ajouter une session</h1>
                </div>
                <div class="col-auto">
                    <a class="btn btn-outline-primary" href="{{ route('admin.sessions.index') }}">
                        <i class="bi-arrow-left me-1"></i> Retour
                    </a>
                </div>
            </div>
        </div>
        <!-- End Page Header -->

        <div class="row justify-content-center">
            <div class="col-lg-10 mb-3 mb-lg-0">
                <!-- Card -->
                <div class="card mb-3 mb-lg-5">
                    <!-- Header -->
                    <div class="card-header">
                        <h4 class="card-header-title">Informations de la session</h4>
                    </div>
                    <!-- End Header -->

                    <!-- Body -->
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.sessions.store') }}" id="sessionAddForm">
                            @csrf

                            <!-- Form: Formation -->
                            <div class="mb-4">
                                <label for="formationSelectLabel" class="form-label">Sélectionner la formation <i class="bi-question-circle text-body ms-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Choisissez la formation pour laquelle vous créez une session."></i></label>
                                <select class="form-select @error('formation_id') is-invalid @enderror" name="formation_id" id="formationSelectLabel" required>
                                    <option value="">Sélectionner une formation</option>
                                    @foreach($formations as $formation)
                                        @if($formation->is_active)
                                            <option value="{{ $formation->id }}" {{ old('formation_id') == $formation->id ? 'selected' : '' }}>{{ Str::limit($formation->name, 40) }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                @error('formation_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Form: Formateurs -->
                            <div class="mb-4">
                                <label class="form-label">Formateurs</label>
                                <div id="trainersContainer">
                                    <div class="mb-3 trainer-item">
                                        <div class="input-group">
                                            <select class="form-select @error('trainers.*') is-invalid @enderror" name="trainers[]" required>
                                                <option value="">Sélectionner un formateur</option>
                                                @foreach($trainers as $trainer)
                                                    <option value="{{ $trainer->id }}" {{ in_array($trainer->id, old('trainers', [])) ? 'selected' : '' }}>{{ $trainer->first_name . ' ' . $trainer->last_name }}</option>
                                                @endforeach
                                            </select>
                                            <button type="button" class="btn btn-outline-danger remove-trainer-item" style="display: none;">
                                                <i class="bi-trash"></i>
                                            </button>
                                        </div>
                                        @error('trainers.*')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <button type="button" class="btn btn-outline-primary btn-sm" id="addTrainerItem">
                                    <i class="bi-plus-circle me-1"></i> Ajouter un formateur
                                </button>
                            </div>

                            <!-- Form: Dates -->
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="mb-4">
                                        <label for="startDateLabel" class="form-label">Date de début</label>
                                        <input type="date" class="form-control @error('start_date') is-invalid @enderror" name="start_date" id="startDateLabel" value="{{ old('start_date') }}" min="2025-08-09" required>
                                        @error('start_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="mb-4">
                                        <label for="endDateLabel" class="form-label">Date de fin</label>
                                        <input type="date" class="form-control @error('end_date') is-invalid @enderror" name="end_date" id="endDateLabel" value="{{ old('end_date') }}" min="2025-08-09" required>
                                        @error('end_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Form: Localisation -->
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="mb-4">
                                        <label for="countryLabel" class="form-label">Pays</label>
                                        <input type="text" class="form-control @error('country') is-invalid @enderror" name="country" id="countryLabel" placeholder="Ex: Cameroun" value="{{ old('country') }}" required>
                                        @error('country')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="mb-4">
                                        <label for="cityLabel" class="form-label">Ville</label>
                                        <input type="text" class="form-control @error('city') is-invalid @enderror" name="city" id="cityLabel" placeholder="Ex: Yaoundé" value="{{ old('city') }}" required>
                                        @error('city')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Form: Type -->
                            <div class="mb-4">
                                <label for="trainingTypeLabel" class="form-label">Type de formation</label>
                                <select class="form-select @error('type') is-invalid @enderror" name="type" id="trainingTypeLabel" required>
                                    <option value="">Sélectionner le type</option>
                                     <option value="Distance" {{ old('type') == 'Distance' ? 'selected' : '' }}>Distance</option>
                                    <option value="Hybride" {{ old('type') == 'Hybride' ? 'selected' : '' }}>Hybride</option>
                                    <option value="Présentiel" {{ old('type') == 'Présentiel' ? 'selected' : '' }}>Présentiel</option>
                                </select>
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Form: Prix -->
                            <div class="mb-4">
                                <label for="priceLabel" class="form-label">Prix (€)</label>
                                <div class="input-group">
                                    <input type="number" 
                                           class="form-control @error('price') is-invalid @enderror" 
                                           name="price" 
                                           id="priceLabel" 
                                           placeholder="Ex: 899" 
                                           min="0" 
                                           step="0.01" 
                                           value="{{ old('price') }}" 
                                           required>
                                    <span class="input-group-text">€</span>
                                </div>
                                <small class="form-text text-muted">
                                    Le prix sera automatiquement formaté avec des séparateurs de milliers
                                </small>
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Boutons -->
                            <div class="d-flex justify-content-end gap-3">
                                <a href="{{ route('admin.sessions.index') }}" class="btn btn-white">Annuler</a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi-check-circle me-1"></i> Créer la session
                                </button>
                            </div>
                        </form>
                    </div>
                    <!-- End Body -->
                </div>
                <!-- End Card -->
            </div>
        </div>

        <!-- JavaScript -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Afficher la notification de succès si présente
                @if(session('success'))
                    showSuccessNotification('{{ session('success') }}');
                @endif

                // Fonction pour afficher la notification de succès
                function showSuccessNotification(message) {
                    const notification = document.createElement('div');
                    notification.className = 'alert alert-success alert-dismissible fade show position-fixed';
                    notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
                    notification.innerHTML = `
                        <i class="bi-check-circle me-2"></i>${message}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    `;
                    document.body.appendChild(notification);
                    setTimeout(() => {
                        if (notification.parentNode) {
                            notification.remove();
                        }
                    }, 3000);
                }

                // Liste complète des formateurs
                const allTrainers = [
                    @foreach($trainers as $trainer)
                        { id: '{{ $trainer->id }}', text: `{!! addslashes($trainer->first_name . ' ' . $trainer->last_name) !!}` },
                    @endforeach
                ];

                // Gestion des formateurs
                const trainersContainer = document.getElementById('trainersContainer');
                const addTrainerButton = document.getElementById('addTrainerItem');

                function updateTrainerOptions() {
                    const selects = trainersContainer.querySelectorAll('select[name="trainers[]"]');
                    const selectedValues = Array.from(selects)
                        .map(select => select.value)
                        .filter(value => value !== '');

                    selects.forEach((select, index) => {
                        const currentValue = select.value;
                        select.innerHTML = '<option value="">Sélectionner un formateur</option>';
                        allTrainers.forEach(trainer => {
                            if (!selectedValues.includes(trainer.id) || trainer.id === currentValue) {
                                const option = document.createElement('option');
                                option.value = trainer.id;
                                option.text = htmlspecialchars_decode(trainer.text);
                                if (trainer.id === currentValue) {
                                    option.selected = true;
                                }
                                select.appendChild(option);
                            }
                        });
                    });
                }

                function htmlspecialchars_decode(str) {
                    if (!str) return '';
                    return str.replace(/&amp;/g, '&')
                              .replace(/&lt;/g, '<')
                              .replace(/&gt;/g, '>')
                              .replace(/&quot;/g, '"')
                              .replace(/&#039;/g, "'");
                }

                addTrainerButton.addEventListener('click', function() {
                    const newItem = document.createElement('div');
                    newItem.className = 'mb-3 trainer-item';
                    newItem.innerHTML = `
                        <div class="input-group">
                            <select class="form-select" name="trainers[]" required>
                                <option value="">Sélectionner un formateur</option>
                            </select>
                            <button type="button" class="btn btn-outline-danger remove-trainer-item">
                                <i class="bi-trash"></i>
                            </button>
                        </div>
                    `;
                    trainersContainer.appendChild(newItem);
                    updateTrainerOptions();
                    updateTrainerRemoveButtons();
                });

                trainersContainer.addEventListener('click', function(e) {
                    if (e.target.closest('.remove-trainer-item')) {
                        e.target.closest('.trainer-item').remove();
                        updateTrainerRemoveButtons();
                        updateTrainerOptions();
                    }
                });

                trainersContainer.addEventListener('change', function(e) {
                    if (e.target.closest('select[name="trainers[]"]')) {
                        updateTrainerOptions();
                    }
                });

                function updateTrainerRemoveButtons() {
                    const items = trainersContainer.querySelectorAll('.trainer-item');
                    const removeButtons = trainersContainer.querySelectorAll('.remove-trainer-item');
                    if (items.length === 1) {
                        removeButtons[0].style.display = 'none';
                    } else {
                        removeButtons.forEach(btn => btn.style.display = 'block');
                    }
                }

                updateTrainerRemoveButtons();
                updateTrainerOptions();

                // Validation des dates avant soumission
                const form = document.getElementById('sessionAddForm');
                form.addEventListener('submit', function(e) {
                    const today = new Date('2025-08-09');
                    const startDate = new Date(document.getElementById('startDateLabel').value);
                    const endDate = new Date(document.getElementById('endDateLabel').value);

                    if (startDate < today) {
                        e.preventDefault();
                        alert('La date de début ne peut pas être antérieure à aujourd\'hui.');
                        return;
                    }

                    if (endDate < today) {
                        e.preventDefault();
                        alert('La date de fin ne peut pas être antérieure à aujourd\'hui.');
                        return;
                    }

                    if (startDate > endDate) {
                        e.preventDefault();
                        alert('La date de début ne peut pas être postérieure à la date de fin.');
                        return;
                    }
                });
            });
        </script>
</x-layouts>
