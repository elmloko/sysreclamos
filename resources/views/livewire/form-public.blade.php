<div class="section">
    <div class="container">
        <h3 class="text-center mb-4">Libro de Reclamaciones</h3>
        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
        <form wire:submit.prevent="submit" class="mx-auto" style="max-width: 800px;">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="fullName">Nombre Completo *</label>
                        <input type="text" id="fullName" name="fullName" class="form-control"
                            placeholder="Ej. César Rojas" wire:model="fullName" style="text-transform: uppercase;" required>
                        @error('fullName') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="address">Dirección</label>
                        <input type="text" id="address" name="address" class="form-control"
                            placeholder="Ej. Av. Los Ángeles 1025" wire:model="address" style="text-transform: uppercase;">
                        @error('address') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="country">País *</label>
                        <input type="text" id="country" name="country" class="form-control"
                            placeholder="Ej. Bolivia" wire:model="country" style="text-transform: uppercase;" required>
                        @error('country') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="codepostal">Codigo de Rastreo</label>
                        <input type="text" id="codepostal" name="codepostal" class="form-control"
                            placeholder="Ej. RP012345678BO" wire:model="codepostal" style="text-transform: uppercase;">
                        @error('codepostal') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="email">Correo Electrónico *</label>
                        <input type="email" id="email" name="email" class="form-control"
                            placeholder="Ej. nombre@correo.com" wire:model="email"  required>
                        @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="phone">Teléfono *</label>
                        <input type="text" id="phone" name="phone" class="form-control"
                            placeholder="Ej. 1 294-0008" wire:model="phone" style="text-transform: uppercase;" required>
                        @error('phone') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="description">Descripción *</label>
                        <textarea id="description" name="description" class="form-control" rows="5"
                            placeholder="Escribe aquí tu reclamación, sugerencia o incidencia" wire:model="description" style="text-transform: uppercase;" required></textarea>
                        @error('description') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <button type="submit" class="btn btn-block btn-lg btn-primary">Enviar</button>
                </div>
            </div>
        </form>
    </div>
</div>
