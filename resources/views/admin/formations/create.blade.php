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
                    <h1 class="page-header-title">Ajouter une formation</h1>
                </div>
                <div class="col-auto">
                    <a class="btn btn-outline-primary" href="{{ route('admin.formations') }}">
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
                        <h4 class="card-header-title">Informations de la formation</h4>
                    </div>
                    <!-- End Header -->

                    <!-- Body -->
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.formations.store') }}" enctype="multipart/form-data" id="formationForm">
                            @csrf

                            <!-- Form: Nom -->
                            <div class="mb-4">
                                <label for="formationNameLabel" class="form-label">Nom (titre) de la formation <i class="bi-question-circle text-body ms-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Le titre principal de votre formation."></i></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="formationNameLabel" placeholder="Ex: Formation en Développement Web" value="{{ old('name') }}">
                                @error('name')
                                    <div class="invalid-feedback">{{ "Le nom (titre) de la formation est requis" }}</div>
                                @enderror
                            </div>
                            <!-- End Form -->

                            <!-- Form: Niveau -->
                            <div class="mb-4">
                                <label for="levelsLabel" class="form-label">Niveaux</label>
                                <select class="form-select @error('level') is-invalid @enderror" name="level" id="levelsLabel">
                                    <option value="">Sélectionner le niveau</option>
                                    <option value="debutant" {{ old('level') == 'debutant' ? 'selected' : '' }}>Débutant</option>
                                    <option value="intermediaire" {{ old('level') == 'intermediaire' ? 'selected' : '' }}>Intermédiaire</option>
                                    <option value="avance" {{ old('level') == 'avance' ? 'selected' : '' }}>Avancé</option>
                                    <option value="expert" {{ old('level') == 'expert' ? 'selected' : '' }}>Expert</option>
                                </select>
                                @error('level')
                                    <div class="invalid-feedback">{{ "Le niveau est requis" }}</div>
                                @enderror
                            </div>
                            <!-- End Form -->

                            <!-- Form: Compétences -->
                            <div class="mb-4">
                                <label class="form-label">Compétences que les apprenants vont acquérir</label>
                                <div id="skillsItemsContainer">
                                    <div class="mb-3 skill-item">
                                        <div class="input-group">
                                            <input type="text" class="form-control @error('skillItem.*') is-invalid @enderror" name="skillItem[]" placeholder="Ex: Maîtriser les langages HTML, CSS et JavaScript" value="{{ old('skillItem.0') }}">
                                            <button type="button" class="btn btn-outline-danger remove-skill-item" style="display: none;">
                                                <i class="bi-trash"></i>
                                            </button>
                                        </div>
                                        @error('skillItem.*')
                                            <div class="invalid-feedback">{{ "la compétence est requise" }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <button type="button" class="btn btn-outline-primary btn-sm" id="addSkillItem">
                                    <i class="bi-plus-circle me-1"></i> Ajouter une compétence
                                </button>
                            </div>
                            <!-- End Form -->

                            <!-- Form: Présentation -->
                            <div class="mb-4">
                                <label for="presentationLabel" class="form-label">Présentation de la formation</label>
                                <textarea class="form-control @error('presentation') is-invalid @enderror" name="presentation" id="presentationLabel" rows="6" placeholder="Décrivez en détail le contenu de la formation, les objectifs, les prérequis, etc...">{{ old('presentation') }}</textarea>
                                @error('presentation')
                                    <div class="invalid-feedback">{{ "la présentation de la formation est requise" }}</div>
                                @enderror
                            </div>
                            <!-- End Form -->

                            <!-- Card: Médias -->
                            <div class="card mb-3">
                                <div class="card-header">
                                    <h4 class="card-header-title">Médias</h4>
                                </div>
                                <div class="card-body">
                                    <!-- Form: YouTube Link -->
                                    <div class="mb-4">
                                        <label for="youtubeLinkLabel" class="form-label">Lien de la vidéo YouTube</label>
                                        <input type="url" class="form-control @error('youtube_link') is-invalid @enderror" name="youtube_link" id="youtubeLinkLabel" placeholder="https://www.youtube.com/watch?v=..." value="{{ old('youtube_link') }}" form="formationForm">
                                        <span class="form-text">Mettez le lien de la vidéo expliquant la formation.</span>
                                        @error('youtube_link')
                                            <div class="invalid-feedback">{{ "le lien de la vidéo youtube est requis" }}</div>
                                        @enderror
                                    </div>
                                    <!-- End Form -->

                                    <!-- Form: Photo -->
                                    <div class="mb-4">
                                        <label for="photoLabel" class="form-label">Photo de la formation</label>
                                        <input type="file" class="form-control @error('photo') is-invalid @enderror" name="photo" id="photoLabel" accept="image/jpeg,image/png,image/gif" form="formationForm">
                                        <span class="form-text">Téléchargez une image représentative de la formation (JPG, PNG, GIF, max 2 Mo).</span>
                                        <div id="photoError" class="text-danger small" style="display: none;"></div>
                                        @error('photo')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <!-- End Form -->
                                </div>
                            </div>
                            <!-- End Card -->

                            <!-- Buttons -->
                            <div class="d-flex justify-content-end gap-3">
                                <a href="{{ route('admin.formations') }}" class="btn btn-white">Annuler</a>
                                <button type="submit" class="btn btn-primary" form="formationForm">Créer la formation</button>
                            </div>
                            <!-- End Buttons -->
                        </form>
                    </div>
                    <!-- End Body -->
                </div>
                <!-- End Card -->
            </div>
        </div>
    </div>

    <!-- JavaScript -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Gestion des compétences
        const skillsContainer = document.getElementById('skillsItemsContainer');
        const addSkillButton = document.getElementById('addSkillItem');
        const photoInput = document.getElementById('photoLabel');
        const photoError = document.getElementById('photoError');
        const maxFileSize = 2 * 1024 * 1024; // 2 Mo en octets

        addSkillButton.addEventListener('click', function() {
            const newItem = document.createElement('div');
            newItem.className = 'mb-3 skill-item';
            newItem.innerHTML = `
                <div class="input-group">
                    <input type="text" class="form-control" name="skillItem[]" placeholder="Ex: Gérer les bases de données" required>
                    <button type="button" class="btn btn-outline-danger remove-skill-item">
                        <i class="bi-trash"></i>
                    </button>
                </div>
            `;
            skillsContainer.appendChild(newItem);
            updateSkillRemoveButtons();
        });

        skillsContainer.addEventListener('click', function(e) {
            if (e.target.closest('.remove-skill-item')) {
                e.target.closest('.skill-item').remove();
                updateSkillRemoveButtons();
            }
        });

        function updateSkillRemoveButtons() {
            const items = skillsContainer.querySelectorAll('.skill-item');
            const removeButtons = skillsContainer.querySelectorAll('.remove-skill-item');
            if (items.length === 1) {
                removeButtons[0].style.display = 'none';
            } else {
                removeButtons.forEach(btn => btn.style.display = 'block');
            }
        }

        updateSkillRemoveButtons();

        // Validation de la taille de l'image
        photoInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            photoError.style.display = 'none'; // Réinitialiser l'erreur
            photoInput.classList.remove('is-invalid'); // Retirer la classe d'erreur
            if (file) {
                if (file.size > maxFileSize) {
                    photoError.textContent = 'L\'image est trop volumineuse. La taille maximale autorisée est de 2 Mo.';
                    photoError.style.display = 'block';
                    photoInput.classList.add('is-invalid');
                    e.target.value = ''; // Réinitialiser l'input
                } else if (!['image/jpeg', 'image/png', 'image/gif'].includes(file.type)) {
                    photoError.textContent = 'Le fichier doit être une image au format JPG, PNG ou GIF.';
                    photoError.style.display = 'block';
                    photoInput.classList.add('is-invalid');
                    e.target.value = '';
                }
            }
        });
    });
</script>
</x-layouts>
