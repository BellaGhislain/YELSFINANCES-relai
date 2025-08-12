<base href="/">
<x-layouts>
    <!-- Content -->
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-sm mb-2 mb-sm-0">
                    <h1 class="page-header-title">Ajouter un formateur</h1>
                </div>
                <div class="col-auto">
                    <a class="btn btn-outline-primary" href="{{ route('admin.trainers') }}">
                        <i class="bi-arrow-left me-1"></i> Retour
                    </a>
                </div>
            </div>
        </div>
        <!-- End Page Header -->

        <div class="row">
            <div class="col-lg-4 mb-3 mb-lg-0">
                <h4>Informations du compte</h4>
            </div>

            <div class="col-lg-8">
                <!-- Card -->
                <div class="card">
                    <!-- Corps -->
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.trainers.store') }}">
                            @csrf
                            <div class="row">
                                <div class="col-sm-6">
                                    <!-- Formulaire -->
                                    <div class="mb-4">
                                        <label for="firstNameLabel" class="form-label">Prénom</label>
                                        <input type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" id="firstNameLabel" placeholder="Jean-Pierre" aria-label="Jean-Pierre" value="{{ old('first_name') }}">
                                        @error('first_name')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <!-- Fin formulaire -->
                                </div>
                                <div class="col-sm-6">
                                    <!-- Formulaire -->
                                    <div class="mb-4">
                                        <label for="lastNameLabel" class="form-label">Nom de famille</label>
                                        <input type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" id="lastNameLabel" placeholder="Nguélé" aria-label="Nguélé" value="{{ old('last_name') }}">
                                        @error('last_name')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <!-- Fin formulaire -->
                                </div>
                            </div>
                            <!-- Fin ligne -->

                            <!-- Formulaire -->
                            <div class="mb-4">
                                <label for="emailLabel" class="form-label">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="emailLabel" placeholder="jeanpierre.nguele@yels.cm" aria-label="jeanpierre.nguele@yels.cm" value="{{ old('email') }}">
                                @error('email')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- Fin formulaire -->

                            <!-- Formulaire -->
                            <div class="mb-4">
                                <label for="phoneLabel" class="form-label">Téléphone</label>
                                <x-phone-input name="phone" :value="old('phone')" placeholder="690123456" :required="true" />
                            </div>
                            <!-- Fin formulaire -->

                            <!-- Modèle de champ d'adresse -->
                            {{-- <div id="addAddressFieldTemplate" style="display: none;">
                                <div class="input-group-add-field">
                                    <input type="text" class="form-control" data-name="addressLine" placeholder="Votre adresse" aria-label="Votre adresse">
                                    <a class="js-delete-field input-group-add-field-delete" href="javascript:;">
                                        <i class="bi-x"></i>
                                    </a>
                                </div>
                            </div> --}}
                            <!-- Fin modèle adresse -->

                            <div class="d-flex justify-content-end gap-3">
                                <a href="{{ route('admin.trainers') }}" class="btn btn-white">Annuler</a>
                                <button type="submit" class="btn btn-primary">Enregistrer</button>
                            </div>
                        </form>
                    </div>
                    <!-- Fin corps -->
                </div>
                <!-- End Card -->
            </div>
        </div>
        <!-- End Row -->
    </div>
    <!-- End Content -->

</x-layouts>
