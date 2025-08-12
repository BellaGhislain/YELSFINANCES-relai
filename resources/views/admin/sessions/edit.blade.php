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
                    <h1 class="page-header-title">Modifier une session</h1>
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
            <div class="card-header">
                <h4 class="card-header-title">Formulaire de modification</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.sessions.update', $session) }}" method="POST" id="editSessionForm">
                    @csrf
                    @method('PUT')

                    <!-- Formation -->
                    <div class="mb-3">
                        <label for="formation_id" class="form-label">Formation</label>
                        <select class="form-select @error('formation_id') is-invalid @enderror" name="formation_id" id="formation_id" required>
                            <option value="" disabled>Choisir une formation</option>
                            @foreach ($formations as $formation)
                                <option value="{{ $formation->id }}" {{ $session->formation_id == $formation->id ? 'selected' : '' }}>
                                    {{ $formation->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('formation_id')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Formateurs -->
                    <div class="mb-3">
                        <label class="form-label">Formateurs</label>
                        <div id="trainersContainer">
                            @if ($session->trainers->isNotEmpty())
                                @foreach ($session->trainers as $index => $trainer)
                                    <div class="mb-3 trainer-item">
                                        <div class="input-group">
                                            <select class="form-select @error('trainers.' . $index) is-invalid @enderror" name="trainers[]" required>
                                                <option value="">Sélectionner un formateur</option>
                                                @foreach ($trainers as $t)
                                                    <option value="{{ $t->id }}" {{ $trainer->id == $t->id ? 'selected' : '' }}>
                                                        {{ $t->first_name . ' ' . $t->last_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <button type="button" class="btn btn-outline-danger remove-trainer-item" style="{{ $index == 0 ? 'display: none;' : 'display: block;' }}">
                                                <i class="bi-trash"></i>
                                            </button>
                                        </div>
                                        @error('trainers.' . $index)
                                            <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </div>
                                @endforeach
                            @else
                                <div class="mb-3 trainer-item">
                                    <div class="input-group">
                                        <select class="form-select @error('trainers.0') is-invalid @enderror" name="trainers[]" required>
                                            @foreach ($trainers as $trainer)
                                                <option value="{{ $trainer->id }}" {{ in_array($trainer->id, old('trainers', [])) ? 'selected' : '' }}>
                                                    {{ $trainer->first_name . ' ' . $trainer->last_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <button type="button" class="btn btn-outline-danger remove-trainer-item" style="display: none;">
                                            <i class="bi-trash"></i>
                                        </button>
                                    </div>
                                    @error('trainers.0')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                            @endif
                        </div>
                        <button type="button" class="btn btn-outline-primary btn-sm" id="addTrainerItem">
                            <i class="bi-plus-circle me-1"></i> Ajouter un formateur
                        </button>
                    </div>

                    <!-- Date de début (masquée si en cours) -->
                    @if ($session->status != 'en cours')
                        <div class="mb-3">
                            <label for="start_date" class="form-label">Date de début</label>
                            <input type="date" class="form-control @error('start_date') is-invalid @enderror" name="start_date" id="start_date" value="{{ $session->start_date ? $session->start_date->format('Y-m-d') : '' }}" min="{{ \Carbon\Carbon::today()->format('Y-m-d') }}" required>
                            @error('start_date')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                    @endif

                    <!-- Date de fin -->
                    <div class="mb-3">
                        <label for="end_date" class="form-label">Date de fin</label>
                        <input type="date" class="form-control @error('end_date') is-invalid @enderror" name="end_date" id="end_date" value="{{ $session->end_date ? $session->end_date->format('Y-m-d') : '' }}" min="{{ \Carbon\Carbon::today()->format('Y-m-d') }}" required>
                        @error('end_date')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Ville -->
                    <div class="mb-3">
                        <label for="city" class="form-label">Ville</label>
                        <input type="text" class="form-control @error('city') is-invalid @enderror" name="city" id="city" value="{{ old('city', $session->city) }}" required>
                        @error('city')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Pays -->
                    <div class="mb-3">
                        <label for="country" class="form-label">Pays</label>
                        <input type="text" class="form-control @error('country') is-invalid @enderror" name="country" id="country" value="{{ old('country', $session->country) }}" required>
                        @error('country')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Type -->
                    <div class="mb-3">
                        <label for="type" class="form-label">Type</label>
                        <select class="form-select @error('type') is-invalid @enderror" name="type" id="type" required>
                            <option value="" disabled>Choisir un type</option>
                            <option value="Distance" {{ $session->type == 'Distance' ? 'selected' : '' }}>Distance</option>
                            <option value="Hybride" {{ $session->type == 'Hybride' ? 'selected' : '' }}>Hybride</option>
                            <option value="Présentiel" {{ $session->type == 'Présentiel' ? 'selected' : '' }}>Présentiel</option>
                        </select>
                        @error('type')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Prix -->
                    <div class="mb-3">
                        <label for="price" class="form-label">Prix (€)</label>
                        <input type="number" 
                               class="form-control @error('price') is-invalid @enderror" 
                               name="price" 
                               id="price" 
                               value="{{ old('price', $session->price) }}" 
                               step="0.01" 
                               required>
                        <small class="form-text text-muted">
                            Le prix sera automatiquement formaté avec des séparateurs de milliers
                        </small>
                        @error('price')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Statut (lecture seule) -->
                    <div class="mb-3">
                        <label for="status_display" class="form-label">Statut</label>
                        <input type="text" class="form-control" id="status_display" value="{{ ucfirst($session->status) }}" readonly>
                    </div>

                    <!-- Boutons -->
                    <div class="d-flex gap-3 justify-content-start">
                        <button type="submit" class="btn btn-primary">Mettre à jour la session</button>
                        <a href="{{ route('admin.sessions.index') }}" class="btn btn-outline-secondary">Annuler</a>
                    </div>
                </form>
            </div>
        </div>
        <!-- End Card -->
    </div>
    <!-- End Content -->

    <!-- JS Implementing Plugins -->
    <script src="{{ asset('assets/js/vendor.min.js') }}"></script>
    <script src="{{ asset('assets/js/theme.min.js') }}"></script>

    <!-- JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
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
            const form = document.getElementById('editSessionForm');
            form.addEventListener('submit', function(e) {
                const today = new Date('2025-08-09');
                const startDateInput = document.getElementById('start_date');
                const endDate = new Date(document.getElementById('end_date').value);

                // Vérifier start_date si présent
                if (startDateInput) {
                    const startDate = new Date(startDateInput.value);
                    if (startDate < today) {
                        e.preventDefault();
                        alert('La date de début ne peut pas être antérieure à aujourd\'hui.');
                        return;
                    }
                    if (startDate > endDate) {
                        e.preventDefault();
                        alert('La date de début ne peut pas être postérieure à la date de fin.');
                        return;
                    }
                }

                // Vérifier end_date
                if (endDate < today) {
                    e.preventDefault();
                    alert('La date de fin ne peut pas être antérieure à aujourd\'hui.');
                    return;
                }
            });
        });
    </script>
</x-layouts>
